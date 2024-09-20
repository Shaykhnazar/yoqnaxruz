<?php

namespace App\Filament\Resources\StationResource\Pages;

use App\Filament\Resources\StationResource;
use App\Models\Station;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewStation extends ViewRecord
{
    protected static string $resource = StationResource::class;

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
                        $record->verifier = $user->name; // Admin's user_id
                    } else {
                        $record->verifier = 'Rejected';
                    }
                    $record->date_verified = now();

                    $record->save();
                    Notification::make()
                        ->title('Success')
                        ->success()
                        ->body("Station has been $status Successfully")
                        ->send();
                })
                ->visible(fn (Station $record) => auth()->user()->hasRole('Super Admin') && $record->approver !== 'Rejected'),

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
                        $record->approver = $user->name; // Super Admin's user_id
                    } else {
                        $record->approver = 'Rejected';
                    }
                    $record->date_approved = now();

                    $record->save();
                    Notification::make()
                        ->title('Success')
                        ->success()
                        ->body("Station has been $status Successfully")
                        ->send();
                })
                ->visible(fn (Station $record) => auth()->user()->hasRole('Admin')),
        ];
    }

}
