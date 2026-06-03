@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->

    <section class="content">
        <h2>Main Plans</h2>
        <div class="mb-3">
            <a class="btn btn-success btn-sm mb-2" href="{{ route('admin.plans.create') }}"><i class="fa fa-plus"></i>
                Add Plan</a>
        </div>
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg mt-4">


            <table class="table data-table table-hover table-striped border-bottom">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Transaction Fee %</th>
                        <th>Discount Type</th>
                        <th>Discount Frequency</th>
                        <th>Discount amount</th>
                        <th>Government Charge </th>
                        <th>Government Charge type</th>
                        <th>Government Charge Amount</th>
                        <th>Digital Tax (%)</th>
                        <th>Status</th>
                        <th>Popular</th>
                        <th>Features</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>


                    @foreach ($plans as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->amount }}</td>
                            <td>{{ $p->transaction_fee }}</td>
                            <td>{{ $p->discount_type }}</td>
                            <td>{{ $p->discount_frequency }}</td>
                            <td>{{ $p->discount_amount }}</td>
                            <td>{{ $p->government_charge }}</td>
                            <td>{{ $p->government_type }}</td>
                            <td>{{ $p->gorvenment_amount }}</td>
                            <td>{{ $p->digital_tax }}</td>
                            <td>{{ $p->status }}</td>
                            <td>{{ $p->popular }}</td>
                            <td>{{ nl2br($p->features) }}</td>
                            <td data-label="Actions">
                                <a class="btn btn-primary btn-xs" href="{{ route('admin.plans.edit', $p->id) }}"><i
                                        class="fa fa-edit"></i>Manage</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </section>
    <!-- /.content -->
@endsection
