<?php

namespace App\Listeners;

use App\Modules\Client\Events\SendMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendMailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  SendMail  $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        Mail::send('Client::emails.payment_email',$event->data, function ($message) use ($event){
            $message->from(env("MAIL_USERNAME"), 'TigerD.vn');
            $message->to($event->customer_email);
            $message->subject($event->subject);
        });
    }
}
