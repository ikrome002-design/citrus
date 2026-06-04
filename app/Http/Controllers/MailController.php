<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailDemo;
use Symfony\Component\HttpFoundation\Response;


class MailController extends Controller {
    
    public function sendEmail() {
        $email = env('MAIL_DEMO_TO', config('mail.from.address'));
   
        $mailData = [
            'title' => 'Demo Email',
            'url' => 'https://www.google.com'
        ];
  
        Mail::to($email)->send(new EmailDemo($mailData));
 
        return response()->json([
            'message' => 'Email has been sent.'
        ], Response::HTTP_OK);


    }

}
