<?php

namespace App\Notifications;

use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserResponse extends Notification
{
    use Queueable;

    private $graduate;
    private $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($graduate)
    {
        $this->graduate = $graduate;
        $this->url = url("http://localhost/reports/{$graduate->graduate_id}");
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'fcm'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'graduate_id' => $this->graduate->graduate_id,
            'title' => "Respond Activity",
            'body' => "Someone has responded {$this->graduate->full_name}.",
            'click_action' => $this->url
        ];
    }

    public function toFcm($notifiable)
    {
        $message = new FcmMessage();

        $message->content([
            'title' => 'Respond Activity',
            'body' => "Someone has responded {$this->graduate->full_name}.",
            'badge' => $notifiable->unreadNotifications->count(),
            'click_action' => $this->url
        ]);

        return $message;
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
