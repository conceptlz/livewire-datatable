@aware(['component'])
@php
    $filterKey = $filter->getKey();
@endphp
<div class="grid gap-4" x-cloak id="{{ $tableName }}-dateRangeFilter-{{$index}}-{{ $filterKey }}" x-data="flatpickrFilter($wire, '{{$index}}.{{ $filterKey }}', @js($filter->getConfigs()), $refs.dateRangeInput, '{{ App::currentLocale() }}')" >
    <div class="space-y-2">
        <x-thunderbolt-livewire-tables::tools.filter-label :$filter :$filterLayout :$tableName :$isTailwind :$isBootstrap4 :$isBootstrap5 :$isBootstrap />
    </div>
    <div class="grid gap-3 text-xs text-b-black-400">
        <div class="grid items-center grid-cols-3 gap-4">
            <label class="font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="{{ $tableName }}-filter-{{$index}}-{{ $filter->getKey() }}" >@lang('Value')</label>

            <input
            type="text"
            x-ref="dateRangeInput"
            x-on:click="init"
            value="{{ $filter->getDateString(isset($this->appliedFilters[$index][$filterKey]) ? $this->appliedFilters[$index][$filterKey] : '') }}"
            wire:key="{{ $filter->generateWireKey($tableName, 'dateRange',$index) }}"
            id="{{ $tableName }}-filter-{{$index}}-dateRange-{{ $filterKey }}"
            class="flex w-full h-8 col-span-2 px-3 py-2 text-xs bg-transparent border rounded-md border-input border-gray-300 ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"

            @if($filter->hasConfig('placeholder')) placeholder="{{ $filter->getConfig('placeholder') }}" @endif
            />  

        </div>
    </div>
</div>
