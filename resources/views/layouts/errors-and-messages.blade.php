@if ($errors->all())
    @foreach ($errors->all() as $message)
        <div class="box no-border">
            <div class="box-tools">
                <p class="alert alert-danger alert-dismissible">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true"></button>
                </p>
            </div>
        </div>
    @endforeach
@elseif(session()->has('message'))
    <div class="box no-border">
        <div class="box-tools">
            <p class="alert alert-success alert-dismissible">
                {{ session()->get('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true"></button>
            </p>
        </div>
    </div>
@elseif(session()->has('error'))
    <div class="box no-border">
        <div class="box-tools">
            <p class="alert alert-danger alert-dismissible">
                {{ session()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true"></button>
            </p>
        </div>
    </div>
@endif
@if (session('success'))
    <div class="box no-border">
        <p class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </p>
    </div>
@endif
@if (session('warning'))
    <div class="box no-border">
        <p class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </p>
    </div>
@endif
@if (session('info'))
    <div class="box no-border">
        <p class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </p>
    </div>
@endif
