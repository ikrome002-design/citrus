<?php

namespace App\Shop\Footers\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Footers\Footer;
use App\Shop\Footers\Exceptions\FooterNotFoundErrorException;
use App\Shop\Footers\Exceptions\CreateFooterErrorException;
use App\Shop\Footers\Exceptions\UpdateFooterErrorException;
use App\Shop\Products\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class FooterRepository extends BaseRepository implements FooterRepositoryInterface
{
    /**
     * FooterRepository constructor.
     *
     * @param Footer $Footer
     */
    public function __construct(Footer $Footer)
    {
        parent::__construct($Footer);
        $this->model = $Footer;
    }

    /**
     * @param array $data
     *
     * @return Footer
     * @throws CreateFooterErrorException
     */
    public function createFooter(array $data) : Footer
    {
       
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateFooterErrorException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Footer
     * @throws FooterNotFoundErrorException
     */
    public function findFooterById(int $id) : Footer
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new FooterNotFoundErrorException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws UpdateFooterErrorException
     */
    public function updateFooter(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new UpdateFooterErrorException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteFooter() : bool
    {
        return $this->delete();
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return Collection
     */
    public function listFooters($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    /**
     * @return Collection
     */
    public function listProducts() : Collection
    {
        return $this->model->products()->get();
    }

    /**
     * @param Product $product
     */
    public function saveProduct(Product $product)
    {
        $this->model->products()->save($product);
    }

    /**
     * Dissociate the products
     */
    public function dissociateProducts()
    {
        $this->model->products()->each(function (Product $product) {
            $product->Footer_id = null;
            $product->save();
        });
    }
}
