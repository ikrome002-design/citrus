
@extends('layouts.admin.app')
@section('css')
<script src="{{ asset('js/ckeditor.min.js') }}"></script>
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <form action="{{ route('admin.products.update', $product->id) }}" method="post" class="form" enctype="multipart/form-data">
            <div class="row">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="put">
                @if(isset(auth('admin')->user()->id))
                    <input type="hidden" name="updated_by" value="{{auth('admin')->user()->id}}">
                @endif
                <div class="col-md-8 product-create-box">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group product-create-group">
                                <label for="name">Product or Service Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{!! $product->name !!}">
                            </div>
                            <div class="form-group product-create-group">
                                <label for="short_description">Short Description </label>
                                <textarea class="form-control" name="short_description" id="short_description" rows="5" placeholder="Short description">{!! $product->short_description !!}</textarea>
                            </div>
                            <div class="form-group product-create-group">
                                <label for="description">Description </label>
                                <textarea class="form-control" name="description" id="editor" rows="5" placeholder="Description">{!! $product->description !!}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body product-create-group">
                            <label>Featured image <span class="text-danger">*</span></label>
                            <div id="userActions" class="rounded-lg bg-white mx-auto text-center p-4"><label for="fileUpload">
                                @if(isset($product->cover))
                                    <img id="imgPrime" src="{{ $product->cover }}" height="150" width="150">
                                @else
                                    <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" height="150" width="150">
                                @endif
                                <p class="m-2">Change feature image</p>
                                <input type="file" id="fileUpload" name="cover" class="d-none image-gallery-input" accept="image/x-png,image/gif,image/jpeg"/>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body product-create-group">
                            <label class="mb-4">Gallery images</label>
                            <div class="form-row">
                                @foreach($images as $image)
                                    <div class="col-md-3">
                                        <img src="{{ asset('storage/'.$image->src.'') }}" alt="" class="img-responsive img-thumbnail"> <br /> <br>
                                        <a onclick="return confirm('Are you sure?')" href="@if(isset(auth('admin')->user()->id)){{ route('admin.product.remove.thumb', ['src' => $image->src]) }} @elseif(isset(auth('vendor')->user()->id)){{ route('product.remove.thumb', ['src' => $image->src]) }}@endif" class="btn btn-danger btn-sm btn-block">Remove?</a><br />
                                    </div>
                                @endforeach
                            </div>
                            <div class="product-gallery-image row">
                                <div class="gallery-image-1 product-create-gallery-img text-center col-auto" image-field="1">
                                    <label for="product-gallery-1">
                                        <div class="border p-4 cursor-pointer">
                                            <input type="file" id="product-gallery-1" name="image[]" class="d-none" accept="image/x-png,image/gif,image/jpeg"/>
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
                    <div class="card mt-3 product-create-group">
                        <div class="card-body product-create-inline">
                            <h5 class="text-primary font-24 mb-4">Type</h5>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="VirtualProduct">
                                    <input type="radio" name="product_type" {{$product->product_type == 'virtual' ? 'checked' : '' }} class="form-check-input" id="VirtualProduct" value="virtual">
                                    Products
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="ServicesProduct">
                                    <input type="radio" name="product_type" {{$product->product_type == 'services' ? 'checked' : '' }}  class="form-check-input" id="ServicesProduct" value="services">
                                    Services
                                </label>
                            </div>
                            <hr/>
                            <p>General</p>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="price">Regular Price ({{ config('cart.currency') }}) <span class="text-danger">*</span></label>
                                    <input type="text" name="price" id="price" placeholder="Regular Price" class="form-control" value="{{ $product->price }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="selling-price">Sell Price ({{ config('cart.currency') }}) <span class="text-danger">*</span></label>
                                    <input type="text" name="sale_price" id="selling-price" placeholder="Selling Price" class="form-control" value="{{ $product->sale_price }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="taxable">Tax Status <span class="text-danger">*</span></label>
                                    <select type="text" name="taxable" id="taxable" class="custom-select form-control">
                                        <option {{$product->taxable == 0 ? 'selected' : '' }} value="0">Tax Free</option>
                                        <option {{$product->taxable == 1 ? 'selected' : '' }} value="1">Taxable</option>
                                    </select>
                                </div>
                                <div class="col-md-4" id="taxDiv">
                                    <label for="taxList">Tax Type </label>
                                    <select name="tax_id" id="taxList" class="custom-select form-control">
                                        @foreach($tax_rates as $row)
                                        <option {{$product->tax_id == $row->id ? 'selected' : '' }} value="{{$row->id}}">{{$row->tax_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr/>
                            <p>Inventory</p>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="sku">SKU <span data-toggle="tooltip" data-placement="top" title="Tooltip on top"><i class="fa fa-question-circle"></i></span></label>
                                    <input type="text" name="sku" id="sku" placeholder="xxxxx" class="form-control" value="{{ $product->sku }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" id="quantity" placeholder="Quantity" class="form-control" value="{{ $product->quantity }}" min="1">
                                </div>
                            </div>
                            <hr/>
                        </div>
                    </div>
                    <div class="card mt-3" id="shipping-card" {{$product->product_type == 'services' ? 'style=display:none' : '' }}>
                        <div class="card-body">
                            <p>Shipping</p>
                             <div class="form-row product-create-group product-create-shipping">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input a12" type="radio" id="FlatRate" value="1" name="flat_rate" {{$product->flat_rate == '1' ? 'checked' : '' }} >
                                  <label class="form-check-label" for="FlatRate">Cost</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group product-create-flat">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Cost</div>
                                        </div>
                                        <input type="text" class="form-control" name="flat_amount" id="Flatamount" placeholder="$0.00" value="{{ $product->flat_amount }}">
                                    </div>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input a12" type="radio" id="freeShippng" value="0" name="flat_rate" {{$product->flat_rate == '0' ? 'checked' : '' }}>
                                  <label class="form-check-label" for="freeShippng">Free Shipping</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h2>Categories</h2>
                            @include('admin.shared.categories', ['categories' => $categories, 'ids' => $product])
                            @if(!$brands->isEmpty())
                                <div class="form-group">
                                    <label for="brand_id">Brand </label>
                                    <select name="brand_id" id="brand_id" class="form-control select2">
                                        <option value=""></option>
                                        @foreach($brands as $brand)
                                            <option @if($brand->id == $product->brand_id) selected="selected" @endif value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @include('admin.shared.status-select', ['status' => $product->status])
                            <hr/>
                            <button type="submit" class="btn btn-success">Update</button>
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
