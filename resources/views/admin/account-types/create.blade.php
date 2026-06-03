@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <h1>Create Account Type</h1>
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg create-caregories-box">
            <form action="{{ route('admin.account.types.store') }}" method="post" class="form" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="col-sm-12">
                        <label for="parent">Account type name</label>
                        <input type="text" name="name" placeholder="Account type" class="form-control"
                            value="{{ old('name') }}" required="">
                    </div>
                    <div class="col-sm-12">
                        <label for="parent">Status</label>
                        <select class="form-select" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-4">ADD </button>

            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
