<?php

namespace App\Listeners;

use App\Events\EmailTemplateEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class EmailTemplateListener
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
    public function handle(EmailTemplateEvent $event)
    {
        Mail::send($event->template,['data'=> $event->data], function ($mes) use ($event){
           $mes->from($event->from);
           $mes->to($event->to);
           $mes->subject($event->subject);
        });

    }
}
