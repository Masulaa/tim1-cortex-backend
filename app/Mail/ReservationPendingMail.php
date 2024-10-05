<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationPendingMail extends Mailable
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
            ->subject('Your Reservation is Pending')
            ->view('emails.reservation_pending')
            ->with([
                'reservation' => $this->reservation,
                'user' => $this->user
            ]);
    }

}
