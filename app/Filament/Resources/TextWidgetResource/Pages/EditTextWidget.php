<?php

namespace App\Filament\Resources\TextWidgetResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\TextWidgetResource;

class EditTextWidget extends EditRecord
{
    protected static string $resource = TextWidgetResource::class;

    protected function getActions() : array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl() : string
    {
        return $this->getResource()::getUrl('index');
    }
}
