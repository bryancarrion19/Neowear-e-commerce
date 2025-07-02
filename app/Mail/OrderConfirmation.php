<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderConfirmation extends Mailable
{
    use SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->to($this->order->user->email) // Enviar al usuario
            ->cc('bryancarrion0420@gmail.com') // También al administrador
            ->subject('Confirmación de Pedido')
            ->view('mails.orders_confirmation')
            ->with(['order' => $this->order])
            ->from('bryancarrion0420@gmail.com', 'NeoWear');
    }
}
