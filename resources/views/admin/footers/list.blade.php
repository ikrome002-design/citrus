@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->

        @if(!$footers->isEmpty())
            <div class="card">
                <div class="card-body">
                    <?php 
                    $type= $_GET['type'];
                    if($type==0)
                    {
                       $get_title='My Account Links';
                    }elseif($type==1){
                        $get_title='Let us help';
                    }else{
                        $get_title='Other links';
                    }
                    ?>
                    <h2 style="display: inline-block;">{{$get_title}}</h2>
                    <div class="btn-group" style="float:right; margin-bottom:5px">

                       <a href="{{ route('admin.footers.create','type='.$_GET['type']) }}" class="btn btn-primary vendor-product-bt"><i class="fa fa-plus"></i> Create</a>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>Title</td>
                                    <td>Link</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($footers as $footer)
                                <tr>
                                    <td>{{ $footer->title }}</td>
                                    <td>{{ $footer->link }}</td>
                                    <td>
                                        <form action="{{ route('admin.footers.destroy', $footer->id) }}" method="post" class="form-horizontal">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="delete">
                                            <input type="hidden" name="type" value="{{$_GET['type']}}">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.footers.edit', $footer->id) }}" class="btn btn-primary vendor-product-bt"><i class="fa fa-edit"></i> Edit</a>
                                                <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger vendor-product-bt"><i class="fa fa-times"></i> Delete</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $footers->links() }}
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            @else
            <p class="alert alert-warning">No brand created yet. <a href="{{ route('admin.footers.create') }}">Create one!</a></p>
        @endif
    </section>
    <!-- /.content -->
@endsection
