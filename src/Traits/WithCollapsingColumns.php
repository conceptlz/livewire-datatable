<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;

use Conceptlz\ThunderboltLivewireTables\Traits\Configuration\CollapsingColumnConfiguration;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\CollapsingColumnHelpers;

trait WithCollapsingColumns
{
    use CollapsingColumnConfiguration;
    use CollapsingColumnHelpers;

    protected bool $collapsingColumnsStatus = true;
}
