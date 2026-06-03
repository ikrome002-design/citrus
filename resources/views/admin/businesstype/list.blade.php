@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <section class="content">
        <h2>Manage Business Type</h2>
         @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg mt-4">
        <!-- Default box -->
           <div class="table-responsive">
                <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <td>Business Type Name</td>
                        <td>Created Date</td>
                        <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($business_type as $business_types)
                        <tr>
                           <td>
                                {{ $business_types->title }}
                           </td>
                           <td>
                           <?php echo date('d F Y', strtotime('-8 hours', strtotime($business_types->created_at))); ?>
                            </td>
                            <td>
                                <form action="{{ route('admin.business_type.destroy', $business_types->id) }}" method="post" class="form-horizontal">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.business_type.edit', $business_types->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger"><i class="fa fa-times"></i> Delete</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
      
        </div>
 
    </section>
    <!-- /.content -->
@endsection
