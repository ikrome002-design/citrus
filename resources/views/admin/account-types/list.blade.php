@extends('layouts.admin.app')

@section('content')
    <section class="content">
        <h2>Account Types</h2>
        <div class="mb-3">
            <a class="btn btn-success btn-sm mb-2" href="{{ route('admin.account.types.create') }}"><i class="fa fa-plus"></i>
                Add Account Type</a>
        </div>
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg mt-4">


            <table class="table data-table table-hover table-bordered table-striped border-bottom">
                <thead>
                    <tr>
                        <td>Account Type Name</td>
                        <td>Status</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($account_types as $account_type)
                        <tr>
                            <td>
                                {{ $account_type->name }}
                            </td>
                            <td>
                                {{ $account_type->status }}
                            </td>
                            <td>
                                <a href="{{ route('admin.account.types.show', $account_type->id) }}"
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
