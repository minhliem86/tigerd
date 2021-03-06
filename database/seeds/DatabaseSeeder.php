<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $tables = [
//        'agencies',
//        'categories',
//        'company',
//        'customers',
//        'news',
//        'pages',
        'payment_methods',
        'payment_suppliers',
//        'promotions',
//        'feedbacks',
//        'products',
//        'attributes',
//        'attribute_values',
        'paymentstatus',
        'shipstatus'
    ];

    protected $seeders = [
//        AgencyTableDataSeeder::class,
//        CompanyTableDataSeeder::class,
//        CustomerTableDataSeeder::class,
//        NewsTableDataSeeder::class,
//        PagesTableDataSeeder::class,
        PaymentStatusTableDataSeeder::class,
        PaymentSupplierTableDataSeeder::class,
//        PromotionTableDataSeeder::class,
//        FeedbackTableDataSeeder::class,
//        AttributeTableDataSeeder::class,
        PaymentMethodTableDataSeeder::class,
        ShipStatusTableDataSeeder::class,

    ];
    public function run()
    {
        Model::unguard();
        if (\DB::connection()->getName() === 'mysql') {
            $this->truncateDatabase();
        }
        foreach ($this->seeders as $seeder) {
            $this->call($seeder);
        }
        Model::reguard();
    }

    private function truncateDatabase()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        foreach ($this->tables as $table) {
            \DB::table($table)->truncate();
        }
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
