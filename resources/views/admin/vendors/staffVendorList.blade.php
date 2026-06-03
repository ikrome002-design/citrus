@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
<h2>Manage Vendors</h2>
          <div class="row staff-vendor-list-top">
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <a href="{{ route('admin.staff.staffVendorList') }}"><div class="card-body shadow-sm">
                        <div class="media">
                            <div class="vendor-product-icon p-3">
                                <i class="fa fa-users text-success fa-2x"></i>
                            </div>
                            <div class="media-body pl-3">
                                 <h3 class="text-success">{{ $vendor_count }}</h3>
                                <p style="color:black;">Total vendors</p>
                            </div>
                        </div>
                    </div></a>
                </div>
            </div>
                       
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card">
                   <a href="{{ route('admin.manage.client') }}"> <div class="card-body shadow-sm">
                        <div class="media">
                            <div class="vendor-product-icon p-3">
                                <i class="fa fa-list text-success fa-2x"></i>
                            </div>
                            <div class="media-body pl-3">
                              
                                 <h3 class="text-success">{{ $best_plan }}</h3>
                                <p style="color:black;">Best selected plan</p>
                            </div>
                        </div>
                    </div></a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <a href="{{ route('admin.manage.client') }}"><div class="card-body shadow-sm">
                        <div class="media">
                            <div class="vendor-product-icon p-3">
                                <i class="fa fa-dollar text-success fa-2x"></i>
                            </div>
                            <div class="media-body pl-3">
                                <h3 class="text-success">{{ $revenue_total }}</h3>
                                <p style="color:black;">Generate revenue plan</p>
                            </div>
                        </div>
                    </div></a>
                </div>
            </div>
             <!-- <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body shadow-sm">
                        <div class="media">
                            <div class="vendor-product-icon p-3">
                                <i class="fa fa-shopping-cart text-success fa-2x"></i>
                            </div>
                            <div class="media-body pl-3">
                                <h3 class="text-success">{{ $order_count }}</h3>
                                <p>Total Product Orders</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        @include('layouts.errors-and-messages')
       
    @if($vendors)
     <div class="row plan-row m-vendors-row mx-0">
        </div>
        <div class="card shadow-sm manage-vendor-table rounded-lg mt-4">
            <div class="card-body">
                <h2 class="card-sub-heading mb-3">All Vendors</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Name</td>
                                <td>City</td>
                                <td>Sign up date</td>
                                <td>Active Plan</td>
                                <td>Price</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;?>

                        @foreach ($vendors as $vendor)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $vendor->vendor_name }}</td>
                                <td>{{ $vendor->city }}</td>
                                <td>{{ $vendor->created_at }}</td>
                                <td>{{ $vendor->name }} <br>@if($vendor->plan_variant == 1) Monthly variant  @else Yearly variant @endif</td>
                                <td>@if($vendor->plan_variant == 1) Initial Price :- {{ $vendor->monthly_initial_price }} <br>Recurring Price :-  {{ $vendor->monthly_recurring_price }} @else Initial Price :- {{ $vendor->yearly_initial_price }} <br>Recurring Price:- {{ $vendor->yearly_recurring_price }} @endif </td>
                                <td>
                                <form action="{{ route('admin.vendors.destroy', $vendor->id) }}" method="post" class="form-horizontal">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.staff.staffVendorShow', $vendor->id) }}" class="btn btn-primary vendor-product-bt"><i class="fa fa-eye"></i> Show</a>&nbsp;
                                    </div>
                                </form>
                                </td>
                            </tr>
                        <?php $i++;?>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $vendors->links() }}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
