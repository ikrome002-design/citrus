@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content admin-fotr-edit">
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg" >
            <form action="{{ route('admin.footers.update', $footer->id) }}" method="post" class="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="put">
                <div class="form-group">
                    <label for="name" class="btn btn-primary rounded-0 vendor-product-bt">Title</label>
                    <input style="margin-top: -7px;" type="text" name="title" id="title" placeholder="title" class="form-control" value="{{ $footer->title }}">
                </div>
                <div class="form-group">
                    <label for="name" class="btn btn-primary rounded-0 vendor-product-bt">Link</label>
                    <input style="margin-top: -7px;" type="text" name="link" id="name" placeholder="link" class="form-control" value="{{ $footer->link }}">
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ route('admin.footers.index','type='.$footer->type) }}" class="btn btn-danger vendor-product-bt">Back</a>
                    <button type="submit" class="btn btn-primary vendor-product-bt">Update</button>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
