@aware(['component'])
@props(['displayMinimisedOnReorder' => false, 'hideUntilReorder' => false, 'customAttributes' => ['default' => true]])

<th x-cloak {{ $attributes }} scope="col"
    {{ 
        $attributes->merge($customAttributes)->class([
            'text-left laravel-livewire-tables-reorderingMinimised' => ($component->isTailwind()) && ($customAttributes['default'] ?? true),
            'laravel-livewire-tables-reorderingMinimised' => ($component->isBootstrap()) && ($customAttributes['default'] ?? true),
        ])
    }}
    @if($hideUntilReorder) :class="!reorderDisplayColumn && 'w-0 p-0 hidden'" @endif
>
    {{ $slot }}
</th>
