@aware(['component'])
<div class="grid gap-4">
    <div class="space-y-2">
        <x-thunderbolt-livewire-tables::tools.filter-label :$filter :$filterLayout :$tableName :$isTailwind :$isBootstrap4 :$isBootstrap5 :$isBootstrap />
    </div>
    <x-thunderbolt-livewire-tables::tools.filter-condition :$filter  />
    @if(!isset($this->filterConditions[$filter->getKey()]) ||!in_array($this->filterConditions[$filter->getKey()],['is empty','is not empty']))

    <div class="rounded-md max-h-40 overflow-auto text-sm pl-[6px]">
            <div>
                <input
                    type="checkbox"
                    id="{{ $tableName }}-filter-{{ $filter->getKey() }}-select-all-@if($filter->hasCustomPosition()){{ $filter->getCustomPosition() }}@endif"
                    wire:input="selectAllFilterOptions('{{ $filter->getKey() }}')"
                    class="text-gray-600 rounded border-gray-300 shadow-sm transition duration-150 ease-in-out focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50  disabled:opacity-50 disabled:cursor-wait"
                >
                <label for="{{ $tableName }}-filter-{{ $filter->getKey() }}-select-all-@if($filter->hasCustomPosition()){{ $filter->getCustomPosition() }}@endif" class="">
                @if ($filter->getFirstOption() != "")
                    {{ $filter->getFirstOption() }}
                @else
                    @lang('All')
                @endif
                </label>
            </div>

            @foreach($filter->getOptions() as $key => $value)
                <div wire:key="{{ $tableName }}-filter-{{ $filter->getKey() }}-multiselect-{{ $key }}-@if($filter->hasCustomPosition()){{ $filter->getCustomPosition() }}@endif">
                    <input
                        type="checkbox"
                        id="{{ $tableName }}-filter-{{ $filter->getKey() }}-{{ $loop->index }}-@if($filter->hasCustomPosition()){{ $filter->getCustomPosition() }}@endif"
                        value="{{ $key }}"
                        wire:key="{{ $tableName }}-filter-{{ $filter->getKey() }}-{{ $loop->index }}-@if($filter->hasCustomPosition()){{ $filter->getCustomPosition() }}@endif"
                        wire:model.live.debounce.250ms="filterComponents.{{ $filter->getKey() }}"
                        class="text-gray-600 rounded border-gray-300 shadow-sm transition duration-150 ease-in-out focus:border-gray-300 focus:ring focus:ring-gray-400 focus:ring-opacity-50  disabled:opacity-50 disabled:cursor-wait"
                    >
                    <label for="{{ $tableName }}-filter-{{ $filter->getKey() }}-{{ $loop->index }}-@if($filter->hasCustomPosition()){{ $filter->getCustomPosition() }}@endif" class="">{{ $value }}</label>
                </div>
            @endforeach
    </div>
    @endif
</div>
