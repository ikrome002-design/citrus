@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="card-body px-0">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="top-heading mb-5">Edit Banners</h1>
                </div>
            </div>
             <div class="container-fluid px-0">
                <div class="card-deck edit-banners">
                    <div class="card">
                         <form action="{{ route('admin.banners.update', $banner->id) }}" method="post" class="p-lg-5 image-upload-form" enctype="multipart/form-data">
                            
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                        <div class="box-body">
                                {{ csrf_field() }}
                                 <label style="color:red;">(For Option Products - Image size should be Width: 990px X Height: 415px) && (For Option services - Image size should be Width: 435px X Height: 415px)</label>
                                <div class="row">

                                <input type="hidden" name="banner_image_old" value="{{ $banner->banner_image }}">
                                <div class="form-group text-center mt-4 col-12">
                                    <div id="userActions" class="rounded-lg bg-white mx-auto text-center p-4">
                                        <label for="fileUpload">
                                 @if(isset($banner->banner_image))
                                <img id="imgPrime" 
                                    src="{!! asset('storage/banners/'.$banner->banner_image) ? : old('banner_image')  !!}" 
                                    height="150" width="150">
                                    @else
                                        <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" height="150" width="150">
                                    @endif
                                <p class="m-2">Change Banner image</p>
                                <input type="file" id="fileUpload" name="banner_image" class="d-none image-gallery-input" accept="image/x-png,image/gif,image/jpeg"/>
                                </label>
                            </div>
                        </div>
                       <div class="col-md-6 mt-lg-5 mt-md-2">
                            <div class="form-group edit-banner-group">
                               <label for="tax_name">Title<span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" placeholder="Title" class="form-control" value="{!! $banner->title ? : old('title')  !!}">
                            </div>
                        </div>
                         <div class="col-md-6 mt-lg-5 mt-md-2">
                              <div class="form-group edit-banner-group">
                               <label for="rate_percentage">SubTitle<span class="text-danger">*</span></label>
                                <input type="text" name="subtitle" id="subtitle" placeholder="SubTitle" class="form-control" value="{!! $banner->subtitle ?: old('subtitle')  !!}">
                            </div>
                        </div>
                    </div>
                     <div class="row">
                       <div class="col-md-6">
                            <div class="form-group">
                                <label for="state_code">Description <span class="text-danger">*</span></label>
                                <input type="text" name="description" id="description" placeholder="Description" class="form-control" value="{!! $banner->description ?: old('description')  !!}">
                            </div>
                        </div>
                         
                       
                        </div>
                        
                           
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer mt-5">
                            <button type="submit" class="btn btn-success float-lg-left">Edit Banner</button>
                         </div>
                    </form>
                    </div>
                </div>
             </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
