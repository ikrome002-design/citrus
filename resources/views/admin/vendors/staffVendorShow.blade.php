@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
     <!-- home banner -->
        @include('layouts.errors-and-messages')
          @if($vendor_details)
        <section class="vendor-info-box">
            <div class="container">
                <section class="vendor-banner" >
                 <figure>
                    @if(isset($vendor_details->cover_image))
                        <img class="mr-5" src="{{ asset("storage/$vendor_details->cover_image") }}" width="100%" height="400px">
                    @else
                        <img class="mr-5" src="{{ asset("images/no-banner.jpg") }}" width="100%" height="200px" >
                    @endif
                   
                </figure>
                </section>
                <div class="row">
                <div class="col-md-12 col-lg-10 col-xl-10 col-12">
                    <div class="media vendor-sales-box">
                      <div class="media-body">
                        <h3>{{ $vendor_details->business_name }} located in {{ $vendor_details->city }}</h3>
                        <p>{{ $vendor_details->short_description }}</p>
                        <div class="vendor-sale">
                            <a class="green-bt" href="javasript:void(0)">On {{ $vendor_details->business_name }} since {{ $vendor_details->business_year }}</a>
                            
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-2 col-xl-2 col-12">
                  <button type="button" class="btn btn-primary vendor-product-bt float-right" data-toggle="modal" data-target="#profiledetail" style=" background-color:green;"> Edit Profile</button>
                    <!-- business Modal -->
                    <div class="modal fade" id="profiledetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Profile Detail</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form method="post" action="{{ route('admin.staff.updateStaffVendorList') }}" enctype="multipart/form-data">
                            <div class="modal-body">
                           {{ csrf_field() }}
                            <input type="hidden" name="id" value={{$vendor_details->id}}> 
                            <input type="hidden" name="type" value="profile"> 
                            <div class="form-group">
                              <label for="recipient-name" class="col-form-label">Description:</label>
                              <textarea class="form-control" name="short_description" >{{ $vendor_details->short_description }}</textarea>
                            </div>

                            <div class="form-group">
                              <label for="recipient-name" class="col-form-label">Our Story:</label>
                              <textarea class="form-control" name="story" >{{ $vendor_details->story }}</textarea>
                            </div>

                            <div class="form-group">
                              <label for="recipient-name" class="col-form-label">Vision and Mission:</label>
                              <textarea class="form-control" name="mission_description" >{{ $vendor_details->mission_description }}</textarea>
                            </div>

                            <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Cover Image:</label>
                            <input type="file" name="image" class="form-control" />
                           </div>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger vendor-product-bt" data-dismiss="modal">Close</button>
                              <button type="submit" name="submit" class="btn btn-primary vendor-product-bt">Save changes</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- modal end -->
                </div>
                </div>
            </div>
        </section><br><br>
        <section class="vendor-story-box">
            <div class="container">
                <div class="row">
                     @if(isset($vendor_details->story))
                     <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                        <h2 class="font-24 mb-3">Our Story</h2>
                        <p>{{ $vendor_details->story }}</p>
                       
                    </div> 
                    @endif
                     <div class="col-md-12 col-lg-12 col-xl-12 col-12 mt-5">
                        <h2 class="font-24 mb-3">Vision and Mission</h2>
                        <p>{{ $vendor_details->mission_description }}</p>
                       
                    </div>
                </div>
            </div>
        </section><br><br>
      
        <section class="vendor_details">
            <div class="container">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Business Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Billing Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Account Details</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="card tab-pane fade show active p-4" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row mt-2 mb-2 align-items-center">
                            <div class="col-md-6 col-6">
                                <h3 class="m-0">Business Details</h3>
                            </div>
                            <div class="col-md-6 col-6 ">
                                <button type="button" class="btn btn-primary float-right vendor-product-bt" data-toggle="modal" data-target="#legaldetail">
                                 Edit Details
                                </button>

                                <!-- business Modal -->
                                <div class="modal fade" id="legaldetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Business Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form method="post" action="{{ route('admin.staff.updateStaffVendorList') }}">
                                      <div class="modal-body">
                                     {{ csrf_field() }}
                                   <input type="hidden" name="id" value={{$vendor_details->id}}> 
                                      <input type="hidden" name="type" value="business"> 
                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Business name:</label>
                                        <input type="text" class="form-control" name="business_name" value="{{ $vendor_details->business_name }}">
                                      </div>

                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Years in business:</label>
                                        <input type="text" class="form-control" name="business_year" value="{{ $vendor_details->business_year }}">
                                      </div>

                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Owner's name:</label>
                                        <input type="text" class="form-control" name="name" value="{{ $vendor_details->name }}">
                                      </div>

                                   <!--    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Manager name:</label>
                                        <input type="text" class="form-control" name="manager_name" value="{{ $vendor_details->manager_name }}">
                                      </div> -->

                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">GST Number:</label>
                                        <input type="text" class="form-control" name="gst_no" value="{{ $vendor_details->gst_no }}">
                                      </div>

                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">PST Number:</label>
                                        <input type="text" class="form-control" name="pst_no" value="{{ $vendor_details->pst_no }}">
                                      </div>

                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Business Address:</label>
                                        <input type="text" class="form-control" name="address" value="{{ $vendor_details->address }}">
                                      </div>
                                    
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger vendor-product-bt" data-dismiss="modal">Close</button>
                                        <button type="submit" name="submit" class="btn btn-primary vendor-product-bt">Save changes</button>
                                      </div>
                                       </form>
                                    </div>
                                  </div>
                                </div>
                                <!-- modal end -->
                            </div>
                         </div>
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6 col-6">Email</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->email }}</div>
                                </div>
                                <hr>
                            
                                <div class="row">
                                    <div class="col-md-6 col-6">Business name</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->business_name }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 col-6">Years in business</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->business_year }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 col-6">Owner's name</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->name }}</div>
                                </div>
                                <hr>
                                <!-- <div class="row">
                                    <div class="col-md-6 col-6">Manager name</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->manager_name }}</div>
                                </div>
                                <hr> -->
                            </div>
                            <div class="col-md-6 ">
                                <div class="row">
                                    <div class="col-md-6 col-6">GST Number</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->gst_no }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 col-6">PST Number</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->pst_no }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 col-6">Business Address</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->address }}</div>
                                </div>
                                <hr>
                               
                            </div>
                        </div>
                    </div>
                    <div class="card tab-pane fade p-3" id="profile" role="tabpanel" aria-labelledby="profile-tab"> 

                    <div class="row mt-2 mb-2 align-items-center">
                            <div class="col-md-6 d-flex col-6">
                                <h3 class="m-0 ">Billing Information</h3><br>
                            </div>
                            <div class="col-md-6 col-6">
                                <button type="button" class="btn btn-primary float-right vendor-product-bt" data-toggle="modal" data-target="#billingdetail">Edit Details
                                </button>
                            </div>
                                <!-- business Modal -->
                                <div class="modal fade" id="billingdetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Billing Detail</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form method="post" action="{{ route('admin.staff.updateStaffVendorList') }}">
                                      <div class="modal-body">
                                     {{ csrf_field() }}
                                     <input type="hidden" name="id" value={{$vendor_details->id}}> 
                                      <input type="hidden" name="type" value="billing"> 
                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Billing address:</label>
                                        <input type="text" class="form-control" name="billing_address" value="{{ $vendor_details->billing_address }}">
                                      </div>

                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Billing city:</label>
                                        <input type="text" class="form-control" name="billing_city" value="{{ $vendor_details->billing_city }}">
                                      </div>

                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Billing province:</label>
                                        <input type="text" class="form-control" name="billing_state" value="{{ $vendor_details->billing_state }}">
                                      </div>

                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Billing postal code:</label>
                                        <input type="text" class="form-control" name="billing_postal_code" value="{{ $vendor_details->billing_postal_code }}">
                                      </div>

                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Billing office number:</label>
                                        <input type="text" class="form-control" name="billing_office_number" value="{{ $vendor_details->billing_office_number }}">
                                      </div>

                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Billing cell number:</label>
                                        <input type="text" class="form-control" name="billing_cell_number" value="{{ $vendor_details->billing_cell_number }}">
                                      </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger vendor-product-bt" data-dismiss="modal">Close</button>
                                        <button type="submit" name="submit" class="btn vendor-product-bt btn-primary">Save changes</button>
                                      </div>
                                       </form>
                                    </div>
                                  </div>
                                </div>
                                <!-- modal end -->
                     </div>
                     <div class="row mt-5">
                             <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6 col-6">Billing Address</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->billing_address }}</div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-md-6 col-6">Billing city</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->billing_city }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 col-6">Billing province</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->billing_state }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 col-6">Billing postal code </div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->billing_postal_code }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 col-6">Billing office number</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->billing_office_number }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 col-6">Billing cell number</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->billing_cell_number }}</div>
                                </div>
                                <hr>
                               
                            </div>
                        </div></div>
                    <div class="card tab-pane fade p-3" id="contact" role="tabpanel" aria-labelledby="contact-tab">  <p></p>
                    <div class="row mt-2 mb-2 align-items-center">
                            <div class="col-md-6 col-6">
                                <h3 class="m-0">Account Information</h3><br>
                            </div>
                            <div class="col-md-6 col-6">
                                <button type="button" class="btn btn-primary float-right vendor-product-bt" data-toggle="modal" data-target="#accountdetail"> Edit Details
                                </button>
                            </div>
                                <!-- business Modal -->
                                <div class="modal fade" id="accountdetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Bank Account Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form method="post" action="{{ route('admin.staff.updateStaffVendorList') }}">
                                      <div class="modal-body">
                                     {{ csrf_field() }}
                                    <input type="hidden" name="id" value={{$vendor_details->id}}> 
                                      <input type="hidden" name="type" value="account"> 

                                     <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Account Holder Name:</label>
                                        <input type="text" class="form-control" name="account_holder" value="{{ $vendor_details->account_holder }}">
                                      </div>
                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Account Number:</label>
                                        <input type="text" class="form-control" name="account_no" value="{{ $vendor_details->account_no }}">
                                      </div>

                                  <!--     <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">IFSC Code:</label>
                                        <input type="text" class="form-control" name="ifsc_code" value="{{ $vendor_details->ifsc_code }}">
                                      </div> -->

                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Branch address:</label>
                                        <input type="text" class="form-control" name="branch_address" value="{{ $vendor_details->branch_address }}">
                                      </div>

                                     
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger vendor-product-bt" data-dismiss="modal">Close</button>
                                        <button type="submit" name="submit" class="btn vendor-product-bt btn-primary">Save changes</button>
                                      </div>
                                       </form>
                                    </div>
                                  </div>
                                </div>
                                <!-- modal end -->
                            </div>
                       <div class="row mt-5">
                             <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6 col-6">Account Holder Name</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->account_holder }}</div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-md-6 col-6">Account Number</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->account_no }}</div>
                                </div>
                                <hr>
                                <!-- <div class="row">
                                    <div class="col-md-6 col-6">IFSC Code</div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->ifsc_code }}</div>
                                </div>
                                <hr> -->
                                <div class="row">
                                    <div class="col-md-6 col-6">Branch address </div>
                                    <div class="col-md-6 col-6 text-primary-color">{{ $vendor_details->branch_address }}</div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
        </section>
        @endif

    <!-- /.content -->
@endsection
