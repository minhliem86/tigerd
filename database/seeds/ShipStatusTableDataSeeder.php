<?php

use Illuminate\Database\Seeder;

class ShipStatusTableDataSeeder extends Seeder
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
                'description' => 'Chưa xử lý',
            ],
            [
                'code' => 2,
                'description' => 'Đang xử lý (đang giao hàng)',
            ],
            [
                'code' => 3,
                'description' => 'Đã giao hàng',
            ]
        ];
        DB::table('shipstatus')->insert($data);
    }
}
