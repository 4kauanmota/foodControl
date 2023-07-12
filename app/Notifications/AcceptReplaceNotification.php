<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptReplaceNotification extends Notification implements ShouldQueue
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

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','mail'];
    }

    public function routeNotificationForMail(Notification $notification): array|string
    {
 
        // Retorna o email e o nome do destinatário...
        return [$this->product->user->name => $this->product->name->email];
    }

    public function withDelay(object $notifiable): array
    {
        return [
            'database' => now()->addSecond(5),
            'mail' => now()->addSecond(5),
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Troca Realizada')
            ->greeting("Olá " .  strstr($this->product->user->name,' ',true))
            ->line("A troca entre os produtos foi realizada!")
            ->line("Informações de contato do proprietário abaixo")
            ->line("Nome do proprietário: {$this->productReplace->user->name}")
            ->line("E-mail do proprietário: {$this->productReplace->user->email}")
            ->line("Nome do produto: {$this->product->name}");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "message" => "Olá " . strstr($this->product->user->name,' ',true) . ", o pedido de troca do seu produto {$this->productReplace->name} pelo produto {$this->product->name} foi aceito. Para mais informações de contato acesse a sua caixa de e-mail",
            "product" => $this->product,
            "productReplace" => $this->productReplace,
        ];
    }
}
