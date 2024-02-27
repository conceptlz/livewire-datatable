@aware(['component', 'tableName'])
@props(['row', 'rowIndex'])

@php
    $customAttributes = $component->getBulkActionsTdAttributes();
    $bulkActionsTdCheckboxAttributes = $component->getBulkActionsTdCheckboxAttributes();
    $theme = $component->getTheme();
@endphp

@if ($component->bulkActionsAreEnabled() && $component->hasBulkActions())
    <x-thunderbolt-livewire-tables::table.td.bulk-action-td wire:key="{{ $tableName }}-tbody-td-bulk-actions-td-{{ $row->{$this->getPrimaryKey()} }}" :displayMinimisedOnReorder="true"  :$customAttributes>
            <input
                x-cloak x-show="!currentlyReorderingStatus"
                x-model="selectedItems"
                wire:key="{{ $tableName . 'selectedItems-'.$row->{$this->getPrimaryKey()} }}"
                wire:loading.attr.delay="disabled"
                value="{{ $row->{$this->getPrimaryKey()} }}"
                type="checkbox"
                {{
                    $attributes->merge($bulkActionsTdCheckboxAttributes)->class([
                        'absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border border-gray-300 text-b-red-600 focus:ring-b-red-600' => ($bulkActionsTdCheckboxAttributes['default'] ?? true),
                        'except' => 'default',
                    ])
                }}
            />
    </x-thunderbolt-livewire-tables::table.td.bulk-action-td>
@endif
