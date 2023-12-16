<?php

namespace App\View\Components\Site;

use Closure;
use Illuminate\View\Component;
use App\Settings\FooterSettings;
use Illuminate\Contracts\View\View;

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
    #[\Override]
    public function render() : View|Closure|string
    {
        return view('components.site.footer', [
            'links' => $this->getFooterLinksProperty(),
            'show_copyright' => $this->showCopyrightProperty(),
            'copyright' => $this->getCopyrightProperty(),
        ]);
    }

    private function getFooterLinksProperty() : ?array
    {
        return app(FooterSettings::class)->links;
    }

    private function getCopyrightProperty() : ?string
    {
        return app(FooterSettings::class)->copyright;
    }

    private function showCopyrightProperty() : ?string
    {
        return app(FooterSettings::class)->show_copyright;
    }
}
