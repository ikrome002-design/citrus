<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css')}}">
    <style type="text/css">
        table { border-collapse: collapse;}
    </style>
</head>
<body>
<section class="container">
    <div class="col-md-12">
        <h2>Hi {{$data['name']}}! <br />Your new password created! </h2>
        <p>Here are the details of the {{$data['role']}} account below: </p>
        <table class="table table-striped" width="100%" border="1" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <th class="col-md-3">Email</th>
                <th>{{$data['email']}}</th>
            </tr>
           
            <tr>
                <th class="col-md-1">Password</th>
                <th>{{$data['password']}}</th>
            </tr>
            </tbody>
            <tfoot>
                <tr>
                    @if($data['role'] == 'staff')
                        <th colspan="2"><a href="{{route('admin.dashboard')}}">Click here</a> for login</th>
                    @else
                        <th colspan="2"><a href="{{route('vendor.dashboard')}}">Click here</a> for login</th>
                    @endif
                </tr>
            </tfoot>
        </table>
    </div>
</section>
</body>
</html>