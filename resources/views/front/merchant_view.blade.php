@extends('layouts.front.app')
@section('content')
    <!-- Main content -->
    <style type="text/css">
        .marchent-detailBanner img{
            height: 400px;
            object-fit: cover;
            object-position: top center;
        }
        section.vendor-imgBox {
            width: 160px; height: 160px;
            border-radius: 100%; z-index: 1;
            border: 7px solid #E8622E;
            margin-top: -75px;
            position: relative;
        }
        section.vendor-imgBox img{
            width: 100%; height: 100%;  
        }
        .marchent-detailBox {
            background: #f6f6f6;
        }
        .card.tab-pane {
            border: 0; background: transparent;
        }
        .vendor-setting-tab .nav-tabs {
            border-bottom: 0;
        }
        .vendor-setting-tab .nav-tabs .nav-link.active {
            background: transparent !important;
            color: #0c2082 !important; border: 0;
            position: relative;
        }
        .vendor-setting-tab .nav-tabs .nav-link.active:before {
            content: ''; position: absolute;
            left: 50%; width: 35px; height: 2px;
            background: #0c2082; bottom: 5px;
            transform: translateX(-50%);
        }
        .nav-tabs .nav-link{
            border:0; color: #1f45fc !important; font-size: 20px;
        }
        .nav-tabs .nav-link:hover{
            border:0;   
        }
    </style>
  <section class="content">
  <!-- <div class="row mb-5 my-account-banner mx-0">
    <div  class="col-12">
      <h2 class="text-center pt-5 pb-5 text-white">Merchant Details 
        
    </h2>
      <br>

    </div>
  </div> -->
  
@include('layouts.errors-and-messages')
 @if($vendor_details)
 <div class="marchent-detailBanner">
       @if(isset($vendor_details->cover_image))
            <img class="w-100" src="{{ asset("storage/$vendor_details->cover_image") }}" width="100%" height="400px">
        @else
            <img class="w-100" src="{{ asset("images/no-banner.jpg") }}" width="100%" height="100%" >
        @endif
 </div>
       <div class="marchent-detailBox">
            <div class="container">
                <section class="vendor-imgBox">
                    @if(isset($vendor_details->avatar))
                        <img class="w-100 rounded-circle" src="{{ asset("storage/profile/vendors/$vendor_details->avatar") }}" width="100%" height="400px">
                    @else
                        <img class="w-100 rounded-circle" src="{{asset("images/dummy-user.png") }}" width="100%" height="100%" >
                    @endif
                </section><br>
                <div class="row">
                <div class="col-md-12 col-lg-10 col-xl-10 col-12">
                    <div class="media vendor-sales-box">
                      <div class="media-body">
                        <h2><b>{{ $vendor_details->first_name }} {{ $vendor_details->last_name }} </b></h2>
                        <p>{{ $vendor_details->short_description }}</p>
                        <div class="vendor-sale">
                            <a class="primary-bt" >{{ $vendor_details->business_name }} located in {{ $vendor_details->cname }} <br> @if($vendor_details->business_year!='')<b>since - {{ $vendor_details->business_year }}</b> @endif</a>
                        </div>
                      </div>
                    </div>
                </div>
                </div>
                  </div>
            
        <br><br>
       
        <section class="vendor_details vendor-setting-tab class">
            <div class="container">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="photo-tab" data-toggle="tab" href="#photo" role="tab" aria-controls="photo" aria-selected="false">Photo</a>
                    </li>
                    <!--<li class="nav-item">-->
                    <!--    <a class="nav-link" id="location-tab" data-toggle="tab" href="#location" role="tab" aria-controls="location" aria-selected="false">Location</a>-->
                    <!--</li>-->
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
                       <div class="row mt-2 mb-2 About_Contact_info_box">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="">Business name</label>
                                <input readonly="" value="{{ $vendor_details->business_name }}">
                            </div>
                            <div class="form-group">
                                <label style="">First Name</label>
                                <input readonly="" value="{{ $vendor_details->first_name }}">
                            </div>
                            <div class="form-group">
                                <label style="">Last Name</label>
                                <input readonly="" value="{{ $vendor_details->last_name }}">
                            </div>
                            <div class="form-group">
                                <label style="">Business Email</label>
                                <input readonly="" value="{{ $vendor_details->email }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="">Years in business</label>
                                <input readonly="" value="{{ $vendor_details->business_year }}">
                            </div>
                            <div class="form-group">
                                <label style="">Phone Number</label>
                                <input readonly="" value="{{ $vendor_details->phone_number }}">
                            </div>
                            <div class="form-group">
                                <label style="">Business Address</label>
                                <input readonly="" value="{{ $vendor_details->business_location }}">
                            </div>
                            
                        </div>
                           
                    </div>
                        <!-- <div class="row">
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
                        </div> -->
                    </div>
                    <div class="card tab-pane fade p-3" id="profile" role="tabpanel" aria-labelledby="profile-tab"> 

                    <div class="row mt-2 mb-2 About_Contact_info_box">
                       <div class="col-md-6">
                            <div class="form-group">
                                <label style="">Contact Person Name</label>
                                <input readonly="" value="{{ $vendor_details->contact_person_name }}">
                            </div>
                            <div class="form-group">
                                <label style="">Contact Email</label>
                                <input readonly="" value="{{ $vendor_details->contact_email }}">
                            </div>
                           
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                                <label style="">Contact Number</label>
                                <input readonly="" value="{{ $vendor_details->contact_no }}">
                            </div>
                            <div class="form-group">
                                <label style="">Contact Address</label>
                                <input readonly="" value="{{ $vendor_details->contact_address }}">
                            </div>  
                            
                        </div>
                           
                    </div>
                        <!-- <div class="row">
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
                        </div> --></div>
                         <div class="card tab-pane fade show active p-3" id="photo" role="tabpanel" aria-labelledby="photo">
                            <h2 class="my-4">Gallery Photo</h2>
                            <div class="About_profile_box mt-3">
                                 <?php if(count($galleries)!=0){?>
                                <!-- <figure> -->
                                    @foreach($galleries as $gallery)
                                    <img class="w-100" src="{{ asset("storage/$gallery->image") }}">
                                    @endforeach
                                <!-- </figure> -->
                                <?php }else{ ?>
                                
                                <span style="color:red;">No image found</span>
                                <?php } ?>
                                
                            </div>
                           
                         </div>
                         <div class="card tab-pane fade p-3" id="location" role="tabpanel" aria-labelledby="location">
                            <div class="row mt-2 mb-2 align-items-center">
                            <h3 class="d-block mb-4 w-100">See Us on Google Map</h3>
                            <div class="col-md-6">
                                <div class="mapBox">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2914.163380563652!2d-89.37166848465323!3d43.080060379145195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8806537211acfeef%3A0xbaf7e58e7f5ea8d!2sMadison%20Sourdough!5e0!3m2!1sen!2sin!4v1626114267819!5m2!1sen!2sin" style="border:0; width: 100%; height: 450px; border-radius: 55px 0 55px 0; box-shadow: 3px 6px 20px #ff733157;" allowfullscreen=""></iframe>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form class="About_Loaction_form">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="" placeholder="New Your">
                                    </div>
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" name="" placeholder="Amarica">
                                    </div>
                                </form>
                            </div>
                        </div>
                         </div>
                    <div class="card tab-pane fade p-3" 
                    id="contact" role="tabpanel" aria-labelledby="contact-tab">  <p></p>
                        <div class="row mt-2 mb-2 align-items-center">
                            <div class="col-md-10">
                                <h3 class="pb-4">About Our Business</h3>
                                <!-- <p>{{ $vendor_details->business_about }}</p>  -->
                                <p style="font-size: 15px; line-height: 28px;">{{ $vendor_details->business_about }}</p>
                            </div>
                        </div>
                    </div>

                   <!-- <div class="card tab-pane fade p-3" id="location" role="tabpanel" aria-labelledby="location-tab">  <p></p>
                    <div class="row mt-2 mb-2 align-items-center">
                                <h3>Location Faiz</h3><br>
                            <div class="col-md-10">
                           
                            </div>
                             
                            </div>
                          <div class="row">
                             <div class="col-md-12">
                                <div class="row">
                                </div>
                                <hr>
                                
                            </div>
                        </div>
                        </div> -->
                    <div class="card tab-pane fade p-3" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">  <p></p>
                        <div class="row mt-2 mb-2 align-items-center">
                            <div class="col-md-12">
                                <h3 class="pt-2 pb-4">Company Overview</h3>
                                <!-- <p>{{$vendor_details->company_overview}}</p> -->
                                <p style="font-size: 16px; line-height: 28px; color: #000;">{{$vendor_details->company_overview}}</p>
                            </div>  
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </section>
        <br> <br>
        @endif
    
</div>
</section>
</div>
    <!-- /.content -->
@endsection

