<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Price;
use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            // Edit Button
            Actions\EditAction::make(),

            // Delete Button
            Actions\DeleteAction::make(),

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
                        ->body("User has been $status Successfully")
                        ->send();
                })
                ->visible(fn (User $record) => in_array($record->approved_by, ['Pending', null])),
        ];
    }
}
