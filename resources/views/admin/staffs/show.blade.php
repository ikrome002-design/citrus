@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <div class="w-100 text-center"> 
                    @if($employee->avatar !='')         
                        <img class="user-image" src="{{ asset( 'storage/profile/users/'.$employee->id.'/'.$employee->avatar.'' ) }}" alt="{!! $employee->name ?: old('name')  !!}"> 
                    @else
                        <img class="user-image" src="{{ asset('images/dummy-user.png')}}" alt="{!! $employee->name ?: old('name')  !!}">
                    @endif
                </div>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>ID</td>
                            <td>{{ $employee->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</td>
                            <td>{{ $employee->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</td>
                            <td>{{ $employee->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</td>
                            <td>{{ $employee->phone }}</td>
                        </tr>
                        <tr>
                            <th>Roles</td>
                            <td>
                                 {{ $employee->roles()->get()->implode('name', ', ') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th> 
                            @if($employee->status == 1)
                                <td><span class="btn btn-success vendor-product-bt">Approved</span></td>
                                @else
                                 <td><span class="btn btn-danger vendor-product-bt">Unapproved</span></td>
                            @endif
                        </tr>
                        <tr>
                            <th>Created at</td>
                            <td>{{ $employee->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Updated at</td>
                            <td>{{ $employee->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="btn-group">
                    <a href="{{ route('admin.staffs.index') }}" class="btn btn-default btn-sm">Back</a>
                </div>
            </div>
        </div>
        <!-- /.box -->

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