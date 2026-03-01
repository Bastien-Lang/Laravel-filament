<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventAttendanceConfirmation;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('visibility', 'PUBLIC')
            ->orderBy('event_date')
            ->paginate(10);

        return view('events.index', compact('events'));
    }

    public function show(Request $request, Event $event)
    { 
        if ($event->visibility === 'PUBLIC') {
            return view('events.show', compact('event'));
        }

       
        if ($event->visibility === 'PRIVATE') {
            if ($request->hasValidSignature() || auth()->id() === $event->organizer_id) {
                return view('events.show', compact('event'));
            }
        }
        $event->load('feedbacks');

        // Sinon, personne ne passe
        abort(403, "Cet événement est privé. Veuillez utiliser le lien reçu par email.");
    }

    public function register(Event $event)
    {
        abort_if($event->visibility !== 'PUBLIC', 404);

        return view('events.register', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        abort_if($event->visibility !== 'PUBLIC', 404);

        $data = $request->validate([
            'contact_name'  => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email'],
            'guests_count'  => ['required', 'integer', 'min:0', 'max:5'],
            'presence'      => ['required', 'in:Oui,Non'],
            'dietary_notes' => ['nullable', 'string'],
            'guests'        => ['array'],
            'guests.*.name' => ['required_with:guests', 'string', 'max:255'],
            'guests.*.dietary' => ['nullable', 'string'],
            'guests.*.email' => ['nullable', 'email'],
        ]);

        DB::transaction(function () use ($event, $data) {
            $registration = Registration::create([
                'event_id'      => $event->id,
                'contact_name'  => $data['contact_name'],
                'contact_email' => $data['contact_email'],
                'status'        => 'CONFIRMED',
            ]);

            Guest::create([
                'registration_id' => $registration->id, 
                'full_name'       => $data['contact_name'],
                'dietary_notes'   => $data['dietary_notes'] ?? null,
                'is_primary'      => true,
            ]);

            for ($i = 0; $i < $data['guests_count']; $i++) {
                Guest::create([
                    'registration_id' => $registration->id,
                    'full_name'       => $data['guests'][$i]['name'] ?? null,
                    'dietary_notes'   => $data['guests'][$i]['dietary'] ?? null,
                    'email'           => $data['guests'][$i]['email'] ?? null,
                    'is_primary'      => false,
                ]);
            }
        });
        Mail::to($registration->contact_email)
            ->send(new EventAttendanceConfirmation($event, $registration->contact_name));

        foreach ($data['guests'] as $guestData) {
            if (!empty($guestData['email'])) {
                Mail::to($guestData['email'])
                    ->send(new EventAttendanceConfirmation($event, $guestData['name'] ?? 'Invité'));
            }
        }

        return redirect()
            ->route('events.confirmation', $event)
            ->with('success', 'Inscription confirmée');
    }

    public function confirmation(Event $event)
    {
        return view('events.confirmation', compact('event'));
    }
}