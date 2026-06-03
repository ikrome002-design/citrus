@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="card-body px-0">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="top-heading mb-5">Edit Features</h1>
                </div>
            </div>
             <div class="container-fluid px-0">
                <div class="card-deck edit-feature-box">
                    <div class="card">
                         <form action="{{ route('admin.features.update', $feature->id) }}" method="post" class="p-lg-5 image-upload-form" enctype="multipart/form-data">
                           
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                        <div class="box-body">
                                {{ csrf_field() }}
                                 <label style="color:red;">(Image size should be Width: 435px X Height: 240px)</label>
                                <div class="row">

                                    <input type="hidden" name="banner_image_old" value="{{ $feature->banner_image }}">
                                    <div class="form-group text-center mt-4 col-12">
                                        <div id="userActions" class="rounded-lg bg-white mx-auto text-center p-4">
                                            <label for="fileUpload">
                                             @if(isset($feature->banner_image))
                                            <img id="imgPrime" 
                                                src="{!! asset('storage/'.$feature->banner_image) ? : old('banner_image')  !!}" 
                                                height="150" width="150">
                                                @else
                                                    <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" height="150" width="150">
                                                @endif
                                            <p class="m-2">Change feature image</p>
                                            <input type="file" id="fileUpload" name="banner_image" class="d-none image-gallery-input" accept="image/x-png,image/gif,image/jpeg"/>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-lg-5 mt-md-3">
                                        <div class="form-group edit-feature-group">
                                           <label for="tax_name">Title<span class="text-danger">*</span></label>
                                            <input type="text" name="title" id="title" placeholder="Title" class="form-control" value="{!! $feature->title ? : old('title')  !!}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-lg-5 mt-md-3">
                                        <div class="form-group edit-feature-group">
                                            <label for="rate_percentage">SubTitle<span class="text-danger">*</span></label>
                                            <input type="text" name="subtitle" id="subtitle" placeholder="SubTitle" class="form-control" value="{!! $feature->subtitle ?: old('subtitle')  !!}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                         <div class="form-group edit-feature-group">
                                             <label for="state_code">Button Link <span class="text-danger">*</span></label>
                                             <input type="text" name="button_link" id="button_link" placeholder="Button Link " class="form-control" value="{!! $feature->button_link ?: old('button_link')  !!}">
                                         </div>
                                     </div>
                                      <div class="col-md-4">
                                          <div class="form-group edit-feature-group">
                                            <label for="postal_code">Button Text<span class="text-danger">*</span></label>
                                             <input type="text" name="button_text" id="button_text" placeholder="Button Text" class="form-control" value="{!! $feature->button_text ?: old('button_text')  !!}">
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group edit-feature-group">
                                            <label for="order"> Order<span class="text-danger">*</span></label>
                                            <input type="text" name="order" id="order" placeholder="e.g. 1" class="form-control" value="{!! $feature->order ?: old('order')  !!}">
                                        </div>
                                    </div>
                                </div>
                                 @include('admin.shared.status-select', ['status' => $feature->status])
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success float-lg-left mt-5">Edit Feature</button>
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
