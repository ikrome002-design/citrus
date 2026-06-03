<?php 
namespace App\Http\Controllers\Vendor\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be resent if the user did not receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/accounts?tab=profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    { 
        $user_id=$request->route('id');
        $doIt = DB::table('customers')->where('id', $user_id)->update(['status' => 1, 'email_verified_at' => date("Y-m-d H:i:s")]);
        $this->middleware('auth');
        $this->middleware('guest')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

  
}