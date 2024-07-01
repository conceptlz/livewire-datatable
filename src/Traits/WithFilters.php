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
            ];
        }

        return [];
    }
    private function getOperator($operand = '')
    {
        return $operand ? $this->operators[$operand] : '=';
    }

    public function getFilterOperandByKey(string $key)
    {
        if(isset($this->filterConditions[$key]) && $this->filterConditions[$key] != '')
        {
            return $this->getOperator($this->filterConditions[$key]);
        }
        else{
            return $this->getOperator();
        }
    }

    public function getFilterCondtionByKey(string $key)
    {
        return (isset($this->filterConditions[$key]) && $this->filterConditions[$key] != '') ? $this->filterConditions[$key] : false;
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
    public function applyFilters(): Builder
    {
        $query = $this->getBuilder();
        if ($this->filtersAreEnabled() && $this->hasFilters() && $this->hasAppliedFiltersWithValues()) {
            foreach ($this->getFilters() as $filter) {
                foreach ($this->getAppliedFiltersWithValues() as $key => $value) {
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
                                            $query->WhereIn(
                                                $relation_key,
                                                $value
                                            );
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
                }
            }
        }
        return $query;
    }
}
