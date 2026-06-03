@extends('layouts.admin.app')

@section('content')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Main content -->
    @include('layouts.errors-and-messages')

    <section class="content">
        <section class="container-fluid px-0">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-12">
                    <div class="dashboard-admin-info">
                        <h2 class="top-heading">Hi {{ auth()->user()->name }}, </h2>
                        <p class="font-24 font-weight-light mb-4">Here is what is happening with your site today.</p>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-4 col-sm-12">
                    <div class="card dashboard-top-plan">
                        <div class="card-body shadow-sm">
                            <div class="row mb-3">
                                <div class="col">Total Earning in This Month</div>
                            </div>
                            <?php
                            $q = 0;
                            foreach ($fdate as $fdate1) {
                                $v = $fdate1->total;
                                $q = $q + $v;
                            } ?>
                            <div class="row">
                                <div class="col d-flex justify-content-between">
                                    <h2 class="font-weight-bold mb-0 top-heading align-self-center">$
                                        {{ $q }}</h2>

                                    <div class="shadow-sm p-3 rounded-circle">
                                        <i class="fa fa-dollar text-success fa-2x"></i>
                                    </div>

                                </div>
                            </div>
                            <hr>

                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-4 col-sm-12">
                    <div class="card dashboard-top-plan">
                        <div class="card-body shadow-sm">
                            <div class="row mb-3">
                                <div class="col">Orders Placed Today</div>
                            </div>
                            <div class="row">
                                <div class="col d-flex justify-content-between">
                                    <h2 class="font-weight-bold top-heading mb-0 align-self-center">{{ $orders_count }}
                                    </h2>
                                    <div class="shadow-sm p-3 rounded-circle">
                                        <i class="fa fa-shopping-cart text-success fa-2x"></i>
                                    </div>

                                </div>
                            </div>
                            <hr>

                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-4 col-sm-12">
                    <div class="card dashboard-top-plan">
                        <div class="card-body shadow-sm">
                            <div class="row mb-3">
                                <div class="col">Total Merchant</div>
                            </div>
                            <div class="row">
                                <div class="col d-flex justify-content-between">
                                    <h2 class="font-weight-bold top-heading mb-0 align-self-center">{{ $vendor_count }}
                                    </h2>
                                    <div class="shadow-sm p-3 rounded-circle">
                                        <i class="fa fa-user text-success fa-2x"></i>
                                    </div>

                                </div>
                            </div>
                            <hr>

                        </div>
                    </div>
                </div>

            </div>
            <!-- end row items -->

            <div class="row mt-5">


                <!-- vendors table -->
                @if ($vendors)
                    @if ($type == 0 || $type == 2)
                        <div class="col-md-12 col-lg-8 col-12 col-sm-12">
                        @else
                            <div class="col-md-12 col-lg-12 col-12 col-sm-12">
                    @endif
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <section class="d-flex justify-content-between align-items-center flex-wrap">
                                    <h4 class="card-sub-heading mb-3 mb-lg-0">Newly Registered Merchant</h4>

                                    @if (auth('admin')->user()->id == 1)
                                        <a href="{{ route('admin.merchant.list') }}" class="btn btn-success">View More</a>
                                    @else
                                    @endif
                                </section>
                                <section class="mt-3 table-responsive">
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Mobile Number</th>
                                                <th scope="col">Signup Date</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($vendors as $customer)
                                                <tr>
                                                    <th scope="row">{{ $customer['first_name'] }}
                                                        {{ $customer['last_name'] }}</th>
                                                    <td>{{ $customer['email'] }}</td>
                                                    <td>{{ $customer['phone_number'] }}</td>
                                                    <td><?php echo date('d F Y', strtotime('-8 hours', strtotime($customer['created_at']))); ?> </td>
                                                    <td>
                                                        @if ($customer['status'] == 1)
                                                            <span class="text-center"
                                                                style="background-color:#588E43; padding: 10px 15px 15px 15px; color: #fff;"><i
                                                                class="fa fa-check"></i> </span>@else<span
                                                                class="text-center"
                                                                style="background-color:#bd2130; padding: 10px 15px 15px 15px; color: #fff;"><i
                                                                    class="fa fa-times"></i> </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </section>
                            </div>
                        </div>
                    </div>
            </div>
            @endif
            <!-- end vendors table -->

            @if ($type == 0 || $type == 2)
                <div class="col-md-12 col-lg-4 col-12 col-sm-12 mt-3 mt-lg-0">
                    <div class="card">
                        <div class="py-4">
                            <h4 class="font-weight-bold px-4">Recent Messages</h4>
                            @if (isset($vendor_msg))
                                <ul class="list-unstyled recent-messages">

                                    @foreach ($vendor_msg as $vendor_msg1)
                                        <li class="media">
                                            <img class="img-fluid mr-3"
                                                src="{{ asset('storage/profile/vendors/' . $vendor_msg1->vendor_image . '') }}"
                                                alt="">
                                            <div class="media-body">
                                                <p>{{ $vendor_msg1->msg }} </p>
                                                <section class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">{{ $vendor_msg1->created_at }}</small>
                                                    <small>
                                                        @if ($vendor_msg1->status == 'replied')
                                                            <button type="button" class="btn btn-success" disabled="">
                                                                Replied </button>
                                                        @else
                                                            <button type="button" class="btn btn-success"
                                                                data-toggle="modal"
                                                                data-target="#exampleModall{{ $vendor_msg1->id }}">
                                                                Reply </button>
                                                        @endif

                                                    </small>


                                                    <div class="modal fade" id="exampleModall{{ $vendor_msg1->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Reply
                                                                        Message</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('admin.reply.msg') }}"
                                                                        method="post">
                                                                        {{ csrf_field() }}
                                                                        <input type="hidden" name="reply_id"
                                                                            value=" {{ $vendor_msg1->id }}">
                                                                        <input type="hidden" name="vendor_id"
                                                                            value=" {{ $vendor_msg1->vendor_id }}">
                                                                        <input type="hidden" name="created_at"
                                                                            value=" {{ $vendor_msg1->created_at }}">
                                                                        <div class="form-group">
                                                                            <label for="exampleInputEmail1">Merchant
                                                                                Message Details :-</label>

                                                                            <ul class="list-unstyled recent-messages"
                                                                                style="font-size: 15px;">
                                                                                <li class="media">
                                                                                    <p>Subject :
                                                                                        {{ $vendor_msg1->subject }}<br>
                                                                                        Message : {{ $vendor_msg1->msg }}
                                                                                    </p>
                                                                                </li>
                                                                            </ul>

                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="exampleInputEmail1">Write
                                                                                Reply</label>
                                                                            <textarea class="form-control" name="msg" required=""></textarea>

                                                                        </div>

                                                                        <div class="modal-footer">

                                                                            <button type="submit" name="submit"
                                                                                class="btn btn-primary">Send</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>


                                                </section>
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                                @if (count($vendor_msg) != 0)
                                    <div class="px-4">

                                        @if ($vendor_msg_count == 0 && $type == 1)
                                            <a href="{{ route('admin.vendors.messages') }}" class="btn btn-warning">See
                                                More</a>
                                        @elseif($vendor_msg_count == 0 && $type == 2)
                                            <a href="{{ route('subadmin.vendors.messages') }}"
                                                class="btn btn-warning">See More</a>
                                        @elseif($vendor_msg_count != 0 && $type == 2)
                                            <a href="{{ route('subadmin.admin_notification') }}"
                                                class="btn btn-warning">See More</a>
                                        @else
                                            <a href="{{ route('admin.admin_notification') }}" class="btn btn-warning">See
                                                More</a>
                                        @endif

                                    </div>
                                @else
                                    <h6 class="font-weight-bold px-4" style="color: red;">No Message yet...</h6>
                                @endif
                        </div>
                    </div>
                </div>
            @endif
            </div>
            @endif
            <!-- end graph and message section -->





        </section>
    </section>
    <!-- /.content -->
@endsection
