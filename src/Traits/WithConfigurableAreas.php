<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;

use Conceptlz\ThunderboltLivewireTables\Traits\Configuration\ConfigurableAreasConfiguration;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\ConfigurableAreasHelpers;

trait WithConfigurableAreas
{
    use ConfigurableAreasConfiguration,
        ConfigurableAreasHelpers;

    protected bool $hideConfigurableAreasWhenReorderingStatus = true;

    protected array $configurableAreas = [
        'before-tools' => null,
        'toolbar-left-start' => null,
        'toolbar-left-end' => null,
        'toolbar-right-start' => null,
        'toolbar-right-end' => null,
        'before-toolbar' => null,
        'after-toolbar' => null,
        'before-pagination' => null,
        'after-pagination' => null,
    ];
}
