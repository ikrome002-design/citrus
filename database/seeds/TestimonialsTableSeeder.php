<?php

use Illuminate\Database\Seeder;

class TestimonialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
     {
   		\DB::table('testimonials')->insert(array (
            0 =>
                array (
                    'title' => 'Rav Nordan',
			        'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
			        'image' => 'testi1.jpg'
              ),
            1 =>
                array (
                    'title' => 'Harry Potter',
			        'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
			        'image' => 'testi2.jpeg'
                ),
            2 =>
                array (
                    'title' => 'Lousi Mark',
			        'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
			        'image' => 'testi3.jpg'
                ),    
            )
    	);
    }
}
