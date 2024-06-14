<?php

namespace Conceptlz\ThunderboltLivewireTables;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;
use Livewire\ComponentHookRegistry;
use Conceptlz\ThunderboltLivewireTables\Commands\MakeCommand;
use Conceptlz\ThunderboltLivewireTables\Features\AutoInjectThunderboltAssets;
use Conceptlz\ThunderboltLivewireTables\Mechanisms\ThunderboltFrontendAssets; 
use Livewire\Livewire;
use Conceptlz\ThunderboltLivewireTables\{FilterComponent,FilterSynth,FilterPills};
class LivewireTablesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

        include_once(__DIR__.'/helpers.php');

        Livewire::component('filter-component',FilterComponent::class);
        Livewire::component('filter-pills',FilterPills::class);

        Livewire::propertySynthesizer(FilterSynth::class);
        AboutCommand::add('Conceptlz Laravel Livewire Tables', fn () => ['Version' => '3.0.0']);

        $this->mergeConfigFrom(
            __DIR__.'/../config/thunderbolt-livewire-tables.php', 'thunderbolt-livewire-tables'
        );

        // Load Default Translations
        $this->loadJsonTranslationsFrom(
            __DIR__.'/../resources/lang'
        );

        // Override if Published
        $this->loadJsonTranslationsFrom(
            $this->app->langPath('vendor/thunderbolt-livewire-tables')
        );

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'thunderbolt-livewire-tables');

        $this->consoleCommands();

         if (config('thunderbolt-livewire-tables.inject_core_assets_enabled') || config('thunderbolt-livewire-tables.inject_third_party_assets_enabled') || config('thunderbolt-livewire-tables.enable_blade_directives')) {
            (new ThunderboltFrontendAssets)->boot();
        } 

    }

    public function consoleCommands()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../resources/lang' => $this->app->langPath('vendor/thunderbolt-livewire-tables'),
            ], 'thunderbolt-livewire-tables-translations');

            $this->publishes([
                __DIR__.'/../config/livewire-tables.php' => config_path('thunderbolt-livewire-tables.php'),
            ], 'thunderbolt-livewire-tables-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/thunderbolt-livewire-tables'),
            ], 'thunderbolt-livewire-tables-views');

            $this->publishes([
                __DIR__.'/../resources/js' => public_path('vendor/conceptlz/thunderbolt-livewire-tables/js'),
                __DIR__.'/../resources/css' => public_path('vendor/conceptlz/thunderbolt-livewire-tables/css'),
            ], 'thunderbolt-livewire-tables-public');

            $this->commands([
                MakeCommand::class,
            ]);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/thunderbolt-livewire-tables.php', 'thunderbolt-livewire-tables'
        );
        if (config('thunderbolt-livewire-tables.inject_core_assets_enabled') || config('thunderbolt-livewire-tables.inject_third_party_assets_enabled') || config('thunderbolt-livewire-tables.enable_blade_directives')) {
            (new ThunderboltFrontendAssets)->register();
            ComponentHookRegistry::register(AutoInjectThunderboltAssets::class);
        } 
    }
}
