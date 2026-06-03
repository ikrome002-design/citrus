@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if(!$brands->isEmpty())
            <div class="card">
                <div class="card-body">
                    <h2>Brands</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Created at</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($brands as $brand)
                                <tr>
                                    <td>
                                        {{ $brand->name }}
                                    </td>
                                    <td><?php echo date('d F Y', strtotime('-8 hours', strtotime($brand->created_at))); ?></td>
                                    <td>
                                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="post" class="form-horizontal">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="delete">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                                <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger"><i class="fa fa-times"></i> Delete</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $brands->links() }}
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            @else
            <p class="alert alert-warning">No brand created yet. <a href="{{ route('admin.brands.create') }}">Create one!</a></p>
        @endif
    </section>
    <!-- /.content -->
@endsection
