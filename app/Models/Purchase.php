<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
    public function lists()
    {
        return $this->hasMany('App\Models\PurchaseList','purchase_id','id');
    }
}
