<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Traits;

use Livewire\Attributes\Modelable;

trait IsExternalFilter
{
    #[Modelable]
    public $value = '';

    public $filterKey = '';
}
