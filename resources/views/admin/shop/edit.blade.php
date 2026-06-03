@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

@section('content')
 <!-- Main content -->
    <section class="content">
        <h2>Edit Shop</h2>
        
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg">
            <form action="{{ route('shop.update', $shops->id) }}" method="post" class="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <input type="hidden" name="_method" value="put">
               
                
                <div class="form-row">
                    <div class="col-sm-12">
                        <label for="parent">Shop Title</label>
                        <select class="form-control" name="title" required="">
                            <option value="{{ $shops->title }}">{{ $shops->business_title }}</option>
                            @foreach($business_type as $btype)
                            <option value="{{$btype->id}}">{{$btype->title}}</option>
                            @endforeach
                        </select>
                       
                    </div>
                </div><br>

                <div class="form-row">
                    <div class="col-sm-12">
                        <label for="parent">Shop Location</label>
                        <textarea type="text" name="location" id="location" placeholder="Shop location" class="form-control" required="">{{ $shops->location }}</textarea>
                    </div>
                </div>

                     <div class="card mt-3">
                        <div class="card-body">
                            <label>Shop image <span class="text-danger">*</span></label>
                            <div id="userActions" class="rounded-lg bg-white mx-auto text-center p-4"><label for="fileUpload">
                                @if(isset($shops->shop_image))
                                    <img id="imgPrime" src="{{ asset( 'storage/shop/'.$shops->shop_image.'' ) }}" height="150" width="150">
                                @else
                                    <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" height="150" width="150">
                                @endif
                                <p class="m-2">Change shop image</p>
                                <input type="file" id="fileUpload" name="shop_image" class="d-none image-gallery-input" >
                                </label>
                            </div>
                        </div>
                    </div>
                
                <button type="submit" class="btn btn-success mt-4">Save</button>

            </form>
        </div>
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
