<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StationResource\Pages;
use App\Filament\Resources\StationResource\RelationManagers;
use App\Models\Station;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StationResource extends Resource
{
    protected static ?string $model = Station::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('station_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('station_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->maxLength(255),
                Forms\Components\TextInput::make('state')
                    ->maxLength(255),
                Forms\Components\TextInput::make('zip_code')
                    ->maxLength(255),
                Forms\Components\TextInput::make('country')
                    ->maxLength(255),
                Forms\Components\TextInput::make('station_manager_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('station_phone1')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('station_phone2')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('street_address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('opening_hours')
                    ->maxLength(255),
                Forms\Components\TextInput::make('closing_time')
                    ->maxLength(255),
                Forms\Components\TextInput::make('geolocation')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('date_created'),
                Forms\Components\DateTimePicker::make('date_verified'),
                Forms\Components\DateTimePicker::make('date_approved'),
                Forms\Components\TextInput::make('added_by')
                    ->maxLength(255),
                Forms\Components\TextInput::make('verifier')
                    ->maxLength(255),
                Forms\Components\TextInput::make('approver')
                    ->maxLength(255),
                Forms\Components\Textarea::make('comment')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('station_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('station_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('station_manager_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('station_phone1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('station_phone2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('street_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('opening_hours')
                    ->searchable(),
                Tables\Columns\TextColumn::make('closing_time')
                    ->searchable(),
                Tables\Columns\TextColumn::make('geolocation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_created')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_verified')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_approved')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('added_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('verifier')
                    ->searchable(),
                Tables\Columns\TextColumn::make('approver')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListStations::route('/'),
            'create' => Pages\CreateStation::route('/create'),
            'edit' => Pages\EditStation::route('/{record}/edit'),
        ];
    }
}
