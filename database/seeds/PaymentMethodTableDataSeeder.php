<?php

use Illuminate\Database\Seeder;

class PaymentMethodTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\PaymentMethod::class)->create();
    }
}
