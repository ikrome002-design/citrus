<?php

namespace App\DataTables\Admin;

use App\Shop\Categories\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'featured_image'])
            ->addColumn('action', 'category.action')
            ->setRowId('id')
            ->editColumn('business_type_id', function ($i) {
                return $i->businessType->title ?? '-';
            })
            ->editColumn('parent_id', function ($i) {
                return $i->parent->name ?? '-';
            })
            ->addColumn('action', function ($i) {
                return "<a href='" . route('admin.categories.edit', $i->id) . "' class='btn btn-primary btn-sm me-1'><i class='fa fa-eye'></i> Manage</a>";
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Category $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('category-table')
            ->addTableClass('table-hover table-bordered table-striped border w-100')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Blfrtip')
            ->orderBy(0)
            ->buttons([
                Button::make('excel')->text('<i class="fa-solid fa-file-excel"></i> Excel'),
                Button::make('csv')->text('<i class="fa-solid fa-file-csv"></i> CSV'),
                Button::make('pdf')->text('<i class="fa-solid fa-file-pdf"></i> PDF'),
                Button::make('print')->text('<i class="fa-solid fa-print"></i>Print'),
                Button::make('reset'),
                Button::make('reload'),
            ])
            ->parameters([
                "sPaginationType" => "full_numbers",
                "language" => [
                    "paginate" => [
                        "first" => '<i class="fa-solid fa-backward-fast"></i>',
                        "previous" => '<i class="fa-solid fa-backward-step"></i>',
                        "next" => '<i class="fa-solid fa-forward-step"></i>',
                        "last" => '<i class="fa-solid fa-forward-fast"></i>',
                    ]
                ],
                "lengthMenu" => [[6, 25, 50, 100, 500, 1000, -1], [6, 25, 50, 100, 500, 1000, 'All']],

                'responsive' => true,

            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make(['data' => 'business_type_id', 'name' => 'business_type_id', 'title' => 'Business Type']),
            Column::make(['data' => 'parent_id', 'name' => 'parent_id', 'title' => 'Parent Category']),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Category_' . date('YmdHis');
    }
}
