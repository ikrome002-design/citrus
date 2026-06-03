@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <!-- Default box -->
        <div class="card shadow-sm rounded-lg" style="max-width:650px;">
            <form action="{{ route('admin.order-status.store') }}" method="post">
            <div class="card-body">
                <h2 class="top-heading mb-4">Order Status</h2>
                {{ csrf_field() }}
                <div class="form-group order-create-group">
                    <label for="name">Name</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Name">
                </div>
                <div class="form-group order-create-group">
                    <label for="color">Color</label>
                    <input class="form-control jscolor" type="text" name="color" id="color" value="{{ old('color') }}">
                </div>
            </div>
            <!-- /.box-body -->
                <div class="card-footer order-create-btns pb-3">
                    <a href="{{ route('admin.order-status.index') }}" class="btn btn-danger vendor-product-bt py-2">Back</a>
                    <button type="submit" class="btn btn-success vendor-product-bt py-2">Create</button>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
@section('js')
    <script src="{{ asset('js/jscolor.min.js') }}" type="text/javascript"></script>
@endsection
