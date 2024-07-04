<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Tables;
use Filament\Tables\Table;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Str;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationLabel = 'Property';
    protected static ?string $modelLabel = 'Property';
    protected static ?string $navigationGroup = 'Property System';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('state')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('country')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pincode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\BelongsToSelect::make('property_type_id')
                    ->relationship('propertyType', 'type')
                    ->required(),
                Forms\Components\TextInput::make('num_bathrooms')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('num_bedrooms')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Toggle::make('is_featured')
                ->label('Is Featured'),
                Forms\Components\FileUpload::make('images')
                ->label('Property Images')
                ->multiple()
                ->image()
                ->directory('property-images')
                ->preserveFilenames()
                ->getUploadedFileNameForStorageUsing(
                    fn (TemporaryUploadedFile $file): string => Str::random(10) . '-' . $file->getClientOriginalName()
                )
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pincode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('propertyType.type')
                    ->label('Property Type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('num_bathrooms')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('num_bedrooms')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('images')
                    ->label('Images')
                    ->getStateUsing(function ($record) {
                        return $record->images;
                    })
                    ->formatStateUsing(function ($state) {
                        return collect($state)->map(function ($path) {
                            return "<img src='" . asset('storage/' . $path) . "' style='height: 50px; width: 50px; margin-right: 5px;'/>";
                        })->implode(' ');
                    })
                    ->html(),
            ])
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'view' => Pages\ViewProperty::route('/{record}'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
