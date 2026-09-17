<?php

namespace App\Mail;

use Illuminate\Support\Collection;
use App\Models\AdminEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RefundMail extends Mailable
{
    use Queueable, SerializesModels;

    public AdminEvent $event;
    public Collection $tickets;

public function __construct(AdminEvent $event, Collection $tickets)
{
    $this->event = $event;
    $this->tickets = $tickets;
}

    public function build()
    {
        return $this->view('Email.refund', [
            'event' => $this->event,
            'tickets' => $this->tickets,
        ])
            ->subject("Your Booking Couldn’t Be Completed – Seats Unavailable : " . $this->event->event_name);
    }
}
