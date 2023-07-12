<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CancelReplaceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $product;
    private $productReplace;

    /**
     * Create a new notification instance.
     */
    public function __construct(Product $product, Product $productReplace)
    {
        $this->product = $product;
        $this->productReplace = $productReplace;
    }

    public function withDelay(object $notifiable): array
    {
        return [
            'database' => now()->addSeconds(5),
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "Olá, o pedido de troca do produto {$this->productReplace->name} pelo produto {$this->product->name} foi recusado",
        ];
    }
}
