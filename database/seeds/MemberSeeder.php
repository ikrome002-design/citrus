<?php

use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       \DB::table('memberships')->insert( array(
            0 =>
                array ( 
                    'name' => 'Silver',
                    'price' => '1000',
                    'package_expire' => '1 Month',
                    'description' => 'Promote your brand and unlimited products through Citrus',
                    
                ),
            1 =>
                array ( 
                    'name' => 'Gold',
                    'price' => '5000',
                    'package_expire' => '6 Month',
                    'description' => 'Full Ecommerce capabilities to promote your brand and Sell Unlimited Products through Citrus.',
                    
                ),

             2 =>
            array ( 
                'name' => 'Diamond',
                'price' => '10000',
                'package_expire' => '1 Year',
                'description' => 'Full Ecommerce capabilities to promote your brand and Sell Unlimited Products through Citrus.',
                
             )
            )
        );
    }
}
