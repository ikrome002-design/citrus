@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <h2>Manage Business Type</h2>
        <div class="text-end mb-3">
            @if (auth()->user()->hasPermissionTo('update account type', 'admin') && !$account_type->transhed())
                <a href="{{ route('admin.account.type.delete', $business_type->id) }}"
                    data-swal-title="Are you sure you want to delete this business type ? If there are categories and products related to this business type will not deleted"
                    class="delete-model btn btn-danger btn-sm me-1"><i class="fa fa-trash"></i>Edit</a>;
            @endif
            @if (auth()->user()->hasPermissionTo('delete account type', 'admin') && !$account_type->transhed())
                <a href="{{ route('admin.account.type.delete', $business_type->id) }}"
                    data-swal-title="Are you sure you want to delete this business type ? If there are categories and products related to this business type will not deleted"
                    class="delete-model btn btn-danger btn-sm me-1"><i class="fa fa-trash"></i> Delete</a>;
            @endif
            @if (auth()->user()->hasPermissionTo('Restore account type', 'admin') && $account_type->transhed())
                <a href="{{ route('admin.account.type.restore', $business_type->id) }}"
                    data-swal-title="Are you sure you want to delete this business type ? If there are categories and products related to this business type will not deleted"
                    class="delete-model btn btn-danger btn-sm me-1"><i class="fa fa-trash"></i> Restore</a>;
            @endif
        </div>
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg">
            <ul class="nav nav-tabs mb-3" id="tablist-header" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-business" type="button"
                        role="tab" aria-controls="tab-business" aria-selected="true">Edit
                        Business
                        Type</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-categories" type="button"
                        role="tab" aria-controls="tab-categories" aria-selected="false">Categories</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-products" type="button"
                        role="tab" aria-controls="tab-products" aria-selected="false">Products</button>
                </li>
            </ul>

            <div class="tablist-content">
                <div class="tab-pane fade show active" id="tab-business" role="tabpanel" aria-labelledby="tab-business">
                    <form action="{{ route('admin.account.type.update', $account_type->id) }}" method="post" class="form"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="form-row">
                            <div class="col-sm-12">
                                <label for="parent">Business Type</label>
                                <input type="text" name="title" id="title" placeholder="Business type"
                                    class="form-control" value="{{ $account_type->title }}" required="">
                            </div>
                            <div class="col-sm-12">
                                <label for="parent">Status (Inactive : merchants can't add and product can't be
                                    shown
                                    in
                                    frontend)
                                </label>
                                <select class="form-select" name="status">
                                    <option @selected($business_type->status == 'active') value="active">Active</option>
                                    <option @selected($business_type->status == 'inactive') value="inactive">Inactive</option>
                                </select>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-success mt-4">Save</button>

                    </form>
                </div>
                <div class="tab-pane fade " id="tab-categories" role="tabpanel" aria-labelledby="tab-categories">
                    {{ $dataTable->table() }}
                </div>
                <div class="tab-pane fade" id="tab-products" role="tabpanel" aria-labelledby="tab-products">...
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection

@section('js')
    {{ $dataTable->scripts() }}
@endsection
