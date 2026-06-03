@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

    @include('layouts.errors-and-messages')
        <!-- Default box -->
        @if($lists)
        <div class="box">
            <div class="box-body">
                <table class="table">
                    <tbody>
                    <tr>
                        <td class="col-md-2">Banner Image</td>
                        <td class="col-md-2">Title</td>
                        <td class="col-md-2">Sub Title</td>
                        <td class="col-md-2">Option</td>
                        <td class="col-md-2">Description</td>
                        <td class="col-md-2">Button Link</td>
                        <td class="col-md-2">Button Text</td>
                    </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>{{ $lists->title }}</td>
                            <td>{{ $lists->subtitle }}</td>
                            <td>{{ $lists->option }}</td>
                            <td>{{ $lists->description }}</td>
                            <td>{{ $lists->button_link }}</td>
                            <td>{{ $lists->button_text}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="btn-group">
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-default btn-sm">Back</a>
                </div>
            </div>
        </div>
        @endif
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
