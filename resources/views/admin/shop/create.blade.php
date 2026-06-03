@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

@section('content')
    <!-- Main content -->
    <section class="content">
         <h2>Create Shop</h2>
        @include('layouts.errors-and-messages')
         <div class="card shadow-sm p-4 rounded-lg create-caregories-box">
            <form action="{{ route('shop.store') }}" method="post" class="form" enctype="multipart/form-data">
                {{ csrf_field() }}
              
             <input type="hidden" name="merchant_id" value="{{ auth('vendor')->user()->id }}">
                <div class="form-row">
                    <div class="col-sm-12">
                        <label for="parent">Shop Title</label>
                        <select class="form-control" name="title" required="">
                            <option value="">Select Shop Title</option>
                            @foreach($business_type as $btype)
                            <option value="{{$btype->id}}">{{$btype->title}}</option>
                            @endforeach
                        </select>

                    </div>
                </div><br>

                <div class="form-row">
                    <div class="col-sm-12">
                        <label for="parent">Shop Location</label>
                        <textarea type="text" name="location" id="location" placeholder="Shop location" class="form-control" required=""></textarea>
                    </div>
                </div><br>
                <div class="card mt-3">
                        <div class="card-body pt-4 pb-5 product-create-group">
                            <label>Shop image <span class="text-danger">*</span></label>
                            <div id="userActions" class="rounded-lg bg-white mx-auto text-center p-4"><label for="fileUpload">
                                <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" height="150" width="150">
                                <p class="m-2">Add shop image</p>
                                <input type="file" id="fileUpload" name="shop_image" class="d-none image-gallery-input "/>
                              <!-- <span id="file_error"></span>  -->
                                </label>
                            </div>
                        </div>
                    </div><br>

             
                <button type="submit" class="btn btn-success mt-4">ADD </button>

            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
@else
@section('js')
<script type="text/javascript">
   
        window.location="{{ route('vendor.dashboard') }}";
   
</script>
@endsection
@endif