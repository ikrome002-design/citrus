<?php

namespace App\Shop\Products\Transformations;

use App\Shop\Products\Product;
use Illuminate\Support\Facades\Storage;

trait ProductTransformable
{
    /**
     * Transform the product
     *
     * @param Product $product
     * @return Product
     */
    protected function transformProduct(Product $product)
    {
        $prod = new Product;
        $prod->id = (int) $product->id;
        $prod->name = $product->name;
        $prod->sku = $product->sku;
        $prod->slug = $product->slug;
        $prod->short_description = $product->short_description;
        $prod->description = $product->description;
        $prod->cover = asset("storage/$product->cover");
        $prod->quantity = $product->quantity;
        $prod->price = $product->price;
        $prod->status = $product->status;
        $prod->weight = (float) $product->weight;
        $prod->mass_unit = $product->mass_unit;
        $prod->sale_price = $product->sale_price;
        $prod->brand_id = (int) $product->brand_id;
        $prod->length = (int) $product->length;
        $prod->width = (int) $product->width;
        $prod->height = (int) $product->height;
        $prod->product_type = $product->product_type;
        $prod->taxable = (int) $product->taxable;
        $prod->flat_rate = (int) $product->flat_rate;
        $prod->flat_amount = $product->flat_amount;
        $prod->tax = $product->tax;
        $prod->tax_id = $product->tax_id;
        $prod->vendor_id = $product->vendor_id;
        $prod->shop_id = $product->shop_id;
        $prod->created_by = $product->created_by;
        $prod->updated_by = $product->updated_by;

        return $prod;
    }
}
