@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <section class="content">
        <h2>Manage Shops  </h2>
     
         @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg mt-4">
        <!-- Default box -->
        
           <div class="table-responsive">
                <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td>S.NO</td>
                            <td>Shop Image</td>
                            <td>Shop Title</td>
                             <td>Location</td>
                            <td>Created Date</td>
                           <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $i=1;?>  
                    @foreach ($shops as $shop)
                        <tr>
                            <td>{{$i}}</td>
                             <td><img src="@if(!empty($shop->shop_image)){{ asset( 'storage/shop/'.$shop->shop_image.'') }}@else{{ asset('images/placeholder-square.png') }}@endif" class="image-icon"></td>
                            <td>
                                {{ $shop->business_title }}
                            </td>
                            <td>
                                {{ $shop->location }}
                            </td>
                    
                            <td>
                               <?php echo date('d F Y', strtotime('-8 hours', strtotime($shop->created_at))); ?>
                            </td>
                           
                            <td>
                                <form action="{{ route('shop.destroy', $shop->id) }}" method="post" class="form-horizontal">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <div class="btn-group">
                                        <a href="{{ route('shop.edit', $shop->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                        @if($shop->type==NULL)
                                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger"><i class="fa fa-times"></i> Delete</button>
                                        @endif
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
@else
@section('js')
<script type="text/javascript">
  
        window.location="{{ route('vendor.dashboard') }}";
   
</script>
@endsection
@endif