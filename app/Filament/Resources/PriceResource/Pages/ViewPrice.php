<?php

namespace App\Filament\Resources\PriceResource\Pages;

use App\Filament\Resources\PriceResource;
use App\Models\Price;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

class ViewPrice extends ViewRecord
{
    protected static string $resource = PriceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('verify')
                ->label('Verify')
                ->icon('heroicon-o-check')
                ->color('success')
                ->requiresConfirmation()
                ->form([
                    Forms\Components\Radio::make('status')
                        ->label('Verification Status')
                        ->options([
                            'Approved' => 'Approve',
                            'Rejected' => 'Reject',
                        ])
                        ->default('Approved')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $record = $this->record;
                    $user = auth()->user();

                    $status = $data['status'];
                    if ($status === 'Approved') {
                        $record->verified_by = $user->name; // Admin's user_id
                    } else {
                        $record->verified_by = 'Rejected';
                    }

                    $record->save();
                    Notification::make()
                        ->title('Success')
                        ->success()
                        ->body("Price has been $status Successfully")
                        ->send();
                })
                ->visible(fn (Price $record) => auth()->user()->hasRole('Super Admin') && $record->approved_by !== null && $record->approved_by !== 'Rejected'),

            Actions\Action::make('approve')
                ->label('Approve')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->form([
                    Forms\Components\Radio::make('status')
                        ->label('Approval Status')
                        ->options([
                            'Approved' => 'Approve',
                            'Rejected' => 'Reject',
                        ])
                        ->default('Approved')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $record = $this->record;
                    $user = auth()->user();

                    $status = $data['status'];
                    if ($status === 'Approved') {
                        $record->approved_by = $user->name; // Super Admin's user_id
                    } else {
                        $record->approved_by = 'Rejected';
                    }

                    $record->save();
                    Notification::make()
                        ->title('Success')
                        ->success()
                        ->body("Price has been $status Successfully")
                        ->send();
                })
                ->visible(fn (Price $record) => auth()->user()->hasRole('Admin')),
        ];
    }
}
