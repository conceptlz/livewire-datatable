<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;

use Conceptlz\ThunderboltLivewireTables\Traits\Configuration\DebuggingConfiguration;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\DebugHelpers;

trait WithDebugging
{
    use DebuggingConfiguration,
        DebugHelpers;

    /**
     * Dump table properties for debugging
     */
    protected bool $debugStatus = false;
}
