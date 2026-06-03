@extends('layouts.admin.app')
@section('content')
	<div class="container">
        <div class="card bg-light mt-3">
            @include('layouts.errors-and-messages')
            <div class="card-header">
                Import Products
            </div>
            <div class="card-body">
                <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button class="btn btn-success vendor-product-bt">Import Products</button>
                    <a class="btn btn-warning vendor-product-bt" href="{{ route('admin.export') }}">Export Products</a>
                </form>
            </div>
        </div>
    </div>
@endsection