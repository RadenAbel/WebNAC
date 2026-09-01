<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JoinRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param array{name:string,age:?int,gender:?string,whatsapp:string,email:string,category:?string,message:?string} $data
     */
    public function __construct(public array $data)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran Baru — ' . $this->data['name'],
            replyTo: [$this->data['email']], // biar admin tinggal klik "Reply" untuk balas ke calon anggota
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.join-request',
            with: ['data' => $this->data],
        );
    }
}