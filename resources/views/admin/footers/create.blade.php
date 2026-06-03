@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content admin-fotr-create">
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg" >
            <form action="{{ route('admin.footers.store') }}" method="post" class="form" enctype="multipart/form-data">
                 <input type="hidden" id="input_count" value="1">
                    <div class="box-body">
                    {{ csrf_field() }}
                   
                    <div class="field_wrapper remove" id="remove_button">
                        <div class="row">
                            <div class="col-md-5 col-lg-5">
                                <div class="form-group">
                                <button type="button" class="btn btn-primary rounded-0 vendor-product-bt">Title</button>
                                <input type="hidden" class="form-control" name="type[]" value="{{$_GET['type']}}" required="" />
                                <input type="text" class="form-control" name="title[]" value="" required="" />
                            </div>
                            </div>
                            <div class="col-md-5 col-lg-5">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary rounded-0 vendor-product-bt">Link</button>
                                    <input type="text" class="form-control" name="link[]" value="" required=""/>
                                </div>
                            </div>    
                            <div class="col-md-1 col-lg-1">
                            <div class="form-group">
                                <a class="add_input_button" title="Add field" style="color:white;">
                                <button type="button" id="add_input_button" name="add_input_button" class="btn btn-primary rounded-0 vendor-product-bt plus-minus-bt">+
                                </button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.footers.index','type=$footer->type') }}" class="btn btn-danger vendor-product-bt">Back</a>
                        <button type="submit" class="btn btn-primary vendor-product-bt">Create</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
@section('js')
<script type="text/javascript">
    
    $(document).ready(function(){
                console.log('i am in 3');
                var max_fields = 5;
                var add_input_button = $('.add_input_button');
                var field_wrapper = $('.field_wrapper');
                var new_field_html = '<div><div class="row" id="remove"><div class="col-md-5 col-lg-5"><div class="form-group"> <button type="button" id="add_more_desc" name="add_more_desc" class="btn btn-primary rounded-0 vendor-product-bt">Title</button> <input type="text" class="form-control" name="title[]" id="multiple_input_fields" value="" required="true" /><span id="warning"></span></div></div><div class="col-md-5 col-lg-5"><div class="form-group"> <button type="button" id="add_more_desc" name="add_more_desc" class="btn btn-primary rounded-0 vendor-product-bt">Link</button> <input type="text" class="form-control" name="link[]" id="multiple_input_fields" value="" required="true" /><span id="warning"></span></div></div><div class="col-md-1"> <a class="remove_input_button" title="Remove field" style="color: white;"><button type="submit" id="remove" name="remove" class="btn btn-danger rounded-0 plus-minus-bt">x</button></a></div></div></div>';
                var input_count = $('#input_count').val();
                // Add button dynamically
                $(add_input_button).click(function(){
                    console.log('i am in 1');
                    if(input_count < max_fields){
                        input_count++;
                        $('#input_count').val(input_count);
                        $(field_wrapper).append(new_field_html);
                    }
                });
                // Remove dynamically added button
                $(field_wrapper).on('click', '.remove_input_button', function(e){
                    console.log('i am in 2');
                    e.preventDefault('div');
                    $(this).parent().parent().parent().remove();
                    input_count--;
                    $('#input_count').val(input_count);
                });
            });
</script>

@endsection