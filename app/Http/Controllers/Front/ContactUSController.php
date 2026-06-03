<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Contact\ContactUS;

class ContactUSController extends Controller
{ 

  public function index(Request $request)
   {  
   	  $contacts = ContactUS::orderBy('id','desc')->get();
        return view('admin.contact.list', [
            'contacts' =>$contacts
        ]);
   }
   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
   public function contactUSPost(Request $request)
   {  
   
    $rules = array(
      
          'name' => 'required',
          'email' => 'required|email',
          'subject' => 'required',
          'message' => 'required',
          
    );

       $this->validate($request, $rules);
       ContactUS::create($request->all());
       $mailData = [
                'message' => $request->message,
                'subject' => $request->subject,    
                'email' => $request->email,
                'name' => $request->name
                
               ];
       Mail::to($request->email)->send(new ContactMail($mailData));
       
       return back()->with('message', 'Thanks for contacting us! We will get back to you soon.');
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function contact_destroy(int $id)
    {
        $contacts =ContactUS::where('id',$id);
        $contacts->delete();

        return back()->with('message', 'Delete successfully.');
    }

   
}