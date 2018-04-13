<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSituations extends Model
{
    //
    public function lists()
    {
        return $this->hasMany('App\Models\SituationList','situation_id','id');
    }
}
