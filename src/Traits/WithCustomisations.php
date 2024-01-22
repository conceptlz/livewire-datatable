<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits;

use Conceptlz\ThunderboltLivewireTables\Traits\Configuration\CustomisationsConfiguration;
use Conceptlz\ThunderboltLivewireTables\Traits\Helpers\CustomisationsHelpers;

trait WithCustomisations
{
    use CustomisationsConfiguration,
        CustomisationsHelpers;

    protected ?string $layout = null;

    protected ?string $slot = null;

    protected ?string $extends = null;

    protected ?string $section = null;

    /**
     * The view to add any modals for the table, could also be used for any non-visible html
     */
    public function customView(): string
    {
        return 'thunderbolt-livewire-tables::stubs.custom';
    }

    /**
     * Add customView to the View
     */
    public function renderingWithCustomisations(\Illuminate\View\View $view, array $data = []): void
    {
        if ($this->hasLayout()) {
            $view->layout($this->getLayout());
        }

        if ($this->hasExtends()) {
            $view->extends($this->getExtends());
        }

        if ($this->hasSection()) {
            $view->section($this->getSection());
        }

        if ($this->hasSlot()) {
            $view->slot($this->getSlot());
        }

        $view = $view->with([
            'customView' => $this->customView(),
        ]);
    }
}
