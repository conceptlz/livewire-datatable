@aware(['component', 'tableName','columnCount'])
@props(['column', 'index'])

@php
    $attributes = $attributes->merge(['wire:key' => $tableName . '-header-col-'.$column->getSlug()]);
    $customAttributes = $component->getThAttributes($column);
    $customSortButtonAttributes = $component->getThSortButtonAttributes($column);
    $direction = $column->hasField() ? $component->getSort($column->getColumnSelectName()) : $component->getSort($column->getSlug()) ?? null ;
    $th_class = ($columnCount == $index) ? 'relative py-4 pl-3 pr-4 sm:pr-6 bg-gray-100 shadow-[inset_1px_-1px_rgba(0,0,0,0.1)] shadow-gray-200 min-w-min w-full justify-end' : 'text-left';
@endphp
<th scope="col" {{
        $attributes->merge($customAttributes)
            ->class([$th_class => $customAttributes['default'] ?? true])
            ->class(['hidden' => $column->shouldCollapseAlways()])
            ->class(['hidden md:table-cell' => $column->shouldCollapseOnMobile()])
            ->class(['hidden lg:table-cell' => $column->shouldCollapseOnTablet()])
            ->except('default')
        }}
    >
        @if($column->getColumnLabelStatus())
            @unless ($component->sortingIsEnabled() && ($column->isSortable() || $column->getSortCallback()))

                <button
                    
                    {{
                        $attributes->merge($customSortButtonAttributes)
                            ->class(['text-sm font-semibold py-2.5 whitespace-nowrap group flex items-center justify-between space-x-4 w-full' => $customSortButtonAttributes['default'] ?? true])
                            ->except(['default', 'wire:key'])
                    }}
                >
                    <span>{{ $column->getTitle() }}</span>

                </button>
            @else
                <button
                    wire:click="sortBy('{{ ($column->isSortable() ? $column->getColumnSelectName() : $column->getSlug()) }}')"
                    {{
                        $attributes->merge($customSortButtonAttributes)
                            ->class(['text-sm font-semibold py-2.5 whitespace-nowrap group flex items-center justify-between space-x-4 w-full' => $customSortButtonAttributes['default'] ?? true])
                            ->except(['default', 'wire:key'])
                    }}
                >
                    <span>{{ $column->getTitle() }}</span>

                    <span class="relative flex items-center">
                        @if ($direction === 'asc')
                            <x-heroicon-o-chevron-up class="w-5 h-5 text-gray-200 group-hover:opacity-0" />
                            <x-heroicon-o-chevron-down class="w-5 h-5 text-gray-200 opacity-0 group-hover:opacity-100 absolute"/>
                        @elseif ($direction === 'desc')
                            <x-heroicon-o-chevron-down class="w-5 h-5 text-gray-200 group-hover:opacity-0" />
                            <x-heroicon-o-x-circle class="w-5 h-5 text-gray-200 opacity-0 group-hover:opacity-100 absolute"/>
                        @else
                            <x-heroicon-o-chevron-up class="w-5 h-5 text-gray-200 opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
                        @endif
                    </span>
                </button>
            @endunless
        @endif
</th>
