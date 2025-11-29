<?php

namespace App\Mail;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommentThankYou extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    public $product;

    public function __construct(Comment $comment, Product $product)
    {
        $this->comment = $comment;
        $this->product = $product;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Terima Kasih atas Komentar dan Rating Anda!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.comment-thank-you',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}