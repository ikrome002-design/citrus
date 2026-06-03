@extends('layouts.front.app')

@section('content')
    <!-- Main content -->

    <section class="contact_page_section ">
      <div class="contact-banner-box">
          <div class="container">
              <div class="row">
                  <div class="col-md-12 col-lg-12 col-12 text-center">
                      <h1>Contact Us</h1>
                  </div>
              </div>
          </div>
      </div>
      <div class="container">
          <div class="row ">
            <div class="col-md-12 col-lg-6">
              <div class="contact-info-box mt-2">
                <h2 class="mb-5">Customer Care</h2>
                  <div>
                      <p class="">For general inquiries, please email us:</p>
                      <a href="mailto:info@buyvi.ca">Info@buyvi.ca</a>
                  </div>
                  <div>
                      <p class="">For information about signing up or questions about what we can do for your business, please email us:</p>
                      <a href="mailto:Sales@buyvi.ca">Sales@buyvi.ca</a>
                      
                  </div>
                  <div>
                      <p>Having technical issues? Please email us at: </p> 
                      <a href="mailto:support@buyvi.ca">Support@buyvi.ca</a>
                  </div>
                  <div>
                    <p>To reach us by telephone call us Toll Free: <a href="tel:1-888-840-1222">1-888-840-1222</a></p>  
                  </div>
                  
              </div>
            </div>
            <div class="col-md-12 col-lg-6">
              
              <div class="contact-box">
                <h2 class="mb-4">Get in Touch</h2>  
            <div class="card shadow-sm border-0">
                @include('layouts.errors-and-messages')
          <div class="card-body">
            <form method="post" action="{{ route('contact.form') }}">
              <div class="form-row m-0">
                <input type="hidden" value="Simple contact form" name="formname" >
                <input type="hidden" value="1" name="formid" >
                <div class="form-group col-12">
                  <label for="name">Name <span class="required">*</span></label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                </div>
                <div class="form-group col-12">
                  <label for="inputPassword4">Email <span class="required">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="phone">Phone <span class="required">*</span></label>
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" value="{{ old('phone') }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="fax">Fax</label>
                  <input type="text" class="form-control" id="fax" name="contact_meta[fax]" placeholder="Fax" value="{{ old('contact_meta.fax') }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="company-name">Company name</label>
                  <input type="text" class="form-control" id="company-name" name="contact_meta[company-name]" placeholder="Company name" value="{{ old('contact_meta.company-name') }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="website">Website</label>
                  <input type="text" class="form-control" id="website" name="contact_meta[website]" placeholder="Website" value="{{ old('contact_meta.website') }}">
                </div>
                <div class="form-group col-12">
                  <label for="message">Message <span class="required">*</span></label>
                  <textarea class="form-control" id="message" height="100" name="message" placeholder="Message">{{ old('message') }}</textarea>
                </div>
                <div class="form-group col-12">
                  <button type="submit" class="btn btn-primary">Send Message</button>
                </div>
              </div>
              @csrf
            </form>
          </div>
        </div>
      </div>
        </div>
          </div>        
      </div>
    </section>
    <!-- /.content -->
@endsection