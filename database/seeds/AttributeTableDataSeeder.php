<?php

use Illuminate\Database\Seeder;

class AttributeTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Attribute::class, 1)->create()->each(function($att){
           $att->attribute_values()->save(factory(App\Models\AttributeValue::class)->make());
        });
    }
}
