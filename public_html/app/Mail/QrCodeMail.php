<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QrCodeMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @param string $eventName
     * @param array $qrCodeDetails
     */
    public function __construct(string $eventName, array $qrCodeDetails)
    {
        $this->eventName = $eventName;
        $this->qrCodeDetails = $qrCodeDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $qrCodePaths = [];
        $qrCodeCids = [];

        $barCodePaths = [];
        $barCodeCids = [];

        // Loop through the event details and find the QR code paths
        foreach ($this->qrCodeDetails as $detail) {
            foreach ($detail['qr_codes'] as $qr) {
                $qrCodePath = storage_path('app/public/' . $qr['qr_code_path']);
                $barCodePath=storage_path('app/public/' . $qr['bar_code_path']);
                // If the file exists, add it to the array
                if (file_exists($qrCodePath)) {
                    $qrCodePaths[] = $qrCodePath;
                    $qrCodeCids[] = $qr['qr_code_cid'];
                } else {
                    // If the file does not exist, log an error message
                    logger('File not found: ' . $qrCodePath);
                }
                if (file_exists($barCodePath)) {
                    $barCodePaths[] = $barCodePath;
                    $barCodeCids[] = $qr['bar_code_cid'];
                } else {
                    // If the file does not exist, log an error message
                    logger('File not found: ' . $barCodePath);
                }
            }
        }
        // Pass the variables to the view
        $mail = $this->view('Email.qrcode', [
            'eventName' => $this->eventName,
            'qrCodeDetails' => $this->qrCodeDetails,
        ])
        ->subject("Your Tickets for $this->eventName");

        // Attach the QR code images with CID
        foreach ($qrCodePaths as $index => $path) {
            $mail->attach($path, [
                'mime' => 'image/png',
                'cid' => $qrCodeCids[$index], // Ensure this matches the cid in the email template
            ]);
        }

        foreach ($barCodePaths as $index => $path) {
            $mail->attach($path, [
                'mime' => 'image/png',
                'cid' => $barCodeCids[$index], // Ensure this matches the cid in the email template
            ]);
        }

        return $mail;
    }
}
