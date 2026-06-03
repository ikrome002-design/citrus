@php($title = 'Verify Email')
@section('content')
    <section class="bg- bg-body-tertiary py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 m-auto">
                    <div class="card py-3 card border shadow-none mb-3">
                        <div class="card-body">
                            <h1 class="card-title text-center mb-3 h5">Verify Email</h1>

                            <form method="post" action="{{ route('verification.send') }}">
                                @csrf
                                <div class="mb-3 form-floating">
                                    <input type="email" name="email" id="loginName"
                                        class="form-control border-0 border-bottom" />
                                    <label class="form-label" for="loginName">Enter email you registered with</label>
                                </div>
                                <button type="submit" class="btn btn-primary w-100  mb-4">Send new link</button>

                            </form>


                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
@endsection
