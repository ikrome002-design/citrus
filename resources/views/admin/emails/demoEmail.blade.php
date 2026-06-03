<!DOCTYPE html>
<html>
<head>
    <title>Citrus</title>
</head>
<body>
   

   <div style='background-color:rgb(255,255,255);margin:0;font:12px/16px Arial,sans-serif'>
          <img src=''>
           <table dir='ltr' style='width:640px;color:rgb(51,51,51);margin:0 auto;border-collapse:collapse;border: 2px solid;    border-color: #e7e7e7;'>
              <tbody>
                 <tr>
                    <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                       <table id='m_-7134114449099840045m_5739355418147783239main' style='width:100%;border-collapse:collapse'>
                          <tbody>
                             <tr>
                                <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
                                   <table id='m_-7134114449099840045m_5739355418147783239header' style='width:100%;border-collapse:collapse'>
                                      <tbody>
                                         <tr>
                                            <td colspan='3' style='text-align:right;padding:0px 0 5px 0;vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif display: none;'>
                                              <img src=''>
                                            </td>
                                         </tr>
                                      </tbody>
                                   </table>
                                </td>
                             </tr>
                             <tr>
                              <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                 <table style='width:100%;border-collapse:collapse'>
                                    <tbody>
                                       <tr style='background-color:#93EB8B'>
                                          <td style='font-size:14px;padding:11px 18px 18px 18px;width:50%;vertical-align:top;line-height:16px;font-family:Arial,sans-serif'>
                                             <h1 style='color:#fff;line-height: 1;text-align: center;'>Citrus One time password</h1>
                                          </td>
                                          
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                             <tr>
                                <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif;padding: 0px 18px 0px 20px;'>
                                   <table style='width:100%;border-collapse:collapse'>
                                      <tbody>
                                         <tr>
                                            <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
                                               <h3 style='font-size:18px;margin:15px 0 0 0;font-weight:normal'> Hello {{ $mailData['name'] }},</h3>
                                               <br/>
                                               <h4 style='margin:5px 0 0 0;font:12px/16px Arial,sans-serif'> Thank you for joining our citrus Shop Local-Support Local platform!</h4>
                                            </td>
                                         </tr>
                                         <tr>
                                            <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                            </td>
                                         </tr>
                                      </tbody>
                                   </table>
                                </td>
                             </tr>
                             <tr>
                                <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif;padding: 0px 18px 0px 20px;'>
                                   <table style='width:100%;border-collapse:collapse'> 
                                   </table>
                                </td>
                             </tr>
                             <tr>
                              <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif padding: 0px 18px 0px 20px;'>
                                 <h3 style='font-size:18px;color:#206080;font-weight:600;padding: 20px 15px;line-height: 1;background: #ddddddb5'>Please keep this email for your records as it holds all the important information you need to access your account.</h3>
                              </td>
                           </tr>     
                              <tr>
                              <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif;'>
                                 <table style='width:100%;border-collapse:collapse; margin-bottom: 12px !important;'>
                                    <tbody>
                                      <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:14px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif'>Citrus ID : {{ $mailData['citrus_merchant_id'] }}  
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:14px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif'> OTP : {{ $mailData['newotp'] }}  
                                          </td>
                                       </tr>
                                       
                                       
                                       <tr>
                                          <td style='padding-left: 15px;vertical-align:top;font-size:12px;line-height:16px;font-weight:bold;color:#206080;font-family:Arial,sans-serif'><span style='color:red'>* The OTP will expire in 10 minutes.</span>
                                          </td>
                                       </tr>
                                       
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                                 <hr>
                             <tr>
                                <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                   <table style='width:100%;padding:0 0 0 0;border-collapse:collapse'>
                                      <tbody>
                                         <tr>
                                            <td style='vertical-align:top;font-size:12px;line-height:16px;font-family:Arial,sans-serif'>
                                               <p style='padding:0 0 20px 15px;margin:10px 0 0 0;font:12px/16px Arial,sans-serif'> We are excited to have you as a member of our collective and wish you all the best! – The Citrus Team! <br> 
                                                 Having technical issues? Please contact us at support@citrus.com and we will be happy to help! Don’t forget to include your name and company name. <br> 
                                               <span style='font-size:16px;font-weight:bold'> <a style='color: #000; text-decoration: none;' href=''><strong>{{getenv('APP_NAME')}}</strong> </a></span> </p>
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
         
        </div>
</body>
</html>