@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
       
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h3 class="font-weight-bold">Edit Plans</h3>
                </div>
                <div class="col-md-6">
                </div>
            </div>
            <div class="">
                <div class="card-deck">

                     <div class="card">

                        <form action="{{ route('admin.memberships.update', $membership->id) }}" method="post" class="p-5">
                             @include('layouts.errors-and-messages')
                            <div class="box-body">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="put">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="font-bold">Name</label>
                                            <input type="text" name="name" id="name" placeholder="Enter plan name" class="form-control" value="{!! $membership->name ?: old('name')  !!}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row admin-plan-edit-monthly">
                                    <div class="col-md-12 col-lg-6 mb-3">
                                        <label class="font-weight-bold" for="font-bold">Monthly Subscription</label>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text">Initial price</div>
                                                    </div>
                                                    <input type="text" class="form-control" id="monthly_initial_price" name="monthly_initial_price" placeholder="0.00" value="{!! $membership->monthly_initial_price ?: old('monthly_initial_price')  !!}">
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                        <div class="input-group">
                                                        <div class="input-group-prepend">
                                                          <div class="input-group-text">Recurring price</div>
                                                        </div>
                                                        <input type="text" class="form-control" id="monthly_recurring_price" placeholder="0.00" name="monthly_recurring_price" value="{!! $membership->monthly_recurring_price ?: old('monthly_recurring_price')  !!}">
                                                      </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6 mb-3">
                                          <label class="font-weight-bold" for="font-bold">Yearly Subscription</label>
                                          <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <div class="input-group">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text">Initial price</div>
                                                    </div>
                                                    <input type="text" class="form-control" id="yearly_initial_price" name="yearly_initial_price" placeholder="0.00" value="{!! $membership->yearly_initial_price ?: old('yearly_initial_price')  !!}">
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                        <div class="input-group">
                                                        <div class="input-group-prepend">
                                                          <div class="input-group-text">Recurring price</div>
                                                        </div>
                                                        <input type="text" class="form-control" id="yearly_recurring_price" name="yearly_recurring_price" placeholder="0.00" value="{!! $membership->yearly_recurring_price ?: old('yearly_recurring_price')  !!}">
                                                      </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                               <div class="form-row">
                                    <div class="col-md-12 col-lg-6 mb-3">
                                       <!--  <label class="font-weight-bold" for="font-bold">Quantity of product</label> -->
                                        <div class="form-row">
                                     <!--        <div class="col-md-12 col-lg-12">
                                                <input class="form-control" type="text" id="quantity" name="quantity" value="{!! $membership->quantity ?: old('quantity')  !!}">
                                            </div> -->
                                            <div class="col-md-12 col-lg-12 d-flex flex-wrap">
                                                <div class="form-group d-flex align-items-center mr-3">
                                                    <input type="checkbox" id="product_display" name="product_display" {{ $membership->display_product!='' ? 'checked' : ''}} value="{{ $membership->display_product!='' ? 'checked' : ''}}">
                                                    <label for="display_product mb-0" style="margin: 0 0 0 10px;"> Product or service can be purchased</label>
                                                </div>
                                                <div class="form-group d-flex align-items-center">
                                                     <input type="checkbox" id="product_purchased" name="product_purchased" {{ $membership->purchase_product!='' ? 'checked' : ''}} value="{{ $membership->purchase_product!='' ? 'checked' : ''}}">
                                                    <label for="vehicle1 mb-0" style="margin: 0 0 0 10px;"> Product or service can be promoted</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6 mb-3">
                                          <label class="font-weight-bold" for="font-bold">Taxes</label>
                                          <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                  <div class="input-group">
                                                    <select class="custom-select form-control" name="tax_id">
                                                      @foreach($tax as $value)
                                                      <option value="{{ $value->id}}" {{ $membership->tax_id==$value->id ? 'selected' : ''}}>{{ $value->tax_name}}</option>
                                                      @endforeach
                                                    </select>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="postal_code">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="4" cols="50">{!! $membership->description ?: old('description')  !!}</textarea>
                                         
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="postal_code">Features List Contents</label>
                                            <textarea class="form-control" id="feature_list" name="feature_list" rows="4" cols="50">{!! $membership->feature_list ?: old('feature_list')  !!}</textarea>
                                         
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="btn-group">
                                    <a href="{{ route('admin.memberships.index') }}" class="btn btn-danger vendor-product-bt">Back</a>
                                    <button type="submit" class="btn btn-success float-lg-left">Update</button>
                                </div>
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
@section('js')
<script type="text/javascript">

$("input[name='product_display']").change(function() {
    var ischecked= $(this).is(':checked');
    if(!ischecked){
        $('#product_display').val('');
    }else{
         $('#product_display').val('checked');
    }
}); 

$("input[name='product_purchased']").change(function() {
    var ischecked= $(this).is(':checked');
    if(!ischecked){
        $('#product_purchased').val('');
       
    }else{
         $('#product_purchased').val('checked');
    }
}); 
</script>
@endsection
