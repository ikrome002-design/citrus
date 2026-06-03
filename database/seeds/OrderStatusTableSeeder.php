<?php

use App\Shop\OrderStatuses\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    public function run()
    {   

        factory(OrderStatus::class)->create([
            'name' => 'Pending',
            'color' => '#E0A800'
        ]);

        factory(OrderStatus::class)->create([
            'name' => 'Processing',
            'color' => '#307BFF'
        ]);
        
        factory(OrderStatus::class)->create([
            'name' => 'Delivered',
            'color' => '#2A8838'
        ]);

        
        factory(OrderStatus::class)->create([
            'name' => 'Cancelled',
            'color' => '#C82433'
        ]);

    }
}