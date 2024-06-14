<?php

namespace Conceptlz\ThunderboltLivewireTables;

use Livewire\Component;
use Conceptlz\ThunderboltLivewireTables\Traits\FilterTraits;
use Conceptlz\ThunderboltLivewireTables\DataTableComponent;
use Illuminate\Support\Collection;
use Conceptlz\ThunderboltLivewireTables\Views\Filter;
use Illuminate\Support\Str;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\FilterHelpers;

class FilterPills extends Component
{
    use FilterHelpers;
    public string $tableName = 'table';
    public $slider_down;
    public array $filterGenericData = [];
    public $popover_layout = true;
    public $filterComponents = [];
    public $appliedFilters;
    public $filterConditions = [];
    public \Illuminate\Support\Collection $filters;
    public DataTableComponent $component;
    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'refreshDatatable' => '$refresh',
        'setFilterPill' => 'setFilterPill',
        'clearFilters' => 'clearFilterEvent',
        'resetFilter' => 'resetFilter'
    ];
    
    public function getFilters(): Collection
    {
        if (! isset($this->filterCollection)) {
            $this->filterCollection = $this->filters;
        }

        return $this->filterCollection;

    }
  
    public function setFilterPill(string $filterKey, mixed $value)
    {
        $this->filterComponents[$filterKey] = $value;
        $this->appliedFilters[$filterKey] = $value;
    }
    
    public function updated(string $name, mixed $value): void
    {
        if (Str::contains($name, 'filterComponents')) {
            $filterName = Str::after($name, 'filterComponents.');
            //addApilog('filterName',$filterName);
            if(Str::contains($filterName, '.'))
            {
                $filterName = Str::before($filterName, '.');
               // addApilog('filterName',$filterName);
            }
            $value = (isset($this->filterComponents[$filterName])) ? $this->filterComponents[$filterName] : $value;
            $this->appliedFilters[$filterName] = $value;
            $name = 'filterComponents.'.$filterName;
        }
        $this->dispatch('updateFilters', name: $name , value: $value);
        //addApilog('$this->filterComponents',$this->filterComponents);
       // addApilog('$this->appliedFilters',$this->appliedFilters);
    }

    
    public function setFilterDefaults(): void
    {
        foreach ($this->getFilters() as $filter) {
            if ($filter->isResetByClearButton()) {
                $this->resetFilter($filter);
            }
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
        
        return view('thunderbolt-livewire-tables::filter-pills');
    }
}
