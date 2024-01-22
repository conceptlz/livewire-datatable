<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Columns;

use Illuminate\Database\Eloquent\Model;
use Conceptlz\ThunderboltLivewireTables\Views\Column;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Configuration\ButtonGroupColumnConfiguration;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Helpers\ButtonGroupColumnHelpers;

class ButtonGroupColumn extends Column
{
    use ButtonGroupColumnConfiguration,
        ButtonGroupColumnHelpers;

    protected array $buttons = [];

    protected string $view = 'livewire-tables::includes.columns.button-group';

    public function __construct(string $title, ?string $from = null)
    {
        parent::__construct($title, $from);

        $this->label(fn () => null);
    }

    public function getContents(Model $row): null|string|\Illuminate\Support\HtmlString|\Conceptlz\ThunderboltLivewireTables\Exceptions\DataTableConfigurationException|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view($this->getView())
            ->withColumn($this)
            ->withRow($row)
            ->withButtons($this->getButtons())
            ->withAttributes($this->hasAttributesCallback() ? app()->call($this->getAttributesCallback(), ['row' => $row]) : []);
    }
}
