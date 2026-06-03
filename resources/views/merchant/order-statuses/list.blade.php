@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

        @include('layouts.errors-and-messages')
        <!-- Default card -->
        @if($orderStatuses)
        <div class="card">
            <div class="card-body">
                <h2>Order Status</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Color</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($orderStatuses as $status)
                            <tr>
                                <td>{{ $status->name }}</td>
                                <td><button class="btn" style="background-color: {{ $status->color }}"><i class="fa fa-check" style="color: #ffffff"></i></button></td>
                                <td>
                                    <form action="{{ route('admin.order-status.destroy', $status->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.order-status.edit', $status->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
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
