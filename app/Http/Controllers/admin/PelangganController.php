<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class PelangganController extends Controller
{
    public function index()
    {
        $data = array(
            'pelanggan' => DB::table('users')
                        ->join('alamats','alamats.user_id','=','users.id')
                        ->join('districts','districts.id','=','alamats.district_id')
                        ->join('cities','cities.id','=','districts.city_id')
                        ->join('provinces','provinces.id','=','cities.province_id')
                        ->select('users.*','districts.name as kecamatan','cities.name as kota','provinces.name as prov')
                        ->where('users.role','=','customer')->get()
        );
        return view('admin.pelanggan.index',$data);
    }
}
