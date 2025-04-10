<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation; // Reservation object
    public $type;        // Type of email: confirm or reject

    /**
     * Create a new message instance.
     *
     * @param  mixed  $reservation
     * @param  string $type
     */
    public function __construct($reservation, $type = 'confirm')
    {
        $this->reservation = $reservation;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->type === 'reject' ? 'Reservation Rejected' : 'Reservation Confirmation';
        $view = $this->type === 'reject' ? 'emails.rejectreservation-notification' : 'emails.reservation-notification';

        return $this->subject($subject)
                    ->view($view)
                    ->with(['reservation' => $this->reservation]);
    }
}
