<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\ComponentHelpers;

trait FilterTraits
{
    // Note Specific Order Below!
use

       
        WithEvents,
        WithFilters,
        ComponentHelpers,
        WithQueryString,
        WithDebugging,
        WithRefresh;

        public function configure(): void
        {

        }
}
