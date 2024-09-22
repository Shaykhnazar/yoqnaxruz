<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComplaintResource\Pages;
use App\Filament\Resources\ComplaintResource\RelationManagers;
use App\Models\Complaint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Review Tasks';

    protected static ?int $navigationSort = 5;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('complaint_id')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('date_logged'),
                Forms\Components\TextInput::make('time'),
                Forms\Components\TextInput::make('user_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('station_id')
                    ->maxLength(255),
                Forms\Components\Textarea::make('complainant')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status')
                    ->maxLength(255),
                Forms\Components\TextInput::make('display')
                    ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No'),

                // Use FileUpload for attachment input
                Forms\Components\FileUpload::make('attachments')
                    ->label('Attachment')
                    ->directory('uploads/feedback')
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('complaint_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_logged')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time'),
                Tables\Columns\TextColumn::make('user_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('station_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\BooleanColumn::make('display')
                    ->label('Display') // Optional label customization
                    ->trueIcon('heroicon-o-check-circle') // Optional icon for true state
                    ->falseIcon('heroicon-o-x-circle') // Optional icon for false state
                    ->trueColor('success') // Optional color for true state
                    ->falseColor('danger') // Optional color for false state
                    ->sortable(),
                Tables\Columns\ImageColumn::make('attachments'),
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
//                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListComplaints::route('/'),
//            'create' => Pages\CreateComplaint::route('/create'),
            'view' => Pages\ViewComplaint::route('/{record}'),
//            'edit' => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

}
