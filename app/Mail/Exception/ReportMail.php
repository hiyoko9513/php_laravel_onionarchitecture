<?php

declare(strict_types=1);

namespace App\Mail\Exception;

use AllowDynamicProperties;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

#[AllowDynamicProperties] class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public Throwable $exception;

    /**
     * Create a new message instance.
     */
    public function __construct(Throwable $e)
    {
        $this->error = $e;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '【emergency】' . env('APP_NAME') . ' bug report',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.exception.report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build(): ReportMail
    {
        return $this->to(env('MAIL_TO_ADDRESS_FOR_DEVELOPER'))
            ->with([
                'requestId'     => Log::sharedContext()['request-id'],
                'jsonMessage'   => $this->error->getMessage(),
                'code'          => $this->error->getCode() ?? 0,
            ]);
        // ->cc('report@hiyoko.com')
        // ->bcc('report@hiyoko.com')
        // ->subject('会員登録が完了しました')
        // ->view('mail.WelcomeEmail')// html mail
        // ->text('mail.WelcomeEmail_text')// text mail
    }
}
