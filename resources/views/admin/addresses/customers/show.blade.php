@extends('layouts.admin.app')

@section('content')
    <section class="content">
        @include('layouts.errors-and-messages')
        <!-- Default box -->
        <h2 class="top-heading mb-4">User Profile</h2>
        <div class="user-profile-box">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-12">
                       <div class="profile-info address-show">
                            <table class="table table-responsive">
                              <tbody>
                                <tr>                              
                                  <td>Alias</td>
                                  <td><a href="javascript:void(0)">{{ $address->alias }}</a></td>                           
                                </tr>
                                <tr>                              
                                  <td>Address 1</td>
                                  <td><a href="javascript:void(0)">{{ $address->address_1 }}</a></td>                 
                                </tr>
                                 <tr>                              
                                  <td>Address 2</td>
                                  <td><a href="javascript:void(0)">{{ $address->address_2 }}</a></td>                          
                                </tr>
                                <tr>                              
                                  <td>City</td>
                                  <td><a href="javascript:void(0)">
                                        @if(isset($address->city))
                                            {{ $address->city }}
                                        @endif</a>
                                    </td>                 
                                </tr>
                                <tr>                              
                                  <td>Country</td>
                                  <td><a href="javascript:void(0)">{{ $address->country->name }}</a></td>                 
                                </tr>
                                <tr>                              
                                  <td>Zip</td>
                                  <td><a href="javascript:void(0)">{{ $address->zip }}</a></td>                 
                                </tr>
                                <tr>                              
                                  <td>Status</td>
                                  <td><a href="javascript:void(0)"> @include('layouts.status', ['status' => $address->status]) </a></td>                 
                                </tr>
                                <tr>
                                    <td colspan="2" ><a href="{{ route('admin.customers.show', $customerId) }}" class="btn btn-info btn-lg">Back</a></td>
                                </tr>
                              </tbody>
                            </table>
                       </div>
                </div>
            </div>
        </div>
    </section>



@endsection