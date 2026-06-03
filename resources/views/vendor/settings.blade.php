@if(Session::get('plans_in')!=0)
@extends('layouts.vendor.app')
@section('content')
        @include('layouts.errors-and-messages')
          @if($vendor_details)
          <style type="text/css">
            a.Card-delete-bt {
                width: 40px;
                height: 40px;
                background: #f57332;
                border-radius: 100%;
                text-align: center;
                line-height: 40px;
                position: absolute;
                left: 10px; top: 10px;
            }
            .card-row {
              display: grid; gap: 20px;
              grid-template-columns: repeat(5, 1fr);
          }
          @media (max-width: 1024px){
            .card-row {                
                grid-template-columns: repeat(3, 1fr);
            }
          }
          @media (max-width: 991px){
            .card-row {                
                grid-template-columns: repeat(2, 1fr);
            }
          }
          @media (max-width: 767px){
             .card-row {                
                grid-template-columns: repeat(1, 1fr);
            }
          }
          </style>
        <section class="vendor-info-box">
            <div class="container-fluid">
                <section class="vendor-banner" >
                 <figure>
                    @if(isset($vendor_details->cover_image))
                        <img class="mr-5" src="{{ asset("storage/$vendor_details->cover_image") }}" width="100%" height="400px">
                    @else
                        <img class="mr-5" src="{{ asset("images/no-banner.jpg") }}" width="100%" height="100%" >
                    @endif
                </figure>
                </section>
                <div class="row">
                <div class="col-md-12 col-lg-10 col-xl-10 col-12">
                    <div class="media vendor-sales-box">
                      <div class="media-body">
                        <h3>{{ $vendor_details->first_name }} {{ $vendor_details->last_name }} </h3>
                        <p>{{ $vendor_details->short_description }}</p>
                        <div class="vendor-sale">
                            <a class="green-bt" >{{ $vendor_details->business_name }} located in {{ $vendor_details->cname }} <br> @if($vendor_details->business_year!='')<b>since - {{ $vendor_details->business_year }}</b> @endif</a>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-2 col-xl-2 col-12">
                <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#profiledetail" style="background-color:green;"> Edit Details</button>
                    <!-- business Modal -->
                                <div class="modal vendor-setting-modal fade" id="profiledetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Detail</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form method="post" action="{{ route('vendor.updateprofile_detail') }}" enctype="multipart/form-data">
                                      <div class="modal-body">
                                     {{ csrf_field() }}
                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Description:</label>
                                        <textarea class="form-control" name="short_description" >{{ $vendor_details->short_description }}</textarea>
                                      </div>


                                      <div class="form-group">
                                     <label for="recipient-name" class="col-form-label">Cover Image:</label>
                                      <input type="file" name="image" class="form-control" />
                                     </div>

                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger py-2" data-dismiss="modal">Close</button>
                                        <button type="submit" name="submit" class="btn btn-primary py-2">Save changes</button>
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
        <!-- <section class="vendor-story-box">
            <div class="container">
                <div class="row">
   
                     <div class="col-md-12 col-lg-12 col-xl-12 col-12 mt-1">
                        <h2 class="font-24 mb-3">Vision and Mission</h2>
                        <p>cghfg</p>
                       
                    </div>
                </div>
                 

            </div>

        </section><br><br> -->
        <section class="vendor_details vendor-setting-tab class">
            <div class="container-fluid">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="photo-tab" data-toggle="tab" href="#photo" role="tab" aria-controls="photo" aria-selected="false">Photo</a>
                    </li>
                   <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="false">Company Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Business Information </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Contact Information</a>
                    </li>
                   
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="card tab-pane fade p-4" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row mt-2 mb-2 align-items-center">
                            <div class="col-md-10">
                                <h3>Business Information</h3>
                            </div><br>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#legaldetail">
                                 Edit Details
                                </button><br>
                                <!-- business Modal -->
                                <div class="modal fade" id="legaldetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Business Information</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form method="post" action="{{ route('vendor.updatesetting') }}">
                                      <div class="modal-body">
                                     {{ csrf_field() }}
                                   
                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Business name:</label>
                                        <input type="text" class="form-control" name="business_name" value="{{ $vendor_details->business_name }}">
                                      </div>
                                      
                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label"> First Name:</label>
                                        <input type="text" class="form-control" name="first_name" value="{{$vendor_details->first_name}}">
                                      </div>
                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label"> Last Name:</label>
                                        <input type="text" class="form-control" name="last_name" value="{{$vendor_details->last_name}}">
                                      </div>
                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Years in business:</label>
                                        <input type="text" class="form-control" name="business_year" value="{{ $vendor_details->business_year }}">
                                      </div>

                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Business Address:</label>
                                        <input type="text" class="form-control" name="business_location" value="{{$vendor_details->business_location}}">
                                      </div>
                                      </div>
                                      <div class="modal-footer vendor-edit-detail-bt">
                                        <button type="button" class="btn btn-danger py-2" data-dismiss="modal">Close</button>
                                        <button type="submit" name="submit" class="btn btn-primary py-3">Save changes</button>
                                      </div>
                                       </form>
                                    </div>
                                  </div>
                                </div>
                                <!-- modal end -->
                            </div>
                         </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                               <div class="row">
                                    <div class="col-md-6">Business name</div>
                                    <div class="col-md-6 text-primary-color">{{ $vendor_details->business_name }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">First Name</div>
                                    <div class="col-md-6 text-primary-color">{{ $vendor_details->first_name }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">Last Name</div>
                                    <div class="col-md-6 text-primary-color">{{ $vendor_details->last_name }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">Business Email</div>
                                    <div class="col-md-6 text-primary-color">{{ $vendor_details->email }}</div>
                                </div>
                                <hr>
                            
                                
                         
                            </div>
                            <div class="col-md-12 col-lg-6">
                                
                               
                                <div class="row">
                                    <div class="col-md-6">Years in business</div>
                                    <div class="col-md-6 text-primary-color">{{ $vendor_details->business_year }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">Phone Number</div>
                                    <div class="col-md-6 text-primary-color">{{ $vendor_details->phone_number }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">Business Address</div>
                                    <div class="col-md-6 text-primary-color">{{ $vendor_details->business_location }}</div>
                                </div>
                                <hr>
                               
                            </div>
                        </div>
                    </div>
                    
                     <div class="card tab-pane fade show active p-3" id="photo" role="tabpanel" aria-labelledby="photo-tab"> 

                    <div class="row mt-2 mb-2 align-items-center">
                            <div class="col-md-10">
                                <h3>Gallery Photo</h3><br>
                            </div>
                           <button type="button" class="btn btn-primary float-right vendor-product-bt" data-toggle="modal" data-target="#photodetail"> Add Gallery Photo
                                </button>

                                <!-- business Modal -->
                                <div class="modal fade" id="photodetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Photo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                        <form method="post" action="{{ route('vendor.updategallery_detail') }}" enctype="multipart/form-data">
                                      <div class="modal-body">
                                     {{ csrf_field() }}
                                     


                                      <div class="form-group">
                                     <label for="recipient-name" class="col-form-label">Gallery Photo:</label>
                                      <input type="file" name="image[]" class="form-control" multiple="" required=""/>
                                     </div>

                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger py-2" data-dismiss="modal">Close</button>
                                        <button type="submit" name="submit" class="btn btn-primary py-2">Save</button>
                                      </div>
                                       </form>
                                    </div>
                                  </div>
                                </div>
                                <!-- modal end -->
                          </div>
                          <div class="card-row">
                            <?php if(count($galleries)!=0){?>
                                     
                            @foreach($galleries as $gallery)
                            <div class="card" style="position: relative; text-align: center;padding: 20px 15px;">
                                <div class="image-grid-container">
                                    
                                    <a class="Card-delete-bt" href="gallery/destroy/{{$gallery->id}}"><i class="fa fa-trash" aria-hidden="true"  style="color:#fff;"></i></a>
                                    <img style="width:100%; height:225px;" src="{{ asset("storage/$gallery->image") }}">
                                    
                                    
                                </div>
                            </div>
                            @endforeach
                            <?php }else{ ?>
                          
                              <span style="color:red;">No image found</span>
                              <?php } ?>

                              </div>
                       </div>
                        
                    <div class="card tab-pane fade p-3" id="profile" role="tabpanel" aria-labelledby="profile-tab"> 

                    <div class="row mt-2 mb-2 align-items-center">
                            <div class="col-md-10">
                                <h3>Contact Information</h3><br>
                            </div>
                           <button type="button" class="btn btn-primary float-right vendor-product-bt" data-toggle="modal" data-target="#billingdetail"> Edit Details
                                </button>

                                <!-- business Modal -->
                                <div class="modal fade" id="billingdetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Contact Information</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form method="post" action="{{ route('vendor.updatecontact') }}">
                                      <div class="modal-body">
                                     {{ csrf_field() }}

                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Contact Person Name:</label>
                                        <input type="text" class="form-control" name="contact_person_name" value="{{$vendor_details->contact_person_name}}">
                                      </div>
                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Contact Email:</label>
                                        <input type="email" class="form-control" name="contact_email" value="{{$vendor_details->contact_email}}">
                                      </div>
                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Contact number:</label>
                                        <input type="text" class="form-control" name="contact_no" value="{{$vendor_details->contact_no}}">
                                      </div>
                                     
                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Contact address:</label>
                                        <input type="text" class="form-control" name="contact_address" value="{{$vendor_details->contact_address}}">
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
                        <div class="row">
                             <div class="col-md-12">
                                
                                <div class="row">
                                    <div class="col-md-6">Contact Person Name</div>
                                    <div class="col-md-6 text-primary-color">{{$vendor_details->contact_person_name}}</div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-md-6">Contact Email</div>
                                    <div class="col-md-6 text-primary-color">{{$vendor_details->contact_email}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">Contact Number</div>
                                    <div class="col-md-6 text-primary-color">{{$vendor_details->contact_no}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">Contact Address </div>
                                    <div class="col-md-6 text-primary-color">{{$vendor_details->contact_address}}</div>
                                </div>
                                <hr>
                                
                               
                            </div>
                        </div></div>
                        
                    <div class="card tab-pane fade p-3" id="contact" role="tabpanel" aria-labelledby="contact-tab">  <p></p>
                     
                    <div class="row mt-2 mb-2 align-items-center">
                            <div class="col-md-10">
                                <h3>About Our Business</h3><br>
                            </div>
                             <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#accountdetail"> Edit Detail
                                </button>
                                <!-- business Modal -->
                                <div class="modal  fade" id="accountdetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit About Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form method="post" action="{{ route('vendor.updateaccount') }}">
                                      <div class="modal-body">
                                     {{ csrf_field() }}
                                     
                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">About our business:</label>
                                        <textarea type="text" class="form-control" name="business_about" >{{$vendor_details->business_about}}</textarea>
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
                          <div class="row">
                             <div class="col-md-12">
                                
                                <div class="row">
                                    <div class="col-md-12">
                                    <p>{{ $vendor_details->business_about }}</p> 
                                    </div>
                                </div>
                                <hr>

                            </div>
                        </div>
                    </div>
                        <div class="card tab-pane fade p-3" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">  <p></p>
                    <div class="row mt-2 mb-2 align-items-center">
                            <div class="col-md-10">
                           
                                <h3>Company Overview</h3><br>
                            </div>
                             <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#shippingDetails"> Edit Detail
                                </button>
                                <!-- business Modal -->
                                <div class="modal  fade" id="shippingDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Company Overview</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form method="post" action="{{ route('vendor.updateCompanyOverview') }}">
                                      <div class="modal-body">
                                     {{ csrf_field() }}
                                     <?php $idd=auth('vendor')->user()->id;?>

                                    <input type="hidden" name="vendor_id" value="{{$idd}}"> 

                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Company overview:</label>
                                        <textarea type="text" class="form-control" name="company_overview" >{{$vendor_details->company_overview}}</textarea>
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
                          <div class="row">
                             <div class="col-md-12">
                                <div class="row">
                                  
                                    <div class="col-md-12 text-primary-color">{{$vendor_details->company_overview}}</div>
                                </div>
                                <hr>
                                
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <br> <br>
        @endif

    <!-- /.content -->
@endsection
@else
@section('js')
<script type="text/javascript">
   
        window.location="{{ route('vendor.dashboard') }}";
   
</script>
@endsection
@endif