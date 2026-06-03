@extends('layouts.vendor.app')
@inject('products','App\Shop\Products\Product')
@section('content')
    <!-- Main content -->
    <section class="content vendor-rating-box">

    <div class="card shadow-sm p-4 rounded-lg mt-4">
        <h4 class="top-heading">Vendor Reviews</h4>
        <hr>
        <!-- Default box -->
        @if($productratings)
            
            <table class="display nowrap dataTable dtr-inline collapsed table table-responsive" id="myTable" style="width: 100%;">
                <thead>
                    <tr>
                        <td>S.NO.</td>
                        <td>Comment</td>
                        <td>Date</td>
                        <td>Rating</td>
                    </tr>
                </thead>
                <tbody>  <?php $j=1;?>
                @foreach ($productratings as $product)
              
                    <tr>
                        <td>{{$j}}</td>
                         <td>
                            {{ $product->review }}
                        </td>
                   
                        
                        <td>
                          {{ date('d-M-Y', strtotime('-8 hours', strtotime($product->updated_at))) }}
                        </td>
                        <td>
                            @for ($i = 0; $i <  $product->rating; $i++)
                                <i class="fa fa-star"></i>
                            @endfor
                            @for ($i = 0; $i <  (5-$product->rating); $i++)
                                <i class="fa fa-star-o"></i>
                            @endfor
                        </td>
                    </tr>
                    <?php $j++;?>
                @endforeach
                </tbody>
            </table>
        @endif
        </div>

    </section>
    <!-- /.content -->
@endsection

