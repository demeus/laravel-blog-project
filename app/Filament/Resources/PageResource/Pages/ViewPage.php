<?php

namespace App\Filament\Resources\PageResource\Pages;

use Filament\Actions;
use App\Filament\Resources\PageResource;
use Filament\Resources\Pages\ViewRecord;

class ViewPage extends ViewRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions() : array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
