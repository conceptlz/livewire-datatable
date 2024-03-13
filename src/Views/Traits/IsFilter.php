<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Traits;

use Conceptlz\ThunderboltLivewireTables\Views\Traits\Configuration\FilterConfiguration;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Core\{HasConfig,HasView};
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Filters\{HasCustomPosition,HasVisibility};
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Helpers\FilterHelpers;

trait IsFilter
{
    use FilterConfiguration,
        FilterHelpers,
        HasConfig,
        HasCustomPosition,
        HasVisibility,
        HasView;

    public  $type;

    public  $with_operand = true;
    
    public $relation_key;
    
    protected string $name;

    protected string $key;

    protected bool $resetByClearButton = true;

    protected mixed $filterCallback = null;

    protected ?string $filterPillTitle = null;

    protected array $filterPillValues = [];

    protected ?string $filterCustomLabel = null;

    protected array $filterLabelAttributes = [];

    protected ?string $filterCustomPillBlade = null;

    protected mixed $filterDefaultValue = null;

    public array $genericDisplayData = [];
}
