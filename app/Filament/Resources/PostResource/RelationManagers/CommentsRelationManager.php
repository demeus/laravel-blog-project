<?php

namespace App\Filament\Resources\PostResource\RelationManagers;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\CommentStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function form(Form $form) : Form
    {
        return $form->schema([
            Section::make()
                ->schema([
                    Select::make('user_id')
                        ->relationship('user', 'name')
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

    public function table(Table $table) : Table
    {
        return $table
            ->recordTitleAttribute('comment')
            ->columns([

                TextColumn::make('comment'),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('user.name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }
}
