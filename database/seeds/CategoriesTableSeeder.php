<?php

use App\Shop\Categories\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {	
    	\DB::table('categories')->insert(array (
            0 =>
                array (
                	'id' => 1,
                	'parent_id' => 1,
                    'is_visible_main'=>'0',
                    'name' => 'Men',
			        'slug' => str_slug('Men'),
			        'description' => 'Great Savings. Every Day. Shop from our Deal of the Day, Lightning Deals and avail other great offers',
			        'status' => 1,
			        'created_at' => date('Y-m-d H:i:s'),
			        'updated_at' => date('Y-m-d H:i:s'),
                ),
            1 =>
                array (
                	'id' => 2,
                	'parent_id' => 1,
                    'is_visible_main'=>'0',
                    'name' => 'Women',
			        'slug' => str_slug('Women'),
			        'description' => 'You will be able to find a wide selection of electronics from top brands. Shop for Mobile Phones, Tablets, Cameras, Televisions, Headphones, Speakers, Laptops, Computers & Accessories, Wearables, Office Products, Data Storage, Gaming accessories, Musical Instruments and much more at the best prices.',
			        'status' => 1,
			        'created_at' => date('Y-m-d H:i:s'),
			        'updated_at' => date('Y-m-d H:i:s'),
                ),
            2 =>
                array (
                	'id' => 3,
                	'parent_id' => 2,
                    'is_visible_main'=>'0',
                    'name' => 'Breakfast',
			        'slug' => str_slug('Breakfast'),
			        'description' => 'Given how powerful social media has become these days, everyone around the world wants to look their best at 0 times. Thus, the right clothing and accessories are almost always in demand. Good-quality shirts, T-shirts, trousers, jeans, shorts, tops, sarees, kurtis, lehenga, dresses, skirts, bra, innerwear, and more are some of the examples that people love and need to wear. Watches, earrings, rings, bracelets, chains, etc can accentuate the look of every outfit. Thus, it’s important to wear complementing accessories when you dress up in your finest.',
			        'status' => 1,
			        'created_at' => date('Y-m-d H:i:s'),
			        'updated_at' => date('Y-m-d H:i:s'),
                ),
            3 =>
                array (
                	'id' => 4,
                	'parent_id' => 3,
                    'is_visible_main'=>'0',
                    'name' => 'Drinks',
			        'slug' => str_slug('Drinks'),
			        'description' => 'Given how powerful social media has become these days, everyone around the world wants to look their best at 0 times. Thus, the right clothing and accessories are almost always in demand. Good-quality shirts, T-shirts, trousers, jeans, shorts, tops, sarees, kurtis, lehenga, dresses, skirts, bra, innerwear, and more are some of the examples that people love and need to wear. Watches, earrings, rings, bracelets, chains, etc can accentuate the look of every outfit. Thus, it’s important to wear complementing accessories when you dress up in your finest.',
			        'status' => 1,
			        'created_at' => date('Y-m-d H:i:s'),
			        'updated_at' => date('Y-m-d H:i:s'),
                ),
            4 =>
                array (
                	'id' => 5,
                	'parent_id' => 4,
                    'is_visible_main'=>'0',
                    'name' => 'Babies',
			        'slug' => str_slug('Babies'),
			        'description' => 'Given how powerful social media has become these days, everyone around the world wants to look their best at 0 times. Thus, the right clothing and accessories are almost always in demand. Good-quality shirts, T-shirts, trousers, jeans, shorts, tops, sarees, kurtis, lehenga, dresses, skirts, bra, innerwear, and more are some of the examples that people love and need to wear. Watches, earrings, rings, bracelets, chains, etc can accentuate the look of every outfit. Thus, it’s important to wear complementing accessories when you dress up in your finest.',
			        'status' => 1,
			        'created_at' => date('Y-m-d H:i:s'),
			        'updated_at' => date('Y-m-d H:i:s'),
                ),
           
            )
    	);
    }
}