@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="home"/>
    <meta property="og:title" content="{{ config('app.name') }}"/>
    <meta property="og:description" content="{{ config('app.name') }}"/>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center">
            <div class="error-template">
                <h1>
                    Oops!</h1>
                <h2>
                    404 Not Found</h2>
                <div class="mb-5">
                    Sorry, an error has occured, Requested page not found!
                </div>
                <div class="btn-group">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg"><span class="fa fa-home"></span>
                        Take Me Home </a><a href="{{ route('contact.form') }}" class="btn btn-default btn-lg"><span class="fa fa-envelope"></span> Contact Support </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection