<?php

namespace App\Filament\Resources\CommentResource\Widgets;

use App\Models\Comment;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\CommentResource;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestCommentsWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table) : Table
    {
        return $table
            ->query(
                Comment::whereDate('created_at', '>', now()->subDays(7)->startOfDay())
            )
            ->columns([
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('user.name'),
                TextColumn::make('post.title')
                    ->sortable()
                    ->searchable()
                    ->description(fn(Comment $comment) => $comment->comment),

                TextColumn::make('created_at')->date()->sortable(),
            ])
            ->actions([
                Action::make('View')
                    ->url(fn (Comment $record) : string => CommentResource::getUrl('edit', ['record' => $record]))
                    ->openUrlInNewTab(),
            ]);
    }
}
