<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Filters;

use Conceptlz\ThunderboltLivewireTables\Views\Filter;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Filters\{HasOptions,IsStringFilter};

class SelectFilter extends Filter
{
    use HasOptions,
        IsStringFilter;
        
    public $type = 'select';    
    protected string $view = 'thunderbolt-livewire-tables::components.tools.filters.select';

    protected string $configPath = 'thunderbolt-livewire-tables.selectFilter.defaultConfig';

    protected string $optionsPath = 'thunderbolt-livewire-tables.selectFilter.defaultOptions';

    public function getKeys(): array
    {
        return collect($this->getOptions())
            ->map(fn ($value, $key) => is_iterable($value) ? collect($value)->keys() : $key)
            ->flatten()
            ->map(fn ($value) => (string) $value)
            ->filter(fn ($value) => strlen($value) > 0)
            ->values()
            ->toArray();
    }

    public function validate(mixed $value): array|string|bool
    {
        if (! in_array($value, $this->getKeys())) {
            return false;
        }

        return $value;
    }

    public function getFilterPillValue($value): ?string
    {
        return $this->getCustomFilterPillValue($value)
            ?? collect($this->getOptions())
                ->mapWithKeys(fn ($options, $optgroupLabel) => is_iterable($options) ? $options : [$optgroupLabel => $options])[$value]
            ?? null;
    }
}
