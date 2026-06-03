<?php

namespace App\Http\Controllers\Auth;

use App\Shop\Customers\Customer;
use App\Shop\Countries\Country;
use App\BusinessType;
use App\Http\Controllers\Controller;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Customers\Requests\CreateCustomerRequest;
use App\Shop\Customers\Requests\RegisterCustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use SendGrid;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;




class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/accounts';

    private $customerRepo;

    /**
     * Create a new controller instance.
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {

       // $this->middleware(['guest', 'verified']);

       $this->middleware('guest');

  
       $this->customerRepo = $customerRepository;

    }

       public function account_type(Request $request)
    {
       $_SESSION['user_type'] = $request->user_type;
       $users=$_SESSION['user_type'];
       $countries=Country::orderby('id','asc')->get();
       if($users==1){
       return view('auth.accountType',["users"=>$users]);
       }else{
        return view('auth.customerRegister',["users"=>$users,"countries"=>$countries]);
       }
    }

     public function create_account_form(Request $request)
    {
       $_SESSION['account_type'] = $request->account_type;
       $_SESSION['user_type'] = $request->user_type;
       $countries=Country::orderby('id','asc')->get();
       $business_types=BusinessType::orderby('id','asc')->get();
       $account_type=$_SESSION['account_type'];
       return view('auth.createAccount',["account_type"=>$account_type,"countries"=>$countries,"business_types"=>$business_types]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Customer
     */
    protected function create(array $data)
    { 
        return $this->customerRepo->createCustomer($data);
    }
 
 /**
     * @param CreateCustomerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */

     public function customer_account(Request $request)
    { 

        $input= $request->all();
    
        $validator = Validator::make(
            $request->all(),
            [
               'first_name'             => 'required',
                'last_name'             => 'required',
                'email'                 => 'required|email|max:255|unique:customers',
                'password'              => 'required|min:6|max:30',
                'password_confirmation' => 'required|same:password',
                'national_id'         => 'required',
                'dob'         => 'required',
                'gender'     => 'required',
                'phone_number'          => 'required|min:10|max:10',
                'country'               => 'required',
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
                'national_id.required'              => trans('validation.national_idRequired'),
                'dob.required'        => trans('validation.dobRequired'),
                'gender.required'            => trans('validation.genderRequired'),
                'country.required'           => trans('validation.countryRequired'),
                'agree.required'            => trans('validation.agreeRequired'),
                'phone_number.required'              => trans('validation.phone_numberRequired'),
                'phone_number.min'                 => trans('validation.phone_numberInvalid'),
                'phone_number.max'                 => trans('validation.phone_numberInvalid'),
                'password_confirmation.same'                 => trans('validation.password_confirmationInvalid'),
                
            ]
        );
       //validation failed
        
    if($validator->fails()) {
        
        return back()->withErrors($validator)->withInput();
    }
    if($input['type']== 'customer')
    {
        $merchant_id='';
       

    }else {
        $merchant_id=$input['merchant_id'];
      
    }
    $firstStringCharacter = substr(ucfirst($input['first_name']), 0, 1);
    $lastStringCharacter = substr(ucfirst($input['last_name']), 0, 1);
    $chars = "0123456789";
    $customer = substr( str_shuffle( $chars ), 0, 6 );
    $customer_id = $firstStringCharacter.$lastStringCharacter.$customer;
    $user = Customer::create([
        'display_name' => $input['first_name'],
        'first_name' => $input['first_name'],
        'last_name' => $input['last_name'],
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
        'national_id' => $input['national_id'],
        'dob' => $input['dob'],
        'gender' => $input['gender'],
        'phone_number' => $input['phone_number'],
        'country' => $input['country'],
        'agree' => $input['agree'],
        'citrus_customer_id' => $customer_id,
        'user_type' => $input['user_type'],
        'merchant_id' => $merchant_id,
        
        
    ]);
   
    // event(new Registered($user));
    
    if($input['type']== 'customer')
    {
         $Id=$user->id;
         $app_name=getenv('APP_NAME');

         $html="<div style='background-color:rgb(255,255,255);margin:0;font:12px/16px Arial,sans-serif;'>
           <table dir='ltr' style='width:640px;color:rgb(51,51,51);margin:0 auto;border-collapse:collapse;border:solid #ddddddb5 2px;'>
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
                                            <td style='font-size:20px;padding:11px 18px 18px 18px;width:100%;vertical-align:top;line-height:20px;font-family:Arial,sans-serif; text-align:center'>
                                               <p style='margin:2px 0 9px 0;font:20px Arial,sans-serif'> <b style='color:#fff'> Thank you for signing up with Citrus. Here is everything you need to know.</b> </p>
                                            </td>
                                         </tr>
                                         <tr>
                                           <td>
                                             <h2 style='color:#206080;line-height: 1;padding-top: 20px;text-align: center;'>WELCOME TO THE CITRUS FAMILY!</h2>
                                           </td>
                                         </tr>
                                      </tbody>
                                   </table>
                                </td>
                             </tr>

                             <tr>
                                <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                   <table style='width:100%;border-collapse:collapse'>
                                   </table>
                                </td>
                             </tr>
                                <tr>
                                <td style='vertical-align:top;font-size:12px;padding:0 0 20px 20px; line-height:16px;font-family:Arial,sans-serif'>
                                   <table style='width:100%;border-collapse:collapse'>
                                      <tbody>
                                         <tr>
                                            <td style='vertical-align:top;padding-bottom: 21px !important;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                               <h3 style='font-size:18px;color:#206080;margin:15px 0 0 0;font-weight:normal'> Hello - ".$input['first_name']." ".$input['last_name']."</h3>
                                               <p style='margin:5px 0 0 0;font:12px/16px Arial,sans-serif'> Click on Verify Email to activate your account </p>
                                            </td>
                                         </tr>
                                         <tr>
                                            <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'> </td>
                                         </tr>
                                         <tr>
                                            <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif'><p style='color:#206080;margin:0;'><b>Email:</b>".$input['email']." </p> </td>
                                         </tr>
                                         <tr>
                                            <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif'><p style='color:#206080;'><b>Password: </b> ".$input['password']."</p> </td>
                                         </tr>
                                      </tbody>
                                   </table>
                                </td>
                             </tr>
                             
                                <tr>
                                <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                   <h3 style='font-size:18px;color:#000;font-weight:600;padding: 20px 15px;background: #ddddddb5'>Email verification</h3>
                                </td>
                             </tr>
                            
                        
                                <td style='padding-left:15px;vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                   <table style='width:95%;border-collapse:collapse'>
                                      <tbody>
                                         <tr>
                                            <td style='width:70%;text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> 
                                                <a style='text-decoration: none;border: 1px solid black;font-weight: 700;padding: 12px 25px; margin-top: 10px; font-size:16px;background-color: #206080;color:#93EB8B;' href= ' ". route('register.emailVerifyByUser', $Id) . " ' >Verify Email </a>
                                            </td>
                                         </tr>
                                         <tr>
                                            <td style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'>
                                               <p style='margin:4px 0 0 0;font:12px/16px Arial,sans-serif'></p>
                                            </td>
                                         </tr>
                                         <tr>
                                            <td style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'>
                                               <p style='margin:4px 0 0 0;font:12px/16px Arial,sans-serif'></p>
                                            </td>
                                         </tr>
                                         <tr>
                                            <td colspan='2' style='padding:0 0 16px 0;text-align:left!important;line-height:18px;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'></td>
                                         </tr>
                                         <tr>
                                            <td colspan='2' style='border-top:1px solid rgb(234,234,234);padding:0 0 16px 0;text-align:left!important;line-height:18px;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'></td>
                                         </tr>
                                      </tbody>
                                   </table>
                                </td>
                             </tr>                    
                             <tr>
                                <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                   <table style='width:100%;padding:0 0 0 0;border-collapse:collapse'>
                                      <tbody>
                                         <tr>
                                           <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                             <p style='padding:0 0 20px 15px;margin:10px 0 0 0;font:14px Arial,sans-serif'>Happy shopping and thank you for supporting local businesses! - <span style='font-size:14px;font-weight:bold'> <a style='color: #206080; text-decoration: none;' href='#'><strong>The ".getenv('APP_SHORT_NAME')." Team</strong> </a></span>
                                          </td>
                                         </tr>
                                         <tr>
                                           <td style='vertical-align:top;padding-bottom: 15px;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                               <p style='padding:0 0 10px 15px;margin:0 0 0 0;font:14px Arial,sans-serif'>Having technical issues? Please contact us at support@citrus and we will be happy to help! </p>
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
        

         $emails = $input['email'];
        $subject = 'Registration';
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

    Alert::success(trans('validation.createSuccess'), 'success');    
    return redirect('login')->with('message', 'Registration done successfully! Your email verification link has been sent to your register email address. Please verify first then login.');
    }
    if($input['type']== 'merchant')
    {
    return redirect()->back()->with('message', trans('validation.createCustomer'));
     }

      if($input['type']== 'staff')
    {
    return redirect()->route('admin.customers.list')->with('success', trans('validation.createCustomer'));
     }
 }



    /**
     * @param RegisterCustomerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterCustomerRequest $request)
    {
      
        $customer = $this->create($request->except('_method', '_token'));
        $emaill = $customer->email ;
        
        $name = $customer->name ;
        $pass = $request->password;
        $Id   = $customer->id ;

        // $app_name=getenv('APP_NAME');;

        // // $customer->sendEmailVerificationNotification();
        // $html="<div style='background-color:rgb(255,255,255);margin:0;font:12px/16px Arial,sans-serif;'>
        //    <table dir='ltr' style='width:640px;color:rgb(51,51,51);margin:0 auto;border-collapse:collapse;border:solid #ddddddb5 2px;'>
        //       <tbody>
        //          <tr>
        //             <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
        //                <table id='m_-7134114449099840045m_5739355418147783239main' style='width:100%;border-collapse:collapse'>
        //                   <tbody>
                           
        //                      <tr>
        //                         <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
        //                            <table style='width:100%;border-collapse:collapse'>
        //                               <tbody>
        //                                  <tr style='background-color:#93EB8B'>
        //                                     <td style='font-size:20px;padding:11px 18px 18px 18px;width:100%;vertical-align:top;line-height:20px;font-family:Arial,sans-serif; text-align:center'>
        //                                        <p style='margin:2px 0 9px 0;font:20px Arial,sans-serif'> <b style='color:#fff'> Thank you for signing up with BuyVi. Here is everything you need to know.</b> </p>
        //                                     </td>
        //                                  </tr>
        //                                  <tr>
        //                                    <td>
        //                                      <h2 style='color:#206080;line-height: 1;padding-top: 20px;text-align: center;'>WELCOME TO THE ".getenv('APP_NAME')." FAMILY!</h2>
        //                                    </td>
        //                                  </tr>
        //                               </tbody>
        //                            </table>
        //                         </td>
        //                      </tr>

        //                      <tr>
        //                         <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
        //                            <table style='width:100%;border-collapse:collapse'>
        //                            </table>
        //                         </td>
        //                      </tr>
        //                         <tr>
        //                         <td style='vertical-align:top;font-size:12px;padding:0 0 20px 20px; line-height:16px;font-family:Arial,sans-serif'>
        //                            <table style='width:100%;border-collapse:collapse'>
        //                               <tbody>
        //                                  <tr>
        //                                     <td style='vertical-align:top;padding-bottom: 21px !important;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
        //                                        <h3 style='font-size:18px;color:#206080;margin:15px 0 0 0;font-weight:normal'> Hello - ".$name."</h3>
        //                                        <p style='margin:5px 0 0 0;font:12px/16px Arial,sans-serif'> Click on Verify Email to activate your account </p>
        //                                     </td>
        //                                  </tr>
        //                                  <tr>
        //                                     <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'> </td>
        //                                  </tr>
        //                                  <tr>
        //                                     <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif'><p style='color:#206080;margin:0;'><b>Email:</b>".$emaill." </p> </td>
        //                                  </tr>
        //                                  <tr>
        //                                     <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif'><p style='color:#206080;'><b>Password: </b> ".$pass."</p> </td>
        //                                  </tr>
        //                               </tbody>
        //                            </table>
        //                         </td>
        //                      </tr>
                             
        //                         <tr>
        //                         <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
        //                            <h3 style='font-size:18px;color:#000;font-weight:600;padding: 20px 15px;background: #ddddddb5'>Email verification</h3>
        //                         </td>
        //                      </tr>
                            
                        
        //                         <td style='padding-left:15px;vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
        //                            <table style='width:95%;border-collapse:collapse'>
        //                               <tbody>
        //                                  <tr>
        //                                     <td style='width:70%;text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> 
        //                                         <a style='text-decoration: none;border: 1px solid black;font-weight: 700;padding: 12px 25px; margin-top: 10px; font-size:16px;background-color: #206080;color:#93EB8B;' href= ' ". route('register.emailVerifyByUser', $Id) . " ' >Verify Email </a>
        //                                     </td>
        //                                  </tr>
        //                                  <tr>
        //                                     <td style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'>
        //                                        <p style='margin:4px 0 0 0;font:12px/16px Arial,sans-serif'></p>
        //                                     </td>
        //                                  </tr>
        //                                  <tr>
        //                                     <td style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'>
        //                                        <p style='margin:4px 0 0 0;font:12px/16px Arial,sans-serif'></p>
        //                                     </td>
        //                                  </tr>
        //                                  <tr>
        //                                     <td colspan='2' style='padding:0 0 16px 0;text-align:left!important;line-height:18px;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'></td>
        //                                  </tr>
        //                                  <tr>
        //                                     <td colspan='2' style='border-top:1px solid rgb(234,234,234);padding:0 0 16px 0;text-align:left!important;line-height:18px;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'></td>
        //                                  </tr>
        //                               </tbody>
        //                            </table>
        //                         </td>
        //                      </tr>                    
        //                      <tr>
        //                         <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
        //                            <table style='width:100%;padding:0 0 0 0;border-collapse:collapse'>
        //                               <tbody>
        //                                  <tr>
        //                                    <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
        //                                      <p style='padding:0 0 20px 15px;margin:10px 0 0 0;font:14px Arial,sans-serif'>Happy shopping and thank you for supporting local businesses! - <span style='font-size:14px;font-weight:bold'> <a style='color: #206080; text-decoration: none;' href='#'><strong>The ".getenv('APP_SHORT_NAME')." Team</strong> </a></span>
        //                                   </td>
        //                                  </tr>
        //                                  <tr>
        //                                    <td style='vertical-align:top;padding-bottom: 15px;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
        //                                        <p style='padding:0 0 10px 15px;margin:0 0 0 0;font:14px Arial,sans-serif'>Having technical issues? Please contact us at support@buyvi.ca and we will be happy to help! </p>
        //                                     </td>
        //                                  </tr>
        //                               </tbody>
        //                            </table>
        //                         </td>
        //                      </tr>
                          
        //                   </tbody>
        //                </table>
        //             </td>
        //          </tr>
        //       </tbody>
        //    </table>
        // </div>";
       
        // $emails = $emaill;
        // $subject = 'Now You Can Shop Local with Buyvi.ca!';
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



        return redirect()->route('register')->with('message', 'Register successfully. Before proceeding please check your email for verification link.');
       

       //return redirect()->route('register')->with(array('message' => 'Register successfully. Before proceeding please check your email for verification link.If you did not get email yet, please click <a href="'.url('register/confirm/resend/'.$lastInsertedId).'">for resend verification email</a>'));


    }
    
    public function emailVerifyByUser($Id)
    {
        // echo "string"; print_r($Id); die();
        $date = date('Y-m-d H:i:s');
        $res = ['status'=>1,'email_verified_at'=>$date];
        DB::table('customers')->where('id', $Id)->update($res);
        return redirect()->route('login')->with('message', 'Account verified successfully. Please login');
    }

    
   public function verification(int $id)
    {
print_r('szxxs'); die();
       $verify = Customer::where('id', $id)->update(['email_verified_at' => Carbon::now()]);
       return redirect()->route('login')->with('message', 'Email verification done successfully. Please login');

    }

}
