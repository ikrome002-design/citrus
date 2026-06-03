<?php

namespace App\Shop\Taxes\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Shop\Taxes\TaxRates;
use Illuminate\Support\Collection;

interface TaxRepositoryInterface extends BaseRepositoryInterface
{
    public function updateTax(array $params) : TaxRates;

    public function listTaxes(string $order = 'id', string $sort = 'desc') : Collection;
    
    public function createTax(array $params) : TaxRates;

    public function findTaxById(int $id) : TaxRates;
    
    public function deleteTax() : bool;

    // public function findProvinces();

	//public function listStates() : Collection;
}
