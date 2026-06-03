<?php

namespace App\Shop\Vendors\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Vendors\Vendor;
use App\Shop\Vendors\Exceptions\VendorNotFoundException;
use App\Shop\Vendors\Repositories\Interfaces\VendorRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use SendGrid;

class VendorRepository extends BaseRepository implements VendorRepositoryInterface
{
    /**
     * VendorRepository constructor.
     *
     * @param Vendor $vendor
     */
    public function __construct(Vendor $vendor)
    {
        parent::__construct($vendor);
        $this->model = $vendor;
    }

    /**
     * List all the Vendors
     *
     * @param string $order
     * @param string $sort
     *
     * @return Collection
     */
    public function listVendors(string $order = 'id', string $sort = 'desc'): Collection
    {
        return $this->all(['*'], $order, $sort);
    }

    /**
     * Create the employee
     *
     * @param array $data
     *
     * @return Employee
     */
    public function createVendor(array $data): Vendor
    {   

        if( isset( $data['avatar'] ) ){
            $data['avatar'] = $data['avatar']->getClientOriginalName();
        }
        $emaill = $data['email'];

       if($data['role']=='2'){
          $role='Staff';
        }else{
          $role='Vendor';
        }
        if($data['status']=='1'){
          $status='Approved';
        }else{
          $status='Unapproved';
        }
        
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
                                                 <tr style='background-color:#588e43'>
                                                    <td style='font-size:20px;padding:11px 18px 18px 18px;width:100%;vertical-align:top;line-height:20px;font-family:Arial,sans-serif; text-align:center'>
                                                       <p style='margin:2px 0 9px 0;font:20px Arial,sans-serif'> <b style='color:#fff'> Reset Password </b> </p>
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
                                                       <h3 style='font-size:18px;color:#206080;margin:15px 0 0 0;font-weight:normal'> Hello ".$data['name']."! <br />Your account has been created!</h3>
                                                       <p style='margin:5px 0 0 0;font:12px/16px Arial,sans-serif'> Here are the details of the account below: </p>
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
                                           <h3 style='font-size:18px;color:#000;font-weight:600;padding: 20px 15px;background: #ddddddb5'>User Details</h3>
                                        </td>
                                     </tr>
                                    
                                
                                        <td style='padding-left:15px;vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                           <table style='width:95%;border-collapse:collapse'>
                                              <tbody>
                                              <tr>
                                                    <td style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> Name: </td>
                                                    <td style='width:70%;text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> ".$data['name']." </td>
                                                 </tr>
                                                 <tr>
                                                    <td style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> Email: </td>
                                                    <td style='width:70%;text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> ".$emaill." </td>
                                                 </tr>
                                                 <tr>
                                                    <td style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> Password: </td>
                                                    <td style='width:70%;text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> ".$data['password']." </td>
                                                 </tr>

                                                 <tr>
                                                    <td style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> Role: </td>
                                                    <td style='width:70%;text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> ".$role." </td>
                                                 </tr>

                                                  <tr>
                                                    <td style='text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> Status: </td>
                                                    <td style='width:70%;text-align:left!important;line-height:18px;padding:0 10px 0 0;vertical-align:top;font-size:12px;font-family:Arial,sans-serif'> ".$status." </td>
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
                                                       <p style='padding:0 0 20px 15px;margin:10px 0 0 0;font:12px/16px Arial,sans-serif'> We hope to see you again soon. <br> <span style='font-size:16px;font-weight:bold'> <a style='color: #000; text-decoration: none;' href='#'><strong>".getenv('APP_NAME')."</strong> </a></span> </p>
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
        $subject = 'New staff register';
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


        $data['password'] = Hash::make($data['password']);
        return $this->create($data);
    }

    /**
     * Find the Vendor by id
     *
     * @param int $id
     *
     * @return Vendor
     */
    public function findVendorById(int $id): Vendor
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new VendorNotFoundException;
        }
    }

    /**
     * Update Vendor
     *
     * @param array $params
     *
     * @return bool
     */
    public function updateVendor(array $params): bool
    {
        if ( !isset( $params['avatar'] ) && isset( $params['avatar_old'] ) ) {
            $params['avatar'] = $params['avatar_old'];
        }elseif(isset($params['avatar'])){
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
     * @param Vendor $Vendor
     *
     * @return bool
     */
    public function isAuthUser(Vendor $vendor): bool
    {
        $isAuthUser = false;
        if (Auth::guard('employee')->user()->id == $vendor->id) {
            $isAuthUser = true;
        }
        return $isAuthUser;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteVendor() : bool
    {
        return $this->delete();
    }
}
