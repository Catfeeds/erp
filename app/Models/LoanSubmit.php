<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanSubmit extends Model
{
    //
    public function lists()
    {
        return $this->hasMany('App\Models\LoanSubmitList','loan_id','id');
    }
}
