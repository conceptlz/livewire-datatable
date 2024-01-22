<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Traits\Helpers;

use Conceptlz\ThunderboltLivewireTables\Views\Columns\LinkColumn;

trait ButtonGroupColumnHelpers
{
    public function getButtons(): array
    {
        return collect($this->buttons)
            ->reject(fn ($button) => ! $button instanceof LinkColumn)
            ->toArray();
    }
}
