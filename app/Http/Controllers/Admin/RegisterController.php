<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Shop\Admins\Requests\CreateEmployeeRequest;
use App\Shop\Employees\Requests\CreateEmployeeBusinessRequest;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Shop\Roles\Repositories\RoleRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use App\Employee;
use App\BusinessDetails;
use App\Shop\Customers\Customer;
use App\Shop\Countries\Country;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    /**
     * @var EmployeeRepositoryInterface
     */
    private $employeeRepo;
    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepo;

    /**
     * EmployeeController constructor.
     *
     * @param EmployeeRepositoryInterface $employeeRepository
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->employeeRepo = $employeeRepository;
        $this->roleRepo = $roleRepository;
    }


    public function showRegisterForm()
    {
        if (auth()->guard('employee')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.admin.register');
    }

    public function showBusinessRegisterForm()
    {
        if (auth()->guard('employee')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.admin.business_register');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CreateEmployeeRequest $request)
    {
        $employee = $this->employeeRepo->createEmployee($request->all());
        if ($request->has('role')) {
            $employeeRepo = new EmployeeRepository($employee);
            $employeeRepo->syncRoles([$request->input('role')]);
        }

        return redirect()->route('admin.login')->with('message', 'Register successfully');
    }

    public function business_register(CreateEmployeeBusinessRequest $request)
    {
        
        $input['employee_id']=$request->employee_id;
        $input['business_name']=$request->business_name;
        $input['office_address']=$request->office_address;
        $BusinessDetails = BusinessDetails::create($input); 
        $BusinessDetails->save();
        return redirect()->route('admin.business.register')->with('message', 'Business details successfully');
    }


     public function reply_msg(request $request)
    {  

      $reply_id=$_POST['reply_id'];
      $msg=$_POST['msg'];
      $vendor_id=$_POST['vendor_id'];
      $created_at=$_POST['created_at'];
      date_default_timezone_set("Asia/Kolkata");
      $replied_at=date('Y-m-d h:i:s');

        $this->validate(request(), [
            
            'msg' => 'required',
            
        ]);

     $data=DB::table('vendor_msg')->insert(
     array(
                
            'msg'       =>   $msg,
            'vendor_id' =>  $vendor_id,
            'reply_id'  =>  $reply_id,
            'created_at'    =>  $created_at
     )
    );

    DB::table('vendor_msg')->where('id', $reply_id)->update(array('status' => 'replied', 'msg_id' => $msg, 'replied_at' => $replied_at)); 

    return redirect()->back()->with('message', 'Reply send successfully.');
    
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
    
        $merchant_id=$input['merchant_id'];
        //$staff_id=$input['staff_id'];
    
    $firstStringCharacter = substr($input['first_name'], 0, 1);
    $lastStringCharacter = substr($input['last_name'], 0, 1);
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
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
        //'staff_id' => $staff_id,
        
    ]);
    
    return redirect()->route('admin.customers.list')->with('success', trans('validation.createCustomer'));
    
 }

}
