<?php

namespace App\Shop\Taxes\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Taxes\Exceptions\TaxInvalidArgumentException;
use App\Shop\Taxes\Exceptions\TaxNotFoundException;
use App\Shop\Taxes\Repositories\Interfaces\TaxRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Shop\Taxes\TaxRates;
use Illuminate\Support\Collection;

class TaxRepository extends BaseRepository implements TaxRepositoryInterface
{
    /**
     * TaxRepository constructor.
     * @param TaxRates $taxrates
     */
    public function __construct(TaxRates $taxrates)
    {
        parent::__construct($taxrates);
        $this->model = $taxrates;
    }

    /**
     * List all the countries
     *
     * @param string $order
     * @param string $sort
     * @return Collection
     */
    public function listTaxes(string $order = 'id', string $sort = 'desc') : Collection
    {
        return $this->model->get();
    }

    /**
     * @param array $params
     * @return Tax
     */
    public function createTax(array $params) : TaxRates
    {
        return $this->create($params);
    }

    /**
     * Find the country
     *
     * @param $id
     * @return Tax
     * @throws TaxNotFoundException
     */
    public function findTaxById(int $id) : TaxRates
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new TaxNotFoundException('Tax not found.');
        }
    }

  
    /**
     * Update the tax
     *
     * @param array $params
     *
     * @return Tax
     * @throws TaxNotFoundException
     */
    public function updateTax(array $params) : TaxRates
    {
        try {
            $this->model->update($params);
            return $this->findTaxById($this->model->id);
        } catch (QueryException $e) {
            throw new TaxInvalidArgumentException($e->getMessage());
        }
    }

    public function deleteTax() : bool
    {
        return $this->delete();
    }

   
}
