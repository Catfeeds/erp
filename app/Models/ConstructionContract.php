<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConstructionContract extends Model
{
    //
    public function lists()
    {
        return $this->hasMany('App\Models\ConstructionContractList','contract_id','id');
    }
}
