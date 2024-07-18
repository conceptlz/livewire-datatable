@php
$columnCount = $columns->count() - 1;
@endphp
@php($tableName = $this->getTableName())
<div>
    <x-thunderbolt-livewire-tables::wrapper :component="$this" :tableName="$tableName" :columnCount="$columnCount">
        @if ($this->hasConfigurableAreaFor('before-tools'))
            @include($this->getConfigurableAreaFor('before-tools'), $this->getParametersForConfigurableArea('before-tools'))
        @endif
        <x-thunderbolt-livewire-tables::tools>
            <x-thunderbolt-livewire-tables::tools.toolbar :$filterGenericData :visibleFilters="$visibleFilters"/>
            <x-thunderbolt-livewire-tables::tools.sorting-pills />
            @if ($this->filtersAreEnabled() && $this->filterPillsAreEnabled())
                @livewire('filter-pills',['filterGenericData' => $filterGenericData,'filters' => $visibleFilters,'tableName' => $tableName,'appliedFilters' => $this->getAppliedFiltersWithValues(),'filterConditions' => $this->filterConditions,'filterComponents' => $this->filterComponents,'queryStringAlias' => $this->getQueryStringAlias(),'queryStringStatus' => $this->queryStringIsEnabled()])
            @endif
        </x-thunderbolt-livewire-tables::tools>

        <x-thunderbolt-livewire-tables::table >
            <x-slot name="thead">
                <x-thunderbolt-livewire-tables::table.th.reorder x-cloak x-show="currentlyReorderingStatus" />
                <x-thunderbolt-livewire-tables::table.th.bulk-actions :displayMinimisedOnReorder="true" />
                <x-thunderbolt-livewire-tables::table.th.collapsed-columns />

                @foreach($columns as $index => $column)
                    @continue($column->isHidden())
                    @continue($this->columnSelectIsEnabled() && ! $this->columnSelectIsEnabledForColumn($column))
                    @continue($column->isReorderColumn() && !$this->getCurrentlyReorderingStatus() && $this->getHideReorderColumnUnlessReorderingStatus())

                    <x-thunderbolt-livewire-tables::table.th wire:key="{{ $tableName.'-table-head-'.$index }}" :column="$column" :index="$index" />
                @endforeach
            </x-slot>

            @if($this->secondaryHeaderIsEnabled() && $this->hasColumnsWithSecondaryHeader())
                <x-thunderbolt-livewire-tables::table.tr.secondary-header :rows="$rows" :$filterGenericData />
            @endif
            @if($this->hasDisplayLoadingPlaceholder())
                <x-thunderbolt-livewire-tables::includes.loading colCount="{{ $this->columns->count()+1 }}" />
            @endif


            <x-thunderbolt-livewire-tables::table.tr.bulk-actions :rows="$rows" :displayMinimisedOnReorder="true" />

            @forelse ($rows as $rowIndex => $row)
                <x-thunderbolt-livewire-tables::table.tr wire:key="{{ $tableName }}-row-wrap-{{ $row->{$this->getPrimaryKey()} }}" :row="$row" :rowIndex="$rowIndex">
                    <x-thunderbolt-livewire-tables::table.td.reorder x-cloak x-show="currentlyReorderingStatus" wire:key="{{ $tableName }}-row-reorder-{{ $row->{$this->getPrimaryKey()} }}" :rowID="$tableName.'-'.$row->{$this->getPrimaryKey()}" :rowIndex="$rowIndex" />
                    <x-thunderbolt-livewire-tables::table.td.bulk-actions wire:key="{{ $tableName }}-row-bulk-act-{{ $row->{$this->getPrimaryKey()} }}" :row="$row" :rowIndex="$rowIndex"/>
                    <x-thunderbolt-livewire-tables::table.td.collapsed-columns wire:key="{{ $tableName }}-row-collapsed-{{ $row->{$this->getPrimaryKey()} }}" :rowIndex="$rowIndex" />

                    @foreach($columns as $colIndex => $column)
                        @continue($column->isHidden())
                        @continue($this->columnSelectIsEnabled() && ! $this->columnSelectIsEnabledForColumn($column))
                        @continue($column->isReorderColumn() && !$this->getCurrentlyReorderingStatus() && $this->getHideReorderColumnUnlessReorderingStatus())

                        <x-thunderbolt-livewire-tables::table.td wire:key="{{ $tableName . '-' . $row->{$this->getPrimaryKey()} . '-datatable-td-' . $column->getSlug() }}"  :column="$column" :colIndex="$colIndex">
                            {{ $column->renderContents($row) }}
                        </x-thunderbolt-livewire-tables::table.td>
                    @endforeach
                </x-thunderbolt-livewire-tables::table.tr>

                <x-thunderbolt-livewire-tables::table.collapsed-columns :row="$row" :rowIndex="$rowIndex" />
            @empty
                <x-thunderbolt-livewire-tables::table.empty />
            @endforelse

            @if ($this->footerIsEnabled() && $this->hasColumnsWithFooter())
                <x-slot name="tfoot">
                    @if ($this->useHeaderAsFooterIsEnabled())
                        <x-thunderbolt-livewire-tables::table.tr.secondary-header :rows="$rows" :$filterGenericData />
                    @else
                        <x-thunderbolt-livewire-tables::table.tr.footer :rows="$rows"  :$filterGenericData />
                    @endif
                </x-slot>
            @endif
        </x-thunderbolt-livewire-tables::table>

        <x-thunderbolt-livewire-tables::pagination :rows="$rows" />

        @includeIf($customView)
    </x-thunderbolt-livewire-tables::wrapper>
</div>