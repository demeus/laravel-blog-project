<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;

class PostResource extends Resource
{
    protected static string|null $navigationGroup = 'Blog';

    protected static string|null $model = Post::class;

    protected static string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form) : Form
    {
        return $form
            ->schema(static::getFormComponents())
            ->columns([
                'md' => 1,
                'lg' => 3,
            ]);


    }

    public static function getFormComponents() : array
    {
        return [
            Forms\Components\Section::make('Content')
                ->schema([
                    TextInput::make('title')
                            ->live()
                            ->required()->minLength(1)->maxLength(150)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ('edit' === $operation) {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),



                        TextInput::make('slug')->required()->minLength(1)->unique(ignoreRecord: true)->maxLength(150),
                        RichEditor::make('body')
                            ->required()
                            ->fileAttachmentsDirectory('posts/images')->columnSpanFull(),

                    Forms\Components\MarkdownEditor::make('teaser')
                        ->maxLength(65535)
                        ->columnSpanFull()
                        ->helperText('An overview of the article used in the feed with the intent to entice readers to click through.'),

//                    SpatieMediaLibraryFileUpload::make('images')
//                        ->collection('images')
//                        ->conversion('medium')
//                        ->disk('media-library')
//                        ->downloadable()
//                        ->imageEditor()
//                        ->imageResizeMode('cover')
//                        ->multiple()
//                        ->visibility('public'),


                ])
                ->collapsible()
                ->columnSpan([
                    'md' => 1,
                    'lg' => 2,
                ]),
            Forms\Components\Section::make('Metadata')
                ->schema([
                    FileUpload::make('image')->image()->directory('posts/thumbnails'),
                    DateTimePicker::make('published_at')->nullable(),
                    Checkbox::make('featured'),
                    Select::make('user_id')
                        ->relationship('author', 'name')
                        ->searchable()
                        ->required(),
                    Select::make('categories')
                        ->multiple()
                        ->relationship('categories', 'title')
                        ->searchable(),
                ])
                ->collapsible()
                ->columnSpan([
                    'lg' => 1,
                ])
            ];
//        return $form
//            ->schema([
//                Section::make('Main Content')->schema(
//                    [
//
//                        TextInput::make('slug')->required()->minLength(1)->unique(ignoreRecord: true)->maxLength(150),
//                        RichEditor::make('body')
//                            ->required()
//                            ->fileAttachmentsDirectory('posts/images')->columnSpanFull(),
//                    ]
//                )->columns(2),
//                Section::make('Meta')->schema(
//                    [
//                        FileUpload::make('image')->image()->directory('posts/thumbnails'),
//                        DateTimePicker::make('published_at')->nullable(),
//                        Checkbox::make('featured'),
//                        Select::make('user_id')
//                            ->relationship('author', 'name')
//                            ->searchable()
//                            ->required(),
//                        Select::make('categories')
//                            ->multiple()
//                            ->relationship('categories', 'title')
//                            ->searchable(),
//                    ]
//                ),
//            ]);
    }
    public static function table(Table $table) : Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('slug')->sortable()->searchable(),
                TextColumn::make('author.name')->sortable()->searchable(),
                TextColumn::make('published_at')->date('Y-m-d')->sortable()->searchable(),
                CheckboxColumn::make('featured'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations() : array
    {
        return [
            CommentsRelationManager::class,
        ];
    }

    public static function getPages() : array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery() : Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
