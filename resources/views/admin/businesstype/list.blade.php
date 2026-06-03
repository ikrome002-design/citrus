@extends('layouts.admin.app')

@section('content')
    <section class="content">
        <h2>Manage Business Type</h2>
        <div class="mb-3">
            <a class="btn btn-success btn-sm mb-2" href="{{ route('admin.business_type.create') }}"><i class="fa fa-plus"></i>
                Add Business Type</a>
        </div>
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg mt-4">


            <table class="table data-table table-hover table-bordered table-striped border-bottom">
                <thead>
                    <tr>
                        <td>Business Type Name</td>
                        <td>Status</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($business_type as $business_types)
                        <tr>
                            <td>
                                {{ $business_types->title }}
                            </td>
                            <td>
                                {{ $business_types->status }}
                            </td>
                            <td>
                                <a href="{{ route('admin.business_type.edit', $business_types->id) }}"
                                    class="btn btn-primary"><i class="fa fa-eye"></i>Manage</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <!-- /.content -->
@endsection
