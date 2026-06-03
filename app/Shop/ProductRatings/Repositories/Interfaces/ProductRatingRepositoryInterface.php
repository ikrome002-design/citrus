<?php

namespace App\Shop\ProductRatings\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Shop\ProductRatings\ProductRating;
use Illuminate\Support\Collection;

interface ProductRatingRepositoryInterface extends BaseRepositoryInterface
{
    

   public function listProductRatings(string $order = 'id', string $sort = 'desc') : Collection;
    
   public function findProductRatingById(int $id) : ProductRating;
    
    
}
