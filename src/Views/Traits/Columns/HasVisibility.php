<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Traits\Columns;

use Conceptlz\ThunderboltLivewireTables\Views\Column;

trait HasVisibility
{
    protected bool $hidden = false;

    public function isVisible(): bool
    {
        return $this->hidden !== true;
    }

    public function isHidden(): bool
    {
        return $this->hidden === true;
    }

    /**
     * @param  mixed  $condition
     */
    public function hideIf($condition): self
    {
        $this->hidden = $condition;

        return $this;
    }
}
