<?php

namespace Illuminate\Auth\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
			->line('You are receiving this email because we received a password reset request for your account.')
            ->line('您收到了这封邮件,是因为我们收到了来自您账户的密码重置请求.')
            ->action('Reset Password', url(config('app.url').route('password.reset', $this->token, false)))
			->line('If you did not request a password reset, no further action is required.')
			->line('如果您没有要求密码重置，则无需要理会当前操作')
			->line('Thanks!')
			->line('谢谢!')
			->salutation(config('app.name').'账户团队');
    }
}
