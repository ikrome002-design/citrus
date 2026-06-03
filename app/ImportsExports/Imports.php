<?php
namespace App\Imports;
use App\Bulk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;

class BulkImport implements ToModel,WithHeadingRow, WithValidation, SkipsOnFailure
{   

    use Importable, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function rules(): array
    {
        return [
            'slug' => 'unique:products|required',
            'name' => 'required',
            'price' => 'required',
        ];

    }

    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Bulk([
            'brand_id'      => $row['brand_id'],
            'name'          => $row['name'],
            'slug'          => $row['slug'],
            'description'   => $row['description'],
            'cover'         => $row['cover'],
            'quantity'      => $row['quantity'],
            'price'         => $row['price'],
            'sale_price'    => $row['sale_price'],
            'status'        => $row['status'],
            'length'        => $row['length'],
            'width'         => $row['width'],
            'height'        => $row['height'],
            'distance_unit' => $row['distance_unit'],
            'weight'        => $row['weight'],
            'mass_unit'     => $row['mass_unit'],
            'product_type'  => $row['product_type'],
            'taxable'       => $row['taxable'],
            'flat_rate'     => $row['flat_rate'],
            'flat_amount'   => $row['flat_amount'],
            'vendor_id'     => $row['vendor_id'],
            'created_by'    => $row['created_by'],
            'updated_by'    => $row['updated_by'],
        ]);
    }
}