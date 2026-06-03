<?php

namespace App\Shop\Vendors\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VendorNotFoundException extends NotFoundHttpException
{

    /**
     * EmployeeNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Vendor not found.');
    }
}
