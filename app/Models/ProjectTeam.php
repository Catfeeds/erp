<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTeam extends Model
{
    //
    public function payments()
    {
        return $this->hasMany('App\Models\RequestPayment','project_team','id');
    }
}
