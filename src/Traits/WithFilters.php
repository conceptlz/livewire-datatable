<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;

use Illuminate\Database\Eloquent\Builder;
use Conceptlz\ThunderboltLivewireTables\Traits\Configuration\FilterConfiguration;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\FilterHelpers;

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

    public function applyFilters(): Builder
    {
        if ($this->filtersAreEnabled() && $this->hasFilters() && $this->hasAppliedFiltersWithValues()) {
            foreach ($this->getFilters() as $filter) {
                foreach ($this->getAppliedFiltersWithValues() as $key => $value) {
                    if ($filter->getKey() === $key && $filter->hasFilterCallback()) {
                        // Let the filter class validate the value
                        $value = $filter->validate($value);

                        if ($value === false) {
                            continue;
                        }

                        ($filter->getFilterCallback())($this->getBuilder(), $value);
                    }
                }
            }
        }

        return $this->getBuilder();
    }
}
