<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancellationInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $cancellationFee;
    public $pdfFilePath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reservation, $cancellationFee, $pdfFilePath)
    {
        $this->reservation = $reservation;
        $this->cancellationFee = $cancellationFee;
        $this->pdfFilePath = $pdfFilePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Cancellation Invoice for Reservation ID: ' . $this->reservation->id)
            ->view('emails.cancellation_invoice')
            ->attach($this->pdfFilePath);
    }
}
