<?php

namespace Conceptlz\ThunderboltLivewireTables;

use Livewire\Component;
use Conceptlz\ThunderboltLivewireTables\Traits\FilterTraits;
use Conceptlz\ThunderboltLivewireTables\DataTableComponent;
use Illuminate\Support\Collection;
use Conceptlz\ThunderboltLivewireTables\Views\Filter;
use Illuminate\Support\Str;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\FilterHelpers;
use Illuminate\Support\Arr;
use Conceptlz\ThunderboltLivewireTables\Traits\WithQueryString;
class FilterPills extends Component
{
    use FilterHelpers;
    
    public string $tableName = 'table';
    public $slider_down;
    public array $filterGenericData = [];
    public $popover_layout = true;
    public $filterComponents = [];
    public $appliedFilters;
    public $queryStringStatus = false;
    public $queryStringAlias = '';
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
    protected function queryString(): array
    {
        if ($this->queryStringStatus) {
            return [
                'filterConditions' => ['except' => null, 'history' => false, 'keep' => false, 'as' => $this->queryStringAlias.'-filters-conditions'],
            ];
        }

        return [];
    }
    public function getFilters(): Collection
    {
        if (! isset($this->filterCollection)) {
            $this->filterCollection = $this->filters;
        }
        //addApilog('$this->appliedFiltersdd',$this->appliedFilters);
        //addApilog('$this->filterComponentsdd',$this->filterComponents);
        return $this->filterCollection;

    }
  
    public function setFilterPill(string $filterKey, mixed $value)
    {
        $this->filterComponents[][$filterKey] = $value;
        $this->appliedFilters[][$filterKey] = $value;
        $this->filterConditions[][$filterKey] = 'is';
       
    }
    
    public function updated(string $name, mixed $value): void
    {
        //addApilog('$name',$name);
       // addApilog('$value',$value);
        if (Str::contains($name, 'filterComponents')) {
            $dot_count = substr_count($name,'.');
            $filterName = Str::after($name, 'filterComponents.');
            //addApilog('filterName',$filterName);
            $index = 0;
            if(Str::contains($filterName, '.') && $dot_count > 2)
            {
                $strs = explode(".",$filterName);
                //addApilog('strs',$strs);
                $index = $strs[0];
                $filterName = $strs[1];
               // addApilog('filterName',$filterName);
            }
            elseif(Str::contains($filterName, '.') && $dot_count == 2)
            {
                $index = ($dot_count == 2) ? Str::before($filterName, '.') : Str::after($filterName, '.');
                $filterName = Str::after($filterName, '.');
               // addApilog('filterName',$filterName);
            }else{
                $index = Str::after($filterName, '.');
                if(is_array($value) && count($value) == 1)
                {
                    $filterName = array_key_first($value);
                    $value = Arr::first($value);
                }
                
            }
        
            //addApilog('index',$index);
            //addApilog('filterName',$filterName);
            $value = (isset($this->filterComponents[$index][$filterName])) ? $this->filterComponents[$index][$filterName] : $value;
            $this->appliedFilters[$index][$filterName] = $value;
            $name = 'filterComponents.'.$index . '.'.$filterName;
           
        }elseif(Str::contains($name, 'filterConditions'))
        {
            $dot_count = substr_count($name,'.');
            $filterName = Str::after($name, 'filterConditions.');

            $index = 0;
            
            if(Str::contains($filterName, '.') && $dot_count == 2)
            {
                $index = ($dot_count == 2) ? Str::before($filterName, '.') : Str::after($filterName, '.');
                $filterName = Str::after($filterName, '.');
               // addApilog('filterName',$filterName);
            }else{
                $index = Str::after($filterName, '.');
                if(is_array($value) && count($value) == 1)
                {
                    $filterName = array_key_first($value);
                    $value = Arr::first($value);
                }
                
            }
        
           // addApilog('index',$index);
            //addApilog('filterName',$filterName);
            $value = (isset($this->filterConditions[$index][$filterName])) ? $this->filterConditions[$index][$filterName] : $value;
            $name = 'filterConditions.'.$index . '.'.$filterName;
        }
        //addApilog('$name',$name);
        //addApilog('$value',$value);
        $this->dispatch('updateFilters', name: $name , value: $value);
       // addApilog('$this->filterComponents',$this->filterComponents);
       // addApilog('$this->appliedFilters',$this->appliedFilters);
    }

    
    public function setFilterDefaults(): void
    {
        foreach ($this->getFilters() as $filter) {
            if ($filter->isResetByClearButton()) {
                $this->resetFilter($filter,'');
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
