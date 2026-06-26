<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactEnquiry extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array{name: string, email: string, company?: string|null, projectType: string, message: string, website?: string|null}  $enquiry
     */
    public function __construct(public array $enquiry) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [
                new Address($this->enquiry['email'], $this->enquiry['name']),
            ],
            subject: 'New website enquiry from '.$this->enquiry['name'],
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'mail.contact-enquiry',
            with: [
                'enquiry' => $this->enquiry,
            ],
        );
    }
}
