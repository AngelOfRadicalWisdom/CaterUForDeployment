<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Customer;
//se App\Traits\SMSMethod;

class SMS extends Controller
{
   // use SMSMethod;
    public function sendSMS($phonenumber){

            // $phonenumber = DB::table('customers')
            //                 ->select('phonenumber')
            //                 ->where('custid',$request->custid)->get();

            $customer = Customer::find($custid);
            $customer->status='notified';
            $customer->save();
                           
            $query_string = 'api.aspx?apiusername='.'APIPEG60E2N2X'.'&apipassword='.'APIPEG60E2N2XPEG60';
            $query_string .= '&senderid='.rawurlencode('TEST').'&mobileno='.rawurlencode($phonenumber);
            $query_string .= '&message='.rawurlencode(stripslashes('Your table is ready. Please be present before 5 minutes.')) . "&languagetype=1";        
            $url ='http://gateway.onewaysms.ph:10001/'.$query_string;
            
            $fd = implode('',file($url));      
            if ($fd)  
            {                       
            if ($fd > 0) {
        //	Print("MT ID : " . $fd);
            $ok = "success!";
            }        
            else {
        //	print("Please refer to API on Error : " . $fd);
            $ok = "fail";
            }
                }           
                else      
                {                       
                    // no contact with gateway                      
                            $ok = "failed";       
                }           
                return $ok;  

        // return response()->json([
        //     'message' => $request->phonenumber
        // ]);
    }  
    public function test(Request $request){
        $table = DB::table('tables')
        ->where('status','Available')
        ->where('capacity','>=',$request->capacity)->get();

        return response()->json([
            'table' => $table
        ]);
    }

    //  public function SMSsend(){
    //     // Account details
    //     $apiKey = urlencode('fvMDnRzaSAA-fosqlj14tGPg5MHd3lY0ENycaAbBRY');
        
    //     // Message details
    //     $numbers = array(639222568271);
    //     $sender = urlencode('CATERU');
    //     $message = rawurlencode('Your table is ready');
    
    //     $numbers = implode(',', $numbers);
    
    //     // Prepare data for POST request
    //     $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
    
    //     // Send the POST request with cURL
    //     $ch = curl_init('https://api.txtlocal.com/send/');
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $response = curl_exec($ch);
    //     curl_close($ch);
        
    //     // Process your response here
    //     echo $response;

    // }
 
    

        
}
