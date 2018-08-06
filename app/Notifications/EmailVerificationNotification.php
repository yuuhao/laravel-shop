<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class EmailVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $token = Str::random(16);
        Cache::set('email_verification_'.$notifiable->email, $token, 30);
        $url = route('email_verification.verify',['email' => $notifiable->email, 'token' => $token]);
        return (new MailMessage)
                    ->greeting($notifiable->name.'您好：') // 设置邮件的欢迎词
                    ->subject('注册成功，请验证您的邮箱') // 设定邮件的标题
                    ->line('请点击下方链接验证您的邮箱')    // 会在邮件内容添加一行文字
                    ->action('验证',$url);   //会在邮件内容添加一个链接按钮。这就是激活链接

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
