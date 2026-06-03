@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
       
        @include('layouts.errors-and-messages')
        <!-- Default box -->
    @if($vendors)
        <div class="card shadow-sm rounded-lg mt-4">
            <div class="card-body">
                <h2>Merchant Messages</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Merchant Image</td>
                                <td>Merchant Name</td>
                                <td>Merchant ID</td>
                                <td>Subject</td>
                                <td>Message</td>
                                <td>Reply Message</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($vendors as $vendor)
                       
                            <tr>
                                <td>{{ $vendor->id }}</td>
                                <td><img id="imgPrime" class="w-100" style="" src="{{ asset( 'storage/profile/vendors/'.$vendor->vendor_image.'' ) }}"  > </td>
                                <td>{{ $vendor->first_name }} {{ $vendor->last_name }}</td>
                                <td>{{ $vendor->vendor_id }}</td>
                                <td>{{ $vendor->subject }}</td>
                                <td><textarea readonly="" class="form-control">{{ $vendor->msg }}</textarea></td>
                                <td><textarea readonly="" class="form-control">{{ $vendor->msg_id }}</textarea></td>
                                @if($vendor->status == 'replied')
                                    <td><span style="display: none; visibility: hidden">1</span>
                                  <button type="button" class="btn btn-success" disabled="">  Replied</button></td>
                                    @else
                                <td><span style="display: none; visibility: hidden">0</span>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalo{{ $vendor->id }}">Reply Now</button></td>
                                @endif
                                
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalo{{ $vendor->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Reply Messages</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                       <form action="{{ route('admin.reply.msg') }}" method="post" >
                                       {{ csrf_field() }}
                                        <input type="hidden" name="reply_id" value=" {{ $vendor->id}}"> 
                                        <input type="hidden" name="vendor_id" value=" {{ $vendor->vendor_id}}"> 
                                        <input type="hidden" name="created_at" value=" {{ $vendor->created_at}}"> 
                                        <div class="form-group">
                                        <label for="exampleInputEmail1">Merchant Message Details :-</label>
                                 
                                        <ul class="list-unstyled recent-messages" style="font-size: 15px;">
                                         <li class="media"><p>Subject : {{ $vendor->subject }}<br> Message :  {{ $vendor->msg }}</p></li>
                                       
                                     </ul>
                                       
                                    </div>
                                      
                                     <div class="form-group">
                                        <label for="exampleInputEmail1">Write Reply</label>
                                        <textarea class="form-control" name="msg" required=""></textarea>
                                        
                                      </div>
                                                         
                                      <div class="modal-footer">
                                       
                                        <button type="submit" name="submit" class="btn btn-primary">Send</button>
                                      </div>
                                       </form>
                                       </div>
                                      
                                    </div>
                                  </div>
                                </div>
                                <!-- Modal end -->
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
