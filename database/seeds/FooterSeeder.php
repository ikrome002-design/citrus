<?php

use Illuminate\Database\Seeder;
use App\Footer;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         \DB::table('footers')->insert(array(
                0 =>
                 array (
                    'type'=>'0',
                    'title' => 'Orders & Returns',
                    'link' => 'accounts?tab=v-pills-my-order'
                    
                ),
                 
                1 =>
                array (
                   
                     'type'=>'0',
                    'title' => 'Account Settings',
                    'link' => 'accounts?tab=v-pills-account-details'
                    
                ),
                2 =>
                array (
                   
                     'type'=>'0',
                    'title' => 'Vendor Login',
                    'link' => 'vendor/login'
                    
                ),
                3 =>
                array (
                   
                     'type'=>'0',
                    'title' => 'Staff Login',
                    'link' => 'admin/login'
                    
                ),
                4 =>
                array (
                    
                     'type'=>'1',
                    'title' => 'Customer Care',
                    'link' => 'contact-us'

                    
                ),
                5 =>
                array (
                    
                     'type'=>'1',
                    'title' => 'Shipping Information',
                    'link' => 'shipping_info'
                    
                ),
                6 =>
                array (
                    
                     'type'=>'1',
                    'title' => 'Return Policy',
                    'link' => 'return_policy'
                    
                ),
                7 =>
                array (
                   
                     'type'=>'1',
                    'title' => 'International Help',
                    'link' => 'internat_help'
                    
                ),
                8 =>
                array (
                    
                     'type'=>'1',
                    'title' => 'Accessibility',
                    'link' => 'accessibility'
                    
                ),
                9 =>
                array (
                    
                     'type'=>'2',
                    'title' => 'Contact Us',
                    'link' => 'contact-us'
                    
                ),
                10 =>
                array (
                    
                     'type'=>'2',
                    'title' => 'Buyvi.ca Mission',
                    'link' => 'mission'
                    
                ),
                11 =>
                array (
                   
                     'type'=>'2',
                    'title' => 'Terms and Conditions',
                    'link' => url()->current().'/pdf/BuyVi_Terms_and_Conditions.pdf'
                    
                ),
                12 =>
                array (
                    
                     'type'=>'2',
                    'title' => 'Become a Vendor',
                    'link' => 'vendor/register'
                    
                ),
                13 =>
                array (
                    
                     'type'=>'2',
                    'title' => 'Start Shopping',
                    'link' => url()->current()
                    
                ),
                14 =>
                array (
                    
                     'type'=>'2',
                    'title' => 'All Vendors',
                    'link' => 'allvendors'
                    
                )
            )
        );
    }
}
