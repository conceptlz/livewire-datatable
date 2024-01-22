<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;

use Conceptlz\ThunderboltLivewireTables\Traits\Configuration\SecondaryHeaderConfiguration;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\SecondaryHeaderHelpers;

trait WithSecondaryHeader
{
    use SecondaryHeaderConfiguration,
        SecondaryHeaderHelpers;

    protected bool $secondaryHeaderStatus = true;

    protected bool $columnsWithSecondaryHeader = false;

    protected $secondaryHeaderTrAttributesCallback;

    protected $secondaryHeaderTdAttributesCallback;

    public function bootedWithSecondaryHeader(): void
    {
        $this->setupSecondaryHeader();
    }

    public function setupSecondaryHeader(): void
    {
        foreach ($this->getColumns() as $column) {
            if ($column->hasSecondaryHeader()) {
                $this->columnsWithSecondaryHeader = true;
            }
        }
    }
}
