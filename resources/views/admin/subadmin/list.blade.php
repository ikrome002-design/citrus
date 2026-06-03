
@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
      <section class="container-fluid px-0">
        @include('layouts.errors-and-messages')
        <!-- Default box -->

        @if($employees)
        <div class="row mt-4">
            <div class="col-md-6 col-lg-6 col-6">
                <h3 class="top-heading">Manage Subadmin</h3>
            </div>
            <div class="col-md-6 col-lg-6 col-6 text-right">
             
              <a href="{{ route('subadmin.subadmin_create') }}" class="btn btn-success vendor-product-bt">Add Subadmin</a>
          
            </div>  
        </div>      
        <div class="row mt-4">
          <div class="col-12">
            <div class="d-flex flex-wrap staff-box-wrapper">
              @foreach ($employees as $employee)
                <div class="card custom-border-radius shadow-sm p-4">
                  <div class="dropdown text-right">
                    <a href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-ellipsis-h"></i>
                    </a>
                    <div class="dropdown-menu bg-purple" aria-labelledby="dropdownMenuButton">
                      <!-- <a class="dropdown-item text-white" href="javascript:void(0)" onclick="staffData({{ json_encode($employee) }})"><i class="fa fa-eye"></i> View</a> -->
                      
                      <a class="dropdown-item text-white" href="{{ route('subadmin.edit', $employee->id) }}"><i class="fa fa-edit"></i> Edit</a>
                    
                      <form action="{{ route('subadmin.destroy', $employee->id) }}" method="post" class="form-horizontal m-0" id="delete-staff-{{$employee->id}}">
                      {{ csrf_field() }}
                        <input type="hidden" name="_method" value="delete">
                        <button onclick="return confirm('Are you sure?')" type="submit" class="dropdown-item text-white"><i class="fa fa-trash"></i> Delete</button>
                      </form>
                    </div>
                  </div>
                    <div class="row">
                      <!-- <div class="col-auto">
                        @if($employee->avatar !='')         
                          <img height="90" width="90" class="rounded float-left img-fluid" src="{{ asset( 'storage/profile/users/'.$employee->id.'/'.$employee->avatar.'' ) }}" alt="{!! $employee->name ?: old('name')  !!}"> 
                        @else
                          <img height="90" width="90" class="rounded float-left img-fluid" src="{{ asset('images/dummy-user.png')}}" alt="{!! $employee->name ?: old('name')  !!}">
                        @endif
                      </div> -->
                      <div class="col-auto align-self-center">
                        <h5 class="card-title">{{$employee->name }}</h5>
                        @if($employee->status == 1)
                          <a href="{{ route('staffs.update.unapprove', ['employee' => $employee->id]) }}" class="btn btn-outline-success btn-sm rounded-pill staff-active" onclick="return confirm('Are you sure? Inactive staff!')"> Active</a>
                        @else
                          <a href="{{ route('staffs.update.approve', ['employee' => $employee->id]) }}" class="btn btn-outline-danger btn-sm rounded-pill" onclick="return confirm('Are you sure? Active staff!')">Inactive</a>
                        @endif
                      </div>
                    </div>

                    <div class="row mt-3"><div class="col">
                      <p class="color-gray">{{str_limit($employee->bio, 150) }}</p>
                      @if($employee->phone)
                        <p class="mb-1 text-primary"><i class="fa fa-phone text-success mr-3"></i> {{$employee->phone }}</p>
                      @endif
                      
                      @if($employee->email)
                        <p class="text-primary"><i class="fa fa-envelope text-success mr-3"></i>{{$employee->email }}</p>
                      @endif

                    
                     
                    </div></div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
        <!-- /.row -->
        @endif
        </section>
    </section>
    <!-- /.content -->
@endsection


