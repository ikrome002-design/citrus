@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
<h2>Manage Merchant</h2>
          <div class="row manage-vendor-top">
            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body shadow-sm">
                        <a href="{{ route('admin.vendors.index') }}"><div class="media">
                            <div class="vendor-product-icon p-3">
                                <i class="fa fa-users text-success fa-2x"></i>
                            </div>
                            <div class="media-body pl-3">
                                <h3 class="text-success">{{ $vendor_count }}</h3>
                                <p style="color:black;">Total merchant</p>
                            </div>
                        </div></a>
                    </div>
                </div>
            </div>
            
        </div>
        @include('layouts.errors-and-messages')
        <!-- Default box -->
    @if($vendors)
     <div class="row plan-row m-vendors-row mx-0">
        </div>
        <div class="card shadow-sm manage-vendor-table rounded-lg mt-4">
            <div class="card-body">
                <h2 class="card-sub-heading mb-3">All merchant</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>First Name</td>
                                <td>Last Name</td>
                                <td>Account Type</td>
                                <td>Business Type</td>
                                <td>Created Date</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($vendors as $vendor)
                            <tr>
                                <td>{{ $vendor->id }}</td>
                                <td>{{ $vendor->first_name }}</td>
                                <td>{{ $vendor->last_name }}</td>
                                
                                <td>@if($vendor->account_type == 0) Individual @elseif($vendor->account_type == 1) Registered Business @else Non-Governmental Organization @endif</td>

                                <td>{{$vendor->btitle}} </td>
                                <td>{{date('d F Y',strtotime('-8 hours', strtotime($vendor->created_at)))}}</td>
                             
                                <td>
                                    <form action="{{ route('admin.vendors.destroy', $vendor->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.merchant.show', $vendor->id) }}" class="btn btn-primary vendor-product-bt"><i class="fa fa-eye"></i> </a>&nbsp;
                                               @if($vendor->status == 1)
                                    <span style="display: none; visibility: hidden">1</span>
                                    <a href="{{ route('admin.vendors.update.unapprove', ['vendor' => $vendor->id]) }}" class="btn btn-success vendor-product-bt" onclick="return confirm('Are you sure?')"> Approved</a>
                                    @else
                               <span style="display: none; visibility: hidden">0</span>
                                    <a href="{{ route('admin.vendors.update.approve', ['vendor' => $vendor->id]) }}" class="btn btn-danger vendor-product-bt" onclick="return confirm('Are you sure?')">Unapproved</a>
                                @endif
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        
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
