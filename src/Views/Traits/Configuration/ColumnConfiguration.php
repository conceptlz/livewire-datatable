<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Traits\Configuration;

use Conceptlz\ThunderboltLivewireTables\DataTableComponent;
use Conceptlz\ThunderboltLivewireTables\Views\Column;

trait ColumnConfiguration
{
    public function setComponent(DataTableComponent $component): self
    {
        $this->component = $component;

        return $this;
    }

    public function label(callable $callback): self
    {
        $this->from = null;
        $this->field = null;
        $this->labelCallback = $callback;

        return $this;
    }

    public function format(callable $callable): Column
    {
        $this->formatCallback = $callable;

        return $this;
    }

    public function html(): self
    {
        $this->html = true;

        return $this;
    }

    public function setTable(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    public function eagerLoadRelations(): self
    {
        $this->eagerLoadRelations = true;

        return $this;
    }

    public function unclickable(): self
    {
        $this->clickable = false;

        return $this;
    }

    public function setCustomSlug(string $customSlug): self
    {
        $this->customSlug = $customSlug;

        return $this;
    }

    public function setColumnLabelStatusDisabled(): self
    {
        $this->setColumnLabelStatus(false);

        return $this;
    }

    public function setColumnLabelStatusEnabled(): self
    {
        $this->setColumnLabelStatus(true);

        return $this;
    }

    public function setColumnLabelStatus(bool $status): void
    {
        $this->displayColumnLabel = $status;
    }

    public function exportCallback(callable $callable): Column
    {
        $this->exportCallback = $callable;

        return $this;
    }
    public function excludeFromExport(): Column
    {
        $this->preventExport = true;

        return $this;
    }

    
}
