<?php

use Illuminate\Database\Seeder;

class BlogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
   {
   		\DB::table('blogs')->insert(array (
            0 =>
                array (
                    'title' => 'Blog-1',
			        'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
			        'image' => 'blog1.jpg'
              ),
            1 =>
                array (
                    'title' => 'Blog-2',
			        'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
			        'image' => 'blog2.jpg'
                ),
            2 =>
                array (
                    'title' => 'Blog-3',
			        'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
			        'image' => 'blog3.jpg'
                ),    
            )
    	);
    }

}
