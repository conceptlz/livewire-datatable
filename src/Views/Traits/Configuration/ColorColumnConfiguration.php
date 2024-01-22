<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Traits\Configuration;

use Conceptlz\ThunderboltLivewireTables\Views\Traits\Columns;

trait ColorColumnConfiguration
{
    public function color(callable $callback): self
    {
        $this->colorCallback = $callback;

        return $this;
    }
}
