@aware(['component'])
@props(['rows'])

@if ($component->hasConfigurableAreaFor('before-pagination'))
    @include($component->getConfigurableAreaFor('before-pagination'), $component->getParametersForConfigurableArea('before-pagination'))
@endif

<div class="mt-6">
    @if ($component->paginationVisibilityIsEnabled())
        <div class="flex items-center justify-between">
            <div class="w-1/2">
                <div class="px-2 space-x-4 divide-x divide-gray-300 flex justify-start items-center">
                    <div>
                        @if ($component->paginationIsEnabled() && $component->isPaginationMethod('standard') && $rows->lastPage() > 1)
                            <p class="paged-pagination-results text-sm text-gray-700 leading-5 dark:text-white">
                                @if($component->showPaginationDetails())
                                    <span>@lang('Showing')</span>
                                    <span class="font-medium">{{ $rows->firstItem() }}</span>
                                    <span>@lang('to')</span>
                                    <span class="font-medium">{{ $rows->lastItem() }}</span>
                                    <span>@lang('of')</span>
                                    <span class="font-medium"><span x-text="paginationTotalItemCount"></span></span>
                                    <span>@lang('results')</span>
                                @endif
                            </p>
                        @elseif ($component->paginationIsEnabled() && $component->isPaginationMethod('simple'))
                            <p class="paged-pagination-results text-sm text-gray-700 leading-5 dark:text-white">
                                @if($component->showPaginationDetails())
                                    <span>@lang('Showing')</span>
                                    <span class="font-medium">{{ $rows->firstItem() }}</span>
                                    <span>@lang('to')</span>
                                    <span class="font-medium">{{ $rows->lastItem() }}</span>
                                @endif
                            </p>
                        @elseif ($component->paginationIsEnabled() && $component->isPaginationMethod('cursor'))
                        @else
                            <p class="total-pagination-results text-sm text-gray-700 leading-5 dark:text-white">
                                @lang('Showing')
                                <span class="font-medium">{{ $rows->count() }}</span>
                                @lang('results')
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            @if ($component->paginationIsEnabled())
                {{ $rows->links('thunderbolt-livewire-tables::specific.tailwind.'.(!$component->isPaginationMethod('standard') ? 'simple-' : '').'pagination') }}
            @endif
        </div>
    @endif
</div>

@if ($component->hasConfigurableAreaFor('after-pagination'))
    @include($component->getConfigurableAreaFor('after-pagination'), $component->getParametersForConfigurableArea('after-pagination'))
@endif