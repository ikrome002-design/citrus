<?php

namespace App\Shop\Employees\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Employees\Employee;
use App\Shop\Employees\Exceptions\EmployeeNotFoundException;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Mail;
use SendGrid;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    /**
     * EmployeeRepository constructor.
     *
     * @param Employee $employee
     */
    public function __construct(Employee $employee)
    {
        parent::__construct($employee);
        $this->model = $employee;
    }

    /**
     * List all the employees
     *
     * @param string $order
     * @param string $sort
     *
     * @return Collection
     */
     public function listEmployees(string $order = 'id', string $sort = 'desc', string $role_id = '2'): Collection
    {   
        $listEmployees = DB::table('employees')->where('id','<>', 1)->get();
        return $listEmployees;
        // return $this->all(['*'], $order, $sort);
    }


    /**
     * Create the employee
     *
     * @param array $data
     *
     * @return Employee
     */
    public function createEmployee(array $data): Employee
    {   

if ( isset( $data['avatar'] ) ) {
         
             $data['avatar'] = $data['avatar']->getClientOriginalName();
        }
        $email = $data['email'];
        $name = $data['name'];
        $password = $data['password'];

        if($data['role']==2){
          $data['type'] = 1;
          $role='Staff';
        }else{
          $role='Staff';
        }


        if($data['status']=='1'){
          $status='Approved';
        }else{
          $status='Unapproved';
        }

   
      // $html="<div style='background-color:rgb(255,255,255);margin:0;font:12px/16px Arial,sans-serif'>
      //     <img src=''>
      //      <table dir='ltr' style='width:640px;color:rgb(51,51,51);margin:0 auto;border-collapse:collapse;border: 2px solid;    border-color: #e7e7e7;'>
      //         <tbody>
      //            <tr>
      //               <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
      //                  <table id='m_-7134114449099840045m_5739355418147783239main' style='width:100%;border-collapse:collapse'>
      //                     <tbody>
      //                        <tr>
      //                           <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;display:none;'>
      //                              <table id='m_-7134114449099840045m_5739355418147783239header' style='width:100%;border-collapse:collapse'>
      //                                 <tbody>
      //                                    <tr>
      //                                       <td colspan='3' style='text-align:right;padding:0px 0 5px 0;vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif;display: none;'>
      //                                         <img src=''>
      //                                       </td>
      //                                    </tr>
      //                                 </tbody>
      //                              </table>
      //                           </td>
      //                        </tr>
      //                        <tr>
      //                         <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
      //                            <table style='width:100%;border-collapse:collapse'>
      //                               <tbody>
      //                                  <tr style='background-color:#93EB8B'>
      //                                     <td style='font-size:14px;padding:11px 18px 18px 18px;width:50%;vertical-align:top;line-height:16px;font-family:Arial,sans-serif'>
      //                                        <h1 style='color:#fff; text-align: center;'>Here is your staff account information.</h1>
      //                                     </td>
      //                                  </tr>
      //                                  <tr>
      //                                    <td>
      //                                      <h2 style='color:#206080;line-height: 1;text-align: center;'>YOUR STAFF ACCOUNT LOGIN INFORMATION</h2>
      //                                    </td>
      //                                    </tr>
      //                               </tbody>
      //                            </table>
      //                         </td>
      //                      </tr>
      //                        <tr>
      //                           <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif;padding: 0px 18px 0px 20px;'>
      //                              <table style='width:100%;border-collapse:collapse'>
      //                                 <tbody>
      //                                    <tr>
      //                                       <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
      //                                          <h3 style='font-size:18px;margin:15px 0 0 0;font-weight:normal'> Hello $name,</h3>
      //                                          <h4 style='margin:5px 0 0 0;color:#206080;font:16px Arial,sans-serif'> Please keep this email for your records as it holds all the important information you need to access your staff account. </h4>
      //                                       </td>
      //                                    </tr>
      //                                    <tr>
      //                                       <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'> </td>
      //                                    </tr>
      //                                 </tbody>
      //                              </table>
      //                           </td>
      //                        </tr>
      //                        <tr>
      //                           <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif;padding: 0px 18px 0px 20px;'>
      //                              <table style='width:100%;border-collapse:collapse'> 
      //                              </table>
      //                           </td>
      //                        </tr>
      //                        <tr>
      //                         <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
      //                            <h3 style='font-size:18px;color:#000;font-weight:600;padding: 20px 15px;background: #ddddddb5'>Here are the details of the account below:</h3>
      //                         </td>
      //                      </tr>     
      //                         <tr>
      //                         <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif;'>
      //                            <table style='width:100%;border-collapse:collapse; margin-bottom: 12px !important;'>
      //                               <tbody>
      //                                  <tr>
      //                                     <td style='padding-left: 15px;color:#206080;vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'> Email : <a href=''>$email</a>  
      //                                     </td>
      //                                  </tr>
      //                                  <tr>
      //                                     <td style='padding-left: 15px;color:#206080;vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'> Password : <a href=''>$password</a>  </td>
      //                                  </tr>
      //                                  <tr>
      //                                     <td style='width:70%;text-align:left!important;line-height:60px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> 
      //                                         <a style='text-decoration: none;border: 1px solid black;padding: 10px;font-weight: 700;background-color: #206080;color:#93EB8B;' href= ' ". route('admin.login') . " ' >LOGIN TO YOUR STAFF ACCOUNT </a>
      //                                     </td>
      //                                   </tr>
      //                               </tbody>
      //                            </table>
      //                         </td>
      //                      </tr>
      //                        <tr>
      //                           <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
      //                              <table style='width:100%;padding:0 0 0 0;border-collapse:collapse'>
      //                                 <tbody>
      //                                    <tr>
      //                                       <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
      //                                          <p style='padding:0 0 20px 15px;margin:10px 0 0 0;font:12px/16px Arial,sans-serif'> Having technical issues? Please contact us at support@buyvi.ca</p>
      //                                       </td>
      //                                    </tr>
      //                                 </tbody>
      //                              </table>
      //                           </td>
      //                        </tr>
                          
      //                     </tbody>
      //                  </table>
      //               </td>
      //            </tr>
      //         </tbody>
      //      </table>
           
      //   </div>";


      
      // $subject = 'Your BuyVi staff account is ready!';
      // $senderEmail = getenv('SENDGRID_EMAIL'); //SENDER_EMAIL

      // $senderName = getenv('APP_NAME'); //SENDER_NAME

      // /** An array to store the status codes for all emails to have a record of all successful emails */
      // $emailReports = [];
      // $addressesArray = $email;
      // $email = new SendGrid\Mail\Mail();
      // $email->setFrom($senderEmail, $senderName);
      // $email->setSubject($subject);
      // $email->addTo($addressesArray);
      // $email->addContent("text/html", $html );
      // $apiKey = getenv('SENDGRID_API_KEY');
      // $sendgrid = new \SendGrid($apiKey);
      
      // try {
      //     $response = $sendgrid->send($email);
      //     array_push($emailReports, $addressesArray . " => " . $response->statusCode());
           
      // } catch (Exception $e) {
      //     echo 'Caught exception: ',  $e->getMessage(), "\n";
      // }

        $data['password'] = Hash::make($data['password']);
        $type=$data['type'];
        return $this->create($data);
    }

    /**
     * Find the employee by id
     *
     * @param int $id
     *
     * @return Employee
     */
    public function findEmployeeById(int $id): Employee
    {   
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new EmployeeNotFoundException;
        }
    }

    /**
     * Find the employee by id
     *
     * @param int $id
     *
     * @return Employee
     */
    public function findEmployeeByEmail(string $email): Employee
    {
        try {
            return $this->findOneOrFail($email);
        } catch (ModelNotFoundException $e) {
            throw new EmployeeNotFoundException;
        }
    }


    /**
     * Update employee
     *
     * @param array $params
     *
     * @return bool
     */
    public function updateEmployee(array $params): bool
    {   
        if ( !isset( $params['avatar'] ) && isset( $params['avatar_old'] ) ) {
            $params['avatar'] = $params['avatar_old'];
        }elseif( isset( $params['avatar'] ) ){
            $params['avatar'] = $params['avatar']->getClientOriginalName();
           
        }
        if (isset($params['password'])) {
            $params['password'] = Hash::make($params['password']);
        }
        return $this->update($params);
    }

    /**
     * @param array $roleIds
     */
    public function syncRoles(array $roleIds)
    {
        $this->model->roles()->sync($roleIds);
    }

    /**
     * @return Collection
     */
    public function listRoles(): Collection
    {
        return $this->model->roles()->get();
    }

    /**
     * @param string $roleName
     *
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->model->hasRole($roleName);
    }

    /**
     * @param Employee $employee
     *
     * @return bool
     */
    public function isAuthUser(Employee $employee): bool
    {
      //echo "<pre>"; print_r(Auth::guard('vendor')->user()->id); die();
        $isAuthUser = false;
        if (Auth::guard('employee')->user()->id == $employee->id) {
            $isAuthUser = true;
        }
        return $isAuthUser;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteEmployee() : bool
    {   
        return $this->delete();
        
    }
}
