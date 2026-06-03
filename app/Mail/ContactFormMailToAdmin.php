<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactFormMailToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {   
        $subject = isset($this->data['formname']) ? $this->data['formname'] : 'Simple Contact Form';
        return $this->view('emails.inquiry.contact-form')
                    ->subject($subject)
                    ->with([ 'form_data' => $this->data ]);
    }
}