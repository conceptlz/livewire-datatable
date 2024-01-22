<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits\Mechanisms;

trait WithThunderboltTableThirdPartyStyles
{
    /** Thunderbolt Third Party Styles */
    public bool $hasRenderedThunderboltTableThirdPartyStyles = false;

    public mixed $thunderboltTableThirdPartyStyleRoute;

    public array $thunderboltTableThirdPartyStyleTagAttributes = [];

    /**
     *  Used If Injection is Enabled
     */
    public function setThunderboltTableThirdPartyStylesRoute(callable $callback): void
    {
        $route = $callback([self::class, 'returnThunderboltTableThirdPartyStylesAsFile']);

        $this->thunderboltTableThirdPartyStyleRoute = $route;
    }

    public function returnThunderboltTableThirdPartyStylesAsFile(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->pretendResponseIsCSS(__DIR__.'/../../../resources/css/laravel-livewire-tables-thirdparty.min.css');
    }

    /**
     *  Used If Injection is Disabled
     */
    public static function thunderboltTableThirdPartyStyles(mixed $expression): string
    {
        return '{!! \Conceptlz\LaravelLivewireTables\Mechanisms\ThunderboltFrontendAssets::tableThirdPartyStyles('.$expression.') !!}';
    }

    public static function tableThirdPartyStyles(array $options = []): array|string|null
    {
        app(static::class)->hasRenderedThunderboltTableThirdPartyStyles = true;

        $debug = config('app.debug');

        $styles = static::tableThirdPartyCss($options);

        // HTML Label.
        $html = $debug ? ['<!-- Thunderbolt Table Third Party Styles -->'] : [];

        $html[] = $styles;

        return implode("\n", $html);

    }

    public static function tableThirdPartyCss(array $options = []): ?string
    {
        $styleUrl = app(static::class)->thunderboltTableThirdPartyStyleRoute->uri;
        $styleUrl = rtrim($styleUrl, '/');

        $styleUrl = (string) str($styleUrl)->start('/');

        return <<<HTML
            <link href="{$styleUrl}" rel="stylesheet" />
        HTML;
    }
}
