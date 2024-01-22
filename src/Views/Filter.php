<?php

namespace Conceptlz\ThunderboltLivewireTables\Views;

use Illuminate\Support\Str;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\IsFilter;

abstract class Filter
{
    use IsFilter;

    protected string $view = '';

    public function __construct(string $name, ?string $key = null)
    {
        $this->name = $name;

        if ($key) {
            $this->key = $key;
        } else {
            $this->key = Str::snake($name);
        }
        $this->config([]);
    }

    /**
     * @return static
     */
    public static function make(string $name, ?string $key = null): Filter
    {
        return new static($name, $key);
    }
}
