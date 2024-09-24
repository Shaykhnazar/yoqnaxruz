<?php

namespace App\Filament\Resources\ComplaintResource\RelationManagers;

use App\Models\ComplaintReply;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;

class RepliesRelationManager extends RelationManager
{
    protected static string $relationship = 'replies';

    protected static ?string $recordTitleAttribute = 'comment';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('comment')
                    ->label('Reply')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->label('Reply Date')
                    ->default(now())
                    ->required(),
            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('comment')
                    ->label('Reply'),
                Tables\Columns\TextColumn::make('date')
                    ->label('Reply Date')
                    ->date(),
                Tables\Columns\TextColumn::make('reply_by')
                    ->label('Replied By'),
            ])
            ->filters([
                // Add any filters if necessary
            ])
            ->actions([
                Action::make('reply')
                    ->label('Reply')   // Label for the button
                    ->action(function (array $data, $record) {  // Action to handle the reply submission
                        // Save the reply to the database
                        ComplaintReply::create([
                            'complaint_id' => $record->complaint_id,
                            'user_id' => auth()->user()->user_id,
                            'comment' => $data['comment'],
                            'date' => now(),
                            'reply_by' => auth()->user()->name,
                        ]);
                    })
                    ->form([    // Modal form schema
                        Forms\Components\Textarea::make('comment')
                            ->label('Reply')
                            ->required(),
                    ])
                    ->modalHeading('Write a Reply')    // Modal heading
                    ->modalButton('Submit Reply')      // Button text in modal
                    ->modalWidth('lg'),              // Modal width (can be 'sm', 'md', 'lg', 'xl', '2xl')
            ]);
    }
}

