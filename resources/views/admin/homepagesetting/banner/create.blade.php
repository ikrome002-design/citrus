@extends('layouts.admin.app')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card-body px-0">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="top-heading mb-4">Add Banners</h1>
                </div>
            </div>
            <div class="container-fluid px-0">
                <div class="card-deck edit-banners">
                     <div class="card">
                        <form action="{{ route('admin.banners.store') }}" method="post" class="p-lg-5 admin-banner-create-box" enctype="multipart/form-data" >
                             @include('layouts.errors-and-messages')
                            <div class="box-body">
                                {{ csrf_field() }}
                                <label style="color:red;">(For Option Products - Image size should be Width: 990px X Height: 415px) && (For Option services - Image size should be Width: 435px X Height: 415px)</label>
                                <div class="row">
                                    <div class="form-group text-center mt-2 mb-5 col-12">
                                        <div id="userActions" class="rounded-lg bg-white mx-auto text-center p-4">   
                                            <label for="fileUpload">
                                                <img id="imgPrime" src="{{ asset('images/upload-file.png')}}" height="150" width="150">
                                                <p class="m-2">Add Banner image</p>
                                            <input type="file" id="fileUpload" name="banner_image" class="d-none" accept="image/x-png,image/gif,image/jpeg"/>
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
                                    
                                   <div class="col-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="description">Description</label>
                                            <textarea type="text" name="description" id="description" placeholder="Add Description" class="form-control">{{ old('description') }}</textarea>
                                        </div>
                                    </div>

                                </div>
                                

                            </div>
                            <!-- /.card-body -->
                            <div class="box-footer mt-4">
                                <button type="submit" class="btn btn-success float-lg-left">Add Banner</button>
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
