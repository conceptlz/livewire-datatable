@aware(['component'])
@props(['customAttributes' => [], 'displayMinimisedOnReorder' => true])

<tr {{ $attributes
            ->merge($customAttributes)
            ->class(['' => $customAttributes['default'] ?? true])
            ->class(['laravel-livewire-tables-reorderingMinimised'])
            ->except('default')
        }}
    >
        {{ $slot }}
</tr>
