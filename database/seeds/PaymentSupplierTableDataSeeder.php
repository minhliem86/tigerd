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
        $data = [
            [
                'name' => 'OnePay',
                'description' => 'Thanh toán thông qua OnePay',
                'order'=> 1,
                'default' => 1
            ],
            [
                'name' => 'Ngân Lượng',
                'description' => 'Thanh toán thông qua Ngân Lượng',
                'order'=> 2,
                'default' => 0
            ],
            [
                'name' => 'Paypal',
                'description' => 'Thanh toán thông qua Paypal',
                'order'=> 3,
                'default' => 0
            ]
        ];

        DB::table('payment_suppliers')->insert($data);

    }
}
