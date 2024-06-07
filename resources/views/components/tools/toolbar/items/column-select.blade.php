@aware(['component', 'tableName'])
<div class="@if ($component->getColumnSelectIsHiddenOnMobile()) hidden sm:block @elseif ($component->getColumnSelectIsHiddenOnTablet()) hidden md:block @endif relative" x-data="{ open: false, childElementOpen: false }"
        @keydown.window.escape="if (!childElementOpen) { open = false }"
        x-on:click.away="if (!childElementOpen) { open = false }"
        wire:key="{{ $tableName }}-column-select-button">

    <button x-on:click="open = !open" type="button" class="rounded-md bg-white border-2 border-gray-300/70 px-3.5 py-1.5 2xl:py-2.5 text-sm font-semibold text-gray-400 shadow-sm hover:text-gray-900 hover:border-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 inline-flex items-center gap-x-1.5 disabled:bg-gray-100 disabled:text-gray-300 disabled:hover:border-gray-300/70">
        <svg class="h-5 w-5" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><line x1="40" y1="64" x2="108" y2="64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="40" y1="104" x2="108" y2="104" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="40" y1="144" x2="108" y2="144" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="40" y1="184" x2="108" y2="184" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="148" y1="64" x2="216" y2="64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="148" y1="104" x2="216" y2="104" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="148" y1="144" x2="216" y2="144" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/><line x1="148" y1="184" x2="216" y2="184" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="24"/></svg>
        Show / Hide
    </button>
    <div x-cloak x-show="open"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="-translate-y-2"
            x-transition:enter-end="translate-y-0"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute right-0 z-50 mt-2 w-full rounded-md divide-y divide-gray-100  origin-top-right md:w-48 focus:outline-none">
        <div class="text-sm bg-white border rounded-md shadow-md border-gray-200/70 text-b-black-400">
            <div class="" role="menu" aria-orientation="vertical" aria-labelledby="column-select-menu">
                <div wire:key="{{ $tableName }}-columnSelect-selectAll-{{ rand(0,1000) }}" class="hover:bg-gray-100 rounded font-medium text-b-black-600
                ">
                    <label
                        wire:loading.attr="disabled"
                        class="
                        relative flex justify-start items-center w-full select-none group rounded px-2.5 py-2 hover:bg-gray-100 hover:text-b-black-800 outline-none data-[disabled]:opacity-50 data-[disabled]:pointer-events-none  font-medium disabled:opacity-50 disabled:cursor-wait"
                    >
                        <input
                            class="text-b-red-600 transition duration-150 ease-in-out border-gray-300 rounded shadow-sm focus:border-b-red-300 focus:ring focus:ring-b-red-200 focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-wait"
                            wire:loading.attr="disabled" 
                            type="checkbox"
                            @checked($component->getSelectableSelectedColumns()->count() == $component->getSelectableColumns()->count())
                            @if($component->getSelectableSelectedColumns()->count() == $component->getSelectableColumns()->count())  wire:click="deselectAllColumns" @else wire:click="selectAllColumns" @endif
                        >
                        <span class="ml-2">{{ __('All Columns') }}</span>
                    </label>
                </div>
                
                @foreach ($component->getColumnsForColumnSelect() as $columnSlug => $columnTitle)
                        <div
                            wire:key="{{ $tableName }}-columnSelect-{{ $loop->index }}" class="hover:bg-gray-100 rounded font-medium text-b-black-600"
                        >
                            <label
                                wire:loading.attr="disabled"
                                wire:target="selectedColumns"
                                class="  relative flex justify-start items-center w-full select-none group rounded px-2.5 py-2 hover:bg-gray-100 hover:text-b-black-800 outline-none data-[disabled]:opacity-50 data-[disabled]:pointer-events-none  font-medium disabled:opacity-50 disabled:cursor-wait"
                            >
                                <input
                                    class="text-b-red-600 rounded border-gray-300 shadow-sm transition duration-150 ease-in-out focus:border-b-red-300 focus:ring focus:ring-b-red-200 focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-wait"
                                    wire:model.live="selectedColumns" wire:target="selectedColumns"
                                    wire:loading.attr="disabled" type="checkbox"
                                    value="{{ $columnSlug }}" />
                                <span class="ml-2">{{ $columnTitle }}</span>
                            </label>
                        </div>
                @endforeach
            </div>
            
        </div>
    </div>
</div>
   