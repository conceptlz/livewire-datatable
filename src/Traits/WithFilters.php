<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;

use Illuminate\Database\Eloquent\Builder;
use Conceptlz\ThunderboltLivewireTables\Traits\Configuration\FilterConfiguration;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\FilterHelpers;
use Conceptlz\ThunderboltLivewireTables\Views\Filters\{SelectFilter,MultiSelectFilter,MultiSelectDropdownFilter,DateRangeFilter,TextFilter};
trait WithFilters
{
    use FilterConfiguration,
        FilterHelpers;

    public bool $filtersStatus = true;

    public bool $filtersVisibilityStatus = true;

    public bool $filterPillsStatus = true;

    public bool $filterSlideDownDefaultVisible = false;

    public string $filterLayout = 'popover';

    public int $filterCount;

    protected $filterCollection;
    
    public array $filterComponents = [];

    public array $filterConditions = [];

    public array $appliedFilters = [];

    public array $filterGenericData = [];

    public function filters(): array
    {
        return [];
    }

    protected function queryStringWithFilters(): array
    {
        if ($this->queryStringIsEnabled() && $this->filtersAreEnabled()) {
            return [
                'appliedFilters' => ['except' => null, 'history' => false, 'keep' => false, 'as' => $this->getQueryStringAlias().'-filters'],
                'filterConditions' => ['except' => null, 'history' => false, 'keep' => false, 'as' => $this->getQueryStringAlias().'-filters-conditions'],
            ];
        }

        return [];
    }
    private function getOperator($operand = '')
    {
        return $operand ? $this->operators[$operand] : '=';
    }

    public function getFilterOperandByKey(string $key,$index)
    {
        if(isset($this->filterConditions[$index][$key]) && $this->filterConditions[$index][$key] != '')
        {
            return $this->getOperator($this->filterConditions[$index][$key]);
        }
        else{
            return $this->getOperator();
        }
    }

    public function getFilterCondtionByKey(string $key,$index)
    {
        //addApilog('$this->filterConditions',$this->filterConditions);
        return (isset($this->filterConditions[$index][$key]) && $this->filterConditions[$index][$key] != '') ? $this->filterConditions[$index][$key] : false;
    }
    private function complexValue($condtion,$value)
    {
        if (isset($condtion)) {
            if ($condtion === 'contains') {
                return '%' . $value . '%';
            } elseif ($condtion === 'does not contain') {
                return '%' . $value . '%';
            } elseif ($condtion === 'starts with') {
                return $value . '%';
            } elseif ($condtion === 'ends with') {
                return '%' . $value;
            } elseif ($condtion === 'is empty' || $condtion === 'is not empty') {
                return '';
            }
        }

        return $value;
    }
    public function getUniqueFilters()
    {
        $filters = [];
        foreach($this->getAppliedFiltersWithValues() as $index => $filter)
        {
            foreach($filter as $key => $value)
            {
                $filters[$key][] =  ['value'=> $value,'index' => $index];
            }
        }
        return $filters;
    }
    public function applyFilters(): Builder
    {
        $query = $this->getBuilder();
        if ($this->filtersAreEnabled() && $this->hasFilters() && $this->hasAppliedFiltersWithValues()) {
            $selected_filters = $this->getUniqueFilters();
           // addApilog('selected_filters',$selected_filters);
            $filter_keys = array_keys($selected_filters);
            foreach ($this->getFilters() as $filter) {
                if(in_array($filter->getKey(),$filter_keys))
                {
                    //addApilog('selected_filters_key',$filter->getKey());
                    $key = $filter->getKey();
                    if(!empty($selected_filters[$key]))
                    {
                        $query->where(function ($query) use($key,$selected_filters,$filter) {
                            foreach($selected_filters[$key] as $data)
                            {
                                $index = $data['index'];
                                $value = $data['value'];
                                $condition = $this->getFilterCondtionByKey($key,$index);
                              
                                if($this->debugIsEnabled())
                                {
                                    addApilog('applyFilters-key',$key);
                                    addApilog('applyFilters-filter',$filter);
                                    addApilog('applyFilters-condition',$condition);
                                }
                                if(! $this->getFilterByKey($key)->isEmpty($value) && (is_array($value) ? count($value) : $value !== null))
                                {
                                    // Let the filter class validate the value
                                    $value = $filter->validate($value);
        
                                    if ($value === false) {
                                        continue;
                                    }
                                    if($filter->hasFilterCallback())
                                    {
                                        $operand = $this->getFilterOperandByKey($key,$index);
                                        if($filter instanceof TextFilter)
                                        {
                                            $condition = $this->getFilterCondtionByKey($key,$index);
                                            $value = $this->complexValue($condition,$value);
                                        }
                                        if(in_array($condition,['is empty','is not empty']))
                                        {
                                            $value = null;
                                            ($filter->getFilterCallback())($query, (string)$value,$operand);
                                        }else{
                                            ($filter->getFilterCallback())($query,$value,$operand);
                                        }
                                        
                                    }else{
                                        $condition = $this->getFilterCondtionByKey($key,$index);
                                        $relation_key = $filter->hasFilterRelationKey();
                                        $query->orWhere(function ($query) use ($value,$condition,$key,$filter,$relation_key,$index) {

                                            $relation_key = ($relation_key != '') ? $relation_key : $key;
                                            if ($condition === 'is empty') {
                                                $query->orWhereNull($relation_key);
                                            } elseif ($condition === 'is not empty') {
                                                $query->orWhereNotNull($relation_key);
                                            }  else {
                                                if($filter instanceof MultiSelectDropdownFilter || $filter instanceof MultiSelectFilter)
                                                {
                                                    if ($condition === 'is empty') {
                                                        $query->orWhereNull($relation_key);
                                                    } elseif ($condition === 'is not empty') {
                                                        $query->orWhereNotNull($relation_key);
                                                    }else if($condition === 'is not') {
                                                        $query->orWhereNotIn(
                                                            $relation_key,
                                                            $value
                                                        );
                                                    }
                                                    else{
                                                        $query->orWhereIn(
                                                            $relation_key,
                                                            $value
                                                        );
                                                    }
                                                
                                                }else if($filter instanceof DateRangeFilter)
                                                {
                                                    $query->orWhere(function ($query) use ($value,$condition,$key,$filter,$relation_key,$index) {
                                                        $query
                                                        ->whereDate($relation_key, '>=', $value['minDate']) 
                                                        ->whereDate($relation_key, '<=', $value['maxDate']);
                                                    });
                                                  
                                                }
                                                else if($filter instanceof NumberRangeFilter)
                                                {

                                                    $query->orWhere(function ($query) use ($value,$condition,$key,$filter,$relation_key,$index) {
                                                        $query
                                                        ->where($relation_key, '>=', $value['min']) 
                                                        ->where($relation_key, '<=', $value['max']);
                                                    });
                                                }
                                                else{
                                                    
                                                    //addApilog('$this->complexValue($condition,$value)',$this->complexValue($condition,$value));
                                                    $query->orWhere(
                                                        $relation_key,
                                                        $this->getFilterOperandByKey($key,$index),
                                                        $this->complexValue($condition,$value)
                                                    );
                                                }
                                            
                                            }
                                        });
                                       
                                    }
                                    
                                    //($filter->getFilterCallback())($this->getBuilder(), $value);
                                }
                                elseif(in_array($condition,['is empty','is not empty'])){
                                    if($filter->hasFilterCallback())
                                    {
                                        $operand = $this->getFilterOperandByKey($key,$index);
                                        $value = null;
                                        ($filter->getFilterCallback())($query,(string)$value,$operand);
                                    }else{
                                        $relation_key = $filter->hasFilterRelationKey();
                                        $query->orWhere(function ($query) use ($condition,$key,$filter,$relation_key,$index) {
            
                                            $relation_key = ($relation_key != '') ? $relation_key : $key;
                                            if ($condition === 'is empty') {
                                                $query->orWhereNull($relation_key);
                                            } elseif ($condition === 'is not empty') {
                                                $query->orWhereNotNull($relation_key);
                                            }  
                                        });
                                    }
                                    
                                }
                            }
                        });
                    }
                }
                
            }
        }
        return $query;
    }
    public function applyFilterss(): Builder
    {
        $query = $this->getBuilder();
        if ($this->filtersAreEnabled() && $this->hasFilters() && $this->hasAppliedFiltersWithValues()) {
            foreach ($this->getFilters() as $filter) {
                foreach ($this->getAppliedFiltersWithValues() as $key => $selectedFilter) {
                    if ($filter->getKey() === $key) {
                        $condition = $this->getFilterCondtionByKey($key);

                        if($this->debugIsEnabled())
                        {
                            addApilog('applyFilters-key',$key);
                            addApilog('applyFilters-filter',$filter);
                            addApilog('applyFilters-condition',$condition);
                        }
                        if(! $this->getFilterByKey($key)->isEmpty($value) && (is_array($value) ? count($value) : $value !== null))
                        {
                            // Let the filter class validate the value
                            $value = $filter->validate($value);

                            if ($value === false) {
                                continue;
                            }
                            if($filter->hasFilterCallback())
                            {
                                $operand = $this->getFilterOperandByKey($key);
                                if($filter instanceof TextFilter)
                                {
                                    $condition = $this->getFilterCondtionByKey($key);
                                    $value = $this->complexValue($condition,$value);
                                }
                                if(in_array($condition,['is empty','is not empty']))
                                {
                                    $value = null;
                                    ($filter->getFilterCallback())($this->getBuilder(), (string)$value,$operand);
                                }else{
                                    ($filter->getFilterCallback())($this->getBuilder(),$value,$operand);
                                }
                                
                            }else{
                                $condition = $this->getFilterCondtionByKey($key);
                                $relation_key = $filter->hasFilterRelationKey();
                                $query->where(function ($query) use ($value,$condition,$key,$filter,$relation_key) {

                                    $relation_key = ($relation_key != '') ? $relation_key : $key;
                                    if ($condition === 'is empty') {
                                        $query->whereNull($relation_key);
                                    } elseif ($condition === 'is not empty') {
                                        $query->whereNotNull($relation_key);
                                    }  else {
                                        if($filter instanceof MultiSelectDropdownFilter || $filter instanceof MultiSelectFilter)
                                        {
                                            if ($condition === 'is empty') {
                                                $query->whereNull($relation_key);
                                            } elseif ($condition === 'is not empty') {
                                                $query->whereNotNull($relation_key);
                                            }else if($condition === 'is not') {
                                                $query->WhereNotIn(
                                                    $relation_key,
                                                    $value
                                                );
                                            }
                                            else{
                                                $query->WhereIn(
                                                    $relation_key,
                                                    $value
                                                );
                                            }
                                           
                                        }else if($filter instanceof DateRangeFilter)
                                        {
                                            $query
                                            ->whereDate($relation_key, '>=', $value['minDate']) 
                                            ->whereDate($relation_key, '<=', $value['maxDate']);
                                        }
                                        else if($filter instanceof NumberRangeFilter)
                                        {
                                            $query
                                            ->where($relation_key, '>=', $value['min']) 
                                            ->where($relation_key, '<=', $value['max']);
                                        }
                                        else{
                                            //addApilog('$this->complexValue($condition,$value)',$this->complexValue($condition,$value));
                                            $query->Where(
                                                $relation_key,
                                                $this->getFilterOperandByKey($key),
                                                $this->complexValue($condition,$value)
                                            );
                                        }
                                       
                                    }
                                });
                            }
                            
                            //($filter->getFilterCallback())($this->getBuilder(), $value);
                        }
                        elseif(in_array($condition,['is empty','is not empty'])){
                            if($filter->hasFilterCallback())
                            {
                                $operand = $this->getFilterOperandByKey($key);
                                $value = null;
                                ($filter->getFilterCallback())($this->getBuilder(),(string)$value,$operand);
                            }else{
                                $relation_key = $filter->hasFilterRelationKey();
                                $query->where(function ($query) use ($condition,$key,$filter,$relation_key) {
    
                                    $relation_key = ($relation_key != '') ? $relation_key : $key;
                                    if ($condition === 'is empty') {
                                        $query->whereNull($relation_key);
                                    } elseif ($condition === 'is not empty') {
                                        $query->whereNotNull($relation_key);
                                    }  
                                });
                            }
                            
                        }
                    }
                    else{
                        $index = $key;
                        
                        foreach($selectedFilter as $key => $value)
                        {
                            if ($filter->getKey() === $key) {
                                $condition = $this->getFilterCondtionByKey($key,$index);
        
                                if($this->debugIsEnabled())
                                {
                                    addApilog('applyFilters-key',$key);
                                    addApilog('applyFilters-filter',$filter);
                                    addApilog('applyFilters-condition',$condition);
                                }
                                if(! $this->getFilterByKey($key)->isEmpty($value) && (is_array($value) ? count($value) : $value !== null))
                                {
                                    // Let the filter class validate the value
                                    $value = $filter->validate($value);
        
                                    if ($value === false) {
                                        continue;
                                    }
                                    if($filter->hasFilterCallback())
                                    {
                                        $operand = $this->getFilterOperandByKey($key,$index);
                                        if($filter instanceof TextFilter)
                                        {
                                            $condition = $this->getFilterCondtionByKey($key,$index);
                                            $value = $this->complexValue($condition,$value);
                                        }
                                        if(in_array($condition,['is empty','is not empty']))
                                        {
                                            $value = null;
                                            ($filter->getFilterCallback())($this->getBuilder(), (string)$value,$operand);
                                        }else{
                                            ($filter->getFilterCallback())($this->getBuilder(),$value,$operand);
                                        }
                                        
                                    }else{
                                        $condition = $this->getFilterCondtionByKey($key,$index);
                                        $relation_key = $filter->hasFilterRelationKey();
                                        $query->where(function ($query) use ($value,$condition,$key,$filter,$relation_key,$index) {
        
                                            $relation_key = ($relation_key != '') ? $relation_key : $key;
                                            if ($condition === 'is empty') {
                                                $query->whereNull($relation_key);
                                            } elseif ($condition === 'is not empty') {
                                                $query->whereNotNull($relation_key);
                                            }  else {
                                                if($filter instanceof MultiSelectDropdownFilter || $filter instanceof MultiSelectFilter)
                                                {
                                                    if ($condition === 'is empty') {
                                                        $query->whereNull($relation_key);
                                                    } elseif ($condition === 'is not empty') {
                                                        $query->whereNotNull($relation_key);
                                                    }else if($condition === 'is not') {
                                                        $query->WhereNotIn(
                                                            $relation_key,
                                                            $value
                                                        );
                                                    }
                                                    else{
                                                        $query->WhereIn(
                                                            $relation_key,
                                                            $value
                                                        );
                                                    }
                                                   
                                                }else if($filter instanceof DateRangeFilter)
                                                {
                                                    $query
                                                    ->whereDate($relation_key, '>=', $value['minDate']) 
                                                    ->whereDate($relation_key, '<=', $value['maxDate']);
                                                }
                                                else if($filter instanceof NumberRangeFilter)
                                                {
                                                    $query
                                                    ->where($relation_key, '>=', $value['min']) 
                                                    ->where($relation_key, '<=', $value['max']);
                                                }
                                                else{
                                                    
                                                    //addApilog('$this->complexValue($condition,$value)',$this->complexValue($condition,$value));
                                                    $query->Where(
                                                        $relation_key,
                                                        $this->getFilterOperandByKey($key,$index),
                                                        $this->complexValue($condition,$value)
                                                    );
                                                }
                                               
                                            }
                                        });
                                    }
                                    
                                    //($filter->getFilterCallback())($this->getBuilder(), $value);
                                }
                                elseif(in_array($condition,['is empty','is not empty'])){
                                    if($filter->hasFilterCallback())
                                    {
                                        $operand = $this->getFilterOperandByKey($key,$index);
                                        $value = null;
                                        ($filter->getFilterCallback())($this->getBuilder(),(string)$value,$operand);
                                    }else{
                                        $relation_key = $filter->hasFilterRelationKey();
                                        $query->where(function ($query) use ($condition,$key,$filter,$relation_key,$index) {
            
                                            $relation_key = ($relation_key != '') ? $relation_key : $key;
                                            if ($condition === 'is empty') {
                                                $query->whereNull($relation_key);
                                            } elseif ($condition === 'is not empty') {
                                                $query->whereNotNull($relation_key);
                                            }  
                                        });
                                    }
                                    
                                }
                            }
                        }
                    }
                }
            }
        }
        return $query;
    }
}
