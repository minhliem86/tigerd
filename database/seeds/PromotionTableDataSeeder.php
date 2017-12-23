<?php

use Illuminate\Database\Seeder;

class PromotionTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Promotion::class, 3)->create();
    }
}
