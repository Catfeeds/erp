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
        return $this->hasMany('App\Models\Bail','project_id','id');
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
    public function picture()
    {
        return $this->hasMany('App\Models\ProjectPicture','project_id','id');
    }
    public function situation()
    {
        return $this->hasMany('App\Models\ProjectSituations','project_id','id');
    }
    public function receipt()
    {
        return $this->hasMany('App\Models\Receipt','project_id','id');
    }
    public function purchases()
    {
        return $this->hasMany('App\Models\Purchase','project_id','id');
    }
}
