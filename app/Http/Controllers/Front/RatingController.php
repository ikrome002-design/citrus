<?php

namespace App\Http\Controllers\Front;

use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Customers\Requests\InsertUserReview;
use App\Shop\Customers\Requests\InsertUserReviewOnVendor;
use App\Http\Controllers\Controller;
use App\productRating;
use DB;
use SendGrid;

class RatingController extends Controller
{

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepo;

    /**
     * RatingController constructor.
     *
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepo = $customerRepository;
    }

    public function index(InsertUserReview $request)
    {
        $customer = $this->customerRepo->findCustomerById(auth()->user()->id);

        $customerRepo = new CustomerRepository($customer);

        $user=auth()->user()->id;
        $input['user_id']=$user;
        $input['product_id']=$request->product_id;
        $input['rating']=$request->rating;
        $input['review']=$request->review;
        $input['vendor_id']=$request->vendor_id;
        $input['status']='1';
        $productRating = productRating::create($input); 
        $productRating->save();

        $ven_id = $input['vendor_id'];
        $vendor = DB::table('vendors')->where('id',$ven_id)->first();

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
                                             <tr style='background-color:#93EB8B'>
                                                <td style='font-size:20px;padding:11px 18px 18px 18px;width:100%;vertical-align:top;line-height:20px;font-family:Arial,sans-serif; text-align:center'>
                                                   <p style='margin:2px 0 9px 0;font:20px Arial,sans-serif'> <b style='color:#fff'>See what they have to say.</b> </p>
                                                </td>
                                             </tr>
                                             <tr>
                                               <td>
                                                 <h2 style='color:#206080;line-height: 1;text-align: center;'>CUSTOMER REVIEW NOTIFICATION</h2>
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
                                                   <h3 style='font-size:18px;color:#206080;margin:15px 0 0 0;font-weight:normal'> Hello ".$vendor->name."! </h3>
                                                   <p style='margin:5px 0 0 0;font:16px Arial,sans-serif'> A customer just posted a new review on your vendor page or one of your products. See what they have to say by clicking below.</p>
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
                                      <td style='width:70%;text-align:left!important;line-height:50px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> 
                                          <a style='text-decoration: none;border: 1px solid black;padding: 10px;font-weight: 700;background-color: #206080;color:#93EB8B;' href= ' ". route('vendor.login')." '>LOGIN TO SEE THE REVIEW </a>
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
        $emails = $vendor->email;
        $subject = 'You Just Received A Review from a Customer!';
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
        return redirect()->back()->with('message', 'Your review has been successfully submitted.');
    }


    public function vendorRating(InsertUserReviewOnVendor $request)
    {
        $customer = $this->customerRepo->findCustomerById(auth()->user()->id);

        $customerRepo = new CustomerRepository($customer);

        $user=auth()->user()->id;
        $input['user_id']=$user;
        $input['vendor_id']=$request->vendor_id;
        $input['rating']=$request->rating;
        $input['review']=$request->review;
          $input['status']='1';
        $productRating = productRating::create($input); 
        $productRating->save();

        $ven_id = $input['vendor_id'];
        $vendor = DB::table('vendors')->where('id',$ven_id)->first();

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
                                             <tr style='background-color:#93EB8B'>
                                                <td style='font-size:20px;padding:11px 18px 18px 18px;width:100%;vertical-align:top;line-height:20px;font-family:Arial,sans-serif; text-align:center'>
                                                   <p style='margin:2px 0 9px 0;font:20px Arial,sans-serif'> <b style='color:#fff'>See what they have to say.</b> </p>
                                                </td>
                                             </tr>
                                             <tr>
                                               <td>
                                                 <h2 style='color:#206080;line-height: 1;text-align: center;'>CUSTOMER REVIEW NOTIFICATION</h2>
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
                                                   <h3 style='font-size:18px;color:#206080;margin:15px 0 0 0;font-weight:normal'> Hello ".$vendor->name."! </h3>
                                                   <p style='margin:5px 0 0 0;font:16px Arial,sans-serif'> A customer just posted a new review on your vendor page or one of your products. See what they have to say by clicking below.</p>
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
                                      <td style='width:70%;text-align:left!important;line-height:50px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> 
                                          <a style='text-decoration: none;border: 1px solid black;padding: 10px;font-weight: 700;background-color: #206080;color:#93EB8B;' href= ' ". route('vendor.login')." '>LOGIN TO SEE THE REVIEW </a>
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
        $emails = $vendor->email;
        $subject = 'You Just Received A Review from a Customer!';
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

        return redirect()->back()->with('message', 'Your review has been successfully submitted.');

    }

   
}