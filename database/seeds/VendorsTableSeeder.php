<?php

use App\Shop\Vendors\Vendor;
use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    static $password='$2y$10$6ELo3zxz3Owxj.srf2hdNe21jyeLho7LpN7VngCXSmsvXcHrtV4O.';
    static $new_password='$2y$10$6dqcL31J1vQniW.oLgMbKupdGIM3dM.Zl8TTtWw/YfWtZn3hPNRq.';
        \DB::table('vendors')->insert( array(
            0 =>
                array ( 
                    'first_name'     => 'Warren',
                    'last_name'      => 'Corwin',
                    'business_name'  => 'Trends',
                    'email'          => 'merchant@merchant.com',
                    'user_type'      => '1',
                    'business_location' => 'xyz',
                    'business_type'  => 1,
                    'business_about' => 'test',
                    'country'        => 99,
                    'phone_number'   => '1234567896',
                    'citrus_merchant_id'    => 'WC123456',
                    'citrus_shop_id'    => 'TR000011',
                    'password'       => $password ?: $password = bcrypt('secret'),
                    'created_at'     => '2021-05-01 12:08:28',
                    'updated_at'     => '2021-05-01 12:08:28',
                    'remember_token' => str_random(10),
                    'payment_status' =>1,
                    'status' => 1,
                    'verify_status' => '1'
                ),
                 1 =>
                array ( 
                    'first_name'     => 'Louis',
                    'last_name'      => 'Corwin',
                    'business_name'  => 'Fashion',
                    'email'          => 'louis@example.com',
                    'user_type'      => '1',
                    'business_location' => 'xyz',
                    'business_type'  => 2,
                    'business_about' => 'test',
                    'country'        => 99,
                    'phone_number'   => '1234567895',
                    'citrus_merchant_id'    => 'LC123466',
                    'citrus_shop_id'    => 'FA000012',
                    'password'       => $password ?: $password = bcrypt('secret'),
                    'created_at'     => '2021-05-01 12:08:28',
                    'updated_at'     => '2021-05-01 12:08:28',
                    'remember_token' => str_random(10),
                    'payment_status' =>1,
                    'status' => 1,
                    'verify_status' => '1'
                    
                ),

                 2 =>
                array ( 
                    'first_name'     => 'John',
                    'last_name'      => 'Martine',
                    'business_name'  => 'Explore',
                    'email'          => 'test@citrus.co.ke',
                    'user_type'      => '1',
                    'business_location' => 'xyz',
                    'business_type'  => 2,
                    'business_about' => 'test',
                    'country'        => 99,
                    'phone_number'   => '1234567899',
                    'citrus_merchant_id'    => 'JM123466',
                    'citrus_shop_id'    => 'EX000012',
                    'password'       => $new_password ?: $new_password = bcrypt('secret'),
                    'created_at'     => '2021-05-01 12:08:28',
                    'updated_at'     => '2021-05-01 12:08:28',
                    'remember_token' => str_random(10),
                    'payment_status' =>1,
                    'status' => 1,
                    'verify_status' => '1'
                    
                )
            )
        );


    }
}
