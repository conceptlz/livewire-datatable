@aware(['component'])

@php($attributes = $attributes->merge(['wire:key' => 'empty-message-'.$component->getId()]))

<tr {{ $attributes }}>
    <td colspan="{{ $component->getColspanCount() }}">
        <div class="flex justify-center items-center space-x-2 ">
            <span class="font-medium py-8 text-gray-400 text-lg ">{{ $component->getEmptyMessage() }}</span>
        </div>
    </td>
</tr>
