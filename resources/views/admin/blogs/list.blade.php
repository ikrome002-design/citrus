@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if(!$blogs->isEmpty())
            <div class="card">
                <div class="card-body">
                    <h2>Manage Blog</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>S.No.</td>
                                    <td>Image</td>
                                    <td>Title</td>
                                    <td>Description</td>
                                    <td>Created at</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i=1;?>    
                            @foreach ($blogs as $blog)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>
                                    @if($blog->image !='')         
                                        <img id="imgPrime" src="{{ asset( 'storage/blog/'.$blog->image.'' ) }} " alt="{!! $blog->title ?: old('title')  !!}" height="100" width="100"> 
                                    @else

                                        <img id="imgPrime" src="{ asset('images/placeholder-square.png') }}" alt="{!! $blog->title ?: old('title')  !!}" height="100" width="100">

                                    @endif 
                                    </td>
                                    <td>
                                        {{ $blog->title }}
                                    </td>
                                    <td>
                                       <textarea class="form-control" rows="2" readonly=""> {{ $blog->description }}
                                       </textarea>
                                    </td>
                                    <td><?php echo date('d F Y', strtotime('-8 hours', strtotime($blog->created_at))); ?></td>
                                    <td>
                                        <form action="{{ route('admin.blog.destroy', $blog->id) }}" method="post" class="form-horizontal">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="delete">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                                <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger"><i class="fa fa-times"></i> Delete</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                             <?php $i++;?>     
                            @endforeach
                            </tbody>
                        </table>
                        {{ $blogs->links() }}
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            @else
            <p class="alert alert-warning">No blog created yet. <a href="{{ route('admin.blog.create') }}">Create one!</a></p>
        @endif
    </section>
    <!-- /.content -->
@endsection
