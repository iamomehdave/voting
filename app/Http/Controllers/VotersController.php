<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Voters;

class VotersController extends Controller
{
     function verify($reference, Request $request) {
        // console.log($reference);

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
        //
        //return response()->json($result['data']);
        //{{$request}}
       // console.log(response()->json($result['data'])); 
        if (array_key_exists('data', $result) || array_key_exists('status', $result['data']) || ($result['data']['status'] === 'success')) {
        
            

            $name =   $result['data']['name'];
            $email =  $result['data']['email'];
            $phone =  $result['data']['phone'];
            $amount = $result['data']['amount'];
            $contestant = $result['data']['contestant'];
            $votes =   $result['data']['number_of_votes'];

        DB:: table('voters')->insert(
           ['name' => $name, 'email'=> $email, 'phone'=> $phone, 'contestant' => $contestant, 'votes'=> $votes ]
            );
            // return response()->json($result['data']);
           
        }else{
            return response()->json([
                'message' => 'Transaction was unsuccessful',
                'success' => false
            ], 401);
        }

    }
}
