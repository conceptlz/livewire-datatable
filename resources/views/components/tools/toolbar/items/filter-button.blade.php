@aware(['component', 'tableName'])
@props(['filterGenericData'])

<div x-cloak x-show="!currentlyReorderingStatus" >
    <div
        @if ($component->isFilterLayoutPopover())
            x-data="{ filterPopoverOpen: false }"
            x-on:keydown.escape.stop="if (!this.childElementOpen) { filterPopoverOpen = false }"
            x-on:mousedown.away="if (!this.childElementOpen) { filterPopoverOpen = false }"
        @endif
        @class([
            'relative block md:inline-block text-left' => $component->isTailwind(),
        ])
    >
        <div>
            <button
                type="button"
                @class([
                    'rounded-md bg-white border-2 border-gray-300/70 px-3.5 py-1.5 2xl:py-2.5 text-sm font-semibold text-gray-400 shadow-sm hover:text-gray-900 hover:border-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 inline-flex items-center gap-x-1.5 disabled:bg-gray-100 disabled:text-gray-300 disabled:hover:border-gray-300/70' => $component->isTailwind(),
                ])
                @if ($component->isFilterLayoutPopover()) x-on:click="filterPopoverOpen = !filterPopoverOpen"
                    aria-haspopup="true"
                    x-bind:aria-expanded="filterPopoverOpen"
                    aria-expanded="true"
                @endif
                @if ($component->isFilterLayoutSlideDown()) x-on:click="filtersOpen = !filtersOpen" @endif
            >
            <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><line x1="128" y1="124" x2="128" y2="216" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="128" y1="40" x2="128" y2="84" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="200" y1="204" x2="200" y2="216" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="200" y1="40" x2="200" y2="164" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="224" y1="164" x2="176" y2="164" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="56" y1="172" x2="56" y2="216" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="56" y1="40" x2="56" y2="132" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="32" y1="132" x2="80" y2="132" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="152" y1="84" x2="104" y2="84" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/></svg>
                @lang('Filters')

                @if ($count = $component->getFilterBadgeCount())
                    <span @class([
                            'rounded-full bg-b-red-50 text-b-red-600 px-1.5 py-0 ml-1' => $component->isTailwind(),
                        ])>
                        {{ $count }}
                    </span>
                @endif

               

            </button>
        </div>

        @if ($component->isFilterLayoutPopover())
            <x-thunderbolt-livewire-tables::tools.toolbar.items.filter-popover :$filterGenericData />
        @endif

    </div>
</div>
