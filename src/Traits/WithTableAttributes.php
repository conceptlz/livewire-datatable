<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;

use Closure;
use Conceptlz\ThunderboltLivewireTables\Traits\Configuration\TableAttributeConfiguration;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\TableAttributeHelpers;

trait WithTableAttributes
{
    use TableAttributeConfiguration,
        TableAttributeHelpers;

    protected array $componentWrapperAttributes = [];

    protected array $tableWrapperAttributes = [];

    protected array $tableAttributes = [];

    protected array $theadAttributes = [];

    protected array $tbodyAttributes = [];

    protected $thAttributesCallback;

    protected $thSortButtonAttributesCallback;

    protected $trAttributesCallback;

    protected $tdAttributesCallback;

    protected $trUrlCallback;

    protected $trUrlTargetCallback;
}
