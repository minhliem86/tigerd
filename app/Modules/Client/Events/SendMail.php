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
    public $data;
    public $customer_email;
    public $subject;

    public function __construct($data = [], $customer_email, $subject)
    {
        $this->data = $data;
        $this->customer_email = $customer_email;
        $this->subject = $subject;
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
