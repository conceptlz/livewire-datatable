<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Filters;

use DateTime;
use Conceptlz\ThunderboltLivewireTables\Views\Filter;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Filters\{HasConfig, IsStringFilter};

class DateTimeFilter extends Filter
{
    use HasConfig,
        IsStringFilter;

    public $type = 'datetime';    

    protected string $view = 'thunderbolt-livewire-tables::components.tools.filters.datetime';

    protected string $configPath = 'thunderbolt-livewire-tables.dateTimeFilter.defaultConfig';

    public function validate(string $value): string|bool
    {
        if (DateTime::createFromFormat('Y-m-d\TH:i', $value) === false) {
            return false;
        }

        return $value;
    }

    public function getFilterPillValue($value): ?string
    {
        if ($this->validate($value)) {
            return DateTime::createFromFormat('Y-m-d\TH:i', $value)->format($this->getConfig('pillFormat'));
        }

        return null;
    }
}
