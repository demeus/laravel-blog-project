<?php

namespace App\Livewire;

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

    public function render()
    {
        return view('livewire.cookie-banner');
    }
}
