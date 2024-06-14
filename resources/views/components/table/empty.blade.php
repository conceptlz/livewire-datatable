@aware(['component'])

@php($attributes = $attributes->merge(['wire:key' => 'empty-message-'.$component->getId()]))

<tr {{ $attributes }}>
    <td colspan="{{ $component->getColspanCount() }}">
        <div class="!absolute top-2/4 -translate-y-2/4 -translate-x-2/4 left-2/4">
            <span class="font-medium py-8 text-gray-400 text-lg ">{{ $component->getEmptyMessage() }}</span>
        </div>
    </td>
</tr>
