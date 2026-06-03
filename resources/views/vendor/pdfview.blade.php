<style type="text/css">
    .zui-table {
        border: solid 1px #DDEEEE;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 13px Arial, sans-serif;
    }
    .zui-table thead th {
        background-color: #000;
        border: solid 1px #DDEEEE;
        color: #fff;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
    }
    .zui-table tbody td {
        border: solid 1px #DDEEEE;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
    }
</style>
<div class="container">
    <div class="card">
        <div class="card-header">

            <h2>Sales Report</h2>
        </div>
        <div class="card-body tab-content" id="pills-tabContent">
            <div class="table-responsive tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                <table class="table table-striped table-bordered dataTable zui-table" width="100%" cellspacing="0">
                    <thead>    
                        <tr>
                        	<th>S.NO.</td>
                            <th>Date</td>
                            <th>Product Name</td>
                            <th>SKU</td>
                            <th>Product Description</td>
                            <th>Quantity</td>
                            <th>Total</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($items as $key => $item)
                    <?php $description= strip_tags($item->product_description);?>
                        <tr>
                        	<td>{{ ++$key }}</td>
                            <td>{{ date('M d, Y', strtotime($item->date)) }}</td>
                            <td>{{$item->product_name}}</td>
                            <td> {{ $item->product_sku }}
                            </td>
                            <td>{{ substr($description, 0,  30) }}</td>
                            <td>
                                {{ $item->quantity }} 
                            </td>
                            <td>{{ config('cart.currency_symbol') }} {{ $item->quantity*$item->product_price }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</div>
<!-- /.content -->
