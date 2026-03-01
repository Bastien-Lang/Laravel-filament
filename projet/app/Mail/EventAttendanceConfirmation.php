<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class EventAttendanceConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $userName;

    public function __construct($event, $userName)
    {
        $this->event = $event;
        $this->userName = $userName;
    }

    public function build()
    {
        $signedUrl = URL::signedRoute('events.show', ['event' => $this->event->id]);

        return $this->subject('Confirmation - ' . $this->event->title)
                    ->view('emails.event-confirmation')
                    ->with([
                        'urlDetails' => $signedUrl, 
                    ]);
    }
}
?>