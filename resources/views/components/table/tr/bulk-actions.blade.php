@aware(['component', 'tableName'])
@props(['rows'])

@if ($component->bulkActionsAreEnabled() && $component->hasBulkActions())
    @php
        $colspan = $component->getColspanCount();
        $selectAll = $component->selectAllIsEnabled();
        $simplePagination = $component->isPaginationMethod('simple');
    @endphp

    <x-thunderbolt-livewire-tables::table.tr.plain
            x-cloak x-show="selectedItems.length > 0 && !currentlyReorderingStatus"
            wire:key="{{ $tableName }}-bulk-select-message"
            class="bg-indigo-50 "
        >
            <x-thunderbolt-livewire-tables::table.td.plain :colspan="$colspan">
                <template x-if="selectedItems.length == paginationTotalItemCount">
                    <div wire:key="{{ $tableName }}-all-selected">
                        <span>
                            @lang('You are currently selecting all')
                            @if(!$simplePagination) <strong><span x-text="paginationTotalItemCount"></span></strong> @endif
                            @lang('rows').
                        </span>

                        <button
                            x-on:click="clearSelected"
                            wire:loading.attr="disabled"
                            type="button"
                            class="ml-1 text-blue-600 underline text-gray-700 text-sm leading-5 font-medium focus:outline-none focus:text-gray-800 focus:underline transition duration-150 ease-in-out "
                        >
                            @lang('Deselect All')
                        </button>
                    </div>
                </template>

                <template x-if="selectedItems.length !== paginationTotalItemCount">
                    <div wire:key="{{ $tableName }}-some-selected">
                        <span>
                            @lang('You have selected')
                            <strong><span x-text="selectedItems.length"></span></strong>
                            @lang('rows, do you want to select all')
                            @if(!$simplePagination) <strong><span x-text="paginationTotalItemCount"></span></strong> @endif
                        </span>

                        <button
                            x-on:click="selectAllOnPage()"
                            wire:loading.attr="disabled"
                            type="button"
                            class="ml-1 text-blue-600 underline text-gray-700 text-sm leading-5 font-medium focus:outline-none focus:text-gray-800 focus:underline transition duration-150 ease-in-out"
                        >
                            @lang('Select All On Page')
                        </button>&nbsp;

                        <button
                            x-on:click="setAllSelected"
                            wire:loading.attr="disabled"
                            type="button"
                            class="ml-1 text-blue-600 underline text-gray-700 text-sm leading-5 font-medium focus:outline-none focus:text-gray-800 focus:underline transition duration-150 ease-in-out"
                        >
                            @lang('Select All')
                        </button>

                        <button
                            x-on:click="clearSelected"
                            wire:loading.attr="disabled"
                            type="button"
                            class="ml-1 text-blue-600 underline text-gray-700 text-sm leading-5 font-medium focus:outline-none focus:text-gray-800 focus:underline transition duration-150 ease-in-out"
                        >
                            @lang('Deselect All')
                        </button>
                    </div>
                </template>
            </x-thunderbolt-livewire-tables::table.td.plain>
        </x-thunderbolt-livewire-tables::table.tr.plain>
@endif
