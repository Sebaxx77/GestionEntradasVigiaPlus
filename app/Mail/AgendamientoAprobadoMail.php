<?php

namespace App\Mail;

use App\Models\Agendamientos\AgendamientoFormatoDescarga;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AgendamientoAprobadoMail extends Mailable
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
        return $this->subject('Agendamiento Aprobado')
            ->markdown('emails.agendamiento.aprobado');
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Agendamiento Aprobado Mail',
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
