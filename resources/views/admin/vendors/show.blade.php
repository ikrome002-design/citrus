@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
     <!-- home banner -->
        @include('layouts.errors-and-messages')
          @if($vendor_details)
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
               
                  </div>
              </div>
        </section><br><br>
       
        <section class="vendor_details vendor-setting-tab class">
            <div class="container-fluid">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="photo-tab" data-toggle="tab" href="#photo" role="tab" aria-controls="photo" aria-selected="false">Photo</a>
                    </li>
                   <li class="nav-item">
                        <a class="nav-link " id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">About</a>
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
                   <!--  <li class="nav-item">
                        <a class="nav-link" id="location-tab" data-toggle="tab" href="#location" role="tab" aria-controls="location" aria-selected="false">Location</a>
                    </li> -->
                   
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="card tab-pane fade p-4" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row mt-2 mb-2 align-items-center">
                            <div class="col-md-10">
                                <h3>Business Information</h3>
                            </div><br>
                           
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
                    <div class="card tab-pane fade p-3" id="profile" role="tabpanel" aria-labelledby="profile-tab"> 

                    <div class="row mt-2 mb-2 align-items-center">
                            <div class="col-md-10">
                                <h3>Contact Information</h3><br>
                            </div>
                           
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
                        
                     <div class="card tab-pane fade show active p-3" id="photo" role="tabpanel" aria-labelledby="photo-tab"> 

                    <div class="row mt-2 mb-2 align-items-center">
                            <div class="col-md-10">
                                <h3>Gallery Photo</h3><br>
                            </div>
                           
                                <!-- modal end -->
                          </div>
                        
                            <div class="card">
                                <div class="image-grid-container">
                                    <?php if(count($galleries)!=0){?>
                                     
                                     @foreach($galleries as $gallery)
                                    
                                    <img style="width:265px; height:225px;" src="{{ asset("storage/$gallery->image") }}">
                                    
                                    @endforeach
                                  <?php }else{ ?>
                                
                                    <span style="color:red;">No image found</span>
                                    <?php } ?>
                                    
                                </div>
                                  
                               
                            </div>
                       </div>
                    <div class="card tab-pane fade p-3" id="contact" role="tabpanel" aria-labelledby="contact-tab">  <p></p>
                     
                    <div class="row mt-2 mb-2 align-items-center">
                            <div class="col-md-10">
                                <h3>About Our Business</h3><br>
                            </div>
                             
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

                   <div class="card tab-pane fade p-3" id="location" role="tabpanel" aria-labelledby="location-tab">  <p></p>
                    <div class="row mt-2 mb-2 align-items-center">
                            <div class="col-md-10">
                           
                                <h3>Location</h3><br>
                            </div>
                             
                            </div>
                          <div class="row">
                             <div class="col-md-12">
                                <div class="row">
                                
                                    <!-- <div class="col-md-12 text-primary-color">
                                       <div id="floating-panel">
                                        <input id="address" type="textbox" value="Sydney, NSW" />
                                        <input id="submit" type="button" value="Geocode" />
                                      </div>
                                      <div id="map"></div>
                                    </div> -->
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
