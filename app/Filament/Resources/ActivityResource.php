<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;

class ActivityResource extends Resource
{
    protected static string|null $model = Activity::class;

    protected static string|null $navigationGroup = 'Others';

    protected static string|null $navigationIcon = 'heroicon-o-list-bullet';

    protected static string|null $recordTitleAttribute = 'id';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('log_name'),

                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('subject_type'),

                Forms\Components\TextInput::make('event'),

                Forms\Components\TextInput::make('subject_id'),

                Forms\Components\TextInput::make('causer_type'),

                Forms\Components\TextInput::make('causer_id'),

                Forms\Components\Textarea::make('properties')
                    ->formatStateUsing(fn(Model $record) => $record->getRawOriginal('properties'))
                    ->json()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('log_name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject_type')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('event')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject_id')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('causer_type')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('causer_id')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
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
            'index' => Pages\ListActivities::route('/'),
            'view'  => Pages\ViewActivity::route('/{record}'),
        ];
    }
}
