@extends('layouts.vendor.app')
@section('content')
    <!-- Main content -->
    <section class="content">

        <div class="row vendor-dashboard-top">
          <div class="col-lg-3 col-md-6 col-sm-12 col-12">
            <div class="card">
                <a href="">
                <div class="card-body shadow-sm">
                    <div class="media">
                        <div class="vendor-product-icon p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20.167 22">
                                <g id="total_products_icon" transform="translate(-21.334 0)">
                                    <g id="Group_95" data-name="Group 95" transform="translate(21.334 0)">
                                        <path id="Path_202" data-name="Path 202"
                                            d="M41.3,4.667a.466.466,0,0,0-.059-.04L31.614.044a.46.46,0,0,0-.394,0L21.6,4.627a.458.458,0,0,0-.261.414V16.958a.458.458,0,0,0,.261.414l9.625,4.583a.46.46,0,0,0,.394,0l9.625-4.583a.458.458,0,0,0,.261-.414V5.041A.456.456,0,0,0,41.3,4.667ZM31.417.966,40,5.052l-1.71.855L29.665,1.8ZM28.6,2.308l9.236,4.4v3.748l-.325.817-.933-.253a.459.459,0,0,0-.546.273l-.354.9-.591-.162V8.25a.458.458,0,0,0-.261-.414L25.906,3.59Zm2.361,18.508-8.708-4.147V5.768l8.708,4.147v10.9Zm.469-11.694-8.569-4.08L24.84,4.1l8.673,4.13Zm9.156,7.547-8.708,4.147V9.927l2.292-.982v3.43a.459.459,0,0,0,.337.442l1.324.363a.47.47,0,0,0,.121.016.459.459,0,0,0,.426-.29l.355-.9.933.253a.457.457,0,0,0,.546-.273l.508-1.279a.464.464,0,0,0,.032-.169V6.7l1.833-.917Z" transform="translate(-21.334 0)" fill="#588e43"
                                        />
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="media-body pl-3">
                            <h3 class="text-success">{{ count($products) }}</h3>
                            <p>Total products</p>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card">
                    
                    <div class="card-body shadow-sm">
                        <div class="media">
                               <div class="vendor-product-icon p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23.4 20">
                                          <g id="total_categories_icon" transform="translate(-3.5 -8)">
                                            <path id="Path_268" data-name="Path 268" d="M12,9H28.9" transform="translate(-3)" fill="none" stroke="#588e43" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            <path id="Path_269" data-name="Path 269" d="M12,18H28.9" transform="translate(-3)" fill="none" stroke="#588e43" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            <path id="Path_270" data-name="Path 270" d="M12,27H28.9" transform="translate(-3)" fill="none" stroke="#588e43" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            <path id="Path_271" data-name="Path 271" d="M4.5,9h0" fill="none" stroke="#588e43" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            <path id="Path_272" data-name="Path 272" d="M4.5,18h0" fill="none" stroke="#588e43" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                            <path id="Path_273" data-name="Path 273" d="M4.5,27h0" fill="none" stroke="#588e43" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                          </g>
                                        </svg>
                                </div>
                              <div class="media-body pl-3">
                               <h3 class="text-success">{{ count($categories) }}</h3>
                                <p>Total Categories</p>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!--  <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <a href="{{ route('vendor.plan') }}">
                    <div class="card-body shadow-sm">
                        <div class="media">
                               <div class="vendor-product-icon p-3">
                                    <svg id="plan_remaining_products_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.001 22.001"><g id="Group_99" data-name="Group 99">
                                        <g id="Group_98" data-name="Group 98">
                                          <path id="Path_206" data-name="Path 206" d="M20,0H2A2,2,0,0,0,0,2V20a2,2,0,0,0,2,2H20a2,2,0,0,0,2-2V2A2,2,0,0,0,20,0ZM9,1h4V9.459l-.434-.348a.5.5,0,0,0-.626,0L11,9.86l-.94-.751a.5.5,0,0,0-.624,0L9,9.461V1ZM21,20a1,1,0,0,1-1,1H2a1,1,0,0,1-1-1V2A1,1,0,0,1,2,1H8v9.5a.5.5,0,0,0,.812.391l.941-.751.94.751a.5.5,0,0,0,.625,0l.936-.75.934.75A.5.5,0,0,0,13.5,11a.5.5,0,0,0,.5-.5V1h6a1,1,0,0,1,1,1V20Z" fill="#588e43"/>
                                          <path id="Path_207" data-name="Path 207" d="M68.5,384h-4a.5.5,0,1,0,0,1h4a.5.5,0,1,0,0-1Z" transform="translate(-61 -365.999)" fill="#588e43"/>
                                          <path id="Path_208" data-name="Path 208" d="M66.853,256.158a.5.5,0,0,0-.708,0l-2,2a.5.5,0,0,0,.707.707L66,257.718v2.793a.5.5,0,0,0,1,0v-2.793l1.147,1.146a.5.5,0,0,0,.707-.707Z" transform="translate(-60.999 -244.01)" fill="#588e43"/>
                                        </g>
                                      </g>
                                    </svg>
                                </div>
                              <div class="media-body pl-3">
                                <h3 class="text-success">{{ count($products) }}/1</h3>
                                <p>Plan remaining products</p>
                              </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div> 
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card">
                    @if(count($products) < 1)
                        <a href="{{ route('products.create') }}">
                            <div class="card-body shadow-sm bg-success">
                             <div class="media">
                               <div class="vendor-product-icon p-3 bg-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 32.159">
                                      <g id="create_new_product_icon" transform="translate(-3.5 -1.961)">
                                        <path id="Path_274" data-name="Path 274" d="M31.5,24V12A3,3,0,0,0,30,9.4l-10.5-6a3,3,0,0,0-3,0L6,9.4A3,3,0,0,0,4.5,12V24A3,3,0,0,0,6,26.595l10.5,6a3,3,0,0,0,3,0l10.5-6A3,3,0,0,0,31.5,24Z" fill="none" stroke="#588e43" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                        <path id="Path_275" data-name="Path 275" d="M4.905,10.44,18,18.015,31.095,10.44" fill="none" stroke="#588e43" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                        <path id="Path_276" data-name="Path 276" d="M18,33.12V18" fill="none" stroke="#588e43" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                      </g>
                                    </svg>
                                </div>
                                    <div class="media-body pl-3">
                                        <h3 class="text-white">Create</h3>
                                        <p class="text-white">New Products</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('vendor.plan') }}">
                        <div class="card-body shadow-sm bg-success">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="shadow-sm p-3 rounded-circle bg-white">
                                        <i class="fa fa-trophy text-success fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center text-white">
                                    <h3>Upgrade</h3>
                                    <p>Your Plan</p>
                                </div>
                            </div>
                        </div>
                        </a>
                    @endif
                </div>
            </div> -->
        </div>
        <br/>
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if(!$products->isEmpty())
            <div class="card mt-5 pt-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-sub-heading font-regular mb-4">All products</h3>
                        </div>
                    </div>
    <form class="acount-mang-form" method="post">
     {{ csrf_field() }}
      <div class="row">
        <div class="form-group col-md-4">
            <select class="form-control form-select" id="category_filter">
                <option value="">All Categories</option>
                @foreach($categories as $categoryy)
                <option value="{{$categoryy->id}}">{{$categoryy->name}}</option>
                
                @endforeach        
            </select>
        </div>
        <div class="form-group col-md-8">
            <button class="btn btn-info" id="company_location_filter">search</button>
        </div>
       </div>
      </form>  

     @if(!$products->isEmpty())
    <div class="table-responsive vendor-product-table">
        <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0" id="company_location_body">
            <thead>
                <tr>
                    <td><input type="checkbox" id="select-product-input"></td>
                    <td colspan="2">Product</td>
                    <td>Categories</td>
                    <td>Quantity</td>
                    <td>Product ID</td>
                    <td>Review</td>
                    <td>Date</td>
                    <td>Actions</td>
                   <!--  <td>Status</td> -->
                </tr>
            </thead>
            <tbody>
             
            @foreach ($products as $product)
                <tr>
                    <td><input type="checkbox" id="select-product-input"></td>
                    <td><img src="@if(!empty($product->cover)){{ asset('storage/'.$product->cover) }}@else{{ asset('images/placeholder-square.png') }}@endif" class="image-icon"></td>
                    <td>
                        {{ $product->name }}
                    </td>
                    <td>
                        @foreach($categories as $category)
                            @foreach($category_products as $category_product)
                                @if($category_product->product_id == $product->id && $category_product->category_id == $category->id )
                                    {{ $category->name }}
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                    <td>{{ $product->quantity }}</td>
                    <td># {{ $product->id }}</td>
                    <td>
                        @php $i = 0 @endphp
                        @foreach($reviews as $review)
                            @if($review->product_id == $product->id )
                                @php $i++ @endphp
                            @endif
                        @endforeach
                        {{ $i }}
                    </td>
                    <td>{{ date("d M Y",strtotime($product->created_at) ) }}</td>
                    <td style="white-space: nowrap;">
                 
                        <form action="{{ route('vendor.products.destroyy') }}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                       <input type="hidden" name="id" value={{ $product->id }}> 
                            
                        <a  href="{{ route('products.edit', $product->id) }}" class="btn btn-success btn-sm vendor-product-bt"><i class="fa fa-edit"></i></a>
                        
                        <button type="submit" class="btn btn-danger vendor-product-bt"><i class="fa fa-trash"></i></button>
                        </form>
                     
                    </td>
                 <!--    <td>
                        
                    <a  href="{{ route('products.update.approve', ['product' => $product->id]) }}" class="btn btn-danger vendor-product-bt" onclick="return confirm('Are you sure? Active product!')"><i class="fa fa-eye-slash"></i></a>
                          
                    </td> -->
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif

                
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
@push('js')

<script>
$('#company_location_filter').click(function(){
    console.log('i am here');
    event.preventDefault();

    var search_data_html;
    var a = $('#category_filter').val();
    
    console.log('a',a);
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: "{{route('CategoryListingFilter')}}",
        type: "Post",
        data: {'category_filter':a,'_token': $('input[name=_token]').val()},
        success: function(data){
          var id;
          var delete_url;
           console.log('data',data);
           if(data.length === 0){
             console.log('1');
             $('#company_location_body tbody').html('No Product found');
           }else{
               console.log('2');
              $.each(data , function(index, val) {

             
             
                console.log('val.id',val.id);
                  id=val.id;
                
                  var origin_url = document.location.origin;
                  var date=date("d M Y",strtotime(val.created_at) );
                  var delete_url=origin_url+'/merchant/products/destroyy/'+id;
                  var edit_url=origin_url+'merchant/products/'+id+'/edit';
                  var delete_message="'Are you sure you want to delete this product?'";
                 
                 
                

                  var token='{{csrf_field()}}';
                  search_data_html+='<tr>'+
                  '<td>'+ <input type="checkbox" id="select-product-input"> +'</td>'+
                  '<td>'+val.id+'</td>'+
                  '<td>'+date+'</td>'+
                  '<td>'hvbn'</td>'+
                  '<td>'vvbn'</td>'+
                  '<td>'+'<img src="@if(!empty('+val.cover+')){{ asset('storage/'.'+val.cover+') }}@else{{ asset('images/placeholder-square.png') }}@endif" class="image-icon">'+'</td>'+
                  '<td>'+
                  '<a href="'+edit_url+'" class="btn btn-success btn-sm vendor-product-bt"><i class="fa fa-edit"></i></a>'+
                  '</td>'+
                  '<td>'+
                  '<form action="'+delete_url+'" method="POST" title="Delete">'+token+
                  '<input name="_method" type="hidden" value="DELETE">'+
                  '<input name="id" type="hidden" value="'+val.id+'">'+
                  '<button type="submit" onclick="return confirm('+delete_message+')">Delete</button></form>'+
                  '</td>'+
                  '</tr>';
                  console.log(val);
                  
             
          });
          $('#company_location_body tbody').html('');
        
          $('#company_location_body').append(search_data_html);

          }

         
          
        }
      });

  });
</script>
@endpush