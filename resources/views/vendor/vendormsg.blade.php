@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        
        @include('layouts.errors-and-messages')
        <!-- Default box -->
        <div class="card shadow-sm rounded-lg mt-4">
            <div class="card-body">
                <h2>Merchant Messages To Admin</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td>S.NO.</td>
                                <td>Subject</td>
                                <td>Message</td>
                                <td>Admin Reply</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;?>
                        @foreach ($vendors as $vendor)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $vendor->subject }}</td>
                                <td><textarea readonly="" class="form-control">{{ $vendor->msg }}</textarea></td>
                               <td><textarea readonly="" class="form-control">{{ $vendor->msg_id }}</textarea></td>
                                @if($vendor->status == 'replied')
                                    <td>
                                  <button type="button" class="btn btn-success" disabled="">  Replied</button></td>
                                    @else
                                    <td><button type="button" class="btn btn-success" disabled="">No Reply</button></td>
                                @endif                        
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
