<?php

namespace App\Listeners;

use App\Modules\Client\Events\SendMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Repositories\CustomerRepository;

class SendMailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $customer;

    public function __construct(CustomerRepository $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Handle the event.
     *
     * @param  SendMail  $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        $customer = $this->customer->find($event->customer_id);
        Mail::send('Client::emails.payment_email', ['customer' => $customer, 'cart' => $event->cart], function ($message) use ($customer){
            $message->to($customer->email);
            $message->subject('Email xác nhận mua hàng.');
        });
    }
}
