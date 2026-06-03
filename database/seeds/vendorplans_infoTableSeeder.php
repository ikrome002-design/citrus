<?php

use Illuminate\Database\Seeder;

class vendorplans_infoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('vendorplan_info')->insert( array(
            0 =>
                 array (
                    'id' => '1',
                    'plan_id' => '1',
                    'plan_name' => 'BUSINESS PROMOTION',
                    'vendor_id' => '1',
                    'staff_id' => '1',
                    'price' => 10,
                    'date' => '2020-11-10',
                    'expiry_date' => '2021-11-10'
                ),
                 1 =>
                array (
                    'id' => '2',
                    'plan_id' => '2',
                    'plan_name' => 'BUSINESS SALES',
                    'vendor_id' => '2',
                    'staff_id' => '1',
                    'price' => 200,
                    'date' => '2020-11-12',
                    'expiry_date' => '2021-11-10'
                )
            )
        );
    }
}
