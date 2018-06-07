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
        Mail::send('Client::emails.payment_email',['name'=> $event->name, 'cart' => $event->cart], function ($message) use ($event){
            $message->from(env("MAIL_USERNAME"));
            $message->to($event->customer_email);
            $message->subject('Email Xác Nhận Mua Hàng Thành Công.');
        });
    }
}
