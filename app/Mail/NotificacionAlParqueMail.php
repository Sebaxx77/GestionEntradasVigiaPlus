<?php

namespace App\Mail;

use App\Models\Agendamientos\AgendamientoFormatoDescarga;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionAlParqueMail extends Mailable
{
    use Queueable, SerializesModels;

    public $agendamiento;

    /**
     * Crea una nueva instancia del mensaje.
     *
     * @param AgendamientoFormatoDescarga $agendamiento
     */
    public function __construct(AgendamientoFormatoDescarga $agendamiento)
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
        return $this->subject('Notificación al Parque')
                    ->markdown('emails.notificacion.parque');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notificacion Al Parque Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.notificacion.parque',
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
