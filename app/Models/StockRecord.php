<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockRecord extends Model
{
    //
    public function lists()
    {
        return $this->hasMany('App\Models\StockRecordList','record_id','id');
    }
}
