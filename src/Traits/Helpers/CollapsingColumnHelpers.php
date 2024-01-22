<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits\Helpers;

trait CollapsingColumnHelpers
{
    public function getCollapsingColumnsStatus(): bool
    {
        return $this->collapsingColumnsStatus;
    }

    public function hasCollapsingColumns(): bool
    {
        return $this->getCollapsingColumnsStatus() === true;
    }

    public function collapsingColumnsAreEnabled(): bool
    {
        return $this->getCollapsingColumnsStatus() === true;
    }

    public function collapsingColumnsAreDisabled(): bool
    {
        return $this->getCollapsingColumnsStatus() === false;
    }
}
