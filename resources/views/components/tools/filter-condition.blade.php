@aware(['component', 'tableName'])
@props(['filter'])
@if($filter->hasFilterWithOperand() &&  $options = $component->getOperands($filter)) 
    <div class="grid items-center grid-cols-3 gap-4">
        <label class="font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="{{ $tableName }}-filter-condition-{{ $filter->getKey() }}">@lang('Condition')</label>
        <select name="operand" wire:model.blur="filterConditions.{{ $filter->getKey() }}" class="flex w-full h-8 col-span-2 px-3 py-2 text-xs bg-transparent border rounded-md border-input border-gray-300 ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="{{ $tableName }}-filter-condition-{{ $filter->getKey() }}">
            @foreach ($options as $operand_key => $operand)
                <option value="{{ $operand_key }}">{{ $operand }}</option>
            @endforeach
        </select>
    </div>
@endif