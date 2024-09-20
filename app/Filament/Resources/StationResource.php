<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StationResource\Pages;
use App\Filament\Resources\StationResource\RelationManagers;
use App\Models\Station;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StationResource extends Resource
{
    protected static ?string $model = Station::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Review Tasks';

    protected static ?int $navigationSort = 3;


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
                    ->disabled()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('date_created')
                    ->disabled(),
                Forms\Components\DateTimePicker::make('date_verified')
                    ->disabled(),
                Forms\Components\DateTimePicker::make('date_approved')
                    ->disabled(),
                Forms\Components\TextInput::make('added_by')
                    ->maxLength(255)
                    ->disabled(), // Disable direct editing
                Forms\Components\TextInput::make('verifier')
                    ->disabled()
                    ->maxLength(255),
                Forms\Components\TextInput::make('approver')
                    ->disabled()
                    ->maxLength(255),
                Forms\Components\Textarea::make('comment')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();

                if ($user->hasRole('Super Admin')) {
                    // Super Admin sees only approved by Admin and not rejected
                    $query->whereNotNull('approver')
                        ->whereNotIn('approver', ['Rejected', 'Pending']);
                }
                // Admins see all records
                // You can add additional role-based queries here if needed
                return $query;
            })
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
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'gray',
                        'Rejected' => 'warning',
                        default => 'success',
                    }),
                Tables\Columns\TextColumn::make('approver')
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'gray',
                        'Rejected' => 'warning',
                        default => 'success',
                    }),
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
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->action(function (Station $record, $data) {
                        $user = auth()->user();

                        $status = $data['status'];
                        $record->approver = $status === 'Approved' ? $user->name : 'Rejected';
                        $record->date_approved = now();
                        $record->save();

                        Notification::make()
                            ->title('Success')
                            ->success()
                            ->body("Station has been $status Successfully")
                            ->send();
                    })
                    ->form([
                        Forms\Components\Radio::make('status')
                            ->label('Approval Status')
                            ->options([
                                'Approved' => 'Approved',
                                'Rejected' => 'Rejected',
                            ])
                            ->default('Approved')
                            ->required(),
                    ])
                    ->visible(fn (Station $record) => auth()->user()->hasRole('Admin')), // Only for Admins
                Tables\Actions\Action::make('verify')
                    ->label('Verify')
                    ->icon('heroicon-o-check')
                    ->requiresConfirmation()
                    ->action(function (Station $record, $data) {
                        $user = auth()->user();

                        $status = $data['status'];
                        $record->verifier = $status === 'Approved' ? $user->name : 'Rejected';
                        $record->date_verified = now();
                        $record->save();

                        Notification::make()
                            ->title('Success')
                            ->success()
                            ->body("Station has been $status Successfully")
                            ->send();
                    })
                    ->form([
                        Forms\Components\Radio::make('status')
                            ->label('Verification Status')
                            ->options([
                                'Approved' => 'Approved',
                                'Rejected' => 'Rejected',
                            ])
                            ->default('Approved')
                            ->required(),
                    ])
                    ->visible(fn (Station $record) => auth()->user()->hasRole('Super Admin')  && $record->approver !== null && $record->approver !== 'Rejected'), // Only for Super Admins if approved
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListStations::route('/'),
            'create' => Pages\CreateStation::route('/create'),
            'view' => Pages\ViewStation::route('/{record}'),
            'edit' => Pages\EditStation::route('/{record}/edit'),
        ];
    }
}
