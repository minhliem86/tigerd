<?php

use Illuminate\Database\Seeder;

class PaymentSupplierTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\PaymentSupplier::class)->create();
    }
}
