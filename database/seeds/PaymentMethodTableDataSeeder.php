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
                'name' => 'COD',
                'slug' => 'cod',
                'description' => 'Thanh toán khi giao hàng',
                'order'=> 1
            ],
            [
                'name' => 'Thanh Toán Online',
                'slug' => 'thanh-toan-online',
                'description' => 'Thanh toán trực tuyến thông qua cổng Onepay',
                'order'=> 2
            ]
        ];
        DB::table('payment_methods')->insert($data);
    }
}
