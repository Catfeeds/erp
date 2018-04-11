<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    //
    public function warehouse()
    {
        return $this->hasOne('App\Models\Warehouse','id','warehouse_id')->first();
    }
    public function material()
    {
        return $this->hasOne('App\Models\Material','id','material_id')->first();
    }
}
