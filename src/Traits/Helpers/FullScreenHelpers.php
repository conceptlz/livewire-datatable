<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits\Helpers;

trait FullScreenHelpers
{
    public function getFullScreenMode(): bool
    {
        return $this->fullScreenMode;
    }

    public function fullScreenmodeIsEnabled(): bool
    {
        return $this->getFullScreenMode() === true;
    }

    public function fullScreenmodeIsDisabled(): bool
    {
        return $this->getFullScreenMode() === false;
    }
}
