<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;

use Livewire\Attributes\Locked;
use Conceptlz\ThunderboltLivewireTables\Traits\Configuration\QueryStringConfiguration;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\QueryStringHelpers;

trait WithQueryString
{
    use QueryStringConfiguration,
        QueryStringHelpers;

    protected ?string $queryStringAlias;

    #[Locked]
    public ?bool $queryStringStatus;

    /**
     * Set the custom query string array for this specific table
     *
     * @return array<mixed>
     */
    protected function queryStringWithQueryString(): array
    {

        if ($this->queryStringIsEnabled()) {
            return [
                $this->getTableName() => ['except' => null, 'history' => false, 'keep' => false, 'as' => $this->getQueryStringAlias()],
            ];
        }

        return [];
    }
}
