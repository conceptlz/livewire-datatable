<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Traits\Configuration;

trait ComponentColumnConfiguration
{
    public function component(string $component): self
    {
        $this->componentView = 'components.'.$component;

        return $this;
    }

    public function slot(callable $callback): self
    {
        $this->slotCallback = $callback;

        return $this;
    }
}
