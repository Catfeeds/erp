<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestPayment extends Model
{
    //
    public function lists()
    {
        return $this->hasMany('App\Models\RequestPaymentList','payment_id','id');
    }
    public function pictures()
    {
        return  $this->hasMany('App\RequestPaymentPicture','payment_id','id');
    }
}
