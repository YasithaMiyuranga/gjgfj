<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceEmail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @param string $eventName
     * @param array $invoiceDetails
     * @param string $total
     * @param string $discount
     */
    public function __construct(string $eventName, array $invoiceDetails,string $total,string $discount)
    {
        $this->eventName = $eventName;
        $this->invoiceDetails = $invoiceDetails;
        $this->total=$total;
        $this->discount=$discount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
 
    
        $mail = $this->view('Email.invoice', [
            'eventName' => $this->eventName,
            'tickets' => $this->invoiceDetails,
            'total' => $this->total,
            'discount' => $this->discount,

        ])
        ->subject("Your Invlice For for $this->eventName");

       
        return $mail;
    }
}
