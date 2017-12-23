<?php

use Illuminate\Database\Seeder;

class PagesTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Pages::class, 3)->create();
    }
}
