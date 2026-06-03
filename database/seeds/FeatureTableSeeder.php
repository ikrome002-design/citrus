<?php

use App\Shop\FeatureSetting\FeatureSetting;
use Illuminate\Database\Seeder;

class FeatureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	\DB::table('feature_settings')->insert(array (
            0 =>
                array (
                    'title' => 'Victoria Products & Services',
			        'subtitle' =>'on sale up to',
			        'order' => 1,
			        'button_link' => 'category/services',
			        'button_text' => 'Shop Now',
			        'status' => 1
                ),
            1 =>
                array (
                    'title' => 'Comox Valley Products & Services',
			        'subtitle' =>'on sale up to',
			        'order' => 2,
			        'button_link' => 'category/services',
			        'button_text' => 'Shop Now',
			        'status' => 1
                ),
            2 =>
                array (
                    'title' => 'Nanaimo Products & Services',
			        'subtitle' =>'on sale up to',
			        'order' => 3,
			        'button_link' => 'category/services',
			        'button_text' => 'Shop Now',
			        'status' => 1
                ),
            )
    	);
    }
}
