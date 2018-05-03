<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockRecordList extends Model
{
    //
    public function record()
    {
        return $this->hasOne('App\Models\StockRecord','id','record_id');
    }
    public function material()
    {
        return $this->hasOne('App\Models\Material','id','material_id');
    }
}
