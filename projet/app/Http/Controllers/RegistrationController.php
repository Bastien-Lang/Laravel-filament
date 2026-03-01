<?php

namespace App\Http\Controllers;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\Event;


class RegistrationController extends Controller
{
    public function cancel(Event $event)
    {
        $registration = Registration::where('event_id', $event->id)
            ->where('contact_email', request()->input('email'))
            ->first();
        if ($registration) {
            $registration->status = 'CANCELED';
            $registration->save();
        }
        return redirect()->route('events.index')->with('success', 'Votre inscription a été annulée.');
    }
}