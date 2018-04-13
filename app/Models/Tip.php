<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    //
    public function project()
    {
        return $this->hasOne('App\Models\Project','id','project_id')->first();
    }
}
