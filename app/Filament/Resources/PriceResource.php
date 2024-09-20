<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PriceResource\Pages;
use App\Filament\Resources\PriceResource\RelationManagers;
use App\Models\Price;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PriceResource extends Resource
{
    protected static ?string $model = Price::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Review Tasks';

    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('fuel_type')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('system_date')
                    ->required(),
                Forms\Components\TextInput::make('system_time')
                    ->required(),
                Forms\Components\DateTimePicker::make('purchase_date')
                    ->required(),
                Forms\Components\TextInput::make('purchase_time')
                    ->required(),
                Forms\Components\TextInput::make('user_geolocation')
                    ->maxLength(255),
                Forms\Components\TextInput::make('litres')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('phone_no')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('station_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('verified_by')
                    ->maxLength(255)
                    ->disabled(), // Disable direct editing
                Forms\Components\TextInput::make('approved_by')
                    ->maxLength(255)
                    ->disabled(), // Disable direct editing
                Forms\Components\TextInput::make('photo')
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
                    // Super Admin sees only approved by Admin
                    $query->whereNotNull('approved_by')
                        ->whereNotIn('approved_by', ['Rejected', 'Pending']);
                }
                // Admins see all records
                // You can add additional role-based queries here if needed
                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('fuel_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('system_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('system_time'),
                Tables\Columns\TextColumn::make('purchase_date')
                    ->date('j, F, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchase_time')
                    ->time('H:i A'),
                Tables\Columns\TextColumn::make('user_geolocation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('litres')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('station_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('verified_by')
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'gray',
                        'Rejected' => 'warning',
                        default => 'success',
                    }),
                Tables\Columns\TextColumn::make('approved_by')
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'gray',
                        'Rejected' => 'warning',
                        default => 'success',
                    }),
                Tables\Columns\TextColumn::make('photo')
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
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->action(function (Price $record, $data) {
                        $user = auth()->user();

                        $status = $data['status'];
                        $record->approved_by = $status === 'Approved' ? $user->name : 'Rejected';
                        $record->save();

                        Notification::make()
                            ->title('Success')
                            ->success()
                            ->body("Price has been $status Successfully")
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
                    ->visible(fn (Price $record) => auth()->user()->hasRole('Admin')), // Only for Admins
                Tables\Actions\Action::make('verify')
                    ->label('Verify')
                    ->icon('heroicon-o-check')
                    ->requiresConfirmation()
                    ->action(function (Price $record, $data) {
                        $user = auth()->user();

                        $status = $data['status'];
                        $record->verified_by = $status === 'Approved' ? $user->name : 'Rejected';
                        $record->save();

                        Notification::make()
                            ->title('Success')
                            ->success()
                            ->body("Price has been $status Successfully")
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
                    ->visible(fn (Price $record) => auth()->user()->hasRole('Super Admin')  && $record->approved_by !== null && $record->approved_by !== 'Rejected'), // Only for Super Admins if approved
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
            'index' => Pages\ListPrices::route('/'),
            'create' => Pages\CreatePrice::route('/create'),
            'view' => Pages\ViewPrice::route('/{record}'),
            'edit' => Pages\EditPrice::route('/{record}/edit'),
        ];
    }
}
