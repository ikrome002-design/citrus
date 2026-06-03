@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card-body px-0">
            <div class="row">
                <div class="col-md-12">
                 <h1 class="top-heading mb-4">Add Features</h1>
                 </div>
            </div>
            <div class="container-fluid px-0">
                <div class="card-deck create-feature-box">
                     <div class="card">
                        <form action="{{ route('admin.features.store') }}" method="post" class="p-lg-5 image-upload-form" enctype="multipart/form-data" >
                             @include('layouts.errors-and-messages')
                            <div class="box-body">
                                {{ csrf_field() }}
                                 <label style="color:red;">(Image size should be Width: 435px X Height: 240px)</label>
                                <div class="row">
                                    <div class="form-group text-center mt-4 col-12">
                                        <div id="userActions" class="rounded-lg bg-white mx-auto text-center p-4">   
                                            <label for="fileUpload">
                                                <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" height="150" width="150">
                                                <p class="m-2">Add Feature image</p>
                                            <input type="file" id="fileUpload" name="banner_image" class="d-none"/>
                                            </label>
                                        </div>
                                    </div>
                                     <div class="col-md-6 mt-lg-5 mt-md-2">
                                         <div class="form-group">
                                           <label class="font-weight-bold" for="title">Title</label>
                                            <input type="text" name="title" id="title" placeholder="Add Title" class="form-control" value="{{ old('title') }}">
                                        </div>
                                    </div>
                                   <div class="col-md-6 mt-lg-5 mt-md-2">
                                         <div class="form-group">
                                           <label class="font-weight-bold" for="subtitle">SubTitle</label>
                                            <input type="text" name="subtitle" id="subtitle" placeholder="Add SubTitle" class="form-control" value="{{ old('subtitle') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                          <label class="font-weight-bold" for="order">Order</label>
                                          <input type="text" name="order" id="order" placeholder="e.g. 1" class="form-control" value="{{ old('order') }}">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="button_text">Button Text</label>
                                            <input type="text" name="button_text" id="button_text" placeholder="Add Button Text" class="form-control" value="{{ old('button_text') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="button_link">Button Link</label>
                                            <input type="text" name="button_link" id="button_link" placeholder="Add Button Link" class="form-control" value="{{ old('button_link') }}">
                                        </div>
                                   </div>
                                </div>
                                @include('admin.shared.status-select', ['status' => 0])

                            </div>
                            <!-- /.card-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success float-lg-left mt-5">Add Feature</button>
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
