<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Traits\Core;

use Conceptlz\ThunderboltLivewireTables\Exceptions\DataTableConfigurationException;
use Conceptlz\ThunderboltLivewireTables\Views\{Column,Filter};

trait HasView
{
    protected function bootedHasView(): void
    {
        if (! property_exists($this, 'view') || ! isset($this->view) || $this->view == null) {
            throw new DataTableConfigurationException('No View Defined');
        }
    }

    public function getView(): string
    {
        return $this->view;
    }

    /**
     * @return $this
     */
    public function setView(string $view): self
    {
        $this->view = $view;

        return $this;
    }

    public function setCustomView(string $customView): self
    {
        $this->setView($customView);

        return $this;
    }

    public function getViewPath(): string
    {
        return $this->view ?? '';
    }
}
