<?php

use App\Shop\Addresses\Address;
use App\Shop\Customers\Customer;
use Illuminate\Database\Seeder;

class CustomerAddressesTableSeeder extends Seeder
{
    public function run()
    {
        factory(Address::class)->create([
			'alias' => 'Home',
			'first_name' => 'Estelle',
			'last_name' => 'Corwin',
	        'address_1' => '1753 Eda Prairie Suite 434',
	        'address_2' => null,
	        'zip' => '50481',
	        'city' => 'Alberta',
	        'province_id' => 1,
	        'country_id' => 38,
	        'customer_id' => 1,
	        'status' => 1
        ]);

        factory(Address::class)->create([
			'alias' => 'Office',
			'first_name' => 'Gerard',
			'last_name' => 'Kemmer',
	        'address_1' => '8619 Nolan Junctions Suite 933',
	        'address_2' => null,
	        'zip' => '10001',
	        'city' => 'British',
	        'province_id' => 1,
	        'country_id' => 38,
	        'customer_id' => 1,
	        'status' => 1
        ]);
    }
}