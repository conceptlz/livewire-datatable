<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Filters;

use Conceptlz\ThunderboltLivewireTables\Views\Filter;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Filters\{IsStringFilter};

class TextFilter extends Filter
{
    use IsStringFilter;

    public $type = 'string';   
     
    protected string $view = 'thunderbolt-livewire-tables::components.tools.filters.text-field';

    public function validate(mixed $value): string|bool
    {
        if ($this->hasConfig('maxlength')) {
            return strlen($value) <= $this->getConfig('maxlength') ? $value : false;
        }

        return strlen($value) ? $value : false;
    }
}
