<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;

use Conceptlz\ThunderboltLivewireTables\Traits\Configuration\LoadingPlaceholderConfiguration;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\LoadingPlaceholderHelpers;

trait WithLoadingPlaceholder
{
    use LoadingPlaceholderConfiguration,
        LoadingPlaceholderHelpers;

    protected bool $displayLoadingPlaceholder = false;

    protected string $loadingPlaceholderContent = 'Loading';

    protected ?string $loadingPlaceholderBlade = null;

    protected array $loadingPlaceHolderAttributes = [];

    protected array $loadingPlaceHolderIconAttributes = [];

    protected array $loadingPlaceHolderWrapperAttributes = [];
}
