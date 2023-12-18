<?php

namespace App\View\Components\Site;

use App\Settings\FooterSettings;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Override;

class Footer extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    #[Override]
    public function render(): View|Closure|string
    {
        return view('components.site.footer', [
            'links'          => $this->getFooterLinksProperty(),
            'social_links'   => $this->getFooterSocialLinksProperty(),
            'show_copyright' => $this->showCopyrightProperty(),
            'copyright'      => $this->getCopyrightProperty(),
        ]);
    }

    private function getFooterLinksProperty(): array|null
    {
        return app(FooterSettings::class)->links;
    }

    private function getFooterSocialLinksProperty(): array|null
    {
        return app(FooterSettings::class)->social_links;
    }

    private function getCopyrightProperty(): string|null
    {
        return app(FooterSettings::class)->copyright;
    }

    private function showCopyrightProperty(): string|null
    {
        return app(FooterSettings::class)->show_copyright;
    }
}
