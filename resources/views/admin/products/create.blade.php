@extends('layouts.admin.app')
@section('css')
<script src="{{ asset('js/ckeditor.min.js') }}"></script>
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <form action="{{ route('admin.products.store') }}" method="post" class="form" enctype="multipart/form-data" >
            <div class="row">
                {{ csrf_field() }}
                <input type="hidden" name="mass_unit" value="Lbs">
                @if(isset(auth('vendor')->user()->id))
                    <input type="hidden" name="created_by" value="{{auth('vendor')->user()->id}}">
                    <input type="hidden" name="vendor_id" value="{{auth('vendor')->user()->id}}">
                @endif
                @if(isset(auth('employee')->user()->id))
                    <input type="hidden" name="created_by" value="{{auth('employee')->user()->id}}">
                @endif
                <div class="col-md-12 col-lg-8 product-create-box">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group product-create-group">
                                <label for="name">Choose Vendor <span class="text-danger">*</span></label>
                               <select class="form-control" name="vendor_id" required="">
                                @foreach($vendor as $vendor1)
                                   <option value="{{ $vendor1->id }}">{{ $vendor1->name }}</option>
                                   @endforeach
                               </select>
                            </div>

                            <div class="form-group product-create-group">
                                <label for="name">Product or Service Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{{ old('name') }}">
                            </div>
                            <div class="form-group product-create-group">
                                <label for="short_description">Short Description </label>
                                <textarea class="form-control" name="short_description" id="short_description" rows="5" placeholder="Short description">{{ old('short_description') }}</textarea>
                            </div>
                            <div class="form-group product-create">
                                <label for="description">Description </label>
                                <textarea class="form-control" name="description" id="editor" rows="5" placeholder="Description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body pt-4 pb-5 product-create-group">
                            <label>Featured image <span class="text-danger">*</span></label>
                            <div id="userActions" class="rounded-lg bg-white mx-auto text-center p-4"><label for="fileUpload">
                                <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" height="150" width="150">
                                <p class="m-2">Add feature image</p>
                                <input type="file" id="fileUpload" name="cover" class="d-none image-gallery-input "  />
                              <!-- <span id="file_error"></span>  -->
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body edit-tax-group">
                            <label class="mb-4">Gallery images</label>
                            <div class="product-gallery-image row">
                                <div class="gallery-image-1 product-create-gallery-img text-center col-auto" image-field="1">
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
                    <div class="card mt-3 product-create-group">
                        <div class="card-body product-create-inline">
                            <h5 class="text-primary font-24 mb-4">Type</h5>
                            <div class="form-check form-check-inline product-create-group">
                                <label class="form-check-label" for="VirtualProduct">
                                    <input type="radio" name="product_type" checked class="form-check-input" id="VirtualProduct" value="virtual">
                                    Product
                                </label>
                            </div>
                            <div class="form-check form-check-inline product-create-group">
                                <label class="form-check-label" for="ServicesProduct">
                                    <input type="radio" name="product_type" class="form-check-input" id="ServicesProduct" value="services">
                                    Service
                                </label>
                            </div>
                            <hr/>
                            <p>General</p>
                            <div class="form-row product-create-group">
                                <div class="col-md-4">
                                    <label for="price">Regular Price ({{ config('cart.currency') }}) <span class="text-danger">*</span></label>
                                    <input type="text" name="price" id="price" placeholder="Regular Price" class="form-control" value="{{ old('price') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="selling-price">Sell Price ({{ config('cart.currency') }}) <span class="text-danger">*</span></label>
                                    <input type="text" name="sale_price" id="selling-price" placeholder="Selling Price" class="form-control" value="{{ old('sale_price') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="taxable">Tax Status <span class="text-danger">*</span></label>
                                    <select type="text" name="taxable" id="taxable" class="custom-select form-control">
                                        <option value="0">Tax Free</option>
                                        <option value="1">Taxable</option>
                                    </select>
                                </div>
                                <div class="col-md-4" id="taxDiv">
                                    <label for="taxList">Tax Type </label>
                                    <select name="tax_id" id="taxList" class="custom-select form-control">
                                        @foreach($tax_rates as $row)
                                        <option value="{{$row->id}}">{{$row->tax_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr/>
                            <p>Inventory</p>
                            <div class="form-row product-create-group">
                                <div class="col-md-6">
                                    <label for="sku">SKU <span data-toggle="tooltip" data-placement="top" title="Tooltip on top"><i class="fa fa-question-circle"></i></span></label>
                                    <input type="text" name="sku" id="sku" placeholder="xxxxx" class="form-control" value="{{ old('sku') }}" >
                                </div>
                                <div class="col-md-6">
                                    <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" id="quantity" placeholder="Quantity" class="form-control" value="{{ old('quantity') }}" min="1">
                                </div>
                            </div>
                            <hr/>
                        </div>
                    </div>
                    <div class="card mt-3" id="shipping-card">
                        <div class="card-body product-create-group">
                            <p>Shipping</p>
                            <div class="form-row product-create-group product-create-shipping">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input a12" type="radio" id="FlatRate" value="1" name="flat_rate">
                                  <label class="form-check-label" for="FlatRate">Cost</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group product-create-flat">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Cost</div>
                                        </div>
                                        <input type="text" class="form-control" name="flat_amount" id="Flatamount" placeholder="$0.00">
                                    </div>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input a12" type="radio" id="freeShippng" value="0" name="flat_rate">
                                  <label class="form-check-label" for="freeShippng">Free Shipping</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h2>Categories</h2>
                            @include('admin.shared.categories', ['categories' => $categories, 'selectedIds' => []])
                            @if(!$brands->isEmpty())
                            <div class="form-group mt-2">
                                <label for="brand_id">Brand </label>
                                <select name="brand_id" id="brand_id" class="form-control select2">
                                    <option value=""></option>
                                    @foreach($brands as $brand)
                                        <option @if(old('brand_id') == $brand->id) selected="selected" @endif value="{{ $brand->id }}">{{ $brand->name }}</option>
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
