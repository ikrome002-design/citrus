@extends('layouts.vendor.app')
@section('content')
    <!-- Main content -->
<section class="content">

<?php 
$data = array();
$monthArray=array();
$categoryArray=array(); 
$priceArray=array();
?>
@foreach ($TotalSpent as $user)

<?php 
$monthNum = $user->month;
$dateObj = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F');
$data[] = $user->total_amount;
$monthArray[]=$monthName;
?>

@endforeach

@foreach ($category as $category1)

<?php 
$categoryArray[] = $category1->category_name;
$priceArray[] = $category1->product_price;

?>

@endforeach
<?php 
$data;
$monthArray;
$categoryArray;
$priceArray;

?>
 <script type="text/javascript">
     var data="<?php echo implode(',',$data); ?>";
     var monthsArray="<?php echo implode(',',$monthArray);  ?>";
     var categoryArray="<?php echo implode(',',$categoryArray);  ?>";
     var priceArray="<?php echo implode(',',$priceArray);  ?>";
 </script>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body shadow-sm">
                        <h5>Total Sales This Month </h5>
                        <canvas id="MonthReport" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body shadow-sm">
                        <h5>Product Sales By Category</h5>
                        <div class="chart-pie pt-4 pb-2">
                        <canvas id="CategorySale" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.box -->
        <div class="row mt-4 text-center">
                        <?php
                            $q=0; 
                            foreach($fdate as $fdate1){
                             
                             $v=$fdate1->total;
                             $q= $q+$v;
                            }?>
            <div class="col-md-4">
                 <div class="card">
                    <div class="card-body shadow-sm">
                        <h4>$ {{ $q }}</h4>
                        <p>Total Sales This Month</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                 <div class="card">
                    <div class="card-body shadow-sm">
                        <?php 
                            $q1=0; 
                            foreach($payout as $payout1){
                             
                             $v1=$payout1->product_price;
                             $q1= $q1+$v1;
                            }?>
                        <h4>$ {{ $q1 }}</h4>
                        <p>Todays Sales</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                 <div class="card">
                    <div class="card-body shadow-sm">
                        <h4>{{ $total_order }}</h4>
                        <p>Total Orders Placed</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body shadow-sm">
                        <h5>Generate Report</h5>
                        <form method="post" action="{{ route('vendor.pdfview') }}">
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="col-md-6">
                                    <p>Select Date:</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" checked="checked" name="month" id="Monthly" value="Monthly" >
                                        <label class="form-check-label" for="Monthly">Monthly</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="month" id="HalfYearly" value="HalfYearly" >
                                        <label class="form-check-label" for="HalfYearly">Half Yearly</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="month" id="Yearly" value="Yearly">
                                        <label class="form-check-label" for="Yearly">Yearly</label>
                                    </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="month" id="Custom" value="Custom">
                                        <label class="form-check-label" for="Yearly">Custom Date</label>
                                    </div>
                                   </div>
                                <div class="col-md-6" id="customdate" style="display: none;">
                                    <p>Select Period:</p>
                                    <div class="row">
                                        <div class="col">
                                            <label for="fromdate">From</label>
                                            <input class="form-control" data-date-format="yyyy/mm/dd" name="from_date" id="datepicker" value="">
                                        </div>
                                        <div class="col">
                                            <label for="fromdate">To</label>
                                            <input data-date-format="dd/mm/yyyy" class="form-control" id="datepicker1" name="to_date" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary mt-3">
                                Generate Report
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
@section('js')
<script src="{{ asset('js/Chart.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!--    <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script type="text/javascript">
$("input[name='month']").on("change", function () {
if(this.value == 'Custom'){
    $("#customdate").show();
     $("#datepicker").datepicker({
        format: 'yyyy/mm/dd',
        maxDate: "+1M"
    });
    $("#datepicker1").datepicker({
        format: 'yyyy/mm/dd',
        maxDate: "+1M"
    });
   }else{
     $("#customdate").hide();
   }
  
});
</script>
@endsection