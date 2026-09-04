<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class JoinRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param array{name:string,nickname:?string,birth_date:string,whatsapp:string,category:string,photo_path:?string,photo_ext:?string,photo_mime:?string} $data
     */
    public function __construct(public array $data)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran Baru — ' . $this->data['name'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.join-request',
            with: ['data' => $this->data],
        );
    }

    public function attachments(): array
    {
        if (empty($this->data['photo_path'])) {
            return [];
        }

        $filename = 'Pas-Foto-' . Str::slug($this->data['name']) . '.' . ($this->data['photo_ext'] ?? 'jpg');

        return [
            Attachment::fromPath($this->data['photo_path'])
                ->as($filename)
                ->withMime($this->data['photo_mime'] ?? 'image/jpeg'),
        ];
    }
}