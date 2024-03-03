<?php

declare(strict_types=1);

namespace App\Notifications\Exceptions;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Throwable;

class ReportNotification extends Notification
{
    use Queueable;

    public Throwable $exception;

    /**
     * Create a new notification instance.
     */
    public function __construct(Throwable $e)
    {
        $this->exception = $e;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $requestId = array_key_exists('request-id', Log::sharedContext())
            ? Log::sharedContext()['request-id'] : 'none';
        $code = $this->exception->getCode() ?? 0;
        return (new MailMessage())
            ->subject('【emergency】' . env('APP_NAME') . ' bug report')
            ->line('request id:' . $requestId)
            ->line('json message:' . $this->exception->getMessage())
            ->line('code:' . $code);
    }
}
