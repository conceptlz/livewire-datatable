@aware(['component', 'tableName'])
@props(['filterGenericData'])

@if ($component->hasConfigurableAreaFor('before-toolbar'))
    @include($component->getConfigurableAreaFor('before-toolbar'), $component->getParametersForConfigurableArea('before-toolbar'))
@endif

<div @class([
        'flow-root' => $component->isTailwind(),
    ])
>
    <div class="flex items-center justify-between">
        <div class="w-1/2 flex justify-start items-center space-x-3">
            @if ($component->fullScreenmodeIsEnabled())
                <x-thunderbolt-livewire-tables::tools.toolbar.items.fullscreen-mode-buttons />
            @endif
            
            @if ($component->showBulkActionsDropdownAlpine())
                <x-thunderbolt-livewire-tables::tools.toolbar.items.bulk-actions />
            @endif
        </div>
        <div class="w-1/2 flex justify-end items-center space-x-3">
            @if ($component->filtersAreEnabled() && $component->filtersVisibilityIsEnabled() && $component->hasVisibleFilters())
                <x-thunderbolt-livewire-tables::tools.toolbar.items.filter-button :$filterGenericData />
            @endif
            @if ($component->columnSelectIsEnabled())
                <x-thunderbolt-livewire-tables::tools.toolbar.items.column-select /> 
            @endif            
            @if ($component->hasExportable())
                <x-thunderbolt-livewire-tables::tools.toolbar.items.export-button />
            @endif
            @if ($component->searchIsEnabled() && $component->searchVisibilityIsEnabled())
                <x-thunderbolt-livewire-tables::tools.toolbar.items.search-field />
            @endif
        </div>
    </div>
</div>
   