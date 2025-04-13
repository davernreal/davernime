<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StreamingPlatformResource\Pages;
use App\Filament\Resources\StreamingPlatformResource\RelationManagers;
use App\Models\StreamingPlatform;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StreamingPlatformResource extends Resource
{
    protected static ?string $model = StreamingPlatform::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationLabel = 'Streaming Platforms';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->string()
                    ->required(),

                Forms\Components\ColorPicker::make('color')
                    ->label('Color'),

                Forms\Components\TextInput::make('logo_url')
                    ->label('Logo URL')
                    ->url()
                    ->nullable()
                    ->helperText('Input logo URL as PNG format.'),
                Forms\Components\FileUpload::make('logo')
                    ->label('Upload Logo')
                    ->image()
                    ->directory('streaming-platforms')
                    ->imagePreviewHeight('250')
                    ->nullable()
                    ->helperText('or you can upload logo as PNG format.')
                    ->image()
                    ->maxSize(1024)

            ])
            ->columns(2); // Agar elemen form lebih rapi
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListStreamingPlatforms::route('/'),
            'create' => Pages\CreateStreamingPlatform::route('/create'),
            'edit' => Pages\EditStreamingPlatform::route('/{record}/edit'),
        ];
    }
}
