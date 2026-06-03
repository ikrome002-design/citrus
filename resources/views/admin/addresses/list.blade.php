@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($addresses)
            <div class="card">
                <div class="card-body">
                    <h2>Addresses</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>Alias</td>
                                    <td>Address 1</td>
                                    <td>Country</td>
                                    <td>Province</td>
                                    <td>City</td>
                                    <td>Zip Code</td>
                                    <td>Status</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($addresses as $address)
                                <tr>
                                    <td><a href="{{ route('admin.customers.show', [$address->customer_id]) }}">{{ $address->alias }}</a></td>
                                    <td>{{ $address->address_1 }}</td>
                                    <td>{{ $address->country }}</td>
                                    <td>{{ $address->province }}</td>
                                    <td>{{ $address->city }}</td>
                                    <td>{{ $address->zip }}</td>
                                    <td>@include('layouts.status', ['status' => $address->status])</td>
                                    <td>
                                        <form action="{{ route('admin.addresses.destroy', $address->id) }}" method="post" class="form-horizontal">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="delete">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.addresses.edit', $address->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                                <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($addresses instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">{{ $addresses->links() }}</div>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        @else
            <div class="card">
                <div class="card-body"><p class="alert alert-warning">No addresses found.</p></div>
            </div>
        @endif
    </section>
    <!-- /.content -->
@endsection