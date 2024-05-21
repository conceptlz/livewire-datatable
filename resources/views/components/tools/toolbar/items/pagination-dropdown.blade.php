@aware(['component', 'tableName'])
<div class="pl-4"
>
    <select wire:model.live="perPage" id="{{ $tableName }}-perPage"
        {{ 
            $attributes->merge($component->getPerPageFieldAttributes())
            ->class([
                'inline rounded-md border-0 py-1.5 pl-3 pr-7 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-primary-600 sm:text-sm sm:leading-6 mx-1' => $component->isTailwind() && $component->getPerPageFieldAttributes()['default-styling'],
            ])
            ->except(['default','default-styling','default-colors']) 
        }}
    >
        @foreach ($component->getPerPageAccepted() as $item)
            <option
                value="{{ $item }}"
                wire:key="{{ $tableName }}-per-page-{{ $item }}"
            >
                {{ $item === -1 ? __('All') : $item }}
            </option>
        @endforeach
    </select>
</div>
