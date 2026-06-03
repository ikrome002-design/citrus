@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
        <!-- Default card -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <td>Name</td>
                            <td>ISO</td>
                            <td>ISO-3</td>
                            <td>Numcode</td>
                            <td>Phone Code</td>
                            <td>Status</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $country->name }}</td>
                            <td>{{ $country->iso }}</td>
                            <td>{{ $country->iso3 }}</td>
                            <td>{{ $country->numcode }}</td>
                            <td>{{ $country->phonecode }}</td>
                            <td>@include('layouts.status', ['status' => $country->status])</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-body">
                @include('admin.shared.provinces', ['country' => $country->id])
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="btn-group">
                    <a href="{{ route('admin.countries.index') }}" class="btn btn-default btn-sm">Back</a>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
