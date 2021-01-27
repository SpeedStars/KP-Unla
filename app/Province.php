<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public function alamat()
    {
        return $this->belongsTo('App\Alamat');
    }
}
