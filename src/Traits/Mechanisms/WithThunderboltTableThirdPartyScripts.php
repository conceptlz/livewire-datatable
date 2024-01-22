<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits\Mechanisms;

use Livewire\Drawer\Utils;

trait WithThunderboltTableThirdPartyScripts
{
    /** Thunderbolt Third Party Scripts */
    public bool $hasRenderedThunderboltTableThirdPartyScripts = false;

    public mixed $thunderboltTableScriptThirdPartyRoute;

    public array $thunderboltTableScriptThirdPartyTagAttributes = [];

    /**
     * Thunderbolt Third Party Scripts
     */
    /**
     * Used if Injection Is Used
     */
    public function setThunderboltTableThirdPartyScriptRoute(callable $callback): void
    {
        $route = $callback([self::class, 'returnThunderboltTableThirdPartyJavaScriptAsFile']);

        $this->thunderboltTableScriptThirdPartyRoute = $route;
    }

    public function returnThunderboltTableThirdPartyJavaScriptAsFile(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->pretendResponseIsJs(__DIR__.'/../../../resources/js/laravel-livewire-tables-thirdparty.min.js');
    }

    /**
     *  Used If Injection is Disabled
     */
    public static function thunderboltTableThirdPartyScripts(mixed $expression): string
    {
        return '{!! \Conceptlz\LaravelLivewireTables\Mechanisms\ThunderboltFrontendAssets::tableThirdPartyScripts('.$expression.') !!}';
    }

    public static function tableThirdPartyScripts(array $options = []): ?string
    {
        app(static::class)->hasRenderedThunderboltTableThirdPartyScripts = true;

        $debug = config('app.debug');

        $scripts = static::tableThirdpartyJs($options);

        // HTML Label.
        $html = $debug ? ['<!-- thunderbolt Third Party Scripts -->'] : [];

        $html[] = $scripts;

        return implode("\n", $html);
    }

    public static function tableThirdpartyJs(array $options = []): string
    {
        // Use the default endpoint...
        $url = app(static::class)->thunderboltTableScriptThirdPartyRoute->uri;

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
