<?php

namespace App\Filament\Resources\TextWidgetResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TextWidgetResource;

class ListTextWidgets extends ListRecords
{
    protected static string $resource = TextWidgetResource::class;

    protected function getHeaderActions() : array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
