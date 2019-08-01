<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
/* use \Yabacon\Paystack;
use Notification;
use App\Notifications\AdminNewOrder;
use App\Notifications\BuyerOrderNotification;
use Yabacon\Paystack\Exception\ApiException;
use Illuminate\Http\Request;
use App\Billing\Payment;
use App\Order; */

class TransactionVerifyController extends Controller
{
    
    
    public function verify($reference, Request $request) {

     dd($request);
        $result = array();

        //The parameter after verify/ is the transaction reference to be verified
        $url = 'https://api.paystack.co/transaction/verify/'. $reference;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
        $ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '. env('PAYSTACK_SECRET_KEY')]
        );
        $request = curl_exec($ch);
        if(curl_error($ch)){
        echo 'error:' . curl_error($ch);
        }
        curl_close($ch);

        if ($request) {
        $result = json_decode($request, true);
        }

        if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {

            $paid_amount = $result['data']['amount'] / 100;
            // return response()->json($result['data']);
            if(Auth::user()->level < 1) {
                // return response()->json($result['data']);
               return $this->onlinePaymentActivate($paid_amount);
            }else {
                return $this->upgradeOnlinePayment($paid_amount);
            }
           
        }else{
            return response()->json([
                'message' => 'Transaction was unsuccessful',
                'success' => false
            ], 401);
        }

    }
    
    
    
    
    public function __invoke($tranx_ref, Payment $payment, Order $order)
    {
       
         $transaction = $payment->verifyResponse($tranx_ref);

         dd($transaction);

        if($transaction->data->status === 'success'){

            //dd($transaction);
           // $savedorder = $order->storeOrder($transaction);

            Notification::route('mail', config('site.support-email'))
            ->notify(new AdminNewOrder($savedorder));

            Notification::route('mail', $transaction->data->metadata->email)
            ->notify(new BuyerOrderNotification($savedorder));


            return response()->json($transaction);
        }

        return response()->json('transaction failed');
         
    }
}


$email = $result['data']['email'];
$amount = $result['data']['amount'];
$name = $result['data']['name'] ;
$phone = $result['data']['phone'];
$contestant = $result['data']['contestant'];
$votes = $result['data']['number_of_votes'] ;

return response()->json($result['data']);
//$dada = response()->json($result['data']);

//$datas = Voters:: create($dada);
// return response()->json($result['data']);


// axios.get(`/verify-transaction/${response.reference}`).
$.ajax({
    //url: '/verify-transaction/'+ response.reference , 
    //method: 'GET'
}).done(function(data) {
  window.location.href = "https://www.example.com" ;
        //location.reload();
    
}).fail(function(err) {

    swal("Opps!", err.message, "error");
    alert('success. transaction ref is 2 ' + response.reference);
  
})
