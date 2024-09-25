<?php

namespace App\Filament\Resources;

use App\Enums\UserRatingEnum;
use App\Filament\Resources\FeedbackResource\Pages;
use App\Models\Feedback;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Review Tasks';

    protected static ?int $navigationSort = 4;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('station_id')
                    ->label('Station')
                    ->relationship('station', 'name') // Use 'station' relationship and display 'name'
                    ->searchable()
                    ->required()
                    ->suffixAction(
                        fn ($record) => $record && $record->station
                            ? Forms\Components\Actions\Action::make('View Station')
                                ->url(route('filament.admin.resources.stations.view', $record->station->id)) // Link to Station detail page
                                ->icon('heroicon-s-eye')
                                ->openUrlInNewTab() // Open link in a new tab
                            : null
                    ),
                Forms\Components\DateTimePicker::make('date'),
                Forms\Components\TimePicker::make('time'),
                // User relationship as Select
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name') // Use 'user' relationship and display 'name'
                    ->searchable()
                    ->required()
                    ->suffixAction(
                        fn ($record) => $record && $record->user
                            ? Forms\Components\Actions\Action::make('View User')
                                ->url(route('filament.admin.resources.users.view', $record->user->id)) // Link to User detail page
                                ->icon('heroicon-s-eye')
                                ->openUrlInNewTab() // Open link in a new tab
                            : null
                    ),
                Forms\Components\Textarea::make('comment')
                    ->required()
                    ->columnSpanFull(),
                // Use a select field for user rating using enum values
                Forms\Components\Select::make('user_rating')
                    ->label('Rating')
                    ->required()
                    ->options([
                        UserRatingEnum::Poor->value => 'Poor',
                        UserRatingEnum::Fair->value => 'Fair',
                        UserRatingEnum::Good->value => 'Good',
                        UserRatingEnum::Great->value => 'Great',
                        UserRatingEnum::Excellent->value => 'Excellent',
                    ]),

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
                // Station relation column
                Tables\Columns\TextColumn::make('station.station_name')
                    ->label('Station')
                    ->url(fn ($record) => route('filament.admin.resources.stations.view', $record->station->id)) // Link to StationResource view
                    ->openUrlInNewTab()
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time'),
                // User relation column
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->formatStateUsing(fn ($state) => $state ?? 'Anonymous')
                    ->url(fn ($record) => $record->user ? route('filament.admin.resources.users.view', $record->user->id) : null) // Link to User detail page
                    ->openUrlInNewTab()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_rating')
                    ->formatStateUsing(fn ($state) => UserRatingEnum::tryFrom($state)?->label() ?? 'Unknown'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeedback::route('/'),
//            'create' => Pages\CreateFeedback::route('/create'),
            'view' => Pages\ViewFeedback::route('/{record}'),
//            'edit' => Pages\EditFeedback::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
