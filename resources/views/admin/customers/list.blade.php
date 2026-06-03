@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

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
                     
    <!-- Default box -->
        @if($customers)
            <div class="card">
                <div class="card-body">
                    <h2>Manage Customers</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>S.No</td>
                                    <td>First Name</td>
                                    <td>Last Name</td>
                                    <td>Email</td>
                                    <td>Phone Number</td>
                                    <td>Created Date</td>
                                    <!-- <td>Staff ID</td> -->
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
                                    <td><?php echo date('d F Y', strtotime('-8 hours', strtotime($customer['created_at']))); ?></td>
                                   
                                    <!-- <td>{{ $customer['staff_id'] }}</td> -->
                                  
                                    <td><div class="col-auto align-self-center">
                        
                        @if($customer['status'] == 1)
                          <a href="{{ route('customers.update.unapprove', ['customer' => $customer['id']]) }}" class="btn btn-outline-success btn-sm rounded-pill staff-active" onclick="return confirm('Are you sure? Inactive customer!')"> Active</a>
                        @else
                          <a href="{{ route('customers.update.approve', ['customer' => $customer['id']]) }}" class="btn btn-outline-danger btn-sm rounded-pill" onclick="return confirm('Are you sure? Active customer!')">Inactive</a>
                        @endif
                      </div></td>
                                    <td>
                                        <form action="{{ route('admin.customers.destroy', $customer['id']) }}" method="post" class="form-horizontal">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="delete">
                                            <div class="btn-group">
                                                <?php if(Request::segment(2)=='shops'){ $shopId=Request::segment(3);?>
                                                    <a href="{{ route('customers.shop_show', [$shopId,$customer['id']]) }}" class="btn btn-danger btn-sm vendor-product-bt"><i class="fa fa-eye"></i></a>
                                                <?php }else{?>
                                                    <a href="{{ route('customers.show', $customer['id']) }}" class="btn btn-danger btn-sm vendor-product-bt"><i class="fa fa-eye"></i></a>
                                                <?php }?>
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
@else
@section('js')
<script type="text/javascript">
   
        window.location="{{ route('vendor.dashboard') }}";
   
</script>
@endsection
@endif