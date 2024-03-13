<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;

trait HasAllTraits
{
    // Note Specific Order Below!
    use WithTableHooks;
    use WithLoadingPlaceholder;
    use ComponentUtilities,
        WithData,
        WithColumns,
        WithSorting,
        WithSearch,
        WithPagination;
    use WithBulkActions,
        WithCollapsingColumns,
        WithColumnSelect,
        WithConfigurableAreas,
        WithCustomisations,
        WithDebugging,
        WithEvents,
        WithFilters,
        WithFooter,
        WithQueryString,
        WithRefresh,
        WithReordering,
        WithSecondaryHeader,
        WithFullScreenMode,
        WithTableAttributes,
        WithExport; 
}
