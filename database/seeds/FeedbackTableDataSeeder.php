<?php

use Illuminate\Database\Seeder;

class FeedbackTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Feedback::class, 10)->create();
    }
}
