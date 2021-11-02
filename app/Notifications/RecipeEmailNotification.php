<?php

namespace App\Notifications;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class RecipeEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public User $user;
    public Recipe $recipe;
    public string $lastMessage;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Recipe $recipe, string $lastMessage)
    {
        $this->recipe = $recipe;
        $this->lastMessage = $lastMessage;
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
        return (new MailMessage)->view('layouts.email.recipes.recipe_answer_notification', [
            'name' => $notifiable->name,
            'lastname' => $notifiable->lastname,
            'subject' => $this->recipe->label,
            'lastMessage' => $this->lastMessage,
            'slug' => $this->recipe->slug
        ]);
//                    ->greeting('Test du hello !')
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!')
//                    ->line($notifiable->name);
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
