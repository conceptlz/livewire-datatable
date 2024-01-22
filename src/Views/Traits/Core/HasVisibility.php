<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Traits\Core;

use Conceptlz\ThunderboltLivewireTables\Exceptions\DataTableConfigurationException;
use Conceptlz\ThunderboltLivewireTables\Views\{Column,Filter};

trait HasVisibility
{
    protected bool $hiddenFromMenus = false;

    protected bool $hiddenFromPills = false;

    public function isHiddenFromMenus(): bool
    {
        return $this->hiddenFromMenus === true;
    }

    public function isVisibleInMenus(): bool
    {
        return $this->hiddenFromMenus === false;
    }

    public function isHiddenFromPills(): bool
    {
        return $this->hiddenFromPills === true;
    }

    public function isVisibleInPills(): bool
    {
        return $this->hiddenFromPills === false;
    }

    public function hiddenFromMenus(): self
    {
        $this->hiddenFromMenus = true;

        return $this;
    }

    public function hiddenFromPills(): self
    {
        $this->hiddenFromPills = true;

        return $this;
    }

    public function hiddenFromAll(): self
    {
        $this->hiddenFromMenus = true;
        $this->hiddenFromPills = true;

        return $this;
    }
}
