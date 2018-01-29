<?php
use Illuminate\Database\Seeder;

class PaymentStatusTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'code' => 1,
                'description' => 'Chưa Thanh Toán',
            ],
            [
                'code' => 2,
                'description' => 'Đã Thanh Toán',
            ]
        ];
        DB::table('paymentstatus')->insert($data);
    }
}
