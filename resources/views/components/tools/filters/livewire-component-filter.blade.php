<div wire:key="filterComponents.{{$index}}.{{ $filter->getKey() }}-wrapper">
    <x-thunderbolt-livewire-tables::tools.filter-label :$filter :$filterLayout :$tableName :$isTailwind :$isBootstrap4 :$isBootstrap5 :$isBootstrap />

    <livewire:dynamic-component :is="$livewireComponent" :filterKey="$filter->getKey()" :index="$index" :key="'filterComponents-'.$filter->getKey()" wire:model.live="filterComponents.{{$index}}.{{ $filter->getKey() }}" />
</div>
