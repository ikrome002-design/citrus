<?php

namespace App\Shop\ProductRatings\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\ProductRatings\Exceptions\ProductRatingInvalidArgumentException;
use App\Shop\ProductRatings\Exceptions\ProductRatingNotFoundException;
use App\Shop\ProductRatings\Repositories\Interfaces\ProductRatingRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Shop\ProductRatings\ProductRating;
use Illuminate\Support\Collection;

class ProductRatingRepository extends BaseRepository implements ProductRatingRepositoryInterface
{
    /**
     * ProductRatingRepository constructor.
     * @param ProductRatings $productrating
     */
    public function __construct(ProductRating $productrating)
    {
        parent::__construct($productrating);
        $this->model = $productrating;
    }

    /**
     * List all the countries
     *
     * @param string $order
     * @param string $sort
     * @return Collection
     */
    public function listProductRatings(string $order = 'id', string $sort = 'desc') : Collection
    {
        return $this->model->get();
    }

   public function findProductRatingById(int $id) : ProductRating
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ProductRatingNotFoundException('Product Rating not found.');
        }
    }
}
