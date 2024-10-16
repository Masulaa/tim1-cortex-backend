<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reservation;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reservation  $reservation
     * @return void
     */
    public function __construct($user, $reservation)
    {
        $this->user = $user;
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Your Reservation is Rejected')->view('emails.reservation_rejected');
    }
}
