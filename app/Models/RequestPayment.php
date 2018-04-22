<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestPayment extends Model
{
    //
    public function lists()
    {
        return $this->hasMany('RequestPaymentList','payment_id','id');
    }
}
