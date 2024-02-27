@aware(['component', 'tableName'])
@php
    $customAttributes = $component->getBulkActionsThAttributes();
    $bulkActionsThCheckboxAttributes = $component->getBulkActionsThCheckboxAttributes();
    $theme = $component->getTheme();
@endphp

@if ($component->bulkActionsAreEnabled() && $component->hasBulkActions())
    <x-thunderbolt-livewire-tables::table.th.plain wire:key="{{ $tableName }}-thead-bulk-actions" :displayMinimisedOnReorder="true" :$customAttributes>
        <div
            x-data="{newSelectCount: 0, indeterminateCheckbox: false, bulkActionHeaderChecked: false}"
            x-init="$watch('selectedItems', value => indeterminateCheckbox = (value.length > 0 && value.length < paginationTotalItemCount))"
            x-cloak x-show="currentlyReorderingStatus !== true"
            @class([
                'inline-flex rounded-md shadow-sm' => $theme === 'tailwind',
            ])
        >
            <input
                x-init="$watch('indeterminateCheckbox', value => $el.indeterminate = value); $watch('selectedItems', value => newSelectCount = value.length);"
                x-on:click="if(selectedItems.length == paginationTotalItemCount) { $el.indeterminate = false; $wire.clearSelected(); bulkActionHeaderChecked = false; } else { bulkActionHeaderChecked = true; $el.indeterminate = false; $wire.setAllSelected(); }"
                type="checkbox"
                :checked="selectedItems.length == paginationTotalItemCount"
                {{
                    $attributes->merge($bulkActionsThCheckboxAttributes)->class([
                        'absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-b-red-600 focus:ring-b-red-600' => ($theme === 'tailwind') && ($bulkActionsThCheckboxAttributes['default'] ?? true),
                        'except' => 'default',
                    ])
                }}
            />
        </div>
    </x-thunderbolt-livewire-tables::table.th.plain>
@endif
