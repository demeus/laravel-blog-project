<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RouteList extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.route-list';

    public ?array $records = [];

    public function mount(): void
    {
        $this->records = $this->getRoutes();
    }


    private function getRoutes()
    {
        $middlewareNames = [];

        return collect(Route::getRoutes())->filter(function ($route) {
            return !Str::startsWith(
                $route->uri(),
                ['_ignition', '_debugbar', 'filament', 'livewire', 'sanctum', 'api', 'admin']
            );
        })->map(function ($route) {
            return [
                'uri'         => $route->uri(),
                'name'        => $route->getName(),
                'methods'     => $route->methods(),
                'action_name' => $route->getActionName(),
                'action'      => [
                    'domain'     => $route->domain(),
                    'middleware' => $route->middleware(),
                ],
            ];
        })->toArray();
    }
}
