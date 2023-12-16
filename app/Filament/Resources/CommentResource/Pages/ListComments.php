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
        //        return [
        //            null => Tab::make('All'),
        //            'new' => Tab::make()->query(fn ($query) => $query->where('status', 'new')),
        //            'processing' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'processing')),
        //            'shipped' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'shipped')),
        //            'delivered' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'delivered')),
        //            'cancelled' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'cancelled')),
        //        ];
        //    }

        $tabs = [
            null => Tab::make('All'),
        ];
        $statuses = CommentStatus::all();
        foreach ($statuses as $status) {
            $tabs[$status->name] = Tab::make()
                ->query(fn (Builder $query) => $query->where('status', $status->value));
        }

        return $tabs;
    }
}
