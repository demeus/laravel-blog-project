<?php

namespace App\Filament\Resources\TextWidgetResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TextWidgetResource;

class CreateTextWidget extends CreateRecord
{
    protected static string $resource = TextWidgetResource::class;

    protected function getRedirectUrl() : string
    {
        return $this->getResource()::getUrl('index');
    }
}
