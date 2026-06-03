@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <style type="text/css">
        .dropdown-menu :hover {
            background-color: #e1e3e9;
            color: black;
        }
    </style>


    <section class="content">
        <div class="conrtainer-fliud">
            @include('layouts.errors-and-messages')

            <div class="row">
                <div class="col-lg-8">
                    <div class="row">

                        {{-- new orders --}}
                        <div class="col-xxl-4 col-md-6 mb-3">
                            <div class="card p-3">
                                <div class="card-body">
                                    <h5 class="card-title mb-3 mb-3 text-secondary fw-bolder">Orders<span
                                            class="text-muted fw-lighter h6">| New</span>
                                    </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-cart-shopping fa-2x text-primary"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h4>{{ env('CURRENCY_SYMBOL') }} 145</h4>
                                            <a href="#" class="card-link">View Orders</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- sales --}}
                        <div class="col-xxl-4 col-md-6 mb-3">
                            <div class="card p-3">
                                <div class="card-body">
                                    <h5 class="card-title mb-3 mb-3 text-secondary fw-bolder">Merchants <span
                                            class="text-muted fw-lighter h6">| New</span>
                                    </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-chart-bar fa-2x text-primary"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h4>{{ env('CURRENCY_SYMBOL') }} 145</h4>
                                            <a href="#" class="card-link">View Mechants</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="card p-3">
                                <div class="card-body">
                                    <h5 class="card-title mb-3 text-secondary fw-bolder">Customers <span
                                            class="text-muted fw-lighter h6">| Total</span>
                                    </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-chart-line fa-2x text-primary"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h4>{{ env('CURRENCY_SYMBOL') }} 145</h4>
                                            <a href="#" class="card-link">View Orders</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Recent sales --}}
                        <div class="col-12 mb-3">
                            <div class="card top-selling overflow-auto">


                                <div class="card-body pb-0">
                                    <h5 class="card-title text-secondary fw-bolder">Recent Orders</h5>

                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Customer</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Satus</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row"><a href="#"><img src="assets/img/product-1.jpg"
                                                            alt=""></a></th>
                                                <td><a href="#" class="text-primary fw-bold">Ut inventore ipsa
                                                        voluptas nulla</a></td>
                                                <td>$64</td>
                                                <td class="fw-bold">124</td>
                                                <td>$5,828</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#"><img src="assets/img/product-2.jpg"
                                                            alt=""></a></th>
                                                <td><a href="#" class="text-primary fw-bold">Exercitationem similique
                                                        doloremque</a></td>
                                                <td>$46</td>
                                                <td class="fw-bold">98</td>
                                                <td>$4,508</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#"><img src="assets/img/product-3.jpg"
                                                            alt=""></a></th>
                                                <td><a href="#" class="text-primary fw-bold">Doloribus nisi
                                                        exercitationem</a></td>
                                                <td>$59</td>
                                                <td class="fw-bold">74</td>
                                                <td>$4,366</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#"><img src="assets/img/product-4.jpg"
                                                            alt=""></a></th>
                                                <td><a href="#" class="text-primary fw-bold">Officiis quaerat sint
                                                        rerum error</a></td>
                                                <td>$32</td>
                                                <td class="fw-bold">63</td>
                                                <td>$2,016</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#"><img src="assets/img/product-5.jpg"
                                                            alt=""></a></th>
                                                <td><a href="#" class="text-primary fw-bold">Sit unde debitis
                                                        delectus repellendus</a></td>
                                                <td>$79</td>
                                                <td class="fw-bold">41</td>
                                                <td>$3,239</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>



                        {{-- Top Seeling Products --}}
                        <div class="col-12">
                            <div class="card top-selling overflow-auto">


                                <div class="card-body pb-0">
                                    <h5 class="card-title text-secondary fw-bolder">Recent Merchants</h5>

                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th scope="col">Product Image</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Sold</th>
                                                <th scope="col">Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row"><a href="#"><img src="assets/img/product-1.jpg"
                                                            alt=""></a></th>
                                                <td><a href="#" class="text-primary fw-bold">Ut inventore ipsa
                                                        voluptas nulla</a></td>
                                                <td>$64</td>
                                                <td class="fw-bold">124</td>
                                                <td>$5,828</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#"><img src="assets/img/product-2.jpg"
                                                            alt=""></a></th>
                                                <td><a href="#" class="text-primary fw-bold">Exercitationem
                                                        similique
                                                        doloremque</a></td>
                                                <td>$46</td>
                                                <td class="fw-bold">98</td>
                                                <td>$4,508</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#"><img src="assets/img/product-3.jpg"
                                                            alt=""></a></th>
                                                <td><a href="#" class="text-primary fw-bold">Doloribus nisi
                                                        exercitationem</a></td>
                                                <td>$59</td>
                                                <td class="fw-bold">74</td>
                                                <td>$4,366</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#"><img src="assets/img/product-4.jpg"
                                                            alt=""></a></th>
                                                <td><a href="#" class="text-primary fw-bold">Officiis quaerat sint
                                                        rerum error</a></td>
                                                <td>$32</td>
                                                <td class="fw-bold">63</td>
                                                <td>$2,016</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#"><img src="assets/img/product-5.jpg"
                                                            alt=""></a></th>
                                                <td><a href="#" class="text-primary fw-bold">Sit unde debitis
                                                        delectus repellendus</a></td>
                                                <td>$79</td>
                                                <td class="fw-bold">41</td>
                                                <td>$3,239</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="col-12">
                        <div class="card overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title mb-3 mb-3 text-secondary fw-bolder">Recent Messages</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
