@aware(['component', 'tableName'])
@props(['filter', 'filterLayout' => 'popover', 'tableName' => 'table', 'isTailwind' => false])

@php
    $customLabelAttributes = $filter->getFilterLabelAttributes();
@endphp
<div class="flex justify-between">
@if($filter->hasCustomFilterLabel() && !$filter->hasCustomPosition())
    @include($filter->getCustomFilterLabel(),['filter' => $filter, 'filterLayout' => $filterLayout, 'tableName' => $tableName, 'isTailwind' => $isTailwind,  'customLabelAttributes' => $customLabelAttributes])
@elseif(!$filter->hasCustomPosition())
    <h4 
        {{
            $attributes->merge($customLabelAttributes)
                ->class(['font-extrabold leading-none mb-6' => $isTailwind && ($customLabelAttributes['default'] ?? true)])
                ->except('default')
        }}
    >{{ $filter->getName() }} is ...</h4>

@endif
    <a href="javascript:void(0);" @click="popoverOpen=!popoverOpen" class="pl-2 py-1 pr-1 text-sky-700 hover:text-sky-800">
        <span class="sr-only">Close</span>
        <svg class="h-3 w-3" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"></rect><line x1="200" y1="56" x2="56" y2="200" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><line x1="200" y1="200" x2="56" y2="56" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line></svg>
    </a>
</div>
