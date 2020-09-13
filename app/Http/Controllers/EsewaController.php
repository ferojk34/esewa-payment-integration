<?php

namespace App\Http\Controllers;

use App\Order;
use App\Payment;
use Illuminate\Http\Request;

class EsewaController extends Controller
{
    public function esewaCheckoutApi(Request $request)
    {
        $ref_id ='tiplearn-'.str_random(5); 
        
        $payment = new Payment();
        $payment->ref_id = $ref_id ;
        $payment->payment_type = 'eSewa';
        $payment->total_price = 1;  // from session we will get total_price . ok.
        $payment->first_name = $request->first_name;
        $payment->last_name = $request->last_name;
        $payment->country = $request->country;
        $payment->district = $request->district;
        $payment->city = $request->city;
        $payment->street_address = $request->street_address;
        $payment->email = $request->email;
        $payment->phone =  $request->phone;
        $payment->save();
        
        $orders = [
            '1' => ['quantity' => 2],
            '2' => ['quantity' => 3]
        ];
        foreach($orders as $product_id => $product){
            Order::create([
                "ref_id" => $ref_id, 
                "product_id" => $product_id,
                "quantity" => $product['quantity']     
                ]);
            };
            
            return response()->json([
                'id' => $payment->id,
                'total_price' => $payment->total_price,
                'ref_id' => $payment->ref_id
                ]);
            }

            public function success(Request $request)
            {
                $oid = $_GET['oid'];
                $ref = $_GET['refId'];
                $fraudcheck_url = 'https://esewa.com.np/epay/transrec';
        
                $payment = Payment::where("ref_id", $oid)->firstorfail();
        
                $data = [
                    'amt' => $payment->total_price,
                    'rid' => $ref,
                    'pid' => $oid,
                    'scd' => 'Dummy Merchant ID' // please use your own merchant id...
                ];
        
                $curl = curl_init($fraudcheck_url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curl);
        
                curl_close($curl);
        
                if (strpos($response, "Success") !== false) {
                    if (isset($payment)) {
                        $data1 = ([
                            'paid_status' => '1',
                            'payment_type' => 'eSewa'
                        ]);
        
                        Payment::where('ref_id', $oid)->update($data1);
                        // Session::forget('cart');
                    }
                    return redirect('success-page');
                }
                else{
                    return redirect('fail-page');
                }
            }
        
            public function failure()
            {
                return redirect('/');
            }
        
        }
