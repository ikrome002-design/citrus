@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="card-body px-0">
            <div class="row px-0">
                <div class="col-md-12">
                    <h1 class="top-heading mb-5">Edit Taxes</h1>
                </div>
            </div>
             <div class="container-fluid px-0">
                <div class="card-deck ">
                    <div class="card">
                         <form action="{{ route('admin.taxes.update', $tax->id) }}" method="post" class="p-5" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                        <div class="box-body">
                                {{ csrf_field() }}
                                <div class="row">
                                   <div class="col-md-6">
                                        <div class="form-group edit-tax-group">
                                           <label for="tax_name">Tax name<span class="text-danger">*</span></label>
                                            <input type="text" name="tax_name" id="tax_name" placeholder="Tax name" class="form-control" value="{!! $tax->tax_name ?: old('tax_name')  !!}">
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                          <div class="form-group edit-tax-group">
                                           <label for="rate_percentage">Rate (%)<span class="text-danger">*</span></label>
                                            <input type="text" name="rate_percentage" id="rate_percentage" placeholder="Rate (%)" class="form-control" value="{!! $tax->rate_percentage ?: old('rate_percentage')  !!}">
                                        </div>
                                    </div>
                                </div>
                                 <div class="row">
                                   <div class="col-md-12">
                                        <div class="form-group edit-tax-group">
                                            <label for="state_code">Province <span class="text-danger">*</span></label>
                                            <input type="text" name="state_code" id="state_code" placeholder="" class="form-control" value="{!! $tax->state_code ?: old('state_code')  !!}" required="">
                                        </div>
                                    </div>
                             <!--         <div class="col-md-6">
                                         <div class="form-group edit-tax-group">
                                           <label for="postal_code">Postal code <span class="text-danger">*</span></label>
                                            <input type="text" name="postal_code" id="postal_code" placeholder="Postal Code" class="form-control" value="{!! $tax->postal_code ?: old('post_code')  !!}">
                                        </div>
                                    </div> -->
                                </div>
                                           <div class="row ">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="postal_code">Description</label>
                                            <textarea name="description" placeholder="description" class="form-control" >{{ $tax->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer mt-3">
                                <button type="submit" class="btn btn-success float-lg-left">Edit Tax</button>
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
