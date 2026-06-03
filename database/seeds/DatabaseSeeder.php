<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EmployeesTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CategoryProductsTableSeeder::class);
        $this->call(MyCountryTableSeeder::class);
        $this->call(MyProvincesTableSeeder::class);
        $this->call(CustomerAddressesTableSeeder::class);
        $this->call(CourierTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
        $this->call(BrandsTableSeeder::class);
        $this->call(FooterSeeder::class);
        $this->call(AttributeTableSeeder::class);
        $this->call(TaxTableSeeder::class);
        $this->call(VendorsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        //$this->call(MyCitiesTableSeeder::class);
        //$this->call(USCitiesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(TaxTableSeeder::class);
        $this->call(BannerTableSeeder::class);
        $this->call(FeatureTableSeeder::class);
        $this->call(MemberSeeder::class);
        $this->call(vendorplan_infoTableSeeder::class);
        $this->call(BusinessTypeTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        $this->call(BlogsTableSeeder::class);
        $this->call(TestimonialsTableSeeder::class);
    



    }
}
