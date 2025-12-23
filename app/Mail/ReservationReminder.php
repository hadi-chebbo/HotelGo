<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reminder: Your Stay at ' . $this->reservation->hotel->name . ' is Tomorrow!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation-reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}