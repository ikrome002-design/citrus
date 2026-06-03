<?php namespace App\Http\Controllers\Auth;

use App\Shop\Customers\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mailer\AppMailer;
use Illuminate\Foundation\Auth\VerifiesEmails;

class ResendVerification extends Controller {

    public function resendVerification($id, AppMailer $mailer) {
        $user = User::where('id',$id)->firstOrFail();
        if ($user->activated === 0){
            //email the user there key
            $mailer->sendEmailConfirmationTo($user);
            $message = ('We just sent you the verification link at your email ('.$user->email.') again, please check it.');
            return view('auth.message')->with('message',$message);
        }
        else {
            return redirect('/')->withErrors(array('message' => 'Your Email is already active, please contact us at muteweb.com if you have any problem.'));
        }
    }

}