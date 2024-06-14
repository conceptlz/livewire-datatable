@aware(['component'])
<div class="grid gap-4">
    <div class="space-y-2">
        <x-thunderbolt-livewire-tables::tools.filter-label :$filter :$filterLayout :$tableName :$isTailwind :$isBootstrap4 :$isBootstrap5 :$isBootstrap />
    </div>
    <div class="grid gap-3 text-xs text-b-black-400">
        <x-thunderbolt-livewire-tables::tools.filter-condition :$filter  />
        @if(!isset($this->filterConditions[$filter->getKey()]) ||!in_array($this->filterConditions[$filter->getKey()],['is empty','is not empty']))

        <div class="grid items-center grid-cols-3 gap-4">
            <label class="font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="{{ $tableName }}-filter-{{ $filter->getKey() }}" >@lang('Value')</label>
            <select wire:model.live="filterComponents.{{ $filter->getKey() }}"
            wire:key="{{ $filter->generateWireKey($tableName, 'select') }}"
            id="{{ $tableName }}-filter-{{ $filter->getKey() }}@if($filter->hasCustomPosition())-{{ $filter->getCustomPosition() }}@endif"
            class="flex w-full h-8 col-span-2 px-3 py-2 text-xs bg-transparent border rounded-md border-input border-gray-300 ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" >
            <option value="">{{ __('select :value',['value' => strtolower($filter->getName())]) }}</option>
            @foreach($filter->getOptions() as $key => $value)
                @if (is_iterable($value))
                    <optgroup label="{{ $key }}">
                        @foreach ($value as $optionKey => $optionValue)
                            <option value="{{ $optionKey }}">{{ $optionValue }}</option>
                        @endforeach
                    </optgroup>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
            </select>
        </div>
        @endif
    </div>
</div>
