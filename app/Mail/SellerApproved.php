<?php

namespace App\Mail;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $seller;
    public $password;

    public function __construct(Seller $seller, $password = null)
    {
        $this->seller = $seller;
        $this->password = $password;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat! Akun Seller Anda Telah Disetujui - MartPlace',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.seller-approved',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
