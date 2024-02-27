<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits\Configuration;

trait FullScreenModeConfiguration
{
    public function setfullScreenMode(bool $status): self
    {
        $this->fullScreenMode = $status;

        return $this;
    }

    public function setFullScreenModeEnabled(): self
    {
        $this->setfullScreenMode(true);

        return $this;
    }

    public function setFullScreenModeDisabled(): self
    {
        $this->setfullScreenMode(false);

        return $this;
    }
}
