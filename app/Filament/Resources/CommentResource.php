<?php

namespace App\Filament\Resources;

use App\Enums\CommentStatus;
use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CommentResource extends Resource
{
    protected static string|null $navigationGroup = 'Blog';

    protected static string|null $model = Comment::class;

    protected static string|null $navigationIcon = 'heroicon-o-chat-bubble-bottom-center';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->schema([
                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('post_id')
                        ->relationship('post', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Textarea::make('comment')
                        ->required()
                        ->minLength(1)
                        ->maxLength(255),

                    Select::make('status')
                        ->options(CommentStatus::class)
                        ->required()
                        ->native(false),
                ]),
        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('user.name'),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('post.title')
                    ->sortable()
                    ->searchable()
                    ->description(fn(Comment $comment) => $comment->comment),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->slideOver(),
            ])
            ->striped()
            ->deferLoading();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListComments::route('/'),
//            'create' => Pages\CreateComment::route('/create'),
            'edit'   => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
