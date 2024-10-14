<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancellationInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $pdfContent;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Reservation  $reservation
     * @param  string  $pdfContent
     * @return void
     */
    public function __construct($reservation, $pdfContent)
    {
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
        return $this->subject('Cancellation Invoice for Reservation ID: ' . $this->reservation->id)
            ->view('emails.reservation_completed')
            ->with([
                'reservationDetails' => $this->reservation,
            ])
            ->attachData($this->pdfContent, 'invoice-' . $this->reservation->id . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}