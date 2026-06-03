@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="card">
            <form action="{{ route('admin.couriers.store') }}" method="post" class="form">
                <div class="card-body">
                    {{ csrf_field() }}
                    <div class="form-group courier-edit-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="{{ old('name') }}">
                    </div>
                    <div class="form-group courier-edit-group">
                        <label for="description">Description </label>
                        <textarea name="description" id="description" rows="5" class="form-control" placeholder="Description">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group courier-edit-group">
                        <label for="URL">URL</label>
                        <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">http://</span>
                              </div>
                            <input type="text" name="url" id="url" placeholder="Link" class="form-control" value="{{ old('url') }}">
                        </div>
                    </div>
                    <div class="form-group courier-edit-group">
                        <label for="is_free">Is Free Delivery? </label>
                        <select name="is_free" id="is_free" class="form-control">
                            <option value="0">No</option>
                            <option value="1" selected="selected">Yes</option>
                        </select>
                    </div>
                    <div class="form-group courier-edit-group" style="display: none" id="delivery_cost">
                        <label for="cost">Delivery Cost <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon">CAD</span>
                            <input class="form-control" type="text" id="cost" name="cost" placeholder="" value="{{old('cost')}}">
                        </div>
                    </div>
                    <div class="form-group courier-edit-group">
                        <label for="status">Status </label>
                        <select name="status" id="status" class="form-control">
                            <option value="0">Disable</option>
                            <option value="1">Enable</option>
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer courier-edit-footer-btn">
                    <div class="btn-group">
                        <a href="{{ route('admin.couriers.index') }}" class="btn btn-danger mr-3">Back</a>
                        <button type="submit" class="btn btn-success">Create</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
