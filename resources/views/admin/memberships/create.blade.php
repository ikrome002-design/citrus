@extends('layouts.admin.app')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid px-0">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h3 class="top-heading">Add Plans</h3>
                </div>
                <div class="col-md-6">
                </div>
            </div>
            <div class="">
                <div class="card-deck">
                     <div class="card">
                        <form action="{{ route('admin.memberships.store') }}" method="post" class="p-4">
                             @include('layouts.errors-and-messages')
                            <div class="box-body">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="font-regular" for="font-bold">Name</label>
                                            <input type="text" name="name" id="name" placeholder="Enter plan name" class="form-control" value="{{ old('name') }}" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row admin-plan-create-monthly">
                                    <div class="col-md-12 col-lg-6 mb-3">
                                        <label class="font-regular" for="font-bold">Monthly Subscription</label>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text">Initial price</div>
                                                    </div>
                                                    <input type="text" class="form-control" id="monthly_initial_price" name="monthly_initial_price" placeholder="0.00" value="{{ old('monthly_initial_price') }}" required="">
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                        <div class="input-group">
                                                        <div class="input-group-prepend">
                                                          <div class="input-group-text">Recurring price</div>
                                                        </div>
                                                        <input type="text" class="form-control" id="monthly_recurring_price" placeholder="0.00" name="monthly_recurring_price" value="{{ old('monthly_recurring_price') }}" required="">
                                                      </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6 mb-3">
                                          <label class="font-regular" for="font-bold">Yearly Subscription</label>
                                          <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <div class="input-group">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text">Initial price</div>
                                                    </div>
                                                    <input type="text" class="form-control" id="yearly_initial_price" name="yearly_initial_price" placeholder="0.00" value="{{ old('yearly_initial_price') }}" required="">
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                        <div class="input-group">
                                                        <div class="input-group-prepend">
                                                          <div class="input-group-text">Recurring price</div>
                                                        </div>
                                                        <input type="text" class="form-control" id="yearly_recurring_price" name="yearly_recurring_price" placeholder="0.00" value="{{ old('yearly_recurring_price') }}" required="">
                                                      </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           <div class="form-row">
                                <div class="col-md-12 col-lg-6 mb-3">
                                    <!-- <label class="font-regular" for="font-bold">Quantity of product</label> -->
                                    <div class="form-row align-items-center">
                                       <!--  <div class="col-md-3">
                                            <input class="form-control" type="text" id="quantity" name="quantity" value="" required="">
                                        </div> -->
                                        <div class="col-md-12">
                                            <div class="form-group product-check-box mb-0 d-flex align-items-center a">
                                                <input type="checkbox" id="product_display" name="product_display" value="">
                                                <label class="mb-0" for="display_product"> Product or service can be purchased</label>
                                                <input type="checkbox" id="product_purchased" name="product_purchased" value="">
                                                <label class="mb-0" for="vehicle1"> Product or service can be promoted</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 mb-3">
                                      <label class="font-regular" for="font-bold">Taxes</label>
                                      <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                              <div class="input-group">
                                                <select class="custom-select form-control" name="tax_id" required>
                                                    <option value="">Select tax</option>
                                                  @foreach($tax as $value)
                                                  <option value="{{ $value->id}}">{{ $value->tax_name}}</option>
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
                                        <label class="font-regular" for="postal_code">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="4" cols="50" required=""></textarea>
                                     
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="font-regular" for="postal_code">Features List Contents</label>
                                            <textarea class="form-control" id="feature_list" name="feature_list" rows="4" cols="50" required=""></textarea>
                                         
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success float-lg-left">Add Plan</button>
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
