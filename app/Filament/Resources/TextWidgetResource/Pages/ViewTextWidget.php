<?php

namespace App\Filament\Resources\TextWidgetResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\TextWidgetResource;

class ViewTextWidget extends ViewRecord
{
    protected static string $resource = TextWidgetResource::class;

    protected function getHeaderActions() : array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
