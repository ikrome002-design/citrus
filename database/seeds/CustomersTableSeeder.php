<?php

use App\Shop\Customers\Customer;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CustomersTableSeeder extends Seeder
{
    public function run()
    {
        static $password='$2y$10$6ELo3zxz3Owxj.srf2hdNe21jyeLho7LpN7VngCXSmsvXcHrtV4O.';
         
        factory(Customer::class)->create([
            'display_name' => 'user',
            'first_name' => 'user',
            'last_name' => 'user',
            'country' => 99,
            'national_id' => '123456',
            'dob' => '11/02/2000',
            'gender' => '0',
            'email' => 'user@example.com',
            'phone_number' => '0987654321',
            'password' => $password ?: $password = bcrypt('secret'),
            'remember_token' => str_random(10),
            'status' => 1,
            'newsletter' => '0',
            'citrus_customer_id'    => 'uu123455',
            'email_verified_at'    => Carbon::now()
        ]);
        
    }
}