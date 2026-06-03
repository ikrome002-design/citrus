@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
        <!-- Default box -->
        @if($memberships)
        <div class="box">
            <div class="box-body">
                <table class="table">
                    <tbody>
                    <tr>
                        <td class="col-md-2">Name</td>
                        <td class="col-md-2">Price ({{ config('cart.currency') }})</td>
                        <td class="col-md-2">Add Product</td>
                        <td class="col-md-2">Sell Product</td>
                        <td class="col-md-2">Display Product</td>
                    </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>{{ $membership_name }}</td>
                            <td>{{ $memberships->price }}</td>
                            <td>{{ $memberships->sell }}</td>
                            <td>{{ $memberships->add }}</td>
                            <td>{{ $memberships->display }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="btn-group">
                    <a href="{{ route('admin.memberships.index') }}" class="btn btn-default btn-sm">Back</a>
                </div>
            </div>
        </div>
        @endif
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
