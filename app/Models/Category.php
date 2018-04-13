<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    public function kinds()
    {
        return $this->hasMany('App\Models\Detail','category_id','id');
    }
}
