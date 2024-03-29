@aware(['component', 'tableName','columnCount'])

@php
    $customAttributes = [
        'wrapper' => $this->getTableWrapperAttributes(),
        'table' => $this->getTableAttributes(),
        'thead' => $this->getTheadAttributes(),
        'tbody' => $this->getTbodyAttributes(),
    ];
@endphp
<div class="mt-6 flow-root">
    <div wire:key="{{ $tableName }}-twrap"
            {{ $attributes->merge($customAttributes['wrapper'])
                ->class(['overflow-x-auto shadow-md ring-1 ring-gray-950 ring-opacity-5 sm:rounded-lg bg-white' => $customAttributes['wrapper']['default'] ?? true])
                ->except('default') }}
        >
        <div class="inline-block overflow-hidden min-w-full align-middle relative">
            
            <table
                wire:key="{{ $tableName }}-table"
                {{ $attributes->merge($customAttributes['table'])
                    ->class(['min-w-full block overflow-auto h-[60vh]' => $customAttributes['table']['default'] ?? true])
                    ->except('default') }}
            >
                <thead wire:key="{{ $tableName }}-thead"
                    {{ $attributes->merge($customAttributes['thead'])
                        ->class(['' => $customAttributes['thead']['default'] ?? true])
                        ->except('default') }}
                >
                    <tr class="[&>th]:sticky [&>th]:top-0 [&>th]:z-20 [&>th]:bg-gray-900 [&>th]:px-6 [&>th]:shadow-[inset_1px_-1px_rgba(0,0,0,0.6)] [&>th]:shadow-gray-800 [&>th]:text-gray-50 [&>th]:py-1">
                        {{ $thead }}
                    </tr>
                </thead>

                <tbody
                    wire:key="{{ $tableName }}-tbody"
                    id="{{ $tableName }}-tbody"
                    {{ $attributes->merge($customAttributes['tbody'])
                            ->class(['divide-y divide-gray-200 bg-white overflow-y-auto [&>tr>td]:py-4 [&>tr>td]:px-6 [&>tr>td]:text-gray-500 [&>tr>td]:text-sm' => $customAttributes['tbody']['default'] ?? true])
                            ->except('default') }}
                >
                    {{ $slot }}
                </tbody>

                @if (isset($tfoot))
                    <tfoot wire:key="{{ $tableName }}-tfoot">
                        {{ $tfoot }}
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
