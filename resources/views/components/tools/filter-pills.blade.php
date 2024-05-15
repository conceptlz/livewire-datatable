@aware(['component', 'tableName'])

@if ($component->filtersAreEnabled() && $component->filterPillsAreEnabled() && $component->hasAppliedVisibleFiltersForPills())
<div class="mt-6 pt-4 border-t border-t-gray-200 flex items-start justify-between"  x-cloak x-show="!currentlyReorderingStatus">
    <div class="w-full flex items-center justify-start">
            @foreach($component->getAppliedFiltersWithValues() as $filterSelectName => $value)
                @php($filter = $component->getFilterByKey($filterSelectName))

                @continue(is_null($filter))
                @continue($filter->isHiddenFromPills())

                @if ($filter->hasCustomPillBlade())
                    @include($filter->getCustomPillBlade(), ['filter' => $filter])
                @else
                    <div class="relative w-fit" 
                    x-data="{
                            popoverOpen: false,
                            popoverArrow: true,
                            popoverPosition: 'bottom',
                            popoverHeight: 0,
                            popoverOffset: 5,
                            popoverHeightCalculate() {
                                this.$refs.popover.classList.add('invisible'); 
                                this.popoverOpen=true; 
                                let that=this;
                                $nextTick(function(){ 
                                    that.popoverHeight = that.$refs.popover.offsetHeight;
                                    that.popoverOpen=false; 
                                    that.$refs.popover.classList.remove('invisible');
                                    that.$refs.popoverInner.setAttribute('x-transition', '');
                                    that.popoverPositionCalculate();
                                });
                            },
                            popoverPositionCalculate(){
                                if(window.innerHeight < (this.$refs.popoverButton.getBoundingClientRect().top + this.$refs.popoverButton.offsetHeight + this.popoverOffset + this.popoverHeight)){
                                    this.popoverPosition = 'top';
                                } else {
                                    this.popoverPosition = 'bottom';
                                }
                            }
                    }"
                    x-init="
                    that = this;
                    window.addEventListener('resize', function(){
                        popoverPositionCalculate();
                    });
                    $watch('popoverOpen', function(value){
                        if(value){ popoverPositionCalculate();  }
                    });"
                     wire:key="{{ $tableName }}-filter-pill-{{ $filter->getKey() }}">
                        <button type="button" x-ref="popoverButton"   class="inline-flex items-center gap-x-1.5 rounded-full bg-white border border-slate-200 px-2.5 py-1.5 mb-3 me-2 text-xs font-normal text-slate-500 shadow-sm shadow-slate-300 hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-400">
                            <span @click="popoverOpen=!popoverOpen" >
                        {{ $filter->getFilterPillTitle() }}: @if($value != null && !empty($value) && $value != 'null' && $value != '')  <span class="font-semibold">{{ $filter->getFilterPillValue($value) }}</span> @endif </span>
                            <a href="javascript:void(0);" wire:click="resetFilter('{{ $filter->getKey() }}')" class="pl-2 py-1 pr-1 text-sky-700 hover:text-sky-800">
                                <span class="sr-only">@lang('Remove filter option')</span>
                                <svg class="h-3 w-3" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><line x1="200" y1="56" x2="56" y2="200" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="200" y1="200" x2="56" y2="56" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                            </a>
                        </button>
                        <div x-ref="popover" x-show="popoverOpen"
                                x-init="setTimeout(function(){ popoverHeightCalculate(); }, 100);"
                                x-trap.inert="popoverOpen"
                                @click.away=""
                                @keydown.escape.window="popoverOpen=false"
                                :class="{ 'top-0 mt-12' : popoverPosition == 'bottom', 'bottom-0 mb-12' : popoverPosition == 'top' }"
                                class="absolute w-[300px] max-w-lg  left-0 z-[60]" x-cloak>
                                <div x-ref="popoverInner" x-show="popoverOpen" class="w-full p-4 bg-white boabsolute w-[300px] max-w-lg  left-0 z-[60]rder rounded-md shadow-lg border-gray-200/70">
                                    <div x-show="popoverArrow && popoverPosition == 'bottom'" class="absolute top-0 inline-block w-5 mt-px overflow-hidden -translate-x-2 -translate-y-2.5 left-1/2"><div class="w-2.5 h-2.5 origin-bottom-left transform rotate-45 bg-white border-t border-l rounded-sm"></div></div>
                                    <div x-show="popoverArrow  && popoverPosition == 'top'" class="absolute bottom-0 inline-block w-5 mb-px overflow-hidden -translate-x-2 translate-y-2.5 left-1/2"><div class="w-2.5 h-2.5 origin-top-left transform -rotate-45 bg-white border-b border-l rounded-sm"></div></div>
                                    {{ $filter->setGenericDisplayData($filterGenericData)->render() }}
                                </div>
                        </div>
                    </div>
                @endif
            @endforeach
    </div>
    <div class="w-48 flex justify-end items-center space-x-3">
            <button wire:click.prevent="setFilterDefaults" type="button" class="rounded-md bg-gray-700 border-1 border-gray-950/70 px-3.5 py-1.5 2xl:py-2.5 text-sm font-semibold text-gray-100 shadow-sm hover:text-gray-300 hover:bg-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 inline-flex items-center gap-x-1.5 disabled:bg-gray-300 disabled:text-gray-100 disabled:hover:border-gray-300/70">
                @lang('Reset')
            </button>
    </div>
</div>
@endif
