<?php

namespace Conceptlz\ThunderboltLivewireTables;

use Livewire\Component;
use Conceptlz\ThunderboltLivewireTables\Traits\FilterTraits;
use Conceptlz\ThunderboltLivewireTables\DataTableComponent;
use Illuminate\Support\Collection;
use Conceptlz\ThunderboltLivewireTables\Views\Filter;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\FilterHelpers;
use Illuminate\Support\Str;
use Conceptlz\ThunderboltLivewireTables\Traits\WithQueryString;

class FilterComponent extends Component
{
    use FilterHelpers;
    
    public string $tableName = 'table';
   // public $visibleFilters = [];
    public $slider_down;
    public array $filterGenericData = [];
    public $popover_layout = true;
    public $filterComponents = [];
    public $appliedFilters = [];
    public \Illuminate\Support\Collection $filters;
    public DataTableComponent $component;
    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'refreshDatatable' => '$refresh',
        'updateFilters' => 'updateFilters',
        'clearFilters' => 'clearFilterEvent',
        'resetFilter' => 'resetFilter'
    ];
   
    public function getFilters(): Collection
    {
        if (! isset($this->filterCollection)) {
            $this->filterCollection = $this->filters;
        }
        //addApilog('$this->appliedFiltersss',$this->appliedFilters);
        //addApilog('$this->filterComponentsss',$this->filterComponents);
        return $this->filterCollection;

    }


    public function setDefaultFilter(string $filterKey, mixed $value): void
    {
        $filter = $this->getFilterByKey($filterKey);
        if($filter)
        {
            if ($filter->hasFilterDefaultValue()) {
                $value = $filter->getFilterDefaultValue();
            }else
            {
                $value = $filter->getDefaultValue();
            }
        }
        $this->dispatch('setFilterPill', filterKey: $filterKey , value: $value);
       
    }

    public function updateFilters(string $name, mixed $value)
    {

        if (Str::contains($name, 'filterComponents')) {
            $filterName = Str::after($name, 'filterComponents.');
            $index = 0;
            if(Str::contains($filterName, '.'))
            {
                $index = Str::before($filterName, '.');
                $filterName = Str::after($filterName, '.');
            }
            //addApilog('updateFilters-index',$index);
            $this->appliedFilters[$index][$filterName] = $this->filterComponents[$index][$filterName] = $value;
            
        }
        
    }
    public function clearFilterEvent(): void
    {
        $this->setFilterDefaults();
    }
    
    /**
     * Runs on every request, immediately after the component is instantiated, but before any other lifecycle methods are called
     */
    public function boot(): void
    {
        //
    }

    /**
     * Runs on every request, after the component is mounted or hydrated, but before any update methods are called
     */
    public function booted(): void
    {
    }
   
    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        
        return view('thunderbolt-livewire-tables::filter');
    }
}
