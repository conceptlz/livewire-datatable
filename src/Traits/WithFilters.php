<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;

use Illuminate\Database\Eloquent\Builder;
use Conceptlz\ThunderboltLivewireTables\Traits\Configuration\FilterConfiguration;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\FilterHelpers;
use Conceptlz\ThunderboltLivewireTables\Views\Filters\{SelectFilter,MultiSelectFilter,MultiSelectDropdownFilter,DateRangeFilter};
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
            addApilog('getOperator',$this->filterConditions[$key]);
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
            } elseif ($condtion === 'begins with') {
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
        addApilog('applyFilters');
        $query = $this->getBuilder();
        if ($this->filtersAreEnabled() && $this->hasFilters() && $this->hasAppliedFiltersWithValues()) {
            foreach ($this->getFilters() as $filter) {
                foreach ($this->getAppliedFiltersWithValues() as $key => $value) {
                    if ($filter->getKey() === $key) {
                        addApilog('applyFilters-key',$key);
                        addApilog('applyFilters-filter',$filter);
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
                                ($filter->getFilterCallback())($this->getBuilder(), $value,$operand);
                                addApilog('callback');
                            }else{
                                $condition = $this->getFilterCondtionByKey($key);
                                addApilog('getFilterCondtionByKey',$condition);
                                $query->where(function ($query) use ($value,$condition,$key,$filter) {
                                    if ($condition === 'is empty') {
                                        $query->whereNull($key);
                                    } elseif ($condition === 'is not empty') {
                                        $query->whereNotNull($key);
                                    }  else {
                                        addApilog('applyFilters-operand-key', $this->getFilterOperandByKey($key));
                                        addApilog('applyFilters-complexValue',$this->complexValue($condition,$value));
                                        if($filter instanceof MultiSelectDropdownFilter || $filter instanceof MultiSelectFilter)
                                        {
                                            $query->WhereIn(
                                                $key,
                                                $value
                                            );
                                        }else if($filter instanceof DateRangeFilter)
                                        {
                                            $query
                                            ->whereDate($key, '>=', $value['minDate']) 
                                            ->whereDate($key, '<=', $value['maxDate']);
                                        }
                                        else if($filter instanceof NumberRangeFilter)
                                        {
                                            $query
                                            ->where($key, '>=', $value['min']) 
                                            ->where($key, '<=', $value['max']);
                                        }
                                        else{
                                            $query->Where(
                                                $key,
                                                $this->getFilterOperandByKey($key),
                                                $this->complexValue($condition,$value)
                                            );
                                        }
                                       
                                    }
                                });
                            }
                            
                            //($filter->getFilterCallback())($this->getBuilder(), $value);
                        }
                        
                    }
                }
            }
        }
        addApilog('query',$query->toSql());
        return $query;
    }
}
