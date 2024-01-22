<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Traits\Core;

use Closure;
use Conceptlz\ThunderboltLivewireTables\Views\{Column,Filter};

trait HasTitleCallback
{
    protected mixed $titleCallback = null;

    // TODO: Test
    public function title(callable $callback): self
    {
        $this->titleCallback = $callback;

        return $this;
    }

    // TODO: Test
    public function getTitleCallback(): ?callable
    {
        return $this->titleCallback;
    }

    public function hasTitleCallback(): bool
    {
        return $this->titleCallback !== null;
    }
}
