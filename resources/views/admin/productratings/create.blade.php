@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.memberships.store') }}" method="post" class="form">
                <div class="box-body">
                    {{ csrf_field() }}
                   
                    <div class="form-group">
                        <label for="varient">Varient </label>
                        <select name="membership_varient_id" id="membership_varient_id" class="form-control select2">
                            @foreach($membership_name as $membershipvarients)
                               <option value="{{ $membershipvarients->id }}">{{ ucfirst($membershipvarients->varient_type) }}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="price">Price <span class="text-danger">*</span></label>
                        <input type="text" name="price" id="price" placeholder="Price" class="form-control" value="{{ old('price') }}">
                    </div>
                    <div class="form-group">
                        <label for="sell_product">Sell Product <span class="text-danger">*</span></label>
                        <input type="text" name="sell" id="sell" placeholder="Sell Product Quantity" class="form-control" value="{{ old('sell') }}">
                    </div>
                    <div class="form-group">
                       <label for="add_product">Add Product <span class="text-danger">*</span></label>
                        <input type="text" name="add" id="add" placeholder="Add Product Quantity" class="form-control" value="{{ old('add') }}">
                    </div>
                    <div class="form-group">
                       <label for="add_product">Display Product <span class="text-danger">*</span></label>
                        <input type="text" name="display" id="display" placeholder="Display Product Quantity" class="form-control" value="{{ old('display') }}">
                    </div>
                  
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <div class="btn-group">
                            <a href="{{ route('admin.memberships.index') }}" class="btn btn-default">Back</a>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
