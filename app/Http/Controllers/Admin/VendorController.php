<?php

namespace App\Http\Controllers\Admin;

use App\VendorBusinessDetail; 
use App\VendorCanadianPost; 
use App\Vendor;
use App\Shop\Countries\Country;
use App\BusinessType;
use App\Shop\Vendors\Requests\CreateVendorRequest;
use App\Shop\Admins\Requests\UpdateVendorRequest;
use App\Shop\Vendors\Requests\UpdateProfileRequest;
use App\Shop\Vendors\Repositories\VendorRepository;
use App\Shop\Vendors\Repositories\Interfaces\VendorRepositoryInterface;
use App\Shop\Roles\Repositories\RoleRepositoryInterface;
use App\Shop\Memberships\Repositories\MembershipRepository;
use App\Shop\Memberships\Repositories\Interfaces\MembershipRepositoryInterface;
use App\Shop\Taxes\Repositories\TaxRepository;
use App\Shop\Taxes\Repositories\Interfaces\TaxRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use SendGrid;


class VendorController extends Controller
{
     /**
     * @var VendorRepositoryInterface
     */
    private $vendorRepo;
    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepo;
    /**
     * VendorController constructor.
     *
     * @param VendorRepositoryInterface $vendorRepository
     
     */
    public function __construct(
        VendorRepositoryInterface $vendorRepository,
        MembershipRepositoryInterface $membershipRepository, 
        TaxRepositoryInterface $taxRepository,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->vendorRepo = $vendorRepository;
        $this->roleRepo = $roleRepository;
        $this->membershipRepo = $membershipRepository;
        $this->taxRepo = $taxRepository;
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$list = $this->vendorRepo->listVendors('created_at', 'desc');
        $vendor = DB::table('vendors')->join('business_type', 'vendors.business_type', '=', 'business_type.id')->select('business_type.id AS bid','business_type.title AS btitle','vendors.*')->orderBy('vendors.id', 'desc')
           ->get();
       
        $vendor_count =count($vendor);
        $best_plan ='';
        $plan_type1='';
        $plan_type2='';
        $revenue_total= '';
     
        // $best_plan = DB::table('vendors')
        //    ->leftJoin('memberships','vendors.plan_id','=','memberships.id')
        //    ->select('memberships.id','memberships.name','vendors.name as vendor_name','vendors.id',DB::raw('COUNT(vendors.plan_id) as total'))
        //    ->groupBy('memberships.id','vendors.plan_id','memberships.name')
        //    ->orderBy('total','desc')
        //    ->limit(1)
        //    ->first(); 

        //    $plan_type1 = DB::table('vendors')
        //    ->join('memberships', 'vendors.plan_id', '=', 'memberships.id')
        //    ->select('vendors.*', 'vendors.id as vendor_id', 'memberships.*', 'vendors.name as vendor_name', DB::raw('SUM(memberships.monthly_initial_price) as total'))
        //     ->where('vendors.plan_variant', 1)
        //    ->orderBy('vendors.id', 'desc')
        //    ->first();

        //     $plan_type2 = DB::table('vendors')
        //    ->join('memberships', 'vendors.plan_id', '=', 'memberships.id')
        //    ->select('vendors.*', 'vendors.id as vendor_id', 'memberships.*', 'vendors.name as vendor_name', DB::raw('SUM(memberships.yearly_initial_price) as total'))
        //     ->where('vendors.plan_variant', 2)
        //    ->orderBy('vendors.id', 'desc')
        //    ->first(); 

        //    $revenue_total= ($plan_type1->total+$plan_type2->total); 

           $order =  DB::table('order_product')->orderBy('id', 'desc')->get();
           $order_count=count($order);
          
          return view('admin.vendors.list',['vendors' => $this->vendorRepo->paginateArrayResults($vendor->all()), "vendor_count" => $vendor_count, "best_plan" => $best_plan, "revenue_total" => $revenue_total, "order_count" => $order_count]);        

 }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clients()
    {   
       
        $id = auth('employee')->user()->id;
        $list = DB::table('vendors')->get();
        $list = DB::table('vendors')
            ->join('memberships', 'vendors.plan_id', '=', 'memberships.id')
            ->select('vendors.*', 'vendors.id as vendor_id', 'vendors.name as vendor_name', 'vendors.created_at as register_date', 'memberships.*', 'memberships.name as membership_name')
            ->where('vendors.staff_id', $id)
            ->get();

       $list1 = DB::table('vendors')
            ->join('memberships', 'vendors.plan_id', '=', 'memberships.id')
            ->select('vendors.*', 'vendors.id as vendor_id', 'vendors.name as vendor_name', 'vendors.created_at as register_date', 'memberships.*', 'memberships.name as membership_name')
            ->where('vendors.staff_id', $id)
            ->where('vendors.payment_status', 0)
            ->get();   
        $list_count=count($list1);  
    
        return view('admin.clients.list', [
            'clients' => $list,
            'list_count' => $list_count
        ]);
    }

     /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function clientShow(int $id)
    {
        $list = $this->vendorRepo->listVendors('created_at', 'desc');

        return view('admin.clients.show', [
            'clients' => $this->vendorRepo->paginateArrayResults($list->all())
        ]);
    }


   /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function clientEdit(int $id)
    {
        $client = DB::table('vendors')
            ->join('vendor_business_details', 'vendors.id', '=', 'vendor_business_details.vendor_id')
            ->select('vendors.*', 'vendor_business_details.*')
            ->where('vendors.id', $id)
            ->first();

        $plan = $this->membershipRepo->findMembershipById($client->plan_id);
        $tax = $this->taxRepo->findTaxById($plan->tax_id);
        return view('admin.clients.edit',[
            'client' => $client,
            'plan'=>$plan,
            'tax'=>$tax
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVendorRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function clientUpdate(UpdateVendorRequest $request, $id)
    {   
        $client = $this->vendorRepo->findVendorById($id);
     
        $clientRepo = new VendorRepository($client);
        $clientRepo->updateVendor($request->except('_token', '_method', 'password'));
        $vendorbusinessDetailCreate = VendorBusinessDetail::where('vendor_id', $id)->update($request->except('_token', '_method', 'password', 'plan_id', 'mission_description', 'do_for_you', 'business_name', 'business_year', 'name', 'manager_name', 'initial_discount')); 

        return redirect()->route('admin.manage.client')->with('message', 'Update successful');
    }
    


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function staffVendorList()
    { 
      $id = auth('employee')->user()->id;
        $vendor = DB::table('vendors')
           ->join('memberships', 'vendors.plan_id', '=', 'memberships.id')
           ->join('vendor_business_details', 'vendors.id', '=', 'vendor_business_details.vendor_id')
           ->select('vendors.*', 'vendors.id as vendor_id', 'memberships.*', 'vendors.name as vendor_name', 'vendor_business_details.*')
           ->where('vendors.staff_id', $id)
           ->orderBy('vendor_name', 'asc')
           ->get();

       
        $vendor_count =count($vendor);
     
        $best_plan = DB::table('vendors')
           ->leftJoin('memberships','vendors.plan_id','=','memberships.id')
           ->select('memberships.id','memberships.name','vendors.name as vendor_name','vendors.id',
                DB::raw('COUNT(vendors.plan_id) as total'))
           ->where('vendors.staff_id', $id)
           ->groupBy('memberships.id','vendors.plan_id','memberships.name')
           ->orderBy('total','desc')
           ->limit(1)
           ->first();  
           if(!empty($best_plan)){
             $best_plan=$best_plan->name;
           }else{
            $best_plan='';
           }

          


           $plan_type1 = DB::table('vendors')
           ->join('memberships', 'vendors.plan_id', '=', 'memberships.id')
           ->select('vendors.*', 'vendors.id as vendor_id', 'memberships.*', 'vendors.name as vendor_name', DB::raw('SUM(memberships.monthly_initial_price) as total'))
            ->where('vendors.plan_variant', 1)
            ->where('vendors.staff_id', $id)
           ->orderBy('vendors.id', 'desc')
           ->first();


            $plan_type2 = DB::table('vendors')
           ->join('memberships', 'vendors.plan_id', '=', 'memberships.id')
           ->select('vendors.*', 'vendors.id as vendor_id', 'memberships.*', 'vendors.name as vendor_name', DB::raw('SUM(memberships.yearly_initial_price) as total'))
            ->where('vendors.plan_variant', 2)
            ->where('vendors.staff_id', $id)
           ->orderBy('vendors.id', 'desc')
           ->first(); 


           $revenue_total= ($plan_type1->total+$plan_type2->total); 

           $order =  DB::table('order_product')
            ->join('vendors', 'vendors.id', '=', 'order_product.vendor_id')
            ->where('vendors.staff_id', $id)
           ->orderBy('order_product.id', 'desc')
           ->get();
           $order_count=count($order);


//echo "<pre>"; print_r($tt); die();
           return view('admin.vendors.staffVendorList',["vendors" =>$this->vendorRepo->paginateArrayResults($vendor->all()), "vendor_count" => $vendor_count, "best_plan" => $best_plan, "revenue_total" => $revenue_total, "order_count" => $order_count]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function staffVendorCreate()
    {
        $memberships = DB::table('memberships')->get();  
        $roles = $this->roleRepo->listRoles();
        return view('admin.vendors.staffVendorCreate', compact('roles'),  ['memberships' => $memberships]);
    }
    public function staffVendorSave()
    {
        $Id = auth('employee')->user()->id;
        $plan_id=$_POST['plan_id'];
        $plan_variant=$_POST['plan_variant'];
        $plan = DB::table('memberships')->where('id', $plan_id)->first();  
        $memberships = DB::table('memberships')->get();  

        $roles = $this->roleRepo->listRoles();
        $tax = $this->taxRepo->findTaxById($plan->tax_id);
        return view('admin.vendors.staffVendorCreate', compact('roles'),  ['memberships' => $memberships,'plan_id' => $plan_id, 'plan_variant' => $plan_variant, 'plan' => $plan, 'tax' => $tax, 'StId' => $Id]);   
    }
    /**
    * Store a newly created resource in storage.
    *
    * @param  Request $request
    *
    * @return \Illuminate\Http\Response
    */

    public function staffVendorAdd(Request $request)
    {
        $stId=$_POST['stId'];
        $password=$_POST['password'];
        $password=Hash::make($password);
        $plan_id=$_POST['plan_id'];
        $mission_description=$_POST['mission_description'];
        $do_for_you=$_POST['do_for_you'];
        $email=$_POST['email'];
        $business_name=$_POST['business_name'];
        $business_year=$_POST['business_year'];   
        $name=$_POST['name'];
        
        $plan_variant=$_POST['plan_variant'];
        $phone=$_POST['cell_number'];
        $created=date("Y-m-d H:i:s");
        
        $role = 'Vendor';
        $status = 'Unapproved';
        $payment_status='1';
        $own_by_vancouver=$_POST['own_by_vancouver'];
        //$head_office_vancouver=$_POST['head_office_vancouver'];
        //$local_community=$_POST['local_community'];
        $gst_no=$_POST['gst_no'];  
        $pst_no=$_POST['pst_no']; 

        $address=$_POST['address'];
        $city=$_POST['city'];
        $state=$_POST['state'];
        $postal_code=$_POST['postal_code'];
        $office_number=$_POST['office_number'];
        $cell_number=$_POST['cell_number'];
        $billing_address=$_POST['billing_address'];   
        $billing_city=$_POST['billing_city'];
        $billing_state=$_POST['billing_state'];
        $billing_postal_code=$_POST['billing_postal_code'];
        $billing_office_number=$_POST['billing_office_number'];
        $billing_cell_number=$_POST['billing_cell_number'];
        $validator = Validator::make($request->all(), [
            'email' => 'unique:vendors|email|max:255',
        ]); 
        if($validator->fails())
        {
            return redirect()->route('admin.staff.staffVendorCreate')->with('message', 'Email already exist !'); 
        }      
        $values = array('password' => $password, 'plan_id' => $plan_id, 'mission_description' => $mission_description, 'do_for_you' => $do_for_you, 'email' => $email, 'business_name' => $business_name, 'business_year' => $business_year, 'name' => $name, 'plan_variant' => $plan_variant, 'staff_id' =>$stId, 'phone' => $phone,'created_at' => $created,'payment_status'=>$payment_status);
        $id=DB::table('vendors')->insertGetId($values);

        $bdetail = array('vendor_id' => $id, 'own_by_vancouver' => $own_by_vancouver, 'gst_no' => $gst_no, 'pst_no' => $pst_no, 'address' => $address, 'city' => $city, 'state' => $state, 'postal_code' => $postal_code, 'office_number' => $office_number, 'cell_number' => $cell_number, 'billing_address' => $billing_address, 'billing_city' => $billing_city, 'billing_state' => $billing_state, 'billing_postal_code' => $billing_postal_code, 'billing_office_number' => $billing_office_number, 'billing_cell_number' => $billing_cell_number,'created_at' => $created);
        DB::table('vendor_business_details')->insert($bdetail);
        
        $memberships = DB::table('memberships')->where('id',$plan_id)->first(); 
        $data['date'] = date('Y-m-d');
        $dt = strtotime(date("Y-m-d"));
        if($plan_variant==1){
            $expiry_date = date("Y-m-d", strtotime("+1 month", $dt));
        }else{
            $expiry_date = date("Y-m-d", strtotime("+1 year", $dt));
        }
          $html="<div style='background-color:rgb(255,255,255);margin:0;font:12px/16px Arial,sans-serif'>
          <img src=''>
           <table dir='ltr' style='width:640px;color:rgb(51,51,51);margin:0 auto;border-collapse:collapse;border: 2px solid;    border-color: #e7e7e7;'>
              <tbody>
                 <tr>
                    <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif'>
                       <table id='m_-7134114449099840045m_5739355418147783239main' style='width:100%;border-collapse:collapse'>
                          <tbody>
                             <tr>
                                <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
                                   <table id='m_-7134114449099840045m_5739355418147783239header' style='width:100%;border-collapse:collapse'>
                                      <tbody>
                                         <tr>
                                            <td colspan='3' style='text-align:right;padding:0px 0 5px 0;vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif display: none;'>
                                              <img src=''>
                                            </td>
                                         </tr>
                                      </tbody>
                                   </table>
                                </td>
                             </tr>
                             <tr>
                              <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif'>
                                 <table style='width:100%;border-collapse:collapse'>
                                    <tbody>
                                       <tr style='background-color: #206080;'>
                                          <td style='font-size:14px;padding:11px 18px 18px 18px;width:50%;vertical-align:top;line-height:16px;font-family:Arial,sans-serif'>
                                             <h1 style='color:#93eb8b;line-height: 1;text-align: center;'>Thank you for signing up with ".getenv('APP_SHORT_NAME')." Here is everything you need to know.</h1>
                                          </td>
                                          
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                             <tr>
                                <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif;padding: 0px 18px 0px 20px;'>
                                   <table style='width:100%;border-collapse:collapse'>
                                      <tbody>
                                       <tr>
                                          <td style='padding-top: 15px;vertical-align:top;font-size:16px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif;text-align: center;'> WELCOME TO THE BUYVI.CA FAMILY!   
                                          </td>
                                       </tr> 
                                         <tr>
                                            <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
                                               <h3 style='font-size:16px;margin:15px 0 0 0;font-weight:normal'> Hello $name,</h3>
                                               <br/>
                                               <h4 style='margin:5px 0 0 0;font:16px Arial,sans-serif'>Congratulations on joining our Vancouver Island exclusive Shop Local-Support Local platform!</h4>
                                            </td>
                                         </tr>
                                         <tr>
                                            <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif'>
                                            </td>
                                         </tr>
                                      </tbody>
                                   </table>
                                </td>
                             </tr>
                             <tr>
                                <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif;padding: 0px 18px 0px 20px;'>
                                   <table style='width:100%;border-collapse:collapse'> 
                                   </table>
                                </td>
                             </tr>
                             <tr>
                              <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
                                 <h3 style='font-size:16px;color:#206080;font-weight:600;padding: 20px 15px;line-height: 1;background: #ddddddb5'>Please keep this email for your records as it holds all the important information you need to access your account.</h3>
                              </td>
                           </tr>     
                              <tr>
                              <td style='vertical-align:top;font-size:16px;line-height:16px;font-family:Arial,sans-serif;'>
                                 <table style='width:100%;border-collapse:collapse; margin-bottom: 12px !important;'>
                                    <tbody>
                                       <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:16px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif'> Email : <a href='' style='font-weight: 400;'>$email</a>  
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:16px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif;padding: 0 0 15px 15px;'> Password : <a href=''>$request->password</a>  
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:16px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif;padding: 0 0 15px 15px;'> Plan Type: <a href=''>
                                          ".$memberships->name."</a>  
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:16px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif;padding: 0 0 15px 15px;'> You’re plan will renew on: <a href=''>".date("F d, Y", strtotime($expiry_date))."</a>  
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:16px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif;padding: 0 0 15px 15px;'> Vendor Login: <a href=''> Please use this login area to set up your vendor profile. (it’s easy!) This is also where are you get access to your orders and manage your products and services. </a>  
                                          </td>
                                       </tr>
                                       <tr>
                                         <td colspan='2' align='center'>
                                         <a href=' ".route("vendor.login")." ' style='color:#93EB8B;background:#206080;text-decoration: none;font-weight: 500;padding: 10px 30px;line-height: 5;'>ACCESS VENDOR LOGIN</a></td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                                 <hr>
                             <tr>
                                <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif'>
                                   <table style='width:100%;padding:0 0 0 0;border-collapse:collapse'>
                                      <tbody>
                                         <tr>
                                            <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif'>
                                               <p style='padding:0 0 20px 15px;margin:10px 0 0 0;font:12px/16px Arial,sans-serif'> We are excited to have you as a member of our collective and wish you all the best! – The BuyVi Team! <br> 
                                                 Having technical issues? Please contact us at support@buyvi.ca and we will be happy to help! Don’t forget to include your name and company name. <br> 
                                               <span style='font-size:20px;font-weight:bold'> <a style='color: #206080; text-decoration: none;' href=''><strong>".getenv('APP_NAME')."</strong> </a></span> </p>
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
           <img src=''>
        </div>";

        $emails = $request->email;
        $phone = $request->phone;

        $subject = 'You Are Now a Vendor with BuyVi.ca!';
        $senderEmail = getenv('SENDGRID_EMAIL'); 
        $senderName = getenv('APP_NAME'); 
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

      return redirect()->route('admin.staff.staffVendorCreate')->with('message', 'Vendor created successfully');  
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function staffVendorShow(int $id)
    { 
        $id = $id;
        $vendor = DB::table('vendors')
           ->join('vendor_business_details', 'vendors.id', '=', 'vendor_business_details.vendor_id')
           ->select('vendors.*', 'vendor_business_details.*')
            ->where('vendors.id',$id)
           ->first();
        return view('admin.vendors.staffVendorShow', ['vendor_details' => $vendor]);
    }
    public function updateStaffVendorList(Request $request)
    {

        $id = $_POST['id'];
        $type = $_POST['type'];
        if($type == 'business')
        {
            $business_name=$_POST['business_name'];
            $business_year=$_POST['business_year'];
            $name=$_POST['name'];
            
            $gst_no=$_POST['gst_no'];
            $pst_no=$_POST['pst_no'];
            $address=$_POST['address']; 
            $vendor_business_details = DB::table('vendor_business_details')->where('vendor_business_details.vendor_id', $id)->update(['gst_no' => $gst_no, 'pst_no' => $pst_no, 'address' => $address]);
            $vendor_details = DB::table('vendors')->where('vendors.id', $id)->update(['business_name' => $business_name, 'business_year' => $business_year, 'name' => $name]);
            return redirect()->route('admin.staff.staffVendorShow', $id)->with('message', 'Your business details updated successfully');
        }

        if($type == 'billing')
        {
            $billing_address=$_POST['billing_address'];
            $billing_city=$_POST['billing_city'];
            $billing_state=$_POST['billing_state'];
            $billing_postal_code=$_POST['billing_postal_code'];
            $billing_office_number=$_POST['billing_office_number'];
            $billing_cell_number=$_POST['billing_cell_number'];

            $vendor_billing_details = DB::table('vendor_business_details')->where('vendor_business_details.vendor_id', $id)->update(['billing_address' => $billing_address, 'billing_city' => $billing_city, 'billing_state' => $billing_state, 'billing_postal_code' => $billing_postal_code, 'billing_office_number' => $billing_office_number, 'billing_cell_number' => $billing_cell_number]);

            return redirect()->route('admin.staff.staffVendorShow', $id)->with('message', 'Your billing details updated successfully');
        }
        if($type == 'account'){
             $account_holder=$_POST['account_holder'];
             $account_no=$_POST['account_no'];
             //$ifsc_code=$_POST['ifsc_code'];
             $branch_address=$_POST['branch_address'];
            
             $vendor_billing_details = DB::table('vendor_business_details')->where('vendor_business_details.vendor_id', $id)->update(['account_holder' => $account_holder, 'account_no' => $account_no, 'branch_address' => $branch_address]);

            return redirect()->route('admin.staff.staffVendorShow', $id)->with('message', 'Your account details updated successfully');
        }
        if($type == 'profile'){
            $short_description=$_POST['short_description'];
            $mission_description=$_POST['mission_description'];
            $story=$_POST['story'];
            if(isset($request->image)){ 
                $request->validate([
                    'image' => 'mimes:jpeg,png,jpg,gif,svg',
                ]);
            $imageName = time().'.'.$request->image->extension();  
            $tt=$request->image->move(public_path('storage'), $imageName);
            $vendor_profile_details = DB::table('vendors')->where('vendors.id', $id)->update(['short_description' => $short_description, 'mission_description' => $mission_description, 'story' => $story, 'cover_image' => $imageName]);
            }
            else{
            $vendor_profile_details = DB::table('vendors')->where('vendors.id', $id)->update(['short_description' => $short_description, 'mission_description' => $mission_description, 'story' => $story]);
            }
            return redirect()->route('admin.staff.staffVendorShow', $id)->with('message', 'Your profile details updated successfully');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $memberships = DB::table('memberships')->get();  
        $roles = $this->roleRepo->listRoles();
        return view('admin.vendors.create', compact('roles'),  ['memberships' => $memberships]);
    }
    public function create1()
    {
        $Id = auth('employee')->user()->id;

        $plan_id=$_POST['plan_id'];
        $plan_variant=$_POST['plan_variant'];
        $plan = DB::table('memberships')->where('id', $plan_id)->first();  
        $memberships = DB::table('memberships')->get();  

        $roles = $this->roleRepo->listRoles();
        $tax = $this->taxRepo->findTaxById($plan->tax_id);
        return view('admin.vendors.create', compact('roles'),  ['memberships' => $memberships,'plan_id' => $plan_id, 'plan_variant' => $plan_variant, 'plan' => $plan, 'tax' => $tax, 'StId' => $Id]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  Request $request
    *
    * @return \Illuminate\Http\Response
    */

    public function vendoradd(Request $request)
    {

        $stId=$_POST['stId'];
        $password=$_POST['password'];
        $password=Hash::make($password);
        $plan_id=$_POST['plan_id'];
        $mission_description=$_POST['mission_description'];
        $do_for_you=$_POST['do_for_you'];
        $email=$_POST['email'];
        $business_name=$_POST['business_name'];
        $business_year=$_POST['business_year'];   
        $name=$_POST['name'];
        $manager_name=$_POST['manager_name'];
        $plan_variant=$_POST['plan_variant'];
        $phone=$_POST['cell_number'];
        $created=date("Y-m-d H:i:s");

        $role = 'Vendor';
        $status = 'Unapproved';
        $payment_status = '1';

        $own_by_vancouver=$_POST['own_by_vancouver'];
        //$head_office_vancouver=$_POST['head_office_vancouver'];
        //$local_community=$_POST['local_community'];
        $gst_no=$_POST['gst_no'];  
        $pst_no=$_POST['pst_no']; 

        $address=$_POST['address'];
        $city=$_POST['city'];
        $state=$_POST['state'];
        $postal_code=$_POST['postal_code'];
        $office_number=$_POST['office_number'];
        $cell_number=$_POST['cell_number'];
        $billing_address=$_POST['billing_address'];   
        $billing_city=$_POST['billing_city'];
        $billing_state=$_POST['billing_state'];
        $billing_postal_code=$_POST['billing_postal_code'];
        $billing_office_number=$_POST['billing_office_number'];
        $billing_cell_number=$_POST['billing_cell_number'];
        $validator = Validator::make($request->all(), [
            'email' => 'unique:vendors|email|max:255',
        ]); 
        if($validator->fails())
        {
            return redirect()->route('admin.vendors.create')->with('message', 'Email already exist !'); 
        }      



        $values = array('password' => $password, 'plan_id' => $plan_id, 'mission_description' => $mission_description, 'do_for_you' => $do_for_you, 'email' => $email, 'business_name' => $business_name, 'business_year' => $business_year, 'name' => $name, 'manager_name' => $manager_name, 'plan_variant' => $plan_variant, 'staff_id' =>$stId, 'phone' => $phone,'created_at' => $created,'payment_status'=>$payment_status);

        $id=DB::table('vendors')->insertGetId($values);

        $bdetail = array('vendor_id' => $id, 'own_by_vancouver' => $own_by_vancouver, 'gst_no' => $gst_no, 'pst_no' => $pst_no, 'address' => $address, 'city' => $city, 'state' => $state, 'postal_code' => $postal_code, 'office_number' => $office_number, 'cell_number' => $cell_number, 'billing_address' => $billing_address, 'billing_city' => $billing_city, 'billing_state' => $billing_state, 'billing_postal_code' => $billing_postal_code, 'billing_office_number' => $billing_office_number, 'billing_cell_number' => $billing_cell_number,'created_at' => $created);
        DB::table('vendor_business_details')->insert($bdetail);
        
        $memberships = DB::table('memberships')->where('id',$plan_id)->first(); 
        $data['date'] = date('Y-m-d');
        $dt = strtotime(date("Y-m-d"));
        if($plan_variant==1){
            $expiry_date = date("Y-m-d", strtotime("+1 month", $dt));
        }else{
            $expiry_date = date("Y-m-d", strtotime("+1 year", $dt));
        }

        $html="<div style='background-color:rgb(255,255,255);margin:0;font:12px/16px Arial,sans-serif'>
          <img src=''>
           <table dir='ltr' style='width:640px;color:rgb(51,51,51);margin:0 auto;border-collapse:collapse;border: 2px solid;    border-color: #e7e7e7;'>
              <tbody>
                 <tr>
                    <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif'>
                       <table id='m_-7134114449099840045m_5739355418147783239main' style='width:100%;border-collapse:collapse'>
                          <tbody>
                             <tr>
                                <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
                                   <table id='m_-7134114449099840045m_5739355418147783239header' style='width:100%;border-collapse:collapse'>
                                      <tbody>
                                         <tr>
                                            <td colspan='3' style='text-align:right;padding:0px 0 5px 0;vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif display: none;'>
                                              <img src=''>
                                            </td>
                                         </tr>
                                      </tbody>
                                   </table>
                                </td>
                             </tr>
                             <tr>
                              <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif'>
                                 <table style='width:100%;border-collapse:collapse'>
                                    <tbody>
                                       <tr style='background-color: #206080;'>
                                          <td style='font-size:14px;padding:11px 18px 18px 18px;width:50%;vertical-align:top;line-height:16px;font-family:Arial,sans-serif'>
                                             <h1 style='color:#93eb8b;line-height: 1;text-align: center;'>Thank you for signing up with ".getenv('APP_SHORT_NAME')." Here is everything you need to know.</h1>
                                          </td>
                                          
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                             <tr>
                                <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif;padding: 0px 18px 0px 20px;'>
                                   <table style='width:100%;border-collapse:collapse'>
                                      <tbody>
                                       <tr>
                                          <td style='padding-top: 15px;vertical-align:top;font-size:16px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif;text-align: center;'> WELCOME TO THE BUYVI.CA FAMILY!   
                                          </td>
                                       </tr> 
                                         <tr>
                                            <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
                                               <h3 style='font-size:16px;margin:15px 0 0 0;font-weight:normal'> Hello $name,</h3>
                                               <br/>
                                               <h4 style='margin:5px 0 0 0;font:16px Arial,sans-serif'>Congratulations on joining our Vancouver Island exclusive Shop Local-Support Local platform!</h4>
                                            </td>
                                         </tr>
                                         <tr>
                                            <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif'>
                                            </td>
                                         </tr>
                                      </tbody>
                                   </table>
                                </td>
                             </tr>
                             <tr>
                                <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif;padding: 0px 18px 0px 20px;'>
                                   <table style='width:100%;border-collapse:collapse'> 
                                   </table>
                                </td>
                             </tr>
                             <tr>
                              <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
                                 <h3 style='font-size:16px;color:#206080;font-weight:600;padding: 20px 15px;line-height: 1;background: #ddddddb5'>Please keep this email for your records as it holds all the important information you need to access your account.</h3>
                              </td>
                           </tr>     
                              <tr>
                              <td style='vertical-align:top;font-size:16px;line-height:16px;font-family:Arial,sans-serif;'>
                                 <table style='width:100%;border-collapse:collapse; margin-bottom: 12px !important;'>
                                    <tbody>
                                       <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:16px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif'> Email : <a href='' style='font-weight: 400;'>$email</a>  
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:16px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif;padding: 0 0 15px 15px;'> Password : <a href=''>$request->password</a>  
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:16px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif;padding: 0 0 15px 15px;'> Plan Type: <a href=''>
                                          ".$memberships->name."</a>  
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:16px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif;padding: 0 0 15px 15px;'> You’re plan will renew on: <a href=''>".date("F d, Y", strtotime($expiry_date))."</a>  
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:16px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif;padding: 0 0 15px 15px;'> Vendor Login: <a href=''> Please use this login area to set up your vendor profile. (it’s easy!) This is also where are you get access to your orders and manage your products and services. </a>  
                                          </td>
                                       </tr>
                                       <tr>
                                         <td colspan='2' align='center'>
                                         <a href=' ".route("vendor.login")." ' style='color:#93EB8B;background:#206080;text-decoration: none;font-weight: 500;padding: 10px 30px;line-height: 5;'>ACCESS VENDOR LOGIN</a></td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                                 <hr>
                             <tr>
                                <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif'>
                                   <table style='width:100%;padding:0 0 0 0;border-collapse:collapse'>
                                      <tbody>
                                         <tr>
                                            <td style='vertical-align:top;font-size:14px;line-height:16px;font-family:Arial,sans-serif'>
                                               <p style='padding:0 0 20px 15px;margin:10px 0 0 0;font:12px/16px Arial,sans-serif'> We are excited to have you as a member of our collective and wish you all the best! – The BuyVi Team! <br> 
                                                 Having technical issues? Please contact us at support@buyvi.ca and we will be happy to help! Don’t forget to include your name and company name. <br> 
                                               <span style='font-size:20px;font-weight:bold'> <a style='color: #206080; text-decoration: none;' href=''><strong>".getenv('APP_NAME')."</strong> </a></span> </p>
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
           <img src=''>
        </div>";

        $emails = $request->email;
        $phone = $request->phone;

        $subject = 'You Are Now a Vendor with BuyVi.ca!';
        $senderEmail = getenv('SENDGRID_EMAIL'); 
        $senderName = getenv('APP_NAME'); 
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


        return redirect()->route('admin.vendors.create')->with('message', 'Vendor created successfully');  
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateVendorRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateVendorRequest $request)
    {
        if ($request->has('avatar') && $request->file('avatar') != ''){
            $file = $request->file('avatar');
            request()->validate([
                'avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:548',
            ]);
            $id = DB::table('vendors')->max('id')+1;
            $destinationPath = 'storage/profile/vendors/'.$id;
            $file->move($destinationPath,$file->getClientOriginalName());
        }
        $vendor = $this->vendorRepo->createVendor($request->all());

        if ($request->has('role')) {
            $vendorRepo = new VendorRepository($vendor);
            $vendorRepo->syncRoles([$request->input('role')]);
        }

        return redirect()->route('admin.vendors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    { 
        $id = $id;
        $vendor_details=Vendor::join('countries', 'vendors.country', '=', 'countries.id')->select('countries.id AS cid','countries.name AS cname','vendors.*')->where('vendors.id', $id)->first();
        $galleries = DB::table('gallery')->where('merchant_id',$id)->get();
        return view('admin.vendors.show', ['vendor_details' => $vendor_details,'galleries' => $galleries]);
    }


    public function updatevendorlist(Request $request)
    {


        $id = $_POST['id'];
        $type = $_POST['type'];
        if($type == 'business'){
            $business_name=$_POST['business_name'];
            $business_year=$_POST['business_year'];
            $name=$_POST['name'];
            $gst_no=$_POST['gst_no'];
            $pst_no=$_POST['pst_no'];
            $address=$_POST['address']; 
            $vendor_business_details = DB::table('vendor_business_details')->where('vendor_business_details.vendor_id', $id)->update(['gst_no' => $gst_no, 'pst_no' => $pst_no, 'address' => $address]);

            $vendor_details = DB::table('vendors')->where('vendors.id', $id)->update(['business_name' => $business_name, 'business_year' => $business_year, 'name' => $name]);

            return redirect()->route('admin.vendors.show', $id)->with('message', 'Your business details updated successfully');
        }

        if($type == 'billing'){
            $billing_address=$_POST['billing_address'];
            $billing_city=$_POST['billing_city'];
            $billing_state=$_POST['billing_state'];
            $billing_postal_code=$_POST['billing_postal_code'];
            $billing_office_number=$_POST['billing_office_number'];
            $billing_cell_number=$_POST['billing_cell_number'];

            $vendor_billing_details = DB::table('vendor_business_details')->where('vendor_business_details.vendor_id', $id)->update(['billing_address' => $billing_address, 'billing_city' => $billing_city, 'billing_state' => $billing_state, 'billing_postal_code' => $billing_postal_code, 'billing_office_number' => $billing_office_number, 'billing_cell_number' => $billing_cell_number]);

    
    return redirect()->route('admin.vendors.show', $id)->with('message', 'Your billing details updated successfully');
}
     if($type == 'account'){
     $account_holder=$_POST['account_holder'];
     $account_no=$_POST['account_no'];
     //$ifsc_code=$_POST['ifsc_code'];
     $branch_address=$_POST['branch_address'];
    
     $vendor_billing_details = DB::table('vendor_business_details')->where('vendor_business_details.vendor_id', $id)->update(['account_holder' => $account_holder, 'account_no' => $account_no, 'branch_address' => $branch_address]);

    return redirect()->route('admin.vendors.show', $id)->with('message', 'Your account details updated successfully');
}

     if($type == 'profile'){
            $short_description=$_POST['short_description'];
            $mission_description=$_POST['mission_description'];
            $story=$_POST['story'];
            if(isset($request->image)){ 
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
                ]);
            $imageName = time().'.'.$request->image->extension();  
            $tt=$request->image->move(public_path('storage'), $imageName);
            $vendor_profile_details = DB::table('vendors')->where('vendors.id', $id)->update(['short_description' => $short_description, 'mission_description' => $mission_description, 'story' => $story, 'cover_image' => $imageName]);
            }
            else{
            $vendor_profile_details = DB::table('vendors')->where('vendors.id', $id)->update(['short_description' => $short_description, 'mission_description' => $mission_description, 'story' => $story]);
            }
            return redirect()->route('admin.vendors.show', $id)->with('message', 'Your profile details updated successfully');
        if($type == 'account'){
             $account_holder=$_POST['account_holder'];
             $account_no=$_POST['account_no'];
             $ifsc_code=$_POST['ifsc_code'];
             $branch_address=$_POST['branch_address'];
            
             $vendor_billing_details = DB::table('vendor_business_details')->where('vendor_business_details.vendor_id', $id)->update(['account_holder' => $account_holder, 'account_no' => $account_no, 'ifsc_code' => $ifsc_code, 'branch_address' => $branch_address]);

            return redirect()->route('admin.vendors.show', $id)->with('message', 'Your account details updated successfully');
        }
        
        

    }
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {

    $vendor = $this->vendorRepo->findVendorById($id);
    $roles = $this->roleRepo->listRoles('created_at', 'desc');
    $isCurrentUser = $this->vendorRepo->isAuthUser($vendor);
    
    return view(
        'admin.vendors.edit',
        [
            'vendor' => $vendor,
            'roles' => $roles,
            'isCurrentUser' => $isCurrentUser,
            'selectedIds' => $vendor->roles()->pluck('role_id')->all()
        ]
    );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVendorRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVendorRequest $request, $id)
    {
        $this->validate($request, [
            'phone' => ['numeric', 'nullable', Rule::unique('vendors')->ignore($id)],
            'email' => ['required', 'email', Rule::unique('vendors')->ignore($id)]
        ]);

        $vendor = $this->vendorRepo->findVendorById($id);
        $isCurrentUser = $this->vendorRepo->isAuthUser($vendor);

         if ($request->has('password') && $request->input('password') != '' && $request->input('password') != $request->input('confirm-password') ){
            
            return redirect()->route('admin.vendors.edit', $id)
            ->with('error', 'Password and confirmed password do not match');
        }

        $empRepo = new VendorRepository($vendor);
        $empRepo->updateVendor($request->except('_token', '_method', 'password'));

        if ($request->has('password') && !empty($request->input('password'))) {
            $vendor->password = Hash::make($request->input('password'));
            $vendor->save();
        }

        if ($request->has('roles') and !$isCurrentUser) {
            $vendor->roles()->sync($request->input('roles'));
        } elseif (!$isCurrentUser) {
            $vendor->roles()->detach();
        }

        if ($request->has('avatar') && $request->file('avatar') != ''){
            $file = $request->file('avatar');
            request()->validate([
                'avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:548',
            ]);

            $destinationPath = 'storage/profile/vendors/'.$id;
            $file->move($destinationPath,$file->getClientOriginalName());
        }

        return redirect()->route('admin.vendors.edit', $id)
            ->with('message', 'Update successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        $vendor = $this->vendorRepo->findVendorById($id);
        $vendorRepo = new VendorRepository($vendor);
        $vendorRepo->deleteVendor();
        DB::table("vendors")->where("id", $id)->delete();
        DB::table("role_user")->where([  ['user_id', $id],  ['role_id', 3] ])->delete();

        return redirect()->route('admin.vendors.index')->with('message', 'Delete successful');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProfile()
    {   
        $vendor_id=auth('vendor')->user()->id;
        $vendor = Vendor::join('business_type', 'vendors.business_type', '=', 'business_type.id')
        ->join('countries', 'vendors.country', '=', 'countries.id')
        ->select('business_type.id AS bid','countries.id AS cid','countries.name AS cname','vendors.*','business_type.*')
        ->where('vendors.id', $vendor_id)
        ->first();

        $countries=Country::where('id','!=',$vendor->cid)->orderby('id','asc')->get();
          
        return view('vendor.profile', ['vendor' => $vendor,"countries"=>$countries]);
    }

    /**
     * @param UpdateProfileRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {   

        $id = auth('vendor')->user()->id;
        $vendor = $this->vendorRepo->findVendorById($id);
        $avatar  = $request->file('avatar');

        if ($request->has('password') && $request->input('password') != '' && !password_verify($request->input('old-password'), $vendor->password)){
            return redirect()->route('vendor.profile')
            ->with('error', 'Invalid Old Password');
        }

        if ($request->has('password') && $request->input('password') != '' && $request->input('password') != $request->input('confirm-password') ){
            
            return redirect()->route('vendor.profile')
            ->with('error', 'Password and confirmed password do not match');
        }
        
        if ($request->has('avatar') && $request->file('avatar') != ''){

            $file = $request->file('avatar');
            request()->validate([
                'avatar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:548',
            ]);

            //$destinationPath = 'storage/profile/vendors/'.$id;
            $file->move(public_path('storage/profile/vendors/'),$file->getClientOriginalName());
            $img = $file->getClientOriginalName();
            DB::table('vendors')->where('vendors.id', $id)->update(['avatar' => $img]);
        }

        DB::table('shops')->where('merchant_id', $id)->where('type','default')->update(['location' => $request->business_location]);
        
        $update = new VendorRepository($vendor);
        $update->updateVendor($request->except('_token', '_method', 'password'));
        if ($request->has('password') && $request->input('password') != '') {
            $update->updateVendor($request->only('password'));
        }

        return redirect()->back()->with('message', 'Update successful');
    }


    public function vendorApprove($id) 
    { 
        $vendor = $this->vendorRepo->findVendorById($id);
        if($vendor)
        {
            $vendor->status = 1;
            $vendor->save();
            return redirect()->back()->with('message', 'Approved successfully');
        }
    }

    public function vendorUnapprove($id) 
    {
        $vendor = $this->vendorRepo->findVendorById($id);

        if($vendor)
        {
            $vendor->status = 0;
            $vendor->save();
            return redirect()->back()->with('error', 'Unapproved successfully');
        }
    }
    public function settings() {

       $vendor = Vendor::join('countries', 'vendors.country', '=', 'countries.id')->select('countries.id AS cid','countries.name AS cname','vendors.*')->where('vendors.id', auth('vendor')->user()->id)->first();

        
        $shipping = DB::table('vendor_canadian_posts')->where('vendor_id',auth('vendor')->user()->id)->first();
        $galleries = DB::table('gallery')->where('merchant_id',auth('vendor')->user()->id)->get();
        

 return view('vendor.settings',['vendor_details'=>$vendor,'shipping' => $shipping,'galleries' => $galleries]);
        
    }

    public function updatesetting() {
     $id = auth('vendor')->user()->id;
     $business_name=$_POST['business_name'];
     $business_year=$_POST['business_year'];
     $first_name=$_POST['first_name'];
     $last_name=$_POST['last_name'];
     $business_location=$_POST['business_location']; 
     
     $vendor_details = DB::table('vendors')->where('id', $id)->update(['business_name' => $business_name, 'business_year' => $business_year, 'first_name' => $first_name, 'last_name' => $last_name, 'business_location' => $business_location]);

    return redirect()->route('vendor.settings')->with('message', 'Business information updated successfully');
 }


  public function updatecontact() {
     $id = auth('vendor')->user()->id;
     $contact_address=$_POST['contact_address'];
     $contact_person_name=$_POST['contact_person_name'];
     $contact_no=$_POST['contact_no'];
     $contact_email=$_POST['contact_email'];

     $vendor_details = DB::table('vendors')->where('id', $id)->update(['contact_address' => $contact_address, 'contact_person_name' => $contact_person_name, 'contact_no' => $contact_no, 'contact_email' => $contact_email]);

    return redirect()->route('vendor.settings')->with('message', 'Contact details updated successfully');
 }

 public function updateaccount() {
     $id = auth('vendor')->user()->id;
     $business_about=$_POST['business_about'];
    
     $vendor_details = DB::table('vendors')->where('id', $id)->update(['business_about' => $business_about]);

    return redirect()->route('vendor.settings')->with('message', 'Business about details updated successfully');
 }

  public function updateCompanyOverview() {

     $input['vendor_id']= auth('vendor')->user()->id;
     $input['company_overview']=$_POST['company_overview'];
    
         $company = DB::table('vendors')->where('id', auth('vendor')->user()->id)->update(['company_overview' => $_POST['company_overview']]);
         return redirect()->route('vendor.settings')->with('message', 'Company Overview details updated successfully');
  
 }

   public function updateprofile_detail(Request $request) {
     $id = auth('vendor')->user()->id;
     $short_description=$_POST['short_description'];
     if(isset($request->image)){
     $request->validate([
            'image' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);
  
        $imageName = time().'.'.$request->image->extension();  
   
        $tt=$request->image->move(public_path('storage'), $imageName);

         $vendor_profile_details = DB::table('vendors')->where('vendors.id', $id)->update(['short_description' => $short_description,'cover_image' => $imageName]);

        }
    
      else{
         $vendor_profile_details = DB::table('vendors')->where('vendors.id', $id)->update(['short_description' => $short_description]);
      }
    return redirect()->route('vendor.settings')->with('message', 'Details updated successfully');
 }
 
 public function updategallery_detail(Request $request)
    { 
        $this->validate($request, [
                'image' => 'required',
                
        ]);
  
        $files = [];
        if($request->hasfile('image'))
         {
         
            foreach($request->file('image') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('storage'), $name);  
                $gallery =  DB::table('gallery')->insert([
                    'image' => $name,
                    'merchant_id' => auth('vendor')->user()->id,
        
                ]);
                $files[] = $name; 
                
           
            }
         }
  
        return back()->with('message', 'Gallery image added successfully');
    }

    public function getPlan() {

        $vendor = $this->vendorRepo->findVendorById(auth('vendor')->user()->id);
        //$plan = $this->membershipRepo->findMembershipById($vendor->id);
        $plan =DB::table('vendors')
           ->join('memberships', 'vendors.plan_id', '=', 'memberships.id')
           ->join('vendorplan_info', 'vendors.plan_id', '=', 'vendorplan_info.plan_id')
           ->select('vendors.*', 'memberships.*', 'vendorplan_info.expiry_date')
           ->where('vendors.id',auth('vendor')->user()->id)
           ->first();
        

        if(!empty($plan)){
          $plan_id=$plan->plan_id;
          $allplans = DB::table('memberships')->where('id', '!=', $plan_id)->get(); 
        }else{
          $allplans = DB::table('memberships')->get();
        } 

        return view('vendor.plan',[
            'vendor'=>$vendor,
            'plan'=>$plan,
            'allplans'=>$allplans,
        ]);
            

    }

 public function updateplan() {
    $id = $_POST['id'];
  
    $plan_variant = $_POST['plan_variant'];
    $vendor = $this->vendorRepo->findVendorById($id);
    $plan = $this->membershipRepo->findMembershipById($vendor->plan_id);
    $plan2 = $this->membershipRepo->findMembershipById($_POST['plan_id']);

    if($plan_variant == 0){
      $totAmt = $plan2->yearly_recurring_price;
    }else{
      $totAmt = $plan2->monthly_recurring_price;
    }
    

    $plan_id = $_POST['plan_id'];
    $plan_name = $_POST['plan_name'];
    return view('vendor.vendor_plan_stripe',[
      'id' => $id,
      'vendor' => $vendor,
      'plan' => $plan,
      'totAmt' => $totAmt,
      'plan_id' => $plan_id,
      'plan_name' => $plan_name,
      'plan_variant' => $plan_variant
    ]);
 }

    public function msg()
    {
        //$vendor_msg =  DB::table('vendor_msg')->where('reply_id', NULL)->orderBy('created_at', 'desc')->limit(10)->get();
        $vendor_msg =  DB::table('vendor_msg')
                    ->join('vendors', 'vendors.id', '=', 'vendor_msg.vendor_id')
                    ->select('vendors.first_name','vendors.last_name','vendors.avatar AS vendor_image','vendor_msg.*')
                    ->where('vendor_msg.reply_id', NULL)
                    ->orderBy('vendor_msg.created_at', 'desc')
                    ->limit(10)->get();
        return view('admin.vendors.msg', [
            'vendors' => $this->vendorRepo->paginateArrayResults($vendor_msg->all())
        ]);
    }


    public function vendormsg()
    {
        $uid=auth('vendor')->user()->id;
        $vendor =  DB::table('vendor_msg')
                ->where('vendor_id', $uid)
                ->where('reply_id', NULL)
                ->orderBy('created_at', 'desc')
                ->get();
        // $vendor =  DB::table('vendor_msg')
        //         ->join('employees', 'employees.id', '=', 'vendor_msg.reply_id')
        //         ->select('employees.name','employees.avatar AS subadmin_image','vendor_msg.*')
        //         ->where('vendor_msg.vendor_id', $uid)
        //         ->orwhere('vendor_msg.reply_id', NULL)
        //         ->orderBy('vendor_msg.created_at', 'desc')
        //         ->get();
        return view('vendor.vendormsg', [
            'vendors' => $this->vendorRepo->paginateArrayResults($vendor->all())
        ]);
    }


    public function msgdestroy(int $id)
    {
        $vendor = $this->vendorRepo->findVendorById($id);
        $vendorRepo = new VendorRepository($vendor);
        $vendorRepo->deleteVendor();
        DB::table("vendor_msg")->where("id", $id)->delete();
        DB::table("vendor_msg")->where("reply_id", $id)->delete();

        return redirect()->route('admin.vendors.msg')->with('message', 'Delete successful');
    }


 public function notification()
    {   $id=auth('vendor')->user()->id;
        $update_data=DB::table("vendor_msg")->where('vendor_id', $id)->where('reply_id', NULL)->where('read_status', '1')->update(array('read_status' => '2'));

        return redirect()->route('vendor.vendor_messages');
    }

    public function admin_notification()
    {   
        $update_data=DB::table("vendor_msg")->where('reply_id', NULL)->where('read_status', '0')->update(array('read_status' => '1'));

        return redirect()->route('admin.vendors.messages');
    }

     public function shop_list()
    {
        
        $shops = DB::table('shops')
        ->join('business_type', 'shops.title', '=', 'business_type.id')
        ->select('business_type.title AS business_title','business_type.id AS bid','shops.*')
        ->where('shops.merchant_id', auth('vendor')->user()->id)
        ->orderBy('shops.id','desc')
        ->get();

       
        return view('admin.shop.list', [
            'shops' =>$shops
        ]);
    }

     public function shop_create()
    {
        $business_type=DB::table('business_type')->orderBy('id','desc')->get();
        return view('admin.shop.create', [
            'business_type'=>$business_type
   
        ]);
    }

    public function shop_store(Request $request)
        {
         $business_type=DB::table('business_type')->where('id',$request->title)->first();
        if ($request->has('shop_image') && $request->file('shop_image') != ''){
            $file = $request->file('shop_image');
            request()->validate([
                'shop_image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:548',
            ]);
            
            
            $file->move(public_path('storage/shop/'),$file->getClientOriginalName());
        }
        $img=$_FILES["shop_image"]["name"];
        $input= $request->all();
        $firstStringCharacter = substr(strtoupper($business_type->title), 0, 2);
        $chars = "0123456789";
        $shop = substr( str_shuffle( $chars ), 0, 2 );
        $citrus_shop_id = $firstStringCharacter.'0000'.$shop;
        $user =  DB::table('shops')->insert([
            'title' => $input['title'],
            'location' => $input['location'],
            'merchant_id' => $input['merchant_id'],
            'citrus_shop_id' => $citrus_shop_id,
            'shop_image' => $img,

        ]);


       return redirect()->route('shop.create')->with('message', 'Shop created successfully');
      
      }

      public function shop_edit($id)
    {
       
        $shops=DB::table('shops')
        ->join('business_type', 'shops.title', '=', 'business_type.id')
        ->select('business_type.title AS business_title','business_type.id AS bid','shops.*')
        ->where('shops.id',$id)->first();

        $business_type=DB::table('business_type')->where('id','!=',$shops->bid)->orderBy('id','desc')->get();
        return view('admin.shop.edit', [
            'shops' => $shops,
            'business_type'=>$business_type
   
        ]);
    }

    // public function shop_update(Request $request, $id)
    // {

    //     if ($request->has('shop_image') && $request->file('shop_image') != ''){
    //        $img=$_FILES["shop_image"]["name"];
    //         $file = $request->file('shop_image');
    //         request()->validate([
    //             'shop_image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:548',
    //         ]);
            
            
    //         $file->move(public_path('storage/shop/'),$file->getClientOriginalName());

    //         DB::table('shops')->where('id', $id)->update(['title' => $request->title, 'location' => $request->location, 'shop_image' => $img]);
    //     }else{
    //         DB::table('shops')->where('id', $id)->update(['title' => $request->title, 'location' => $request->location]);
    //     }
       
    //    $shop_count=DB::table('shops')->where('id', $id)->where('type','default')->count();
    //    if($shop_count!=0){

    //     Vendor::where('id', auth('vendor')->user()->id)->update(['business_type' => $request->title, 'business_location' => $request->location]);

    //    }

    //     $request->session()->flash('message', 'Update successful');
    //     return redirect()->route('shop.edit', $id);
    // }

    public function shop_destroy(int $id)
    {
        $shop = DB::table('shops')->where('id', $id);
        $shop->delete();

        request()->session()->flash('message', 'Delete successful');
        return redirect()->route('shop.list');
    }
    
     public function gallery_destroy(int $id)
    {
        $gallery = DB::table('gallery')->where('id', $id);
        $gallery->delete();

        return back()->with('message', 'Gallery image delete successfully');
    }
    
   

      public function sociallink_list()
    {
        $sociallinks = DB::table('sociallinks')->where('merchant_id', auth('vendor')->user()->id)->orderBy('id','desc')->get();

       
        return view('admin.sociallink.list', [
            'sociallinks' =>$sociallinks
        ]);
    }

     public function sociallink_create()
    {
        
        return view('admin.sociallink.create');
    }

    public function sociallink_store(Request $request)
        {

        $input= $request->all();
        
        $user =  DB::table('sociallinks')->insert([
            'title' => $input['title'],
            'link' => $input['link'],
            'merchant_id' => $input['merchant_id'],

        ]);

       return redirect()->route('sociallink.create')->with('message', 'Social link created successfully');
      
      }

      public function sociallink_edit($id)
    {
       
        $sociallink=DB::table('sociallinks')->where('id',$id)->first();
        return view('admin.sociallink.edit', [
            'sociallink' => $sociallink
   
        ]);
    }

    public function sociallink_update(Request $request, $id)
    {
        DB::table('sociallinks')->where('id', $id)->update(['title' => $request->title, 'link' => $request->link]);
    
        $request->session()->flash('message', 'Update successful');
        return redirect()->route('sociallink.edit', $id);
    }

    public function sociallink_destroy(int $id)
    {
        $sociallink = DB::table('sociallinks')->where('id', $id);
        $sociallink->delete();

        request()->session()->flash('message', 'Delete successful');
        return redirect()->route('sociallink.list');
    }



    

}
