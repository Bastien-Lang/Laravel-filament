<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\Registration; // Ajouté pour la clarté
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str; // INDISPENSABLE pour Str::random()
use App\Mail\EventFeedbackMail;

class SendEventFeedbackEmails extends Command
{
    protected $signature = 'mail:send-feedback';
    protected $description = 'Envoie un mail de feedback aux participants des événements terminés hier';

    public function handle()
    {
        // 1. Récupérer les événements passés (entre il y a 24h et maintenant)
        $events = Event::where('event_date', '<', now())
                       ->where('event_date', '>=', now()->subDay())
                       ->get();

        if ($events->isEmpty()) {
            $this->info("Aucun événement terminé hier n'a été trouvé.");
            return;
        }

        foreach ($events as $event) {
            // 2. On parcourt chaque inscription de l'événement
            // On utilise with('registration') ou l'accès direct via la relation
            foreach ($event->registrations as $registration) {
                
                // 3. Sécurité : Ne pas renvoyer de mail si l'avis a déjà été donné
                if ($registration->feedback_rating !== null) {
                    continue; 
                }

                // 4. Générer un token unique si le champ est vide
                if (!$registration->feedback_token) {
                    $registration->update([
                        'feedback_token' => Str::random(32)
                    ]);
                }
                if (!$registration->feedback_token) {
                    $registration->feedback_token = Str::random(32);
                    $registration->save(); // On force la sauvegarde en base
                }
                // 5. Envoyer le mail avec l'objet Event ET Registration (pour le token)
                Mail::to($registration->contact_email)->send(new EventFeedbackMail($event, $registration));
            }
            
            $this->info("Emails de feedback envoyés pour l'événement : {$event->title}");
        }

        $this->info("Traitement terminé.");
    }
}