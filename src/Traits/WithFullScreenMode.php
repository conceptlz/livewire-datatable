<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;

use Conceptlz\ThunderboltLivewireTables\Traits\Configuration\FullScreenModeConfiguration;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\FullScreenHelpers;

trait WithFullScreenMode
{
    use FullScreenModeConfiguration,
    FullScreenHelpers;

    /**
     * Dump table properties for debugging
     */
    protected bool $fullScreenMode = false;
}
