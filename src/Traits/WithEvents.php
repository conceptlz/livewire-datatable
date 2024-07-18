<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;
use Illuminate\Support\Str;

trait WithEvents
{
    public function setSortEvent($field, $direction): void
    {
        $this->setSort($field, $direction);
    }

    public function clearSortEvent(): void
    {
        $this->clearSorts();
    }

    public function setFilterEvent($filter, $value): void
    {
        if($this->debugIsEnabled())
        {
            addApilog('setFilterEvent',$filter);
        }
        $this->setFilter($filter, $value);
    }

    public function clearFilterEvent(): void
    {
        $this->setFilterDefaults();
    }

    public function updateFilters(string $name, mixed $value)
    {
        if (Str::contains($name, 'filterComponents')) {
            $this->resetComputedPage();

            // Clear bulk actions on filter
            $this->clearSelected();
            $this->setSelectAllDisabled();

            // Clear filters on empty value
            $filterName = Str::after($name, 'filterComponents.');
            $index = 0;
            if(Str::contains($filterName, '.'))
            {
                $index = Str::before($filterName, '.');
                $filterName = Str::after($filterName, '.');
                //addApilog('index-filterName',$index);
               // addApilog('filterName',$filterName);
            }
            //addApilog(';filterNam',$filterName);
            $filter = $this->getFilterByKey($filterName);

            if ($filter && $filter->isEmpty($value)) {
                $this->resetFilter($filterName,$index);
            }else{
                //addApilog('filterName',$filterName);
                //$this->setFilter($filterName,$value);
                //addApilog('$this->filterComponents',$this->filterComponents);
                $this->appliedFilters[$index][$filterName] = $this->filterComponents[$index][$filterName] = $value;
            }
           // addApilog('$this->filterComponents',$this->filterComponents);
           // addApilog('$this->appliedFilters',$this->appliedFilters);
        }

        if (Str::contains($name, 'filterConditions')) {
            $this->resetComputedPage();

            // Clear bulk actions on filter
            $this->clearSelected();
            $this->setSelectAllDisabled();
            
            // Clear filters on empty value
            $filterName = Str::after($name, 'filterConditions.');
            $index = 0;
            if(Str::contains($filterName, '.'))
            {
                $index = Str::before($filterName, '.');
                $filterName = Str::after($filterName, '.');
            }
            $this->filterConditions[$index][$filterName] = $value;
            $this->appliedFilters[$index][$filterName] = (isset($this->appliedFilters[$index][$filterName])) ? $this->appliedFilters[$index][$filterName] : '';
            $this->filterComponents[$index][$filterName] = (isset($this->filterComponents[$index][$filterName])) ? $this->filterComponents[$index][$filterName] : '';
           // addApilog('$this->appliedFilters-updateFilters',$this->appliedFilters);
          
        }
        
    }
}
