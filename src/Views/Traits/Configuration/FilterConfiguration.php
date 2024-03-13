<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Traits\Configuration;

use Conceptlz\ThunderboltLivewireTables\Views\Filter;

trait FilterConfiguration
{
    public function setFilterPillTitle(string $title): self
    {
        $this->filterPillTitle = $title;

        return $this;
    }

    /**
     * @param  array<mixed>  $values
     */
    public function setFilterPillValues(array $values): self
    {
        $this->filterPillValues = $values;

        return $this;
    }

    public function notResetByClearButton(): self
    {
        $this->resetByClearButton = false;

        return $this;
    }

    public function setCustomFilterLabel(string $filterCustomLabel): self
    {
        $this->filterCustomLabel = $filterCustomLabel;

        return $this;
    }

    public function setFilterPillBlade(string $blade): self
    {
        $this->filterCustomPillBlade = $blade;

        return $this;
    }

    /**
     * Sets a Default Value via the Filter Component
     *
     * @param  mixed  $value
     */
    public function setFilterDefaultValue($value): self
    {
        $this->filterDefaultValue = $value;

        return $this;
    }

    public function setFilterLabelAttributes(array $filterLabelAttributes): self
    {
        $this->filterLabelAttributes = [...['default' => false], ...$filterLabelAttributes];

        return $this;
    }

    public function setGenericDisplayData(array $genericDisplayData = []): self
    {
        $this->genericDisplayData = [
            'filterLayout' => $genericDisplayData['filterLayout'],
            'tableName' => $genericDisplayData['tableName'],
            'isTailwind' => $genericDisplayData['isTailwind'],
            'isBootstrap' => ($genericDisplayData['isBootstrap4'] || $genericDisplayData['isBootstrap5']),
            'isBootstrap4' => $genericDisplayData['isBootstrap4'],
            'isBootstrap5' => $genericDisplayData['isBootstrap5'],
        ];

        return $this;
    }

    public function setFilterWithOperand(bool $status): self
    {
        $this->with_operand = $status;
        return $this;
    }

    public function setFilterRelationKey(string $key_name): self
    {
        $this->relation_key = $key_name;
        return $this;
    }
}
