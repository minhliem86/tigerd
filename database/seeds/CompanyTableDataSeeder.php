<?php

use Illuminate\Database\Seeder;

class CompanyTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\CompanyInfomations::class,1)->create();
    }
}
