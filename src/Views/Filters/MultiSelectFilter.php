<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Filters;

use Conceptlz\ThunderboltLivewireTables\Views\Filter;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Filters\{HasOptions,IsArrayFilter};

class MultiSelectFilter extends Filter
{
    use HasOptions,
        IsArrayFilter;
    public $type = 'string';    
    
    protected string $view = 'thunderbolt-livewire-tables::components.tools.filters.multi-select';

    protected string $configPath = 'thunderbolt-livewire-tables.multiSelectFilter.defaultConfig';

    protected string $optionsPath = 'thunderbolt-livewire-tables.multiSelectFilter.defaultOptions';

    public function validate(mixed $value): array|int|string|bool
    {
        if (is_array($value)) {
            foreach ($value as $index => $val) {
                // Remove the bad value
                if (! in_array($val, $this->getKeys())) {
                    unset($value[$index]);
                }
            }
        }

        return $value;
    }

    public function getFilterPillValue($value): ?string
    {
        $values = [];

        foreach ($value as $item) {
            $found = $this->getCustomFilterPillValue($item) ?? $this->getOptions()[$item] ?? null;

            if ($found) {
                $values[] = $found;
            }
        }

        return implode(', ', $values);
    }
}
