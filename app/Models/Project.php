<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     */
    public function bail()
    {
        return $this->hasMany('App\Models\ProjectBail','project_id','id');
    }

    public function mainContract()
    {
        return $this->hasMany('App\Models\MainContract','project_id','id');
    }

    public function outContract()
    {
        return $this->hasMany('App\Models\OutContract','project_id','id');
    }

    public function budget()
    {
        return $this->hasMany('App\Models\Budget','project_id','id');
    }
}
