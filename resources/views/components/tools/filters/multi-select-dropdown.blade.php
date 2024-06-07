<div>
    <x-thunderbolt-livewire-tables::tools.filter-label :$filter :$filterLayout :$tableName :$isTailwind :$isBootstrap4 :$isBootstrap5 :$isBootstrap />


    @if ($isTailwind)
        <div class="rounded-md shadow-sm">
            <select multiple
                wire:model.live.debounce.250ms="filterComponents.{{ $filter->getKey() }}"
                wire:key="{{ $filter->generateWireKey($tableName, 'multiselectdropdown') }}"
                id="{{ $tableName }}-filter-{{ $filter->getKey() }}@if($filter->hasCustomPosition())-{{ $filter->getCustomPosition() }}@endif"
                class="block w-full transition duration-150 ease-in-out px-3 py-2 text-xs bg-transparent border rounded-md border-input border-gray-300 ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 "

                flex w-full h-8 col-span-2 
            >
            @if ($filter->getFirstOption() != "")
                <option @if($filter->isEmpty($this)) selected @endif value="all">{{ $filter->getFirstOption()}}</option>
            @endif
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
    @elseif ($isBootstrap)
        <select multiple
            wire:model.live.debounce.250ms="filterComponents.{{ $filter->getKey() }}"
            wire:key="{{ $filter->generateWireKey($tableName, 'multiselectdropdown') }}"
            id="{{ $tableName }}-filter-{{ $filter->getKey() }}@if($filter->hasCustomPosition())-{{ $filter->getCustomPosition() }}@endif"
            class="{{ $isBootstrap4 ? 'form-control' : 'form-select' }}"
        >
        @if ($filter->getFirstOption() != "")
            <option @if($filter->isEmpty($this)) selected @endif value="all">{{ $filter->getFirstOption()}}</option>
        @endif
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
    @endif
</div>