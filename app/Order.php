<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Billing\TransactionRef;
class Order extends Model
{
   
    const CHARGES = 100;

    protected $guarded = [];

    protected $attributes = ['visible' => 1];

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }  

    public  function storeOrder($transaction)
    {
        return static::create([
            'transaction_reference' => $transaction->data? $transaction->data->reference : TransactionRef::trans_ref(),
            'buyer_name' => $transaction->data? $transaction->data->metadata->buyer_name : $transaction->buyer_name,
            'buyer_email' => $transaction->data?  $transaction->data->metadata->email : $transaction->buyer_email,
            'buyer_phone_number' => $transaction->data ? $transaction->data->metadata->phone_number : $transaction->buyer_phone_number,
            'project_id' => $transaction->data ?  $transaction->data->metadata->project_id : $transaction->project_id,
            'amount' => $transaction->data ? $transaction->data->amount/100 :  $transaction->amount,
            'charges' => $transaction->data->charges?? SELF::CHARGES,
            'card_type' => $transaction->data->authorization->card_type ?? '',
            'card_last_four' => $transaction->data->authorization->last4 ?? '',
            'bank' => $transaction->data ? $transaction->data->authorization->bank :  $transaction->bank,
            'account_number' => $transaction->data? 0 : $transaction->account_number, 
            'buyer' => $transaction->data ? '' : $transaction->buyer, 
            'delivery_status' => $transaction->data ? 0 : $transaction->delivery_status,
            //'payment_status' => $transaction->status,
        ]);
    }
}
