<?php

namespace App\Mail;

use App\Models\Agendamiento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionASeguridadMail extends Mailable
{
    use Queueable, SerializesModels;

    public $agendamiento;

    /**
     * Crea una nueva instancia del mensaje.
     *
     * @param Agendamiento $agendamiento
     */
    public function __construct(Agendamiento $agendamiento)
    {
        $this->agendamiento = $agendamiento;
    }

    /**
     * Construye el mensaje de correo.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notificación a Seguridad')
            ->markdown('emails.notificacion.parque');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notificacion A Seguridad Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.notificacion.seguridad',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
