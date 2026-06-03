<?php

namespace App\Exports;
use App\Bulk;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BulkExport implements FromQuery,WithHeadings
{	

	/**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;

    public function headings(): array
    {
        return [
            'id',
            'brand_id',
            'sku',
            'name',
            'slug',
            'description',
            'cover',
            'quantity',
            'price',
            'sale_price',
            'status',
            'length',
            'width',
            'height',
            'distance_unit',
            'weight',
            'mass_unit',
            'created_at',
            'updated_at',
            'product_type',
            'taxable',
            'flat_rate',
            'flat_amount',
            'vendor_id',
            'created_by',
            'updated_by',
        ];
    }

    public function query()
    {
        return Bulk::query();
    }
    
    public function map($bulk): array
    {
        return [
            $bulk->id,
            $bulk->brand_id,
            $bulk->sku,
            $bulk->name,
            $bulk->slug,
            $bulk->description,
            $bulk->cover,
            $bulk->quantity,
            $bulk->price,
            $bulk->sale_price,
            $bulk->status,
            $bulk->length,
            $bulk->width,
            $bulk->height,
            $bulk->distance_unit,
            $bulk->weight,
            $bulk->mass_unit,
            Date::dateTimeToExcel($bulk->created_at),
            Date::dateTimeToExcel($bulk->updated_at),
            $bulk->product_type,
            $bulk->taxable,
            $bulk->flat_rate,
            $bulk->flat_amount,
            $bulk->vendor_id,
            $bulk->created_by,
            $bulk->updated_by,
            
        ];
    }
}
