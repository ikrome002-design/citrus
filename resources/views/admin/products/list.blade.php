@extends('layouts.admin.app')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <a href="{{ route('admin.products.index') }}">
                        <div class="card-body shadow-sm">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="shadow-sm p-3 rounded-circle">
                                        <i class="fa fa-gift text-success fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h3 class="text-success">{{ count($products) }}</h3>
                                    <p style="color:black;">Total Products</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <a href="{{ route('admin.categories.index') }}">
                        <div class="card-body shadow-sm">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="shadow-sm p-3 rounded-circle">
                                        <i class="fa fa-list text-success fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h3 class="text-success">{{ count($categories) }}</h3>
                                    <p style="color:black;">Total Categories</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">

                    <a href="{{ route('admin.products.create') }}">
                        <div class="card-body shadow-sm bg-success">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="shadow-sm p-3 rounded-circle bg-white">
                                        <i class="fa fa-gift text-success fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center text-white">
                                    <h3>Create</h3>
                                    <p>New Products</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <br />
        @include('layouts.errors-and-messages')
        <!-- Default box -->
        @if (!$products->isEmpty())
            <div class="card mt-5">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h3>All products</h3>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <a href="/admin/import" class="btn btn-white border"><i class="fa fa-upload"></i> Import</a>
                            <a href="{{ route('admin.export') }}" class="btn btn-white border"><i
                                    class="fa fa-download"></i> Export</a>
                        </div>
                    </div>
                    @include('admin.shared.products')
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
