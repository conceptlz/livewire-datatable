@aware(['component', 'tableName'])
<div
    x-cloak x-show="filterPopoverOpen"
    x-transition:enter="transition ease-out duration-100"
    x-transition:enter-start="transform opacity-0 scale-95"
    x-transition:enter-end="transform opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75"
    x-transition:leave-start="transform opacity-100 scale-100"
    x-transition:leave-end="transform opacity-0 scale-95"
    class="origin-top-left absolute left-0 mt-2 w-full md:w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50 "
    role="menu"
    aria-orientation="vertical"
    aria-labelledby="filters-menu"
>
    <div class="py-1.5" >
        @foreach ($component->getVisibleFilters() as $filter)
            <a href="javascript:void(0);" wire:click="setDefaultFilter('{{ $filter->getKey() }}','');"
                    role="menuitem"
                    id="{{ $tableName }}-filter-{{ $filter->getKey() }}-wrapper"
             class="relative flex justify-start items-center w-full select-none group rounded px-2.5 py-2 hover:bg-gray-100 hover:text-b-black-800 outline-none data-[disabled]:opacity-50 data-[disabled]:pointer-events-none">
                    <span class="mr-2 flex h-3.5 w-3.5 items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-2 h-2 fill-current"><circle cx="12" cy="12" r="10"></circle></svg></span>
                    <span>{{ $filter->getName() }}</span>
            </a>
        @endforeach
    </div>
   

    @if ($component->hasAppliedVisibleFiltersWithValuesThatCanBeCleared())
        <div class="block px-4 py-3 text-sm text-gray-700 " role="menuitem">
            <button
                x-on:click="filterPopoverOpen = false"
                wire:click.prevent="setFilterDefaults"
                type="button"
                class="w-full inline-flex items-center justify-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 "
            >
                @lang('Clear')
            </button>
        </div>
    @endif
</div>