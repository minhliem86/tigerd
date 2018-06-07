<?php

namespace App\Modules\Client\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendMail extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $cart;
    public $customer_email;
    public $name;

    public function __construct($cart, $customer_email, $name)
    {
        $this->cart = $cart;
        $this->customer_email = $customer_email;
        $this->name = $name;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
