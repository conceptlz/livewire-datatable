<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Filters;

use Conceptlz\ThunderboltLivewireTables\Views\Filter;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Filters\{HasOptions,IsArrayFilter};

class MultiSelectDropdownFilter extends Filter
{
    use HasOptions,
        IsArrayFilter;
    public $type = 'string';    
    protected string $view = 'thunderbolt-livewire-tables::components.tools.filters.multi-select-dropdown';

    protected string $configPath = 'thunderbolt-livewire-tables.multiSelectDropdownFilter.defaultConfig';

    protected string $optionsPath = 'thunderbolt-livewire-tables.multiSelectDropdownFilter.defaultOptions';

    public function validate(mixed $value): array|int|string|bool
    {
        if (is_array($value)) {
            foreach ($value as $index => $val) {
                // Remove the bad value
                if (! in_array($val, $this->getKeys())) {
                    unset($value[$index]);
                }
            }

            return $value;
        }

        return (is_string($value) || is_numeric($value)) ? $value : false;
    }

    public function getFilterPillValue($value): ?string
    {
        $values = [];

        foreach ($value as $item) {
            $found = $this->getCustomFilterPillValue($item)
                        ?? collect($this->getOptions())
                            ->mapWithKeys(fn ($options, $optgroupLabel) => is_iterable($options) ? $options : [$optgroupLabel => $options])[$item]
                        ?? null;

            if ($found) {
                $values[] = $found;
            }
        }

        return implode(', ', $values);
    }

    public function isEmpty($value): bool
    {
        if (! is_array($value)) {
            return true;
        } elseif (in_array('all', $value)) {
            return true;
        }

        return false;
    }
}
