<?php

use App\Shop\Taxes\TaxRates;
use Illuminate\Database\Seeder;

class TaxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(TaxRates::class)->create();
    }
}
