@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default card -->
        @if($couriers)
            <div class="card">
                <div class="card-body">
                    <h2> <i class="fa fa-truck"></i> Couriers</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Description</td>
                                    <td>URL</td>
                                    <td>Free Delivery</td>
                                    <td>Cost</td>
                                    <td>Status</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($couriers as $courier)
                                <tr>
                                    <td>{{ $courier->name }}</td>
                                    <td>{{ str_limit($courier->description, 100, ' ...') }}</td>
                                    <td>{{ $courier->url }}</td>
                                    <td>
                                        @include('layouts.status', ['status' => $courier->is_free])
                                    </td>
                                    <td>
                                        {{ config('cart.currency') }} {{ $courier->cost }}
                                    </td>
                                    <td>@include('layouts.status', ['status' => $courier->status])</td>
                                    <td>
                                        <form action="{{ route('admin.couriers.destroy', $courier->id) }}" method="post" class="form-horizontal">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="delete">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.couriers.edit', $courier->id) }}" class="btn btn-primary vendor-product-bt"><i class="fa fa-edit"></i> Edit</a>
                                                <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger vendor-product-bt"><i class="fa fa-times"></i> Delete</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        @endif

    </section>
    <!-- /.content -->
@endsection
