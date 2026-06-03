<?php

use App\Shop\BannerSetting\BannerSetting;
use Illuminate\Database\Seeder;

class BannerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
   		\DB::table('banner_settings')->insert(array (
            0 =>
                array (
                    'title' => 'Buying & Selling Has Changed',
			        'subtitle' => 'The World Has Changed',
			        'description' => 'Supports Businesses so they can grow, expand, and reach a far wider audience
                                Serves Customers by making shopping as quick and simple as it was always meant to',
                    'banner_image' => 'slide.png'
			          
                ),
            1 =>
                array (
                    'title' => 'Buying & Selling Has Changed',
			        'subtitle' => 'The World Has Changed',
			        'description' => 'Supports Businesses so they can grow, expand, and reach a far wider audience
                                Serves Customers by making shopping as quick and simple as it was always meant to',
                    'banner_image' => 'slide.png'
			        
                ),
            2 =>
                array (
                    'title' => 'Buying & Selling Has Changed',
                    'subtitle' => 'The World Has Changed',
                    'description' => 'Supports Businesses so they can grow, expand, and reach a far wider audience
                                Serves Customers by making shopping as quick and simple as it was always meant to',
                    'banner_image' => 'slide.png'
                    
                ),    
            )
    	);
    }
}
