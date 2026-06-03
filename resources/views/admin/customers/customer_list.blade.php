@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
     @if (session('success'))
                      <div class="alert alert-success alert-dismissable fade show" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <h4><i class="icon fa fa-check fa-fw" aria-hidden="true"></i> Success</h4>
                        {{ session('success') }}
                      </div>
                      @endif
                      @if (session('error'))
                      <div class="alert alert-danger alert-dismissable fade show" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <h4><i class="icon fa fa-check fa-close" aria-hidden="true"></i> Error</h4>
                        {{ session('error') }}
                      </div>
                      
                    @endif
    <!-- Default box -->
        @if($customers)
            <div class="card">
                <div class="card-body">
                    <h2>Customers</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>S.No</td>
                                    <td>First Name</td>
                                    <td>Last Name</td>
                                    <td>Email</td>
                                    <td>Phone Number</td>
                                    <!-- <td>Signup Date</td> -->
                                    <td>Merchant ID</td>
                                    <td>Status</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                               <?php $i=1;?> 
                            @foreach ($userAmt as $customer)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $customer['first_name'] }}</td>
                                    <td>{{ $customer['last_name'] }}</td>
                                    <td>{{ $customer['email'] }}</td>
                                    <td>{{ $customer['phone_number'] }}</td>
                                    <td>{{ $customer['merchant_id'] }}</td>
                                  
                                    <td>@include('layouts.status', ['status' => $customer['status']])</td>
                                    <td>
                                        <form action="{{ route('admin.customers.destroy', $customer['id']) }}" method="post" class="form-horizontal">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="delete">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.customers.show_customer', $customer['id']) }}" class="btn btn-danger btn-sm vendor-product-bt"><i class="fa fa-eye"></i></a>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                <?php $i++;?>
                            @endforeach
                            </tbody>
                        </table>
                       
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection