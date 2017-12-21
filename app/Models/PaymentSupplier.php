<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSupplier extends Model
{
    public $table = 'payment_suppliers';

    protected $guard = ['id'];
}
