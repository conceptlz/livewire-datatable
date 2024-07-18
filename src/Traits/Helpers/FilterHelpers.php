<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Conceptlz\ThunderboltLivewireTables\Views\Filter;
use Conceptlz\ThunderboltLivewireTables\Views\Filters\MultiSelectDropdownFilter;
use Conceptlz\ThunderboltLivewireTables\Views\Filters\MultiSelectFilter;

trait FilterHelpers
{
    protected $number_operands = [
        '=' => 'is equal to', 
        '<>' => 'is not equal to', 
        '<'  => 'is less than',
        '<=' => 'is less than equal to',
        '>' => 'is greater than', 
        '>=' => 'is greater than equal to'];


    protected $string_operands = [
        'is' => 'is',
        'is not' => 'is not', 
        'contains' => 'contains',
        'does not contain' => 'does not contain',
        'starts with' => 'starts with',
        'ends with' => 'ends with',
        'is empty' => 'is empty', 
        'is not empty' => 'is not empty'];

    protected $select_operands = [
            'is' => 'is',
            'is not' => 'is not', 
            'is empty' => 'is empty', 
            'is not empty' => 'is not empty'];

    protected $boolean_operands = [
        'is' => 'is',
        'is not' => 'is not', 
    ];

    protected $operators = [
        '=' => '=',
        '>' => '>',
        '<' => '<',
        '<>' => '<>',
        '>=' => '>=',
        '<=' => '<=',
        'is' => '=',
        'is not' => '<>', 
        'contains' => 'LIKE',
        'does not contain' => 'NOT LIKE',
        'starts with' => 'LIKE',
        'ends with' => 'LIKE',
        'is empty' => '=',
        'is not empty' => '<>',
        'includes' => '=',
        'does not include' => '<>',
    ];
    /**
     * Sets Filter Default Values
     */
    public function mountFilterHelpers(): void
    {
       // addApilog('mountFilterHelpers-setFilter','mountFilterHelpers');
      //  addApilog('mountFilterHelpers-appliedFilters',$this->appliedFilters);
       // addApilog('mountFilterHelpers-filterComponents',$this->filterComponents);
        foreach ($this->getFilters() as $index => $filter) {
            if (! isset($this->appliedFilters[$index][$filter->getKey()])) {
                if ($filter->hasFilterDefaultValue()) {
                    $this->setFilter($filter->getKey(), $filter->getFilterDefaultValue(),$index);
                } else {
                    //$this->resetFilter($filter);
                    if($filter->getDefaultValue() != '' && $filter->getDefaultValue() != null && empty($filter->getDefaultValue()))
                    {
                        $this->setFilter($filter->getKey(), $filter->getDefaultValue(),$index);
                    }
                }
            } else {
               // addApilog('mountFilterHelpers-setFilter',$filter->getKey());
                $this->setFilter($filter->getKey(), $this->appliedFilters[$index][$filter->getKey()],$index);
            }
        }
        foreach( $this->appliedFilters as $index => $filter)
        {
            if(is_array($filter))
            {
                foreach($filter as $key => $value)
                {
                    if (! isset($this->filterComponents[$index][$key])) {
                        $this->filterComponents[$index][$key] = $value;
                    }
                }
            }
        }
       // addApilog('mountFilterHelpers-appliedFilters',$this->appliedFilters);
       // addApilog('mountFilterHelpers-filterComponents',$this->filterComponents);
    }

    public function getFiltersStatus(): bool
    {
        return $this->filtersStatus;
    }

    public function filtersAreEnabled(): bool
    {
        return $this->getFiltersStatus() === true;
    }

    public function filtersAreDisabled(): bool
    {
        return $this->getFiltersStatus() === false;
    }

    public function getFiltersVisibilityStatus(): bool
    {
        return $this->filtersVisibilityStatus;
    }

    public function filtersVisibilityIsEnabled(): bool
    {
        return $this->getFiltersVisibilityStatus() === true;
    }

    public function filtersVisibilityIsDisabled(): bool
    {
        return $this->getFiltersVisibilityStatus() === false;
    }

    public function getFilterSlideDownDefaultStatus(): bool
    {
        return $this->filterSlideDownDefaultVisible;
    }

    public function filtersSlideDownIsDefaultVisible(): bool
    {
        return $this->getFilterSlideDownDefaultStatus() === true;
    }

    public function filtersSlideDownIsDefaultHidden(): bool
    {
        return $this->getFilterSlideDownDefaultStatus() === false;
    }

    public function getFilterPillsStatus(): bool
    {
        return $this->filterPillsStatus;
    }

    public function filterPillsAreEnabled(): bool
    {
        return $this->getFilterPillsStatus() === true;
    }

    public function filterPillsAreDisabled(): bool
    {
        return $this->getFilterPillsStatus() === false;
    }

    public function hasFilters(): bool
    {
        return $this->getFiltersCount() > 0;
    }

    public function hasVisibleFilters(): bool
    {
        return $this->getFilters()
            ->reject(fn (Filter $filter) => $filter->isHiddenFromMenus())
            ->count() > 0;
    }

    public function getFilters(): Collection
    {
        //addApilog('filterCollection',$this->filterCollection);
        if (! isset($this->filterCollection)) {
            $this->filterCollection = collect($this->filters());
            //addApilog('filters',$this->filterCollection);
        }

        return $this->filterCollection;

    }

    public function getFiltersCount(): int
    {
        if (! isset($this->filterCount)) {
            $this->filterCount = $this->getFilters()->count();
        }

        return $this->filterCount;

    }

    /**
     * @return mixed
     */
    public function getFilterByKey(string $key)
    {
        return $this->getFilters()->first(function ($filter) use ($key) {
            return $filter->getKey() === $key;
        });
    }

    public function setDefaultFilter(string $filterKey, mixed $value): void
    {
        $filter = $this->getFilterByKey($filterKey);
        if($filter)
        {
            if ($filter->hasFilterDefaultValue()) {
                $this->setFilter($filter->getKey(), $filter->getFilterDefaultValue());
            }else
            {
                $this->setFilter($filter->getKey(), $filter->getDefaultValue());
            }
        }else{
            $this->setFilter($filterKey, $value);
        }
       
    }

    #[On('set-filter')]
    public function setFilter(string $filterKey, mixed $value,int $index): void
    {
        $this->appliedFilters[$index][$filterKey] = $this->filterComponents[$index][$filterKey] = $value;
        // addApilog('appliedFilters-setFilter',$this->appliedFilters);
       // addApilog('filterComponents-setFilter',$this->filterComponents); 
    }

    public function selectAllFilterOptions(string $filterKey,$index): void
    {
        $filter = $this->getFilterByKey($filterKey);

        if (! $filter instanceof MultiSelectFilter && ! $filter instanceof MultiSelectDropdownFilter) {
            return;
        }

        if (count($this->getAppliedFilterWithValue($filterKey,$index) ?? []) === count($filter->getOptions())) {
            $this->resetFilter($filterKey,$index);

            return;
        }

        $this->setFilter($filterKey, array_keys($filter->getOptions()),$index);
    }

    #[On('clear-filters')]
    public function setFilterDefaults(): void
    {
        foreach ($this->getFilters() as $filter) {
            if ($filter->isResetByClearButton()) {
                $this->resetFilter($filter,'');
            }
        }
       // addApilog('setFilterDefaults',$this->appliedFilters);
    }

    /**
     * @return array<mixed>
     */
    public function getAppliedFilters(): array
    {
        $validFilterKeys = $this->getFilters()
            ->map(fn (Filter $filter) => $filter->getKey())
            ->toArray();
      /*   addApilog('getAppliedFilters-validFilterKeys',$validFilterKeys);
        addApilog('getAppliedFilters-filters',$this->appliedFilters); */
        /* return collect($this->filterComponents ?? [])
            ->filter(fn ($value, $key) => in_array($key, $validFilterKeys, true))
            ->toArray(); */
           // addApilog('$this->appliedFilters',$this->appliedFilters);
        $data = collect($this->appliedFilters ?? [])
            ->filter(function ($value, $key) use($validFilterKeys) {
                if(is_array($value))
                {
                    if(!empty($value))
                    {
                        $key = array_keys($value)[0];
                  
                        return in_array($key, $validFilterKeys, true);
                    }
                   
                }else{
                   return in_array($key, $validFilterKeys, true);
                }
            } )
            ->toArray();
            //addApilog('data',$data);
            return $data;
    }

    public function hasAppliedFiltersWithValues(): bool
    {
        //addApilog('count($this->getAppliedFiltersWithValues())',count($this->getAppliedFiltersWithValues()));
        return count($this->getAppliedFiltersWithValues()) > 0;
    }

    public function hasAppliedVisibleFiltersWithValuesThatCanBeCleared(): bool
    {
        return collect($this->getAppliedFiltersWithValues())
        ->map(function ($_item, $key) {
            if(is_array($_item))
            {   
                $filters = [];
                foreach($_item as $key => $value)
                {
                    $filters[] =  $this->getFilterByKey($key);
                }
                return $filters;
            }else{
                return  $this->getFilterByKey($key);
            }
        })->reject(function ($filter, $key){
            if(is_array($filter))
            {   
                $filters = [];
                foreach($filter as $key => $value)
                {
                    return $value->isHiddenFromMenus() && ! $value->isResetByClearButton();
                }
            }else{
                return  $filter->isHiddenFromMenus() && ! $filter->isResetByClearButton();
            }
        })->count() > 0;
    }

    public function getFilterBadgeCount(): int
    {
        return collect($this->getAppliedFiltersWithValues())
                ->map(function ($_item, $key) {
                    if(is_array($_item))
                    {   
                        $filters = [];
                        foreach($_item as $key => $value)
                        {
                            $filters[] =  $this->getFilterByKey($key);
                        }
                        return $filters;
                    }else{
                        return  $this->getFilterByKey($key);
                    }
                })
            ->reject(function ($filter, $key){
                if(is_array($filter))
                {   
                    $filters = [];
                    foreach($filter as $key => $value)
                    {
                        return $value->isHiddenFromFilterCount();
                    }
                }else{
                    return  $filter->isHiddenFromFilterCount();
                }
            })
            ->count();
    }

    public function hasAppliedVisibleFiltersForPills(): bool
    {
        return collect($this->getAppliedFiltersWithValues())
            ->map(function ($_item, $key) {
                if(is_array($_item))
                {   
                    $filters = [];
                    foreach($_item as $key => $value)
                    {
                        $filters[] =  $this->getFilterByKey($key);
                    }
                    return $filters;
                }else{
                    return  $this->getFilterByKey($key);
                }
            })->reject(function ($filter, $key){
                if(is_array($filter))
                {   
                    $filters = [];
                    foreach($filter as $key => $value)
                    {
                        return $value->isHiddenFromPills();
                    }
                }else{
                    return  $filter->isHiddenFromPills();
                }
            })
            ->count() > 0;
    }

    /**
     * @return array<mixed>
     */
    public function getAppliedFiltersWithValues(): array
    {
       // addApilog('$this->getAppliedFilters()',$this->getAppliedFilters());
        return array_filter($this->getAppliedFilters(), function ($item, $key) {
            /* addApilog('item',$item);
            addApilog('key',$key); */
           //return ! $this->getFilterByKey($key)->isEmpty($item) && (is_array($item) ? count($item) : $item !== null);
           return true;
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * @return mixed
     */
    public function getAppliedFilterWithValue(string $filterKey,$index)
    {
        //addApilog('setall',$this->getAppliedFiltersWithValues());
        return $this->getAppliedFiltersWithValues()[$index][$filterKey] ?? null;
    }

    public function getAppliedFiltersWithValuesCount(): int
    {
        return count($this->getAppliedFiltersWithValues());
    }

    /**
     * @param  mixed  $filter
     */
    public function resetFilter($filter,$index): void
    {
        if (! $filter instanceof Filter) {
            $filter = $this->getFilterByKey($filter);
        }
        
       // addApilog('reset-filter',$this->appliedFilters);
        if($filter->getDefaultValue() != '' && $filter->getDefaultValue() != null && empty($filter->getDefaultValue()))
        {
           // addApilog('reset-filter',$filter->getKey());
            $this->setFilter($filter->getKey(), $filter->getDefaultValue(),$index);
        }else{
            if($index == '')
            {
                $this->appliedFilters = [];
                $this->filterComponents = [];
                $this->filterConditions = [];
            }else{
                unset($this->appliedFilters[$index][$filter->getKey()]);
                unset($this->filterComponents[$index][$filter->getKey()]);
                if(isset($this->filterConditions[$index][$filter->getKey()]))
                {
                    unset($this->filterConditions[$index][$filter->getKey()]);
                }
            }
            
        }
       // addApilog('reset-filter',$this->appliedFilters);
       
    }

    public function getFilterLayout(): string
    {
        return $this->filterLayout;
    }

    public function isFilterLayoutPopover(): bool
    {
        return $this->getFilterLayout() === 'popover';
    }

    public function isFilterLayoutSlideDown(): bool
    {
        return $this->getFilterLayout() === 'slide-down';
    }

    /**
     * Get whether any filter has a configured slide down row.
     */
    public function hasFiltersWithSlidedownRows(): bool
    {
        return $this->getFilters()
            ->reject(fn (Filter $filter) => ! $filter->hasFilterSlidedownRow())
            ->count() > 0;
    }

    /**
     * Get whether filter has a configured slide down row.
     */
    public function getVisibleFilters(): Collection
    {
        return $this->getFilters()->reject(fn (Filter $filter) => $filter->isHiddenFromMenus());
    }

    /**
     * Get filters sorted by row
     *
     * @return array<mixed>
     */
    public function getFiltersByRow(): array
    {
        $orderedFilters = [];
        $filterList = ($this->hasFiltersWithSlidedownRows()) ? $this->getVisibleFilters()->sortBy('filterSlidedownRow') : $this->getVisibleFilters();
        if ($this->hasFiltersWithSlidedownRows()) {
            foreach ($filterList as $filter) {
                $orderedFilters[(string) $filter->getFilterSlidedownRow()][] = $filter;
            }

            if (empty($orderedFilters['1'])) {
                $orderedFilters['1'] = (isset($orderedFilters['99']) ? $orderedFilters['99'] : []);
                if (isset($orderedFilters['99'])) {
                    unset($orderedFilters['99']);
                }
            }
        } else {
            $orderedFilters = Arr::wrap($filterList);
            $orderedFilters['1'] = $orderedFilters['0'] ?? [];
            if (isset($orderedFilters['0'])) {
                unset($orderedFilters['0']);
            }
        }
        ksort($orderedFilters);

        return $orderedFilters;
    }

    public function hasFilterGenericData(): bool
    {
        return ! empty($this->filterGenericData);
    }

    public function getFilterGenericData()
    {
        if (! $this->hasFilterGenericData()) {
            $this->setFilterGenericData($this->generateFilterGenericData());
        }

        return $this->filterGenericData;
    }

    public function getOperands($filter)
    {
        $operands = [
            'select' => $this->select_operands,
            'boolean' => $this->boolean_operands,
            'string' => $this->string_operands,
            'json' => $this->string_operands,
            'editable' => $this->string_operands,
            'number' => $this->number_operands,
            'date' => $this->number_operands,
            'time' => $this->number_operands,
            'boolean' => [],
            'scope' => ['includes'],
        ];
        if($filter->type != '' && isset($operands[$filter->type]))
        {
            return $operands[$filter->type];
        }
        return [];
    }
}
