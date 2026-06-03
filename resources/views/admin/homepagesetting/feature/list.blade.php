@extends('layouts.admin.app')

@section('content')
<!-- Main content -->
<section class="content">
@include('layouts.errors-and-messages')
<!-- Default box -->
    @if($lists)
    <div class="card shadow-sm rounded">
        <div class="mb-5 card-header">
            <div class="row">
                <div class="col-auto">
                    <h3 class="top-heading">Manage Features</h3>
                </div>
                <div class="col-auto ml-auto">
                    <a href="{{ route('admin.features.create') }}" class="btn btn-success ml-5 float-lg-right">Create New Features</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
            @foreach($lists as $row)
                <div class="col-md-12 col-lg-6">
                    <div class="border mb-3">
                        <div class="row p-3">
                            <div class="col-12 mb-3">
                                <img class="rounded float-left img-fluid" src="{{  asset('storage/'.$row->banner_image) }}" alt="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="font-weight-bold">Title</h6>
                                <p>{{ $row->title }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="font-weight-bold">Sub Title</h6>
                                <p>{{ $row->subtitle }}</p>
                            </div>
                             
                            <div class="col-md-6 mb-3">
                                <h6 class="font-weight-bold">Button Link</h6>
                                <p>{{ $row->button_link }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6 class="font-weight-bold">Button Text</h6>
                                <p>{{ $row->button_text }}</p>
                            </div>
                            <div class="col-12 mb-3">
                                <h6 class="font-weight-bold">Section Name</h6>
                                <p>{{ $row->order }}</p>
                            </div>

                            <div class="col-md-12 text-center mt-2 manage-feature-form">
                                <div class="d-flex flex-wrap" role="group" aria-label="Basic example">
                                    <a href="{{ route('admin.features.edit', $row->id) }}" class="btn btn-success mr-2">Edit Feature</a>

                                    <form action="{{ route('admin.features.destroy', $row->id) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button  class="btn btn-danger mr-1" type="submit" onclick="return confirm('Are you sure?')">
                                            Delete  Feature
                                        </button>

                                        @if($row->status == 1)
                                        <td><span style="display: none; visibility: hidden">1</span>
                                        <a href="{{ route('admin.features.unapprove', ['id' => $row->id]) }}" class="btn btn-success btn-sm" onclick="return confirm('Are you sure?')"> Approved</a></td>
                                        @else
                                    <td><span style="display: none; visibility: hidden">0</span>
                                        <a href="{{ route('admin.features.approve', ['id' => $row->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Unapproved</a></td>
                                    @endif

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
