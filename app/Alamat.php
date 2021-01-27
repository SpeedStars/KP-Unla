<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    protected $table = 'alamats';
    protected $fillable = ['user_id','province_id','city_id','district_id'];

}
