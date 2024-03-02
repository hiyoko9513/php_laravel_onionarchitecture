<?php

declare(strict_types=1);

namespace App\Mail\Exception;

use AllowDynamicProperties;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
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
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build(): ReportMail
    {
        return $this->to('report@hiyoko.com')
            ->with([
                'jsonMessage' => $this->error->getMessage(),
                'code' => $this->error->getCode() ?? 0,
            ]);
        // ->cc('report@hiyoko.com')// cc
        // ->bcc('report@hiyoko.com')// bcc
        // ->subject('会員登録が完了しました')// 件名
        // ->view('mail.WelcomeEmail')// 本文（HTMLメール）
        // ->text('mail.WelcomeEmail_text')// 本文（プレーンテキストメール）
    }
}
