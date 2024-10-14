<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationReturnedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reservation;
    public $pdfContent;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Reservation $reservation
     * @param string $pdfContent
     * @return void
     */
    public function __construct($user, $reservation, $pdfContent)
    {
        $this->user = $user;
        $this->reservation = $reservation;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Your Reservation is Completed')
            ->view('emails.reservation_completed')
            ->with([
                'userName' => $this->user->name,
                'reservationDetails' => $this->reservation,
            ])
            ->attachData($this->pdfContent, 'invoice-' . $this->reservation->id . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}