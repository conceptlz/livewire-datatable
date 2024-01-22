<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Filters;

use DateTime;
use Conceptlz\ThunderboltLivewireTables\Views\Filter;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Filters\{HasConfig, IsStringFilter};

class DateFilter extends Filter
{
    use HasConfig,
        IsStringFilter;

    protected string $view = 'livewire-tables::components.tools.filters.date';

    protected string $configPath = 'livewire-tables.dateFilter.defaultConfig';

    public function validate(string $value): string|bool
    {
        if (DateTime::createFromFormat('Y-m-d', $value) === false) {
            return false;
        }

        return $value;
    }

    public function getFilterPillValue($value): ?string
    {
        if ($this->validate($value)) {
            return DateTime::createFromFormat('Y-m-d', $value)->format($this->getConfig('pillFormat'));
        }

        return null;
    }
}
