@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <section class="content">
            <h2>Categories</h2>
            @include('layouts.errors-and-messages')

            <div class="card shadow-sm p-4 rounded-lg mt-4">
                {{ $dataTable->table() }}
            </div>

        </section>
        <!-- /.content -->
    @endsection
    @section('js')
        {{ $dataTable->scripts() }}
    @endsection
