<?php

namespace App\Filament\Resources\ComplaintResource\Pages;

use App\Filament\Resources\ComplaintResource;
use App\Models\ComplaintReply;
use Filament\Forms;
use Filament\Resources\Pages\ViewRecord;

class ViewComplaint extends ViewRecord
{

    protected static string $resource = ComplaintResource::class;

    // Define a form to submit a reply
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Textarea::make('comment')
                ->label('Admin Reply')
                ->required(),
            Forms\Components\Hidden::make('complaint_id')
                ->default($this->record->id),
            Forms\Components\Hidden::make('user_id')
                ->default(auth()->user()->user_id),
            Forms\Components\Hidden::make('reply_by')
                ->default(auth()->user()->name),
        ];
    }

    // Handle reply submission
    public function submitReply()
    {
        $this->form->getState();
        $this->validate(); // Validate the form fields

        // Save the reply
        ComplaintReply::create([
            'complaint_id' => $this->record->id,
            'user_id' => auth()->user()->user_id,
            'comment' => $this->form->getState()['comment'],
            'date' => now(),
            'reply_by' => auth()->user()->name,
        ]);

        // Reset the form after submission
        $this->resetForm();

        // Optionally show a success message
        $this->notify('success', 'Reply submitted successfully!');
    }

    // Actions available on the page
//    protected function getActions(): array
//    {
//        return [
//            Action::make('submitReply')
//                ->label('Submit Reply')
//                ->form($this->getFormSchema())
//                ->action('submitReply'),
//        ];
//    }
}
