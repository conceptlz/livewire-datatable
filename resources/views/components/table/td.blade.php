@aware(['component', 'row', 'rowIndex', 'tableName','columnCount'])
@props(['column', 'colIndex'])

@php
    $customAttributes = $component->getTdAttributes($column, $row, $colIndex, $rowIndex);
    $td_class = ($columnCount == $colIndex) ? 'whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-3 flex items-center space-x-4' : 'whitespace-nowrap min-w-min';
@endphp

<td wire:key="{{ $tableName . '-table-td-'.$row->{$this->getPrimaryKey()}.'-'.$column->getSlug() }}"
    @if ($column->isClickable())
        @if($component->getTableRowUrlTarget($row) === "navigate") wire:navigate href="{{ $component->getTableRowUrl($row) }}"
        @else onclick="window.open('{{ $component->getTableRowUrl($row) }}', '{{ $component->getTableRowUrlTarget($row) ?? '_self' }}')"
        @endif
    @endif
        {{
            $attributes->merge($customAttributes)
                ->class([$td_class => $component->isTailwind() && ($customAttributes['default'] ?? true)])
                ->class(['hidden' =>  $component->isTailwind() && $column && $column->shouldCollapseAlways()])
                ->class(['hidden sm:table-cell' => $component->isTailwind() && $column && $column->shouldCollapseOnMobile()])
                ->class(['hidden md:table-cell' => $component->isTailwind() && $column && $column->shouldCollapseOnTablet()])
                ->class(['' => $component->isBootstrap() && ($customAttributes['default'] ?? true)])
                ->class(['d-none' => $component->isBootstrap() && $column && $column->shouldCollapseAlways()])
                ->class(['d-none d-sm-table-cell' => $component->isBootstrap() && $column && $column->shouldCollapseOnMobile()])
                ->class(['d-none d-md-table-cell' => $component->isBootstrap() && $column && $column->shouldCollapseOnTablet()])
                ->style(['cursor:pointer' => $component->isBootstrap()])
                ->except('default')
        }}
    >
        {{ $slot }}
</td>
