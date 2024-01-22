<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits\Mechanisms;

use Livewire\Drawer\Utils;

trait WithThunderboltTableScripts
{
    /** Thunderbolt Scripts */
    public bool $hasRenderedThunderboltTableScripts = false;

    public mixed $thunderboltTableScriptRoute;

    public array $thunderboltTableScriptTagAttributes = [];

    public function useThunderboltTableScriptTagAttributes(array $attributes): void
    {
        $this->thunderboltTableScriptTagAttributes = [...$this->thunderboltTableScriptTagAttributes, ...$attributes];
    }

    /**
     *  Used If Injection is Enabled
     */
    public function setThunderboltTableScriptRoute(callable $callback): void
    {
        $route = $callback([self::class, 'returnThunderboltTableJavaScriptAsFile']);

        $this->thunderboltTableScriptRoute = $route;
    }

    public function returnThunderboltTableJavaScriptAsFile(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->pretendResponseIsJs(__DIR__.'/../../../resources/js/laravel-livewire-tables.min.js');
    }

    /**
     *  Used if Injection is disabled
     */
    public static function thunderboltTableScripts(mixed $expression): string
    {
        return '{!! \Conceptlz\LaravelLivewireTables\Mechanisms\ThunderboltFrontendAssets::tableScripts('.$expression.') !!}';
    }

    public static function tableScripts(array $options = []): ?string
    {
        app(static::class)->hasRenderedThunderboltTableScripts = true;

        $debug = config('app.debug');

        $scripts = static::tableJs($options);

        // HTML Label.
        $html = $debug ? ['<!-- Thunderbolt Core Table Scripts -->'] : [];

        $html[] = $scripts;

        return implode("\n", $html);
    }

    public static function tableJs(array $options = []): string
    {
        // Use the default endpoint...
        $url = app(static::class)->thunderboltTableScriptRoute->uri;

        $url = rtrim($url, '/');

        $url = (string) str($url)->start('/');

        // Add the build manifest hash to it...

        $nonce = isset($options['nonce']) ? "nonce=\"{$options['nonce']}\"" : '';

        $extraAttributes = Utils::stringifyHtmlAttributes(
            app(static::class)->thunderboltTableScriptTagAttributes,
        );

        return <<<HTML
        <script src="{$url}" {$nonce} {$extraAttributes}></script>
        HTML;
    }
}
