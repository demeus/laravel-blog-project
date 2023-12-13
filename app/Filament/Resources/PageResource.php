<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static string|null $model = Page::class;

    protected static string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getFormComponents())
            ->columns([
                'md' => 1,
                'lg' => 3,
            ]);
    }

    public static function getFormComponents(): array
    {
        return [
            Section::make('Content')
                ->schema([
                    TextInput::make('title')
                        ->live()
                        ->required()
                        ->minLength(1)
                        ->maxLength(150)
                        ->afterStateUpdated(function (string $operation, $state, Set $set) {
                            if ('edit' === $operation) {
                                return;
                            }

                            $set('slug', Str::slug($state));
                        }),

                    TextInput::make('slug')
                        ->required()
                        ->minLength(1)
                        ->unique(ignoreRecord: true)
                        ->maxLength(150),

                    RichEditor::make('content')
                        ->required()
                        ->fileAttachmentsDirectory('Pages/images')
                        ->columnSpanFull(),

                ])
                ->collapsible()
                ->columnSpan([
                    'md' => 1,
                    'lg' => 2,
                ]),

            Section::make('Metadata')
                ->schema([

                    Select::make('user_id')
                        ->hidden()
                        ->default(auth()->id())
                        ->relationship('author', 'name')
                        ->searchable()
                        ->required(),

                    SpatieMediaLibraryFileUpload::make('image')
                        ->collection('image')
                        ->conversion('medium')
                        ->disk('local')
                        ->downloadable()
                        ->imageCropAspectRatio('16:9')
                        ->imageEditor()
                        ->imageResizeMode('cover')
                        ->imageResizeTargetHeight('1080')
                        ->imageResizeTargetWidth('1920')
                        ->visibility('public'),

                    Textarea::make('description')
                        ->maxLength(65535)
                        ->rows(5)
                        ->helperText('A short description used on the blog, social previews, and Google.'),


                    TagsInput::make('tags'),

                    Group::make()
                        ->schema([
                            Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn(Page $page): string|null => $page->created_at?->isoFormat('LLL')),

                            Placeholder::make('updated_at')
                                ->label('Last modified at')
                                ->content(fn(Page $page): string|null => $page->updated_at?->isoFormat('LLL')),
                        ])
                        ->hidden(fn(Page $page) => !$page->exists),

                ])
                ->collapsible()
                ->columnSpan([
                    'lg' => 1,
                ])
        ];

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(static::getTableColumns())
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->numeric()
                ->label('ID')
                ->sortable()
                ->weight('bold'),

            Tables\Columns\SpatieMediaLibraryImageColumn::make('image')
                ->collection('image')
                ->conversion('medium')
                ->disk('media-library')
                ->defaultImageUrl('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMjMgMTIzIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGZpbGw9IiM1MDQ2RTYiIGQ9Ik0wIDBoMTIzdjEyM0gweiIvPjxwYXRoIGZpbGw9IiNGRkYiIGZpbGwtcnVsZT0ibm9uemVybyIgZD0iTTUyLjkwOTA5MDkgMzBjNi4yNzU5NjMxIDAgMTEuMzYzNjM2NCA1LjAzNjc5NjYgMTEuMzYzNjM2NCAxMS4yNXY1LjYyNWMwIDMuMTA2NjAxNyAyLjU0MzgzNjYgNS42MjUgNS42ODE4MTgyIDUuNjI1aDUuNjgxODE4MUM4MS45MTIzMjY3IDUyLjUgODcgNTcuNTM2Nzk2NiA4NyA2My43NXYyMy42MjVDODcgOTAuNDggODQuNDU0NTQ1NSA5MyA4MS4zMTgxODE4IDkzSDQyLjY4MTgxODJDMzkuNTQ1NDU0NSA5MyAzNyA5MC40OCAzNyA4Ny4zNzV2LTUxLjc1QzM3IDMyLjUyIDM5LjU0MjQyNDIgMzAgNDIuNjgxODE4MiAzMFpNNjIgNzcuMjVINTAuNjM2MzYzNmMtMS4yNTUxOTI2IDAtMi4yNzI3MjcyIDEuMDA3MzU5My0yLjI3MjcyNzIgMi4yNXMxLjAxNzUzNDYgMi4yNSAyLjI3MjcyNzIgMi4yNUg2MmMxLjI1NTE5MjYgMCAyLjI3MjcyNzMtMS4wMDczNTkzIDIuMjcyNzI3My0yLjI1UzYzLjI1NTE5MjYgNzcuMjUgNjIgNzcuMjVabTExLjM2MzYzNjQtOUg1MC42MzYzNjM2Yy0xLjI1NTE5MjYgMC0yLjI3MjcyNzIgMS4wMDczNTkzLTIuMjcyNzI3MiAyLjI1czEuMDE3NTM0NiAyLjI1IDIuMjcyNzI3MiAyLjI1aDIyLjcyNzI3MjhjMS4yNTUxOTI2IDAgMi4yNzI3MjcyLTEuMDA3MzU5MyAyLjI3MjcyNzItMi4yNXMtMS4wMTc1MzQ2LTIuMjUtMi4yNzI3MjcyLTIuMjVaIi8+PHBhdGggZmlsbD0iI0ZGRiIgZmlsbC1ydWxlPSJub256ZXJvIiBkPSJNNjUgMzFjMi40OTI3MjI3IDIuODc0MDgzOSAzLjg2MjY3MTEgNi41NTIyNzIyIDMuODU3Mzg5MSAxMC4zNTY3NDI4djUuNjU0ODkwMWMwIC42MjQyOTk5LjUwNjY3ODEgMS4xMzA5NzggMS4xMzA5NzggMS4xMzA5NzhoNS42NTQ4OTAxQzc5LjQ0NzcyNzggNDguMTM3MzI4OSA4My4xMjU5MTYxIDQ5LjUwNzI3NzMgODYgNTJjLTIuNzAxNDg2Ny0xMC4yNzQ0MTg3LTEwLjcyNTU4MTMtMTguMjk4NTEzMy0yMS0yMVoiLz48L2c+PC9zdmc+')
                ->circular()
                ->label(''),

            TextColumn::make('title')
                ->sortable()
                ->searchable()
                ->description(fn(Page $page) => $page->slug),


            TextColumn::make('author.name')
                ->sortable()
                ->searchable(),

            TextColumn::make('created_at')
                ->dateTime()
                ->label('Created')
                ->sortable(),


            TextColumn::make('updated_at')
                ->label('Updated')
                ->sortable(),


        ];
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
            'index'  => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit'   => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
