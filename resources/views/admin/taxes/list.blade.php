@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($taxes)
        <div class="container-fluid px-0">
            <div class="row mb-5">
                <div class="col-md-6">
                    <h3 class="top-heading">Manage Taxes</h3>
                </div>
                <div class="col-md-6 ">
                    <a href="{{ route('admin.taxes.create')}}" class="btn btn-success ml-5 float-lg-right">Create New Tax</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex flex-wrap tax-box-wrapper mt-4">
                @foreach($taxes as $row)
                    <div class="tax-box">
                        <div class="card-deck">
                            <div class="card custom-border-radius tax-card">
                                <div class="card-body">
                                    <div class="tx-box"><img src="{{ asset('images/tax.svg')}}" class="tax-img"/></div>
                                    <h5 class="card-title font-18">{{ ucfirst($row->tax_name) }}</h5>
                                    <p>{{ ucfirst($row->description) }}</p>
                                <hr>
                                <div class="row fs14 mt-4">
                                    <div class="col-md-5">
                                        <label>Rate(%)</label>
                                        <h6 class="font-weight-bold">{{ $row->rate_percentage }}%</h6>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="y-line"></div>
                                    </div>
                                    <div class="col-md-5">
                                        <label>Province</label>
                                        <h6 class="font-weight-bold">{{ $row->state_code }}</h6>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                 <form action="{{ route('admin.taxes.destroy', $row->id) }}" method="post" class="form-horizontal">
                                     {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('admin.taxes.edit', $row->id) }}" class="btn btn-success float-none mr-2 px-md-4">Edit Tax</a>
                                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger float-none mr-2 px-md-4">Delete Tax</button>
                                        </div>
                                    </div>
                                </form>
                                </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                {{ $taxes->links() }}
                @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
