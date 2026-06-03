@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <section class="content">
        <h2>Manage Contacts</h2>
         @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg mt-4">
        <!-- Default box -->
           <div class="table-responsive">
                <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <td>S.NO.</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Subject</td>
                        <td>Message</td>
                        <td>Created Date</td>
                        <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                     <?php $i=1;?>
                    @foreach ($contacts as $contact)
                        <tr>
                           <td>
                                {{ $i }}
                           </td>
                           <td>
                                {{ $contact->name }}
                           </td>
                           <td>
                                {{ $contact->email }}
                           </td>
                           <td>
                                {{ $contact->subject }}
                           </td>
                           <td>
                                <textarea class="form-control" readonly="" rows="2">{{ $contact->message}}</textarea>
                           </td>
                           <td>
                           <?php echo date('d F Y', strtotime('-8 hours', strtotime($contact->created_at))); ?>
                            </td>
                            <td>
                                <form action="{{ route('contact.destroy', $contact->id) }}" method="post" class="form-horizontal">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <div class="btn-group">
                                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger"><i class="fa fa-times"></i> Delete</button>
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
 
    </section>
    <!-- /.content -->
@endsection
