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
    public function applies()
    {
        return $this->hasMany('App\Models\BuildPayFinish','project_team','id');
    }
    public function invoices()
    {
        return $this->hasMany('App\Models\BuildInvoice','project_team','id');
    }

}
