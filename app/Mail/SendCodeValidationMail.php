<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendCodeValidationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    /**
     * Create a new message instance.
     */
    public function __construct(Int $code)
    {   
        $this->code = $code;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Código de Validación Pharmix',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: $this->constructBody()
        );
    }
    public function constructBody() {
        return "
         <table width='100%' border='0' cellspacing='0' cellpadding='0' style='background-color: #f4f4f7; padding: 20px 0; font-family: sans-serif;'>
            <tr>
                <td align='center'>
                    <table width='100%' max-width='600' border='0' cellspacing='0' cellpadding='0' style='max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: left;'>
                        <tr>
                            <td style='padding: 30px 20px; background-color: #041f50; text-align: center;'>
                                <h2 style='margin: 0; font-family: Cinzel, serif; color: #ffffff; letter-spacing: 1px;'>CÓDIGO DE VALIDACIÓN</h2>
                            </td>
                        </tr>
                        <tr>
                            <td style='padding: 30px; color: #333333; line-height: 1.6;'>
                                <p style='font-weight: 300; margin-top: 0;'>¡Hola!,</p>
                                <p style='font-weight: 300;'>
                                    Esperamos que se encuentre muy bien. Desde <strong>Pharmix</strong> hemos recibido su solicitud para el envío del código necesario para la gestión de su proceso.
                                </p>
                                <div style='text-align: center; margin: 30px 0;'>
                                    <span style='background-color: #f3f4f6; border: 1px dashed #ced4da; border-radius: 6px; padding: 15px 30px; font-size: 32px; font-weight: bold; letter-spacing: 6px; color: #041f50; display: inline-block;'>
                                        {$this->code}
                                    </span>
                                </div>
                                <p style='font-size: 14px; color: #6b7280; font-weight: 300;'>
                                    Queremos que su experiencia sea óptima. Por ello, recuerde que este código es de un solo uso y vencerá pronto.
                                    Si tiene alguna inquietud o no solicitó este mensaje, por favor comuníquese de inmediato con nuestro equipo de soporte o desarrolladores a través de nuestros canales oficiales.
                                </p>
                                <p style='margin-bottom: 0; font-weight: 300;'>
                                    Atentamente,<br>
                                    El equipo de <strong style='font-family: Cinzel, serif; color: #041f50;'>PHARMIX</strong>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #605e5e; color: #e2e8f0; text-align: center; padding: 20px; font-size: 12px;'>
                                <p style='font-style: italic; margin: 0 0 5px 0;'>Este es un correo automático, por favor no responda a este mensaje.</p>
                                <p style='font-style: italic; margin: 0;'>&copy; 2026 PHARMIX todos los derechos reservados.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        ";
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
