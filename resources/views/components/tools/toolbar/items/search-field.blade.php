@aware(['component', 'tableName'])

<div x-cloak x-show="!currentlyReorderingStatus" 
    x-data="{ show_search: false, has_search :  $wire.entangle('search')}" 
    x-on:click.away="if (has_search == '') { show_search = false }">
        
        <button type="button" x-show="!show_search" x-on:click="show_search = true" class="rounded-md bg-white border-2 border-gray-300/70 px-3.5 py-1.5 2xl:py-2.5 text-sm font-semibold text-gray-400 shadow-sm hover:text-gray-900 hover:border-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 inline-flex items-center gap-x-1.5 disabled:bg-gray-100 disabled:text-gray-300 disabled:hover:border-gray-300/70">
            <svg class="h-5 w-5" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><circle cx="112" cy="112" r="80" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="168.57" y1="168.57" x2="224" y2="224" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/></svg>
        </button>
        <div class="flex rounded-md shadow-sm" x-show="show_search">
            <input 
                wire:model{{ $component->getSearchOptions() }}="search"
                placeholder="{{ $component->getSearchPlaceholder() }}"
                type="text"
                {{ 
                    $attributes->merge($component->getSearchFieldAttributes())
                    ->class([
                        'block w-full border-gray-300 rounded-md shadow-sm transition duration-150 ease-in-out sm:text-sm  rounded-none rounded-l-md focus:ring-0 focus:border-gray-300 px-3.5 py-1.5 2xl:py-2.5' => $component->isTailwind() && $component->hasSearch() && $component->getSearchFieldAttributes()['default'] ?? true,
                        'block w-full border-gray-300 rounded-md shadow-sm transition duration-150 ease-in-out sm:text-sm  rounded-md focus:border-gray-600 focus:border-2 focus:ring-0 px-3.5 py-1.5 2xl:py-2.5 ' => $component->isTailwind() && !$component->hasSearch() && $component->getSearchFieldAttributes()['default'] ?? true,
                    ])
                    ->except('default') 
                }}

            />
            @if ($component->hasSearch())
            <div>
                    <div
                        wire:click="clearSearch" x-on:click="show_search = false"
                        class="inline-flex h-full items-center px-3 text-gray-500 bg-gray-50 rounded-r-md border border-l-0 border-gray-300 cursor-pointer sm:text-sm "
                    >
                        <x-heroicon-m-x-mark class='w-4 h-4' />
                    </div>
            </div>        
            @endif
        </div>


</div>
