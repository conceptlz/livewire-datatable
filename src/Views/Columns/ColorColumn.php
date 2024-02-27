<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Columns;

use Illuminate\Database\Eloquent\Model;
use Conceptlz\ThunderboltLivewireTables\Exceptions\DataTableConfigurationException;
use Conceptlz\ThunderboltLivewireTables\Views\Column;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Columns\HasDefaultStringValue;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Configuration\ColorColumnConfiguration;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Helpers\ColorColumnHelpers;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\IsColumn;

class ColorColumn extends Column
{
    use IsColumn;
    use ColorColumnConfiguration,
        ColorColumnHelpers;
    use HasDefaultStringValue;

    public ?object $colorCallback = null;

    protected string $view = 'thunderbolt-livewire-tables::includes.columns.color';

    public function __construct(string $title, ?string $from = null)
    {
        parent::__construct($title, $from);
        if (! isset($from)) {
            $this->label(fn () => null);
        }

    }

    public function getContents(Model $row): null|string|\Illuminate\Support\HtmlString|DataTableConfigurationException|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view($this->getView())
            ->withIsTailwind($this->getComponent()->isTailwind())
            ->withIsBootstrap($this->getComponent()->isBootstrap())
            ->withColor($this->getColor($row))
            ->withAttributeBag($this->getAttributeBag($row));
    }

    public function getValue(Model $row): string
    {
        return parent::getValue($row) ?? $this->getDefaultValue();
    }
}
