@extends('layouts.admin.app')

@section('content')
<!-- Main content -->
<section class="content">
@include('layouts.errors-and-messages')
<!-- Default box -->
    @if($lists)
    <div class="card shadow-sm rounded manage-banners">
        <div class="mb-5 card-header">
            <div class="row">
                <div class="col-auto">
                    <h3 class="top-heading">Manage Banners</h3>
                </div>
                <div class="col-auto ml-auto">
                    <a href="{{ route('admin.banners.create') }}" class="btn btn-success ml-5 float-lg-right">Create New Banners</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
            @foreach($lists as $row)
                <div class="col-md-12 col-lg-6 mb-md-3 mb-lg-0">
                    <div class="border admin-mange-banner-box">
                        <div class="row p-3">
                            <div class="col-12 mb-3">
                                <img class="rounded float-left img-fluid" src="{{  asset('storage/banners/'.$row->banner_image) }}" alt="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="font-weight-bold">Title</h6>
                                <p>{{ $row->title }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="font-weight-bold">Sub Title</h6>
                                <p>{{ $row->subtitle }}</p>
                            </div>
                            
                            <hr>
                            <div class="col-md-12 mb-3">
                                <h6 class="font-weight-bold">Description</h6>
                                <p>{{ $row->description }}</p>
                            </div>
                            
                            
                            <div class="col-md-12 text-center mt-2 admin-mange-banner-bt">
                                <div class="d-flex flex-wrap" role="group" aria-label="Basic example">
                                    <a href="{{ route('admin.banners.edit', $row->id) }}" class="btn btn-success mr-2">Edit Banner</a>
                                    <form action="{{ route('admin.banners.destroy', $row->id) }}"        method="post">                                        
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button  class="btn btn-danger" type="submit" onclick="return confirm('Are you sure?')">
                                            Delete  Banner
                                        </button>

                                       
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
    <!-- /. card -->
    @endif
</section>
<!-- /.content -->
@endsection
