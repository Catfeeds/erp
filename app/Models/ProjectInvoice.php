<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectInvoice extends Model
{
    //
    public function lists()
    {
        return $this->hasMany('App\Models\InvoiceList','invoice_id','id');
    }
}
