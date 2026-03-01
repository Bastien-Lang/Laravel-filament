<?php

namespace App\Filament\Resources\Events\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema; 
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Table;
// Les nouveaux imports pour v4
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Models\Registration;
use App\Mail\EventAttendanceConfirmation;
use Illuminate\Support\Facades\Mail;

class GuestsRelationManager extends RelationManager
{
    protected static string $relationship = 'guests'; 

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('full_name')
                    ->required(),
                TextInput::make('email')
                    ->required()
                    ->email(),
                TextInput::make('dietary_notes'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('registration.contact_name')
                    ->label('Inscription'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                    $event = $this->getOwnerRecord();

                    $registration = Registration::create([
                        'event_id' => $event->id,
                        'contact_name' => $data['full_name'],
                        'contact_email' => $data['email'],
                    ]);

                    Mail::to($data['email'])->send(new EventAttendanceConfirmation($event, $data['full_name']));

                    $data['registration_id'] = $registration->id;
                    return $data;
                })
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}