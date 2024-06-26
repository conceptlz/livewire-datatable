<?php

namespace Conceptlz\ThunderboltLivewireTables\DataTransferObjects;

use Conceptlz\ThunderboltLivewireTables\DataTableComponent;

class DebuggableData
{
    public DataTableComponent $component;

    public function __construct(DataTableComponent $component)
    {
        $this->component = $component;
    }

    public function toArray(): array
    {
        return [
            'query' => (clone $this->component->getBuilder())->toSql(),
            'filters' => $this->component->getAppliedFiltersWithValues(),
            'sorts' => $this->component->getSorts(),
            'search' => $this->component->getSearch(),
            'select-all' => $this->component->getSelectAllStatus(),
            'selected' => $this->component->getSelected(),
        ];
    }
}
