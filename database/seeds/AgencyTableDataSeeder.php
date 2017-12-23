<?php

use Illuminate\Database\Seeder;

class AgencyTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Agencies::class, 5)->create()
            ->each(function ($agency){
            $agency->categories()->save(factory(App\Models\Category::class)->make());
        });
    }
}
