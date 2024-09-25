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
                // User relationship as Select
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name') // Use 'user' relationship and display 'name'
                    ->searchable()
                    ->required()
                    ->suffixAction(
                        fn ($record) => $record && $record->user_id
                            ? Forms\Components\Actions\Action::make('View User')
                                ->url(route('filament.admin.resources.users.view', $record->user->id)) // Link to User detail page
                                ->icon('heroicon-s-eye')
                                ->openUrlInNewTab() // Open link in a new tab
                            : null
                    ),
                Forms\Components\Select::make('station_id')
                    ->label('Station')
                    ->relationship('station', 'name') // Use 'station' relationship and display 'name'
                    ->searchable()
                    ->required()
                    ->suffixAction(
                        fn ($record) => $record && $record->station_id
                            ? Forms\Components\Actions\Action::make('View Station')
                                ->url(route('filament.admin.resources.stations.view', $record->station->id)) // Link to Station detail page
                                ->icon('heroicon-s-eye')
                                ->openUrlInNewTab() // Open link in a new tab
                            : null
                    ),
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
                // User relation column
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->url(fn ($record) => route('filament.admin.resources.users.view', $record->user->id)) // Link to UserResource view
                    ->openUrlInNewTab()
                    ->searchable(),

                // Station relation column
                Tables\Columns\TextColumn::make('station.station_name')
                    ->label('Station')
                    ->url(fn ($record) => route('filament.admin.resources.stations.view', $record->station->id)) // Link to StationResource view
                    ->openUrlInNewTab()
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
            ])->defaultSort('created_at', 'desc')
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
            RelationManagers\RepliesRelationManager::class,
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
