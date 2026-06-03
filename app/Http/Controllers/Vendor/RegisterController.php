<?php


namespace App\Http\Controllers\Vendor;
use App\Vendor; 
use App\VendorBusinessDetail; 
use App\Http\Controllers\Controller; 
use App\Shop\Vendors\Requests\CreateVendorRequest;
use App\Shop\Vendors\Requests\CreateVendorBusinessRequest;
use App\Shop\Memberships\Repositories\MembershipRepository;
use App\Shop\Memberships\Repositories\Interfaces\MembershipRepositoryInterface;
use App\Shop\Taxes\Repositories\TaxRepository;
use App\Shop\Taxes\Repositories\Interfaces\TaxRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Shop\Vendors\Repositories\VendorRepository;
use App\Shop\Vendors\Repositories\Interfaces\VendorRepositoryInterface;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
//use Mail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;
use Stripe;
use SendGrid;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailDemo;

class RegisterController extends Controller
{

  public function __construct(
      VendorRepositoryInterface $vendorRepository, 
      EmployeeRepositoryInterface $employeeRepository, 
      MembershipRepositoryInterface $membershipRepository, 
      TaxRepositoryInterface $taxRepository
    )
  {
      $this->vendorRepo = $vendorRepository;
      $this->employeeRepo = $employeeRepository;
      $this->membershipRepo = $membershipRepository;
      $this->taxRepo = $taxRepository;
     
  }

  public $successStatus = 200;
  
  public function showVendorRegister()
  {

    if (auth()->guard('vendor')->check()) {
        return redirect()->route('vendor.dashboard');
    }

    $plans = $this->membershipRepo->listMemberships('created_at', 'desc');

    return view('auth.vendor.register',[
        'plans'=>$plans
    ]);
  }

  public function showVendorRegisterForm($id)
  {
    if (auth()->guard('vendor')->check()) {
        return redirect()->route('vendor.dashboard');
    }
    $plan = $this->membershipRepo->findMembershipById($id);
    $tax = $this->taxRepo->findTaxById($plan->tax_id);
    return view('auth.vendor.register-form',[
        'plan'=>$plan,
        'tax'=>$tax
    ]);
  }

/**
   * Create Merchant account.
   *
   * @return \Illuminate\Http\Response
   */
 public function create_account(Request $request)
    {

        $input= $request->all();
    
        $validator = Validator::make(
            $request->all(),
            [
               'first_name'             => 'required',
                'last_name'             => 'required',
                'email'                 => 'required|email|max:255|unique:vendors',
                'password'              => 'required|min:6|max:30',
                'business_name'         => 'required',
                'business_type'         => 'required',
                'business_location'     => 'required',
                'business_about'        => 'required',
                'phone_number'          => 'required|min:10|max:10',
                'country'               => 'required',
                'role'                  => 'required',
                'agree'                 => 'required',
            ],
            [
                'first_name.required'         => trans('validation.first_nameRequired'),
                'last_name.required'          => trans('validation.last_nameRequired'),
                'email.required'              => trans('validation.emailRequired'),
                'email.email'                 => trans('validation.emailInvalid'),
                'password.required'           => trans('validation.passwordRequired'),
                'password.min'                => trans('validation.PasswordMin'),
                'password.max'                => trans('validation.PasswordMax'),
                'business_name.required'              => trans('validation.business_nameRequired'),
                'business_type.required'        => trans('validation.business_typeRequired'),
                'business_location.required'            => trans('validation.business_locationRequired'),
                'business_about.required'            => trans('validation.business_aboutRequired'),
                'country.required'           => trans('validation.countryRequired'),
                'role.required'               => trans('validation.roleRequired'),
                'agree.required'            => trans('validation.agreeRequired'),
                'phone_number.required'              => trans('validation.phone_numberRequired'),
                'phone_number.min'                 => trans('validation.phone_numberInvalid'),
                'phone_number.max'                 => trans('validation.phone_numberInvalid'),
                
            ]
        );
       //validation failed
        
    if($validator->fails()) {
        
        return back()->withErrors($validator)->withInput();
    }
    
    $business_type=DB::table('business_type')->where('id',$input['business_type'])->first();
    $firstStringCharacter = substr(ucfirst($input['first_name']), 0, 1);
    $lastStringCharacter = substr(ucfirst($input['last_name']), 0, 1);
    $chars = "0123456789";
    $merchant = substr( str_shuffle( $chars ), 0, 6 );
    $merchant_id = $firstStringCharacter.$lastStringCharacter.$merchant;
    $shopStringCharacter = substr(strtoupper($business_type->title), 0, 2);
        $shop = substr( str_shuffle( $chars ), 0, 2 );
        $citrus_shop_id = $shopStringCharacter.'0000'.$shop;
    $user = Vendor::create([
        'first_name' => $input['first_name'],
        'last_name' => $input['last_name'],
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
        'business_name' => $input['business_name'],
        'business_type' => $input['business_type'],
        'business_location' => $input['business_location'],
        'phone_number' => $input['phone_number'],
        'country' => $input['country'],
        'role' => $input['role'],
        'agree' => $input['agree'],
        'business_about' => $input['business_about'],
        'user_type' => $input['user_type'],
        'account_type' => $input['account_type'],
        'citrus_merchant_id' => $merchant_id,
        'citrus_shop_id' => $citrus_shop_id
    ]);
    $id=$user->id;

     $data =  DB::table('shops')->insert([
            'title' => $input['business_type'],
            'location' => $input['business_location'],
            'merchant_id' => $id,
            'citrus_shop_id' => $citrus_shop_id,
            'type' => 'default',

        ]);
    
    $details = $request->only('email', 'password');
    $details['status'] = 1;
    if ($user!='') {
       Session::put('email', $input['email']);
          Alert::success('Registration done successfully. Your Citrus ID is'.' '.$merchant_id, 'success');
         return view('auth.holding-page');
       
    }

  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function register(CreateVendorRequest $request)
  {  
    //print_r('dfgdfg'); die();
    $plan_id = $_POST['plan_id'];
    $plan_variant=$_POST['plan_variant'];
    $input = $request->all();
    $password = $input['password'];
    $input['password'] = Hash::make($input['password']);
    
    $vendorCreate = Vendor::create($input); 
    $vendorCreate->save();
    
    $input['vendor_id']=$vendorCreate->id;
    $vendorbusinessDetailCreate = VendorBusinessDetail::create($input); 
    $vendorbusinessDetailCreate->save();
    $email = $input['email'];
    $input['password'] = $password;

    if($request->role=='2'){
      $role='Staff';
    }else{
      $role='Vendor';
    }

    if($request->status=='1'){
      $status='Approved';
    }else{
      $status='Unapproved';
    }

    $memberships = DB::table('memberships')->where('id',$plan_id)->first(); 
    $data['date'] = date('Y-m-d');
    $dt = strtotime(date("Y-m-d"));
    if($plan_variant==1){
      $expiry_date = date("Y-m-d", strtotime("+1 month", $dt));
    }else{
      $expiry_date = date("Y-m-d", strtotime("+1 year", $dt));
    }
   
      // $html="<div style='background-color:rgb(255,255,255);margin:0;font:12px/16px Arial,sans-serif'>
      //     <img src=''>
      //      <table dir='ltr' style='width:640px;color:rgb(51,51,51);margin:0 auto;border-collapse:collapse;border: 2px solid;    border-color: #e7e7e7;'>
      //         <tbody>
      //            <tr>
      //               <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
      //                  <table id='m_-7134114449099840045m_5739355418147783239main' style='width:100%;border-collapse:collapse'>
      //                     <tbody>
      //                        <tr>
      //                           <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
      //                              <table id='m_-7134114449099840045m_5739355418147783239header' style='width:100%;border-collapse:collapse'>
      //                                 <tbody>
      //                                    <tr>
      //                                       <td colspan='3' style='text-align:right;padding:0px 0 5px 0;vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif display: none;'>
      //                                         <img src=''>
      //                                       </td>
      //                                    </tr>
      //                                 </tbody>
      //                              </table>
      //                           </td>
      //                        </tr>
      //                        <tr>
      //                         <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
      //                            <table style='width:100%;border-collapse:collapse'>
      //                               <tbody>
      //                                  <tr style='background-color:#93EB8B'>
      //                                     <td style='font-size:14px;padding:11px 18px 18px 18px;width:50%;vertical-align:top;line-height:16px;font-family:Arial,sans-serif'>
      //                                        <h1 style='color:#fff;line-height: 1;text-align: center;'>Thank you for signing up with ".getenv('APP_SHORT_NAME')." Here is everything you need to know.</h1>
      //                                     </td>
                                          
      //                                  </tr>
      //                               </tbody>
      //                            </table>
      //                         </td>
      //                      </tr>
      //                        <tr>
      //                           <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif;padding: 0px 18px 0px 20px;'>
      //                              <table style='width:100%;border-collapse:collapse'>
      //                                 <tbody>
      //                                    <tr>
      //                                       <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
      //                                          <h3 style='font-size:18px;margin:15px 0 0 0;font-weight:normal'> Hello $request->name,</h3>
      //                                          <br/>
      //                                          <h4 style='margin:5px 0 0 0;font:12px/16px Arial,sans-serif'> Thank you for joining our Vancouver Island exclusive Shop Local-Support Local platform!</h4>
      //                                       </td>
      //                                    </tr>
      //                                    <tr>
      //                                       <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
      //                                       </td>
      //                                    </tr>
      //                                 </tbody>
      //                              </table>
      //                           </td>
      //                        </tr>
      //                        <tr>
      //                           <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif;padding: 0px 18px 0px 20px;'>
      //                              <table style='width:100%;border-collapse:collapse'> 
      //                              </table>
      //                           </td>
      //                        </tr>
      //                        <tr>
      //                         <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
      //                            <h3 style='font-size:18px;color:#206080;font-weight:600;padding: 20px 15px;line-height: 1;background: #ddddddb5'>Please keep this email for your records as it holds all the important information you need to access your account.</h3>
      //                         </td>
      //                      </tr>     
      //                         <tr>
      //                         <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif;'>
      //                            <table style='width:100%;border-collapse:collapse; margin-bottom: 12px !important;'>
      //                               <tbody>
      //                                  <tr>
      //                                     <td style='padding-left: 15px;vertical-align:top;font-size:12px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif'> Email : <a href=''>$request->email</a>  
      //                                     </td>
      //                                  </tr>
      //                                  <tr>
      //                                     <td style='padding-left: 15px;vertical-align:top;font-size:12px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif'> Password : <a href=''>$request->password</a>  
      //                                     </td>
      //                                  </tr>
      //                                  <tr>
      //                                     <td style='padding-left: 15px;vertical-align:top;font-size:12px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif'> Plan Type: <a href=''>
      //                                     ".$memberships->name."</a>  
      //                                     </td>
      //                                  </tr>
      //                                  <tr>
      //                                     <td style='padding-left: 15px;vertical-align:top;font-size:12px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif'> You’re plan will renew on: <a href=''>".date("F d, Y", strtotime($expiry_date))."</a>  
      //                                     </td>
      //                                  </tr>
      //                                  <tr>
      //                                     <td style='padding-left: 15px;vertical-align:top;font-size:12px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif'> Vendor Login: <a href=''> Please use this login area to set up your vendor profile. (it’s easy!) This is also where are you get access to your orders and manage your products and services. </a>  
      //                                     </td>
      //                                  </tr>
      //                                  <tr>
      //                                    <td colspan='2' align='center'>
      //                                    <a href=' ".route("vendor.login")." ' style='color:#93EB8B;background:#206080;text-decoration: none;font-weight: 500;padding: 10px 30px;line-height: 5;'>ACCESS VENDOR LOGIN</a></td>
      //                                  </tr>
      //                               </tbody>
      //                            </table>
      //                         </td>
      //                      </tr>
      //                            <hr>
      //                        <tr>
      //                           <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
      //                              <table style='width:100%;padding:0 0 0 0;border-collapse:collapse'>
      //                                 <tbody>
      //                                    <tr>
      //                                       <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
      //                                          <p style='padding:0 0 20px 15px;margin:10px 0 0 0;font:12px/16px Arial,sans-serif'> We are excited to have you as a member of our collective and wish you all the best! – The BuyVi Team! <br> 
      //                                            Having technical issues? Please contact us at support@buyvi.ca and we will be happy to help! Don’t forget to include your name and company name. <br> 
      //                                          <span style='font-size:16px;font-weight:bold'> <a style='color: #000; text-decoration: none;' href=''><strong>".getenv('APP_NAME')."</strong> </a></span> </p>
      //                                       </td>
      //                                    </tr>
      //                                 </tbody>
      //                              </table>
      //                           </td>
      //                        </tr>
                          
      //                     </tbody>
      //                  </table>
      //               </td>
      //            </tr>
      //         </tbody>
      //      </table>
      //      <img src=''>
      //   </div>";

  
      // $emails = $request->email;
      // $phone = $request->phone;

      
      // $subject = 'You Are Now a Vendor with BuyVi.ca!';
      // $senderEmail = getenv('SENDGRID_EMAIL'); //SENDER_EMAIL
      // $senderName = getenv('APP_NAME'); //SENDER_NAME
      // /** An array to store the status codes for all emails to have a record of all successful emails */
      // $emailReports = [];
      // $addressesArray = $emails;
      // $email = new SendGrid\Mail\Mail();
      // $email->setFrom($senderEmail, $senderName);
      // $email->setSubject($subject);
      // $email->addTo($addressesArray);
      // $email->addContent("text/html", $html );
      // $apiKey = getenv('SENDGRID_API_KEY');
      // $sendgrid = new \SendGrid($apiKey);
      
      // try {
      //     $response = $sendgrid->send($email);
      //     array_push($emailReports, $addressesArray . " => " . $response->statusCode());
      // } catch (Exception $e) {
      //     echo 'Caught exception: ',  $e->getMessage(), "\n";
      // }

    /*Mail::send('emails.admin.CreateUserEmail',["data"=>$input] , function ($message) use ($email){
        $message->to($email);
        $message->subject('Account created successfully!');
    });*/

    $details = $request->only('email', 'password');
    $details['status'] = 1;
    if (auth()->guard('vendor')->attempt($details)) {
          Auth::user();

       return redirect()->route('vendor.dashboard');
    }
    
  }

  
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function VendorRegisterPayment()
  {  

    if (!auth()->guard('vendor')->check()) {
        return redirect(route('vendor.login'))->with('error', 'You must be a merchant to see this page');
    }elseif(auth()->guard('vendor')->user()->payment_status == 1){
        return redirect()->route('vendor.dashboard');
    }
    $vendor = $this->vendorRepo->findVendorById(auth('vendor')->user()->id);
    $staffs = $this->employeeRepo->listEmployees();
    $plan = $this->membershipRepo->findMembershipById($vendor->plan_id);
    $tax = $this->taxRepo->findTaxById($plan->tax_id);

    return view('auth.vendor.payment',[
        'vendor'=>$vendor,
        'staffs'=>$staffs,
        'plan'=>$plan,
        'tax'=>$tax
    ]);
  }


    public function send_msg(request $request)
    {  

      $subject=$_POST['subject'];
      $msg=$_POST['msg'];
      $vendor_id=$_POST['vendor_id'];
      $this->validate(request(), [
        'subject' => 'required',
        'msg' => 'required',
        
      ]);
      $data=DB::table('vendor_msg')->insert(
        array(
              'subject'   =>   $subject,
              'msg'       =>   $msg,
              'vendor_id' =>  $vendor_id      
        )
      );

      // $admin = DB::table('employees')->where('type',0)->first();
      // $html="<div style='background-color:rgb(255,255,255);margin:0;font:12px/16px Arial,sans-serif;'>
      //        <table dir='ltr' style='width:640px;color:rgb(51,51,51);margin:0 auto;border-collapse:collapse;border:solid #ddddddb5 2px;'>
      //           <tbody>
      //              <tr>
      //                 <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
      //                    <table id='m_-7134114449099840045m_5739355418147783239main' style='width:100%;border-collapse:collapse'>
      //                       <tbody>
                             
      //                          <tr>
      //                             <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
      //                                <table style='width:100%;border-collapse:collapse'>
      //                                   <tbody>
      //                                      <tr style='background-color:#93EB8B'>
      //                                         <td style='font-size:20px;padding:11px 18px 18px 18px;width:100%;vertical-align:top;line-height:20px;font-family:Arial,sans-serif; text-align:center'>
      //                                            <p style='margin:2px 0 9px 0;font:20px Arial,sans-serif'> <b style='color:#fff'>See what they have to say.</b> </p>
      //                                         </td>
      //                                      </tr>
      //                                      <tr>
      //                                        <td>
      //                                          <h2 style='color:#206080;line-height: 1;text-align: center;'>MESSAGE NOTIFICATION</h2>
      //                                        </td>
      //                                      </tr>
      //                                   </tbody>
      //                                </table>
      //                             </td>
      //                          </tr>

      //                          <tr>
      //                             <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
      //                                <table style='width:100%;border-collapse:collapse'>
      //                                </table>
      //                             </td>
      //                          </tr>
      //                             <tr>
      //                             <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
      //                                <table style='width:100%;border-collapse:collapse'>
      //                                   <tbody>
      //                                      <tr>
      //                                         <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
      //                                            <h3 style='font-size:18px;color:#206080;margin:15px 0 0 0;font-weight:normal'> Hello ".$admin->name."! </h3>
      //                                            <p style='margin:5px 0 0 0;font:16px Arial,sans-serif'> There are messages from merchant awaiting a response.</p>
      //                                         </td>
      //                                      </tr>
      //                                      <tr>
      //                                         <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'> </td>
      //                                      </tr>
      //                                   </tbody>
      //                                </table>
      //                             </td>
      //                          </tr>
      //                           <tr>
      //                               <td style='width:70%;text-align:left!important;line-height:50px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> 
      //                                   <a style='text-decoration: none;border: 1px solid black;padding: 10px;font-weight: 700;background-color: #206080;color:#93EB8B;' href= ' ". route('admin.login')." '>LOGIN NOW</a>
      //                               </td>
      //                            </tr>                   
      //                       </tbody>
      //                    </table>
      //                 </td>
      //              </tr>
      //           </tbody>
      //        </table>
      //     </div>";
      // $emails = $admin->email;
      // $subject = 'New Message Waiting in Super Admin';
      // $senderEmail = getenv('SENDGRID_EMAIL'); //SENDER_EMAIL
      // $senderName = getenv('APP_NAME'); //SENDER_NAME
     
      // $emailReports = [];
      // $addressesArray = $emails;
      // $email = new SendGrid\Mail\Mail();
      // $email->setFrom($senderEmail, $senderName);
      // $email->setSubject($subject);
      // $email->addTo($addressesArray);
      // $email->addContent("text/html", $html );
      // $apiKey = getenv('SENDGRID_API_KEY');
      // $sendgrid = new \SendGrid($apiKey);
      
      // try {
      //     $response = $sendgrid->send($email);
      //     array_push($emailReports, $addressesArray . " => " . $response->statusCode());
      // } catch (Exception $e) {
      //     echo 'Caught exception: ',  $e->getMessage(), "\n";
      // }
      return redirect()->route('vendor.dashboard')->with('message', 'Message send successfully. Please wait for admin reply.');
    }

    public function show_allmsg()
    {
      $id=Auth()->user()->id;
        
      $vendor_msg = DB::table('vendor_msg')->where('vendor_id', $id)->get();
     
       
      return view('vendor.msg-list',['msg'=>$vendor_msg]);
    }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function VendorRegisterPaymentProcess()
  {
    $id = auth('vendor')->user()->id;
    $vendor = $this->vendorRepo->findVendorById($id);
    $plan = $this->membershipRepo->findMembershipById($vendor->plan_id);
    $tax = $this->taxRepo->findTaxById($plan->tax_id);
    $totAmt = $_POST['totAmt'];

    return view('front.vendor_stripe',[
      'id' => $id,
      'vendor' => $vendor,
      'plan' => $plan,
      'tax' => $tax,
      'totAmt' => $totAmt
    ]);

    // $request['payment_status'] = 1;
    // $vendor = Vendor::where('id', $id)->update($request);
    // return redirect()->route('vendor.dashboard')->with('message', 'Payment successfully');
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function VendorRegisterContact(Request $request)
  { 
    $id = auth('vendor')->user()->id;
    $data['staff_id'] = $request->input('staff_id');
    $vendor = Vendor::where('id', $id)->update($data);
    return redirect()->route('vendor.register.payment')->with('message', 'Your request has been successfully submitted');
    
  }

  public function verify_email()
    {
      return view('auth.verify-email');
    }

    public function send_otp()
    {
      return view('auth.otp');
    }


    public function verification(Request $request)
    {

      $detail=Vendor::where('email',$request->email)->get();
      
      $count=count($detail);
      if($count==0){
       return redirect()->back()->with('error', 'Email address is not exist'); 
      }
      if($detail[0]->status ==0){
        $random = rand(100000, 999999);
        $date=now()->addMinutes(10);
        //print_r(now()); die();
        //$otp = substr( str_shuffle( $random ), 0, 6 );
        Session::put('detail', $detail);
        $update_otp=Vendor::where('id', $detail[0]->id)->update(array('otp' => $random, 'otp_expires_at' => $date));
        $otpdetail=Vendor::where('email',$request->email)->get();
        $newotp=$otpdetail[0]->otp;
        $name=$otpdetail[0]->first_name.' '.$otpdetail[0]->last_name;
        Session::put('email', $request->email);
        // Session::put('name', $name);
        $email1 = $request->email;
      
       $html="<div style='background-color:rgb(255,255,255);margin:0;font:12px/16px Arial,sans-serif;'>
            <table dir='ltr' style='width:640px;color:rgb(51,51,51);margin:0 auto;border-collapse:collapse;border: 2px solid;    border-color: #e7e7e7;'>
              <tbody>
                 <tr>
                    <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                       <table id='m_-7134114449099840045m_5739355418147783239main' style='width:100%;border-collapse:collapse'>
                          <tbody>
                           
                             <tr>
                              <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                 <table style='width:100%;border-collapse:collapse'>
                                    <tbody>
                                       <tr style='background-color:#5bbb47'>
                                          <td style='font-size:14px;padding:11px 18px 18px 18px;width:50%;vertical-align:top;line-height:16px;font-family:Arial,sans-serif'>
                                             <h1 style='color:#fff;line-height: 1;text-align: center;'>Citrus One Time Password</h1>
                                          </td>
                                          
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                             <tr>
                                <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif;padding: 0px 18px 0px 20px;'>
                                   <table style='width:100%;border-collapse:collapse'>
                                      <tbody>
                                         <tr>
                                            <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
                                               <h3 style='font-size:18px;margin:15px 0 0 0;font-weight:normal'> Hello  ".$name.",</h3>
                                               <br/>
                                               <h4 style='margin:5px 0 0 0;font:12px/16px Arial,sans-serif'> Thank you for joining with Citrus. Here is everything you need to know.</h4>
                                            </td>
                                         </tr>
                                         <tr>
                                            <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                            </td>
                                         </tr>
                                      </tbody>
                                   </table>
                                </td>
                             </tr>
                             <tr>
                                <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif;padding: 0px 18px 0px 20px;'>
                                   <table style='width:100%;border-collapse:collapse'> 
                                   </table>
                                </td>
                             </tr>
                             <tr>
                              <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
                                 <h3 style='font-size:18px;color:#206080;font-weight:600;padding: 20px 15px;line-height: 1;background: #ddddddb5'>Please keep this email for your records as it holds all the important information you need to access your account.</h3>
                              </td>
                           </tr>     
                              <tr>
                              <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif;'>
                                 <table style='width:100%;border-collapse:collapse; margin-bottom: 12px !important;'>
                                    <tbody>
                                      <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:14px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif'>Citrus ID : ".$otpdetail[0]->citrus_merchant_id."  
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:14px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif'> OTP : ".$newotp." 
                                          </td>
                                       </tr>
                                       
                                       
                                       <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:12px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif'><span style='color:red'>* The OTP will expire in 10 minutes.</span>
                                          </td>
                                       </tr>
                                       
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                                 <hr>
                             <tr>
                                <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                   <table style='width:100%;padding:0 0 0 0;border-collapse:collapse'>
                                      <tbody>
                                         <tr>
                                            <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                               <p style='padding:0 0 20px 15px;margin:10px 0 0 0;font:12px/16px Arial,sans-serif'> We are excited to have you as a member of our collective and wish you all the best! – The Citrus Team! <br> 
                                                 Having technical issues? Please contact us at support@citrus.com and we will be happy to help! Don’t forget to include your name and company name. <br> 
                                               <span style='font-size:16px;font-weight:bold'> <a style='color: #000; text-decoration: none;' href=''><strong>{{getenv('APP_NAME')}}</strong> </a></span> </p>
                                            </td>
                                         </tr>
                                      </tbody>
                                   </table>
                                </td>
                             </tr>
                          
                          </tbody>
                       </table>
                    </td>
                 </tr>
              </tbody>
           </table>
        </div>";
        

         $emails = $email1;
        $subject = 'Citrus One Time Password';
        $senderEmail = getenv('SENDGRID_EMAIL'); //SENDER_EMAIL
        $senderName = getenv('APP_NAME'); //SENDER_NAME
       
        $emailReports = [];
        $addressesArray = $emails;
        $email = new SendGrid\Mail\Mail();
        $email->setFrom($senderEmail, $senderName);
        $email->setSubject($subject);
        $email->addTo($addressesArray);
        $email->addContent("text/html", $html );
        $apiKey = getenv('SENDGRID_API_KEY');
        $sendgrid = new \SendGrid($apiKey);
        
        try {
            $response = $sendgrid->send($email);
            array_push($emailReports, $addressesArray . " => " . $response->statusCode());
             
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
      return redirect()->route('otp')->with('success', 'OTP has been sent to your registered email address.');
      }else{
        return redirect()->back()->with('message', 'Email address already verified'); 
      }

  }

  public function verify_otp(Request $request)
    {
      $detail=Vendor::where('email',$request->email)->where('otp',$request->otp)->get();
      $count=count($detail);
      if($count==1){

        if($detail[0]->verify_status ==1){
          return redirect()->back()->with('message', 'Email address already verified'); 
        }
       
      if($detail[0]->otp_expires_at > now()){
       
        $update_data=Vendor::where('id', $detail[0]->id)->update(array('status' => 1,'verify_status' => '1'));
         
      return redirect()->route('vendor.login')->with('success', 'Email verification done successfully.');
      }else{
        Session::put('email', $request->email);
         return redirect()->back()->with('error', 'OTP number expired. Please click RESEND button to get new OTP'); 

      }
    }else{
        return redirect()->back()->with('error', 'OTP number do not match'); 
      }

  }

}
