@extends('layouts.admin.app')
@inject('vendors','App\Shop\Vendors\Vendor')
@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($productratings)
            <div class="card">
                <div class="card-body">
                    <h2>Manage Product reviews</h2>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-approved-tab" data-toggle="pill" href="#pills-approved" role="tab" aria-controls="pills-approved" aria-selected="true">Approved Product Ratings</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-unapproved-tab" data-toggle="pill" href="#pills-unapproved" role="tab" aria-controls="pills-approved" aria-selected="true">Unapproved Product Ratings</a>
                        </li>
                       
                    </ul>
                    <hr/>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-approved" role="tabpanel" aria-labelledby="pills-approved-tab">
                            <form action="{{ route('admin.productratings.multipleunapprove') }}" method="post" class="form">
                                 {{ csrf_field() }}
                                <input type="hidden" value="" name="_method">
                                <button type="submit" class="btn btn-primary float-right mb-3" id="save_unapprove_value">Unapprove rating</button>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <input type="hidden" id="selected_unapprove_ids" name="selected_unapprove_ids"/>
                                            <tr>
                                                <td><input type="checkbox" id="select_unapprove_all"/></td>
                                                <td>ID</td>
                                                <td>User Name</td>
                                                <td>Product Name</td>
                                                <td>Rating</td>
                                                <td>Review</td>
                                                <td>Vendor's name</td>
                                                <td>Review Type</td>
                                                <td>Status</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php  $i=1;?>
                                        @foreach($productratings as $row)
                                            @if($row->status == 1)
                                            <tr>
                                                <td><input name="selector_unapprove[]" id="del_Checkbox{{$row->id}}" class="dels_Checkbox" type="checkbox" value="{{$row->id}}" /></td>
                                                <td>{{ $i}}</td>
                                                <td>{{ $row->cname}}</td>
                                                <td>{{ $row->pname}}</td>
                                                
                                                <td>{{ $row->rating }}</td>
                                                <td>{{ $row->review }}</td>
                                                <td>
                                                    <?php 
                                                    $value=$vendors->where('id',$row->vendor_id)->first();
                                                    if(!empty($value)){
                                                        echo $value->name;
                                                    }else{
                                                        echo '';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    if($row->product_id==null){
                                                        echo 'Vendor';
                                                    }else{
                                                        echo 'Product';
                                                    }
                                                    ?>
                                                </td>
                                                @if($row->status == 1)
                                                    <td><span style="display: none; visibility: hidden">1</span>
                                                    <a href="{{ route('admin.productratings.update.unapprove', ['productrating' => $row->id]) }}" class="btn btn-success vendor-product-bt" onclick="return confirm('Are you sure?')"> Approved</a></td>
                                                    @else
                                                    <td><span style="display: none; visibility: hidden">0</span>
                                                    <a href="{{ route('admin.productratings.update.approve', ['productrating' => $row->id]) }}" class="btn btn-danger vendor-product-bt" onclick="return confirm('Are you sure?')">Unapproved</a></td>
                                                @endif
                                                    <td><a href="{{ route('admin.productratings.destroy', ['id' => $row->id]) }}" class="btn btn-danger vendor-product-bt" onclick="return confirm('Are you sure?')">Delete</a></td>
                                            </tr>
                                            @endif
                                            <?php $i++;?>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{ $productratings->links() }}
                                </div>
                            </form>
                        </div>
                         <div class="tab-pane fade" id="pills-unapproved" role="tabpanel" aria-labelledby="pills-unapproved-tab">
                            <form action="{{ route('admin.productratings.multipleapprove') }}" method="post" class="form">
                                 {{ csrf_field() }}
                                <input type="hidden" value="put" name="_method">
                                <button type="submit" class="btn btn-primary float-right mb-3" id="save_value">Approve rating</button>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <td><input type="checkbox" id="select_all"/></td>
                                                <td>ID</td>
                                                <td>User Name</td>
                                                <td>Product Name</td>
                                                <td>Rating</td>
                                                <td>Review</td>
                                                <td>Vendor's name</td>
                                                <td>Review Type</td>
                                                <td>Status</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $j=1;?>
                                        @foreach($productratings as $row)
                                            @if($row->status == 0)
                                            <input type="hidden" id="selected_ids" name="selected_ids"/>
                                            <tr>
                                                <td><input name="selector[]" id="ad_Checkbox{{$row->id}}" class="ads_Checkbox" type="checkbox" value="{{$row->id}}" /></td>
                                                <td>{{ $j}}</td>
                                                <td>{{ $row->cname}}</td>
                                                <td>{{ $row->pname}}</td>
                                                
                                                <td>{{ $row->rating }}</td>
                                                <td>{{ $row->review }}</td>
                                                <td>
                                                    <?php 
                                                    $value=$vendors->where('id',$row->vendor_id)->first();
                                                    if(!empty($value)){
                                                        echo $value->name;
                                                    }else{
                                                        echo '';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    if($row->product_id==null){
                                                        echo 'Vendor';
                                                    }else{
                                                        echo 'Product';
                                                    }
                                                    ?>
                                                </td>
                                                @if($row->status == 1)
                                                    <td><span style="display: none; visibility: hidden">1</span>
                                                    <a href="{{ route('admin.productratings.update.unapprove', ['productrating' => $row->id]) }}" class="btn btn-success btn-sm vendor-product-bt" onclick="return confirm('Are you sure?')"> Approved</a></td>
                                                    @else
                                                     <td><span style="display: none; visibility: hidden">0</span>
                                                    <a href="{{ route('admin.productratings.update.approve', ['productrating' => $row->id]) }}" class="btn btn-danger btn-sm vendor-product-bt" onclick="return confirm('Are you sure?')">Unapproved</a></td>
                                                @endif
                                            </tr>
                                            @endif
                                              <?php $j++;?>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{ $productratings->links() }}
                                </div>  
                            </form>
                        </div>
                        
                    </div>
                  
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
@section('js')
<script type="text/javascript">
$('#select_all').change(function() {
  var checkboxes = $(this).closest('form').find(':checkbox');
  checkboxes.prop('checked', $(this).is(':checked'));
});
$('#save_value').click(function () {
    checked = $(".ads_Checkbox:checked").length;

      if(!checked) {
        alert("You must check at least one checkbox.");
        return false;
      } else{
        var arr = $('.ads_Checkbox:checked').map(function () {
         return this.value;
         }).get();
         console.log(arr);
         $('#selected_ids').val(arr);

      }
     
 });

$('#select_unapprove_all').change(function() {
  var checkboxes = $(this).closest('form').find(':checkbox');
  checkboxes.prop('checked', $(this).is(':checked'));
});
$('#save_unapprove_value').click(function () {
    checked = $(".dels_Checkbox:checked").length;

      if(!checked) {
        alert("You must check at least one checkbox.");
        return false;
      } else{
        var arr = $('.dels_Checkbox:checked').map(function () {
         return this.value;
         }).get();
         console.log(arr);
         $('#selected_unapprove_ids').val(arr);
      }
});
</script>
@endsection

