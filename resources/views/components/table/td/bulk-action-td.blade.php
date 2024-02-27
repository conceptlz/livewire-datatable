@aware(['component', 'rowIndex', 'rowID'])
@props(['column' => null, 'customAttributes' => [], 'displayMinimisedOnReorder' => false, 'hideUntilReorder' => false])

<td {{ $attributes
        ->merge($customAttributes)
        ->class(['relative h-[60px]' => $customAttributes['default'] ?? true])
        ->class(['d-none' => $column && $column->shouldCollapseAlways()])
        ->class(['d-none d-sm-table-cell' => $column && $column->shouldCollapseOnMobile()])
        ->class(['d-none d-md-table-cell' => $column && $column->shouldCollapseOnTablet()])
        ->except('default')
    }}>
        {{ $slot }}
</td>
