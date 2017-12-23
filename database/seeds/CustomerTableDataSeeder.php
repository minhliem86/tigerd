<?php

use Illuminate\Database\Seeder;

class CustomerTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Customer::class, 10)->create();
    }
}
