<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Traits;

use Conceptlz\ThunderboltLivewireTables\DataTableComponent;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Columns\{HasVisibility, IsCollapsible, IsSearchable, IsSelectable, IsSortable};
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Configuration\ColumnConfiguration;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Core\{HasAttributes,HasFooter,HasSecondaryHeader,HasView};
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Helpers\{ColumnHelpers,RelationshipHelpers};

trait IsColumn
{
    use ColumnConfiguration,
        ColumnHelpers,
        RelationshipHelpers,
        IsCollapsible,
        IsSearchable,
        IsSelectable,
        IsSortable,
        HasAttributes,
        HasFooter,
        HasSecondaryHeader,
        HasView,
        HasVisibility;

    protected ?DataTableComponent $component = null;

    // What displays in the columns header
    protected string $title;

    // Act as a unique identifier for the column
    protected string $hash;

    // The columns or relationship location: i.e. name, or address.group.name
    protected ?string $from = null;

    // The underlying columns name: i.e. name
    protected ?string $field = null;

    // The table of the columns or relationship
    protected ?string $table = null;

    // An array of relationships: i.e. address.group.name => ['address', 'group']
    protected array $relations = [];

    protected bool $eagerLoadRelations = false;

    protected mixed $formatCallback = null;

    protected bool $html = false;

    protected mixed $labelCallback = null;

    protected bool $clickable = true;

    protected ?string $customSlug = null;
}
