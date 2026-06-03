@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default card -->
        @if($countries)
            <div class="card">
                <div class="card-body">
                    <h2>Countries</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>ISO</td>
                                    <td>ISO-3</td>
                                    <td>Numcode</td>
                                    <td>Phone Code</td>
                                    <td>Status</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($countries as $country)
                                <tr>
                                    <td>{{ $country->name }}</td>
                                    <td>{{ $country->iso }}</td>
                                    <td>{{ $country->iso3 }}</td>
                                    <td>{{ $country->numcode }}</td>
                                    <td>{{ $country->phonecode }}</td>
                                    <td>@include('layouts.status', ['status' => $country->status])</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.countries.show', $country->id) }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Show</a>
                                            <a href="{{ route('admin.countries.edit', $country->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $countries->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        @endif

    </section>
    <!-- /.content -->
@endsection
