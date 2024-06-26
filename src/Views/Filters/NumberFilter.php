<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Filters;

use Conceptlz\ThunderboltLivewireTables\Views\Filter;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Filters\{IsStringFilter};

class NumberFilter extends Filter
{
    use IsStringFilter;
    
    public $type = 'number';

    protected string $view = 'thunderbolt-livewire-tables::components.tools.filters.number';

    public function validate(mixed $value): float|int|bool
    {
        return is_numeric($value) ? $value : false;
    }
}
