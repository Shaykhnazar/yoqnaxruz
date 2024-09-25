<?php

namespace App\Filament\Resources;

use App\Enums\UserRatingEnum;
use App\Filament\Resources\FeedbackResource\Pages;
use App\Filament\Resources\FeedbackResource\RelationManagers;
use App\Models\Feedback;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Forms\Components\TextInput::make('station_id')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('date'),
                Forms\Components\TimePicker::make('time'),
                Forms\Components\TextInput::make('user_id')
                    ->maxLength(255),
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
                Tables\Columns\TextColumn::make('station_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time'),
                Tables\Columns\TextColumn::make('user_id')
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
