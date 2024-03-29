@aware(['component', 'tableName'])
<div
    x-data="{ open: false, childElementOpen: false, isTailwind: @js($component->isTailwind()), isBootstrap: @js($component->isBootstrap()) }"
    x-cloak x-show="(selectedItems.length > 0 || alwaysShowBulkActions)"
    @class([
        'relative w-64' => $component->isTailwind(),
    ])
>

        <button
            @class([
                'relative min-h-[38px] flex items-center justify-between w-full py-2 pl-3 pr-10 text-left bg-white border-2 rounded-md shadow-sm cursor-default border-gray-300/70 focus:outline-none  text-sm' => $component->isTailwind(),
            ])
            type="button"
            id="{{ $tableName }}-bulkActionsDropdown" 
            :class="{ 'focus:ring-2 focus:ring-offset-2 focus:ring-gray-400' : !open }"
            x-on:click="open = !open"
            
            aria-haspopup="true" aria-expanded="false">

            @lang('Bulk Actions')
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="w-5 h-5 text-gray-400"><path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd"></path></svg>
            </span>
        </button>
        
        <ul
                x-on:click.away="if (!childElementOpen) { open = false }"
                @keydown.window.escape="if (!childElementOpen) { open = false }"
                x-cloak x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute w-full py-1 mt-1 overflow-auto text-sm bg-white rounded-md shadow-md max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
            >
                @foreach ($component->getBulkActions() as $action => $title)
                    <li 
                         wire:click="{{ $action }}"
                         @if($component->hasConfirmationMessage($action))
                                    wire:confirm="{{ $component->getBulkActionConfirmMessage($action) }}"
                        @endif
                        wire:key="{{ $tableName }}-bulk-action-{{ $action }}"
                        :class="{ 'bg-gray-100 text-gray-900' : selectableItemIsActive(item), '' : !selectableItemIsActive(item) }"
                        class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 flex items-center space-x-2 ">
                        
                        <span class="block font-medium truncate">{{ $title }}</span>
                    </li>
                @endforeach
        </ul>
</div>
