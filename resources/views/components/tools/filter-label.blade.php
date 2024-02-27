@aware(['component', 'tableName'])
@props(['filter', 'filterLayout' => 'popover', 'tableName' => 'table', 'isTailwind' => false])

@php
    $customLabelAttributes = $filter->getFilterLabelAttributes();
@endphp

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
