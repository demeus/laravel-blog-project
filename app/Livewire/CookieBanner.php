<?php

namespace App\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CookieBanner extends Component
{
    public bool $showBanner = true;

    public function closeBanner(): void
    {
        Session::put('cookie_consent', true);
        $this->showBanner = false;
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.cookie-banner');
    }
}
