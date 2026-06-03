<?php

namespace App\Shop\Customers\Transformations;

use App\Shop\Customers\Customer;

trait CustomerTransformable
{
    protected function transformCustomer(Customer $customer)
    {
        $prop = new Customer;
        $prop->id = (int) $customer->id;
        $prop->first_name = $customer->first_name;
        $prop->last_name = $customer->last_name;
        $prop->email = $customer->email;
        $prop->status = (int) $customer->status;
        $prop->created_at = $customer->created_at;
        $prop->phone_number = $customer->phone_number;
        $prop->newsletter = $customer->newsletter;
        return $prop;
    }
}
