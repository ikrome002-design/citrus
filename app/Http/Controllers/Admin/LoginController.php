<?php

namespace App\Http\Controllers\Admin;


use App\Shop\Admins\Requests\LoginRequest;
use App\Shop\Employees\Requests\ResetPasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use SendGrid;
use DB;
use Session;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';


    /**
     * Shows the admin login form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        // if (auth()->guard('employee')->check()) {
        //     return redirect()->route('admin.dashboard');
        // }

        return view('auth.admin.login');
    }
    
     public function subadminLoginForm()
    {
        return view('auth.subadmin.login');
    }

   

    /**
     * Login the employee
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
         $email = $request->input('email') ; 
         $password = $request->input('password') ; 
        $deactive_users = DB::table('employees')->where([  ['email', $email],  ['status', 0] ])->pluck('name')->first();
        $users = DB::table('employees')->where([  ['email', $email],  ['status', 1] ])->first();
        
        if (!empty($deactive_users)) {

          return redirect()->route('admin.login')->with('error', 'Your account has been deactivated. Please contact to admin.');

        }else{
            $details = $request->only('email', 'password');
            $details['status'] = 1;
        }
        if (auth()->guard('employee')->attempt($details) && $users->type==0) {
            //return $this->sendLoginResponse($request);
            Auth::user();
           return redirect()->route('admin.dashboard')->with('message', 'Login successfully');
        }else{
            return redirect()->route('admin.login')->with('error', 'These credentials do not match our records.');
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    public function ResetPasswordForm(){
        if (auth()->guard('employee')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.admin.resetpassword');
    }
    
    public function ResetPassword(ResetPasswordRequest $request){
        if (auth()->guard('employee')->check()) {
            return redirect()->route('admin.dashboard');
        }
        $emaill = $request->input('email') ; 
        $user_name = DB::table('employees')->where('email', $emaill)->pluck('name')->first();

        if (empty($user_name)) {

            return redirect()->route('admin.resetpassword')
            ->with('error', 'We can not find a user with that e-mail address.');
        }
        
        $password = str_random(8);
        $hashed_random_password = Hash::make($password);
        $data = array('email'=>$emaill, 'password'=>$password, 'name' => $user_name, 'role'=> 'staff');
        
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
                                               <p style='margin:5px 0 0 0;font:16px Arial,sans-serif'> No problem! We’ve got you covered!</p>
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

        DB::table('employees')
        ->where('email', $emails)  // find your user by their email
        ->limit(1)  
        ->update(array('password' => $hashed_random_password)); 

        return redirect()->route('admin.login')
            ->with('message', 'Password reset succesfully and send to your register email address. Please check your register email address');
    }


      public function logout(Request $request)
    { 
         Auth::logout();
         Session::flush();
         //$this->clearcache($request);
         //apc_clear_cache();
         //$this->session->clean();
         //clearstatcache(true,$request);
        return redirect()->route('admin.login');
    }

      public function staff_logout(Request $request)
    { 
         Auth::logout();
         Session::flush();
        return redirect()->route('staff.login');
    }
    
     public function subadmin_logout(Request $request)
    { 
         Auth::logout();
         Session::flush();
        return redirect()->route('subadmin.login');
    }

    /**
     * Login the employee
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function staff_login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
         $email = $request->input('email') ; 
         $password = $request->input('password') ; 
        $deactive_users = DB::table('employees')->where([  ['email', $email],  ['status', 0] ])->pluck('name')->first();
        $users = DB::table('employees')->where([  ['email', $email],  ['status', 1] ])->first();
        
        if (!empty($deactive_users)) {

          return redirect()->route('admin.login')->with('error', 'Your account has been deactivated. Please contact to admin.');

        }else{
            $details = $request->only('email', 'password');
            $details['status'] = 1;
        }
        if (auth()->guard('employee')->attempt($details) && $users->type==1) {
            //return $this->sendLoginResponse($request);
            Auth::user();
             return redirect()->route('admin.staff_dashboard')->with('message', 'Login successfully');
            
        }else{
            return redirect()->route('staff.login')->with('error', 'These credentials do not match our records.');
            
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    
      public function subadmin_login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
         $email = $request->input('email') ; 
         $password = $request->input('password') ; 
        
        $users = DB::table('employees')->where([  ['email', $email]])->first();
        
       
            $details = $request->only('email', 'password');
            
        
        if (auth()->guard('employee')->attempt($details) && $users->type==2) {
            //return $this->sendLoginResponse($request);
            Auth::user();
             return redirect()->route('admin.subadmin_dashboard')->with('message', 'Login successfully');
            
        }else{
            return redirect()->route('subadmin.login')->with('error', 'These credentials do not match our records.');
            
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

}
