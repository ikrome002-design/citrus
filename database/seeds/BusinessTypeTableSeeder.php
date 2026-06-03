<?php

use Illuminate\Database\Seeder;

class BusinessTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
    {
   		\DB::table('business_type')->insert(array (
            0 =>
                array (
                    'title' => 'Dry Cleaner'
			        
                ),
            1 =>
                array (
                    'title' => 'Restaurant and Fast Foods'
			        
                ),

             2 =>
                array (
                    'title' => 'Kiosk'
			        
                ),

             3 =>
                array (
                    'title' => 'Boutique'
			        
                ),

             4 =>
                array (
                    'title' => 'Bar + Wines and Spirits'
			        
                ),

                


            )
    	);
    }
}
