<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Conceptlz\ThunderboltLivewireTables\Exceptions\DataTableConfigurationException;
use Conceptlz\ThunderboltLivewireTables\Traits\Configuration\ComponentConfiguration;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\ComponentHelpers;

trait ComponentUtilities
{
    use ComponentConfiguration,
        ComponentHelpers;

    public array $table = [];

    public ?string $theme = null;

    protected Builder $builder;

    protected $model;

    protected ?string $primaryKey;

    protected array $relationships = [];

    protected string $tableName = 'table';

    protected ?string $dataTableFingerprint;

    protected bool $offlineIndicatorStatus = true;

    protected bool $eagerLoadAllRelationsStatus = false;

    protected string $emptyMessage = 'No items found. Try to broaden your search.';

    protected array $additionalSelects = [];

    /**
     * Set any configuration options
     */
    abstract public function configure(): void;

    /**
     * Sets the Theme if not set on first mount
     */
    public function mountComponentUtilities(): void
    {
        // Sets the Theme - tailwind/bootstrap
        if (is_null($this->theme)) {
            $this->setTheme();
        }
    }

    /**
     * Runs configure() with Lifecycle Hooks on each Lifecycle
     */
    public function bootedComponentUtilities(): void
    {addApiLog('bootedComponentUtilities','bootedComponentUtilities');
        // Fire Lifecycle Hooks for configuring
        $this->callHook('configuring');
        $this->callTraitHook('configuring');

        // Call the configure() method
        $this->configure();

        // Fire Lifecycle Hooks for configured
        $this->callHook('configured');
        $this->callTraitHook('configured');

        // Make sure a primary key is set
        if (! $this->hasPrimaryKey()) {
            throw new DataTableConfigurationException('You must set a primary key using setPrimaryKey in the configure method.');
        }

    }

    /**
     * Returns a unique id for the table, used as an alias to identify one table from another session and query string to prevent conflicts
     */
    protected function generateDataTableFingerprint(): string
    {
        $className = str_split(static::class);
        $crc32 = sprintf('%u', crc32(serialize($className)));

        return base_convert($crc32, 10, 36);
    }

    /**
     * Keep track of any properties on the custom query string key for this specific table
     */
    public function updated(string $name, string|array $value): void
    {
        addApiLog('updated',$name);
        if ($name === 'search') {
            $this->resetComputedPage();

            // Clear bulk actions on search
            $this->clearSelected();
            $this->setSelectAllDisabled();

            if ($value === '') {
                $this->clearSearch();
            }
        }

        if (Str::contains($name, 'filterComponents')) {
            $this->resetComputedPage();

            // Clear bulk actions on filter
            $this->clearSelected();
            $this->setSelectAllDisabled();

            // Clear filters on empty value
            $filterName = Str::after($name, 'filterComponents.');
            $filter = $this->getFilterByKey($filterName);

            if ($filter && $filter->isEmpty($value)) {
                $this->resetFilter($filterName);
            }else{
                //addApilog('filterName',$filterName);
                //$this->setFilter($filterName,$value);
                //addApilog('$this->filterComponents',$this->filterComponents);
                $this->appliedFilters = $this->filterComponents;
            }
        }

        if (Str::contains($name, 'filterConditions')) {
            $this->resetComputedPage();

            // Clear bulk actions on filter
            $this->clearSelected();
            $this->setSelectAllDisabled();

            // Clear filters on empty value
            $filterName = Str::after($name, 'filterConditions.');
            $filter = $this->getFilterByKey($filterName);
            $value = $this->filterComponents[$filterName];
            if ($filter && $filter->isEmpty($value)) {
                $this->resetFilter($filterName);
            }else{
                $this->appliedFilters = $this->filterComponents;
            }
        }

    }

    /**
     * 1. After the sorting method is hit we need to tell the table to go back into reordering mode
     */
    public function hydrate(): void
    {
        $this->restartReorderingIfNecessary();
    }
}
