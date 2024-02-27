<?php

namespace Conceptlz\ThunderboltLivewireTables\Features;

use Illuminate\Foundation\Http\Events\RequestHandled;
use Livewire\ComponentHook;
use Conceptlz\ThunderboltLivewireTables\Mechanisms\ThunderboltFrontendAssets;

use function Livewire\on;

class AutoInjectThunderboltAssets extends ComponentHook
{
    public static bool $hasRenderedAComponentThisRequest = false;

    public static bool $forceAssetInjection = false;

    public static bool $shouldInjectThunderboltThirdPartyAssets = false;

    public static bool $shouldInjectThunderboltAssets = false;

    public static function provide(): void
    {
        static::$shouldInjectThunderboltAssets = config('thunderbolt-livewire-tables.inject_core_assets_enabled', true);
        static::$shouldInjectThunderboltThirdPartyAssets = config('thunderbolt-livewire-tables.inject_third_party_assets_enabled', true);

        on('flush-state', function () {
            static::$hasRenderedAComponentThisRequest = false;
            static::$forceAssetInjection = false;
        });

        if (static::$shouldInjectThunderboltAssets || static::$shouldInjectThunderboltThirdPartyAssets) {

            app('events')->listen(RequestHandled::class, function (RequestHandled $handled) {

                if (! static::$shouldInjectThunderboltAssets && ! static::$shouldInjectThunderboltThirdPartyAssets) {
                    return;
                }

                // If All Scripts Have Been Rendered - Return
                if (
                    (
                        ! static::$shouldInjectThunderboltAssets || app(ThunderboltFrontendAssets::class)->hasRenderedThunderboltTableScripts
                    ) &&
                    (
                        ! static::$shouldInjectThunderboltThirdPartyAssets || app(ThunderboltFrontendAssets::class)->hasRenderedThunderboltTableThirdPartyScripts
                    )
                ) {
                    return;
                }

                if (! str($handled->response->headers->get('content-type'))->contains('text/html')) {
                    return;
                }

                if (! method_exists($handled->response, 'status') || ! method_exists($handled->response, 'getContent') || ! method_exists($handled->response, 'setContent') || ! method_exists($handled->response, 'getOriginalContent') || ! property_exists($handled->response, 'original')) {
                    return;
                }

                if ($handled->response->status() !== 200) {
                    return;
                }

                $html = $handled->response->getContent();

                if (str($html)->contains('</html>')) {
                    $original = $handled->response->getOriginalContent();
                    $handled->response->setContent(static::injectAssets($html));
                    $handled->response->original = $original;
                }
            });
        }
    }

    public function dehydrate(): void
    {
        static::$hasRenderedAComponentThisRequest = true;
    }

    public static function injectAssets(mixed $html): string
    {

        $html = str($html);
        $rappaStyles = ((static::$shouldInjectThunderboltAssets === true) ? ThunderboltFrontendAssets::tableStyles() : '').' '.((static::$shouldInjectThunderboltThirdPartyAssets === true) ? ThunderboltFrontendAssets::tableThirdPartyStyles() : '');
        $rappaScripts = ((static::$shouldInjectThunderboltAssets === true) ? ThunderboltFrontendAssets::tableScripts() : '').' '.((static::$shouldInjectThunderboltThirdPartyAssets === true) ? ThunderboltFrontendAssets::tableThirdPartyScripts() : '');

        if ($html->test('/<\s*head(?:\s|\s[^>])*>/i') && $html->test('/<\s*\/\s*body\s*>/i')) {
            static::$shouldInjectThunderboltAssets = static::$shouldInjectThunderboltThirdPartyAssets = false;

            return $html
                ->replaceMatches('/(<\s*head(?:\s|\s[^>])*>)/i', '$1'.$rappaStyles)
                ->replaceMatches('/(<\s*\/\s*head\s*>)/i', $rappaScripts.'$1')
                ->toString();
        }
        static::$shouldInjectThunderboltAssets = static::$shouldInjectThunderboltThirdPartyAssets = false;

        return $html
            ->replaceMatches('/(<\s*html(?:\s[^>])*>)/i', '$1'.$rappaStyles)
            ->replaceMatches('/(<\s*\/\s*head\s*>)/i', $rappaScripts.'$1')
            ->toString();
    }
}
