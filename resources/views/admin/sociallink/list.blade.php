@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <section class="content">
        <h2>Manage Social Link</h2>
     
         @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg mt-4">
        <!-- Default box -->
        
           <div class="table-responsive">
                <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td>Title</td>
                             <td>Link</td>
                            <td>Created Date</td>
                           <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        
                    @foreach ($sociallinks as $sociallink)
                        <tr>
                            <td>
                                {{ $sociallink->title }}
                            </td>
                            <td>
                                {{ $sociallink->link }}
                            </td>
                    
                            <td>
                               <?php echo date('d F Y', strtotime('-8 hours', strtotime($sociallink->created_at))); ?>
                            </td>
                           
                            <td>
                                <form action="{{ route('sociallink.destroy', $sociallink->id) }}" method="post" class="form-horizontal">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <div class="btn-group">
                                        <a href="{{ route('sociallink.edit', $sociallink->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
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
@else
@section('js')
<script type="text/javascript">
  
        window.location="{{ route('vendor.dashboard') }}";
   
</script>
@endsection
@endif