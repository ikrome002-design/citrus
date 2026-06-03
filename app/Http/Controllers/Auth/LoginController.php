<?php

namespace App\Http\Controllers\Auth;

use App\Shop\Admins\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Session;
use SendGrid;
use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/accounts?tab=profile';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Login the admin
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        // echo "<pre>"; print_r($request->all());die;
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
       
        $details = $request->only('email', 'password');
        $details['status'] = 1;
        $userData =  DB::table('customers')->where('email', $request->email)->first();  

        $user = $request;
        // event(new Registered($user));

    if(isset($userData))
    { 

      if (Hash::check( $request->password, $userData->password)) {


              if(!empty($userData->email_verified_at))
              {
                 if (auth()->attempt($details)) {

                 Auth::user();
                       return redirect()->route('shop.listing')->with('message', 'Login successfully');
                    
                  }
             }  
             else{

             return redirect()->route('login')->with('error', 'Please verify your email address first then login.');
              }  

       }
             
         
    }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.

        //$this->incrementLoginAttempts($request);


        return $this->sendFailedLoginResponse($request);
    }

    public function ResetPasswordUser(Request $request)
    {
        $emaill = $request->input('email') ; 
        $user_name = DB::table('customers')->where('email', $emaill)->pluck('first_name')->first();

        if (empty($user_name)) {
            return redirect()->route('password.request')
            ->with('error', 'We can not find a user with that e-mail address.');
        }
        $password = str_random(8);
        $hashed_random_password = Hash::make($password);
        $data = array('email'=>$emaill, 'password'=>$password, 'first_name' => $user_name);
        
        $html="<div style='background-color:rgb(255,255,255);max-width: 646px;margin: 0 auto;font:12px/16px Arial,sans-serif;border:solid #ddddddb5 2px;'>
           <table dir='ltr' style='width:640px;color:rgb(51,51,51);margin:0 auto;border-collapse:collapse'>
              <tbody>
                 <tr>
                    <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                       <table id='m_-7134114449099840045m_5739355418147783239main' style='width:100%;border-collapse:collapse'>
                          <tbody>
                           
                             <tr>
                                <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                   <table style='width:100%;border-collapse:collapse'>
                                      <tbody>
                                         <tr style='background-color:#93EB8B'>
                                            <td style='font-size:20px;padding:11px 18px 18px 18px;width:100%;vertical-align:top;line-height:20px;font-family:Arial,sans-serif; text-align:center'>
                                               <p style='margin:2px 0 9px 0;font:20px Arial,sans-serif'> <b style='color:#fff'> This should help!</b> </p>
                                            </td>
                                         </tr>
                                         <tr>
                                           <td>
                                             <h2 style='color:#206080;line-height: 1;text-align: center;'>IT SEEMS YOU FORGOT YOUR PASSWORD</h2>
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
                                <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                   <table style='width:100%;border-collapse:collapse'>
                                      <tbody>
                                         <tr>
                                            <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                               <h3 style='font-size:18px;color:#206080;margin:15px 0 0 0;font-weight:normal'> Hello ".$user_name."! </h3>
                                               <p style='margin:5px 0 0 0;font:12px/16px Arial,sans-serif'> No problem! We’ve got you covered!</p>
                                            </td>
                                         </tr>
                                         <tr>
                                            <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'> </td>
                                         </tr>
                                      </tbody>
                                   </table>
                                </td>
                             </tr>
                             
                            <tr>
                                <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                   <h3 style='font-size:18px;color:#000;font-weight:600;padding: 20px 15px;background: #ddddddb5'>Login Details</h3>
                                </td>
                             </tr>
                                <td style='padding-left:15px;vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                   <table style='width:95%;border-collapse:collapse'>
                                      <tbody>
                                         <tr>
                                            <td style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> Email: </td>
                                            <td style='width:70%;text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> ".$data['email']." </td>
                                         </tr>
                                         <tr>
                                            <td style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> Password: </td>
                                            <td style='width:70%;text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> ".$data['password']." </td>
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
                                               <p style='padding:0 0 20px 15px;margin:10px 0 0 0;font:12px/16px Arial,sans-serif'>Still having technical issues? Please contact us at support@buyvi.ca </p>
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
       
        $emails = $emaill;
        
        $subject = 'Reset Your BuyVi Password';
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

        DB::table('customers')
            ->where('email', $emails)  // find your user by their email
            ->limit(1)  
            ->update(array('password' => $hashed_random_password)); 
        return redirect()->route('password.request')
            ->with('message', 'Password reset succesfully and send to your register email address. Please check your register email address');

    }

     public function logout()
    {
        Auth::logout();
         Session::flush();
        return redirect()->route('login');
    }


}
