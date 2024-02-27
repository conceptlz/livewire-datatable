<?php

namespace Conceptlz\ThunderboltLivewireTables\Mechanisms;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Livewire\Drawer\Utils;
use Conceptlz\ThunderboltLivewireTables\Traits\Mechanisms\WithThunderboltTableScripts;
use Conceptlz\ThunderboltLivewireTables\Traits\Mechanisms\WithThunderboltTableStyles;
use Conceptlz\ThunderboltLivewireTables\Traits\Mechanisms\WithThunderboltTableThirdPartyScripts;
use Conceptlz\ThunderboltLivewireTables\Traits\Mechanisms\WithThunderboltTableThirdPartyStyles;

class ThunderboltFrontendAssets
{
    use WithThunderboltTableScripts;
    use WithThunderboltTableStyles;
    use WithThunderboltTableThirdPartyScripts;
    use WithThunderboltTableThirdPartyStyles;

    public function register(): void
    {
        app()->singleton($this::class);
    }

    public function boot(): void
    {
        // Set the JS route for the core tables JS
        app($this::class)->setThunderboltTableScriptRoute(function ($handle) {
            $scriptPath = rtrim(config('thunderbolt-livewire-tables.script_base_path', '/thunderbolt/laravel-livewire-tables'), '/').'/laravel-livewire-tables.min.js';

            return Route::get($scriptPath, $handle);
        });

        // Set the CSS route for the core tables CSS
        app($this::class)->setThunderboltTableStylesRoute(function ($handle) {
            $stylesPath = rtrim(config('thunderbolt-livewire-tables.script_base_path', '/thunderbolt/laravel-livewire-tables'), '/').'/laravel-livewire-tables.min.css';

            return Route::get($stylesPath, $handle);
        });

        // Set the JS route for the third party JS
        app($this::class)->setThunderboltTableThirdPartyScriptRoute(function ($handle) {
            $scriptPath = rtrim(config('thunderbolt-livewire-tables.script_base_path', '/thunderbolt/laravel-livewire-tables'), '/').'/laravel-livewire-tables-thirdparty.min.js';

            return Route::get($scriptPath, $handle);
        });

        // Set the CSS route for the third party CSS
        app($this::class)->setThunderboltTableThirdPartyStylesRoute(function ($handle) {
            $stylesPath = rtrim(config('thunderbolt-livewire-tables.script_base_path', '/thunderbolt/laravel-livewire-tables'), '/').'/laravel-livewire-tables-thirdparty.min.css';

            return Route::get($stylesPath, $handle);
        });

        static::registerBladeDirectives();

    }

    protected function registerBladeDirectives()
    {
        Blade::directive('thunderboltTableScripts', [static::class, 'thunderboltTableScripts']);
        Blade::directive('thunderboltTableStyles', [static::class, 'thunderboltTableStyles']);
        Blade::directive('thunderboltTableThirdPartyScripts', [static::class, 'thunderboltTableThirdPartyScripts']);
        Blade::directive('thunderboltTableThirdPartyStyles', [static::class, 'thunderboltTableThirdPartyStyles']);
    }

    protected function pretendResponseIsJs(string $file): \Symfony\Component\HttpFoundation\Response
    {

        if (config('thunderbolt-livewire-tables.cache_assets', false) === true) {
            $expires = strtotime('+1 day');
            $lastModified = filemtime($file);
            $cacheControl = 'public, max-age=86400';
        } else {
            $expires = strtotime('+1 second');
            $lastModified = \Carbon\Carbon::now()->timestamp;
            $cacheControl = 'public, max-age=1';
        }

        $headers = [
            'Content-Type' => 'application/javascript; charset=utf-8',
            'Expires' => Utils::httpDate($expires),
            'Cache-Control' => $cacheControl,
            'Last-Modified' => Utils::httpDate($lastModified),
        ];

        return response()->file($file, $headers);
    }

    protected function pretendResponseIsCSS(string $file): \Symfony\Component\HttpFoundation\Response
    {
        if (config('thunderbolt-livewire-tables.cache_assets', false) === true) {
            $expires = strtotime('+1 day');
            $lastModified = filemtime($file);
            $cacheControl = 'public, max-age=86400';
        } else {
            $expires = strtotime('+1 second');
            $lastModified = \Carbon\Carbon::now()->timestamp;
            $cacheControl = 'public, max-age=1';
        }

        $headers = [
            'Content-Type' => 'text/css; charset=utf-8',
            'Expires' => Utils::httpDate($expires),
            'Cache-Control' => $cacheControl,
            'Last-Modified' => Utils::httpDate($lastModified),
        ];

        return response()->file($file, $headers);
    }

    /*
    public function maps(): \Symfony\Component\HttpFoundation\Response
    {
        return Utils::pretendResponseIsFile(__DIR__.'/../../../resources/js/laravel-livewire-tables.min.js.map');
    }

    protected static function minify(string $subject): array|string|null
    {
        return preg_replace('~(\v|\t|\s{2,})~m', '', $subject);
    }*/
}
