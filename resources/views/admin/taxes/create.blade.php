@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid px-0">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h3 class="top-heading">Manage Taxes</h3>
                </div>
            </div>
            <div class="">
                <div class="card-deck">
                     <div class="card">
                        <form action="{{ route('admin.taxes.store') }}" method="post" class="p-5">
                             @include('layouts.errors-and-messages')
                            <div class="box-body">
                                {{ csrf_field() }}
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="font-bold">Tax name<span class="text-danger">*</span></label>
                                            <input type="text" name="tax_name" id="tax_name" placeholder="Enter Tax name" class="form-control" value="{{ old('tax_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                           <label class="font-weight-bold" for="perc_rate">Tax Rate (%)<span class="text-danger">*</span></label>
                                            <input type="text" name="rate_percentage" id="rate_percentage" placeholder="0.00%" class="form-control" value="{{ old('rate_percentage') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="state_code">Province<span class="text-danger">*</span></label>
                                            <input type="text" name="state_code" id="state_code" placeholder="province" class="form-control" value="{{ old('state_code') }}" required="">
                                        </div>
                                    </div>
                                     
                                </div>
                                <!-- <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="postal_code">Postal Code</label>
                                            <input type="text" name="postal_code" id="postal_code" placeholder="Postal Code" class="form-control" value="{{ old('postal_code') }}">
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="postal_code">Description<span class="text-danger">*</span></label>
                                            <textarea name="description" placeholder="description" class="form-control" required="">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer mt-3">
                                <button type="submit" class="btn btn-success float-lg-left">Add Tax</button>
                             </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
