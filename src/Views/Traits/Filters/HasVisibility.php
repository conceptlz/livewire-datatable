<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Traits\Filters;

use Conceptlz\ThunderboltLivewireTables\Views\Traits\Core\HasVisibility as HasCoreVisibility;
use Conceptlz\ThunderboltLivewireTables\Views\{Column,Filter};

trait HasVisibility
{
    use HasCoreVisibility;

    protected bool $hiddenFromFilterCount = false;

    public function isHiddenFromFilterCount(): bool
    {
        return $this->hiddenFromFilterCount === true;
    }

    public function isVisibleInFilterCount(): bool
    {
        return $this->hiddenFromFilterCount === false;
    }

    public function hiddenFromFilterCount(): self
    {
        $this->hiddenFromFilterCount = true;

        return $this;
    }

    public function hiddenFromAll(): self
    {
        $this->hiddenFromMenus = true;
        $this->hiddenFromPills = true;
        $this->hiddenFromFilterCount = true;

        return $this;
    }
}
