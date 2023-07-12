<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductReplaceNotification extends Notification implements ShouldQueue
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

    public function withDelay(object $notifiable): array
    {
        return [
            'database' => now()->addSecond(5),
            'mail' => now()->addSecond(5),
        ];
    }

    public function routeNotificationForMail(Notification $notification): array|string
    {
 
        // Retorna o email e o nome do destinatário...
        return [$this->product->user->name => $this->product->name->email];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Solicitação de Troca de Produto')
        ->greeting("Olá " . strstr($this->product->user->name,' ',true))
        ->line("Foi feito um pedido de troca pelo seu produto {$this->product->name}")
        ->line("Para mais informações acesse a aba de notificações no nosso sistema");
                    
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => "Olá " . strstr($this->product->user->name,' ',true) . ", você possui o produto {$this->product->name} e o(a) " . strstr($this->productReplace->user->name,' ',true) . " tem o produto {$this->productReplace->name}. Ambos os itens parecem adequados para a troca mútua. Ele(a) deseja trocar os produtos, caso queira efetuar a troca será necessário apenas confirmar com o botão abaixo, caso não queira, poderá cancelar!",
            'product' => $this->product,
            'productReplace' => $this->productReplace,
        ];
    }
}
