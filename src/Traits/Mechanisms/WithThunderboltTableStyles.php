<?php

namespace Conceptlz\ThunderboltLivewireTables\Traits\Mechanisms;

trait WithThunderboltTableStyles
{
    /** Thunderbolt Styles */
    public bool $hasRenderedThunderboltTableStyles = false;

    public mixed $thunderboltTableStylesRoute;

    public array $thunderboltTableStyleTagAttributes = [];

    /**
     *  Used If Injection is Enabled
     */
    public function setThunderboltTableStylesRoute(callable $callback): void
    {
        $route = $callback([self::class, 'returnThunderboltTableStylesAsFile']);

        $this->thunderboltTableStylesRoute = $route;
    }

    public function returnThunderboltTableStylesAsFile(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->pretendResponseIsCSS(__DIR__.'/../../../resources/css/laravel-livewire-tables.min.css');
    }

    /**
     *  Used If Injection is Disabled
     */
    public static function thunderboltTableStyles(mixed $expression): string
    {
        return '{!! \Conceptlz\LaravelLivewireTables\Mechanisms\ThunderboltFrontendAssets::tableStyles('.$expression.') !!}';
    }

    public static function tableStyles(array $options = []): array|string|null
    {
        app(static::class)->hasRenderedThunderboltTableStyles = true;

        $debug = config('app.debug');

        $styles = static::tableCss($options);

        // HTML Label.
        $html = $debug ? ['<!-- Thunderbolt Core Table Styles -->'] : [];

        $html[] = $styles;

        return implode("\n", $html);

    }

    public static function tableCss(array $options = []): ?string
    {
        $styleUrl = app(static::class)->thunderboltTableStylesRoute->uri;
        $styleUrl = rtrim($styleUrl, '/');

        $styleUrl = (string) str($styleUrl)->start('/');

        return <<<HTML
            <link href="{$styleUrl}" rel="stylesheet" />
        HTML;
    }
}
