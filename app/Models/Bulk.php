<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Bulk extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'brand_id', 'sku', 'name', 'slug', 'description', 'cover', 'quantity', 'price', 'sale_price', 'status', 'length', 'width', 'height', 'distance_unit', 'weight', 'mass_unit'
    ];
}