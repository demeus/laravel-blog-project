<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\ActivityResource\Pages;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationGroup = 'Web site';

    protected static ?string $navigationIcon = 'activity';

    protected static ?string $recordTitleAttribute = 'id';

    #[\Override]
    public static function form(Form $form) : Form
    {
        return $form
            ->schema([

                TextInput::make('log_name'),

                Textarea::make('description')
                    ->columnSpanFull(),

                TextInput::make('subject_type'),

                TextInput::make('event'),

                TextInput::make('subject_id'),

                TextInput::make('causer_type'),

                TextInput::make('causer_id'),

                Textarea::make('properties')
                    ->formatStateUsing(fn (Model $record) => $record->getRawOriginal('properties'))
                    ->json()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('log_name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject_type')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('event')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject_id')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('causer_type')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('causer_id')
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

    public static function getRelations() : array
    {
        return [
            //
        ];
    }

    public static function getPages() : array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
            'view' => Pages\ViewActivity::route('/{record}'),
        ];
    }
}
