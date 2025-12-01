<?php

namespace App\Mail;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $seller;
    public $reason;

    public function __construct(Seller $seller, $reason = null)
    {
        $this->seller = $seller;
        $this->reason = $reason ?? 'Data yang Anda berikan tidak memenuhi syarat atau tidak lengkap.';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan Penolakan Pendaftaran Seller - MartPlace',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.seller-rejected',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
