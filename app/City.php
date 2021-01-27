<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function alamat()
    {
        return $this->belongsTo('App\Alamat');
    }
}
