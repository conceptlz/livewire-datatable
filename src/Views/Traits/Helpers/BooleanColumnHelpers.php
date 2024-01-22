<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Traits\Helpers;

use Closure;

trait BooleanColumnHelpers
{
    public function getSuccessValue(): bool
    {
        return $this->successValue;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
