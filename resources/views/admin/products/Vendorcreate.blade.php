@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')
@section('css')
<script src="{{ asset('js/ckeditor.min.js') }}"></script>
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
         <h2>Create Product</h2>
        @include('layouts.errors-and-messages')
        <form action="{{ route('products.store') }}" method="post" class="form" enctype="multipart/form-data">
            <div class="row">
                {{ csrf_field() }}
                <?php if(Request::segment(2)=='shops'){?>
                    <input type="hidden" name="shop_id" value="{{Request::segment(3)}}">
                <?php }else{?>
                     <input type="hidden" name="shop_id" value="{{$shop->id}}">
                <?php }?>
                <input type="hidden" name="mass_unit" value="Lbs">
                <?php if(isset(auth('vendor')->user()->id)){?>
                    <input type="hidden" name="created_by" value="{{auth('vendor')->user()->id}}">
                    <input type="hidden" name="vendor_id" value="{{auth('vendor')->user()->id}}">
                <?php }?>
                <?php if(isset(auth('admin')->user()->id)){?>
                   
                    <input type="hidden" name="updated_by" value="{{auth('admin')->user()->id}}">
                <?php }?>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Product Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{{ old('name') }}" required="">
                            </div>
                            <div class="form-group">
                                <label for="short_description">Short Description </label>
                                <textarea class="form-control" name="short_description" id="short_description" rows="5" placeholder="Short description">{{ old('short_description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="description">Description </label>
                                <textarea class="form-control" name="description" id="editor" rows="5" placeholder="Description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body">
                            <label>Featured image <span class="text-danger">*</span></label>
                            <div id="userActions" class="rounded-lg bg-white mx-auto text-center p-4"><label for="fileUpload">
                                <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" height="150" width="150">
                                <p class="m-2">Add Product feature image</p>
                                <input type="file" id="fileUpload" name="cover" class="d-none image-gallery-input" />
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body">
                            <label class="mb-3">Gallery images</label>
                            <div class="product-gallery-image row">
                                <div class="gallery-image-1 text-center col-auto" image-field="1">
                                    <label for="product-gallery-1">
                                        <div class="border p-4 cursor-pointer">
                                            <input type="file" id="product-gallery-1" name="image[]" class="d-none" />
                                            <div class="add-image">
                                                <i class="fa fa-plus fa-2x"></i>
                                                <p class="m-2">Add image</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body">
                            <input type="hidden" name="product_type" id="VirtualProduct" value="virtual">
                            <input type="hidden" name="taxable" id="taxable" value="0">
                            
                            <p>General</p>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="price">Regular Price (USD) <span class="text-danger">*</span></label>
                                    <input type="text" name="price" id="price" placeholder="Regular Price" class="form-control" value="{{ old('price') }}" required="">
                                </div>
                                <div class="col-md-6">
                                    <label for="selling-price">Sell Price (USD) <span class="text-danger">*</span></label>
                                    <input type="text" name="sale_price" id="selling-price" placeholder="Selling Price" class="form-control" value="{{ old('sale_price') }}" required="">
                                </div>
                              
                            </div>
                            <hr/>
                            <p>Inventory</p>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="sku">SKU Code <span data-toggle="tooltip" data-placement="top" title="Tooltip on top"><i class="fa fa-question-circle"></i></span></label><span class="text-danger">*</span>
                                    <input type="text" name="sku" id="sku" placeholder="xxxxx" class="form-control" value="{{ old('sku') }}" required="">
                                </div>
                                <div class="col-md-6">
                                    <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" id="quantity" placeholder="Quantity" class="form-control" value="{{ old('quantity') }}" min="1" required="">
                                </div>
                            </div>
                            <hr/>
                        </div>
                    </div>
                    <div class="card mt-3" id="shipping-card">
                        <div class="card-body">
                            <p>Shipping</p>
                            <div class="form-row">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input a12" type="radio" id="FlatRate" value="1" name="flat_rate" checked="checked">
                                  <label class="form-check-label" for="FlatRate">Cost</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input a12" type="radio" id="freeShippng" value="0" name="flat_rate">
                                  <label class="form-check-label" for="freeShippng">Free Shipping</label>
                                </div>
                              
                            </div>
                            <div class="form-row mt-3 flat_rate">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Cost</div>
                                            </div>
                                            <input type="text" class="form-control" name="flat_amount" id="Flatamount" placeholder="$0.00" value="{{ old('flat_amount') }}">
                                    </div>
                                </div>
                            </div>
                         
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h2>Categories</h2>
                           
                            @if(!$categories->isEmpty())
                            <div class="form-group mt-2">
                                <label for="category_id">Categories </label>
                                 
                                  <select id="inputState" class="form-control" name="categories[]" required="">
                                     @foreach($categories as $category)
                                    <option value="{{$category->id}}" >{{$category->name}}</option>
                                    @endforeach
                                  </select>
                            </div>
                            @endif
                            @include('admin.shared.status-select', ['status' => 0])
                            <hr/>
                            <button type="submit" class="btn btn-success">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </form>

    </section>
    <!-- /.content -->
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@section('js')
<script>
    $(document).ready(function(){
        $('#taxDiv').hide();
        $('#taxable').change(function(){
            var taxVal = $('#taxable').val();
            if(taxVal==1){
                $('#taxDiv').show();
            }else{
                $('#taxDiv').hide();
            }
        })
    })
</script>
@endsection
@endsection
@else
@section('js')
<script type="text/javascript">
  
        window.location="{{ route('vendor.dashboard') }}";
   
</script>
@endsection
@endif
