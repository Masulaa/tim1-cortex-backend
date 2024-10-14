<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationStartedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($reservation, $user)
    {
        $this->reservation = $reservation;
        $this->user = $user;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Your Reservation Has Started!')
            ->view('emails.reservation_started') // Izmenjeno na reservation_started
            ->with([
                'reservation' => $this->reservation,
                'user' => $this->user
            ]);
    }
}