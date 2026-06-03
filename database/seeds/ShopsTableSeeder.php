<?php

use Illuminate\Database\Seeder;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {   
        \DB::table('shops')->insert(array (
            0 =>
                array ( 
                        'id' => 1,
                        'title' => 1,
                        'location' => 'xyz',
                        'citrus_shop_id' => 'TR000011',
                        'merchant_id' => 1,
                        'type' => 'default'
                       
                ),
            1 =>
                array ( 
                        'id' => 2,
                         'title' => 2,
                        'location' => 'xyz',
                        'citrus_shop_id' => 'FA000012',
                        'merchant_id' => 2,
                        'type' => 'default'

                ),

            2 =>
                array ( 
                        'id' => 3,
                         'title' => 2,
                        'location' => 'xyz',
                        'citrus_shop_id' => 'EX000012',
                        'merchant_id' => 3,
                        'type' => 'default'

                ),
               
           
            )
        );
  
     
    }
}