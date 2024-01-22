<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Traits\Columns;

use Closure;
use Conceptlz\ThunderboltLivewireTables\DataTableComponent;
use Conceptlz\ThunderboltLivewireTables\Views\{Column,Filter};

trait IsSearchable
{
    protected bool $searchable = false;

    protected mixed $searchCallback = null;

    public function getSearchCallback(): ?callable
    {
        return $this->searchCallback;
    }

    public function isSearchable(): bool
    {
        return $this->hasField() && $this->searchable === true;
    }

    public function hasSearchCallback(): bool
    {
        return $this->searchCallback !== null;
    }

    public function searchable(?callable $callback = null): self
    {
        $this->searchable = true;

        $this->searchCallback = $callback;

        return $this;
    }
}
