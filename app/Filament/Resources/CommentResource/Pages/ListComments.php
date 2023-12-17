<?php

namespace App\Filament\Resources\CommentResource\Pages;

use Filament\Actions;
use App\Enums\CommentStatus;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CommentResource;

class ListComments extends ListRecords
{
    protected static string $resource = CommentResource::class;

    protected function getHeaderActions() : array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs() : array
    {
        $tabs     = [
            null => Tab::make('All'),
        ];
        $statuses = CommentStatus::all();
        foreach ($statuses as $status) {
            $tabs[$status->name] = Tab::make()
                ->icon($status->getIcon())
                ->query(fn (Builder $query) => $query->where('status', $status->value));
        }

        return $tabs;
    }
}
