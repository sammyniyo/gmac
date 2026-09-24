<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order request '.$this->order->reference.' from '.$this->order->customer_name,
            replyTo: [
                new Address($this->order->email, $this->order->customer_name),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order-received',
        );
    }
}
