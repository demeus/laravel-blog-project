<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use App\Models\Media;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MediaResource extends Resource
{
    protected static string|null $model = Media::class;

    protected static string|null $navigationIcon = 'images';

    protected static string|null $navigationGroup = 'Web site';

    protected static int|null $navigationSort = 2;


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file_name')
                    ->state(fn(Media $record): string => $record->getUrl('small'))
                    ->label('Image')
                    ->extraImgAttributes(fn(Media $record): array => [
                        'loading' => 'lazy',
                    ]),

                Tables\Columns\TextColumn::make('model_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model_id')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('mime_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('disk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('conversions_disk')
                    ->label('Disk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('size')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedia::route('/'),
            //            'create' => Pages\CreateMedia::route('/create'),
            //            'edit'   => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
