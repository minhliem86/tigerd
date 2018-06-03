<?php
namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmailTemplateEvent extends Event{

    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $template;
    public $data;
    public $from;
    public $to;
    public $subject;

    public function __construct($template = '', $data = [], $from, $to, $subject)
    {
        $this->template = $template;
        $this->data = $data;
        $this->from = $from;
        $this->to = $to;
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