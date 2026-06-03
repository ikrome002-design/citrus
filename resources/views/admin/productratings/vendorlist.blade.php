@extends('layouts.vendor.app')
@inject('products','App\Shop\Products\Product')
@section('content')
    <!-- Main content -->
    <section class="content vendor-rating-box">

    <div class="card shadow-sm p-4 rounded-lg mt-4">
        <h4 class="top-heading">All Review</h4>
        <hr>
        <!-- Default box -->
        @if($productratings)
            <div class="row float-right mb-4">
                <div class="col-xl-3">
                    <select class="form-control mb-2 float-right search_rating"> 
                        <option value="">Sorted by: Recommended</option>
                        <option value="top_rated">Top Rated</option>
                        <option value="most_recent">Most Recent</option>
                    </select>
                </div>
            </div>
            <table class="display nowrap dataTable dtr-inline collapsed table table-responsive" id="myTable" style="width: 100%;">
                <thead>
                    <tr>
                        <td>S.NO.</td>
                        <td>Comment</td>
                        <td>Product name</td>
                        <td>Date</td>
                        <td>Rating</td>
                        <td>Review for</td>
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
                            <?php 
                            $value=$products->where('id',$product->product_id)->first();
                            if(!empty($value)){
                                echo $value->name;
                            }else{
                                echo '';
                            }
                            ?>
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
                        <td>
                            @if($product->product_id!=null)
                            <button type="button" class="btn btn-primary btn-xs">Product</button>
                            @else
                            <button type="button" class="btn btn-success btn-xs">Vendor</button>
                            @endif

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

