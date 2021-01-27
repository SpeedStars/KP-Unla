<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Province;
use App\City;
use App\District;
use App\Alamat;

class CheckoutController extends Controller
{
    public function index()
    {
        
        
        $id_user = \Auth::user()->id;
        $keranjangs = DB::table('keranjangs')
                            ->join('users','users.id','=','keranjangs.user_id')
                            ->join('products','products.id','=','keranjangs.products_id')
                            ->select('products.name as nama_produk','products.image','products.weight','users.name','keranjangs.*','products.price')
                            ->where('keranjangs.user_id','=',$id_user)
                            ->get();
                            // dd($keranjangs);
        
        $berattotal = 0;
        foreach($keranjangs as $k){
            $berat = $k->weight * $k->qty;
            $berattotal = $berattotal + $berat;
        }
        $city = DB::table('alamats')->where('user_id',$id_user)->get();
        // $city_destination =  $city[0]->id;
        // $alamat_toko = DB::table('alamat_toko')->first();
        
        $alamat_user = DB::table('alamats')
            ->join('districts','districts.id','=','alamats.district_id')
            ->join('cities','cities.id','=','districts.city_id')
            ->join('provinces','provinces.id','=','cities.province_id')
            ->select('provinces.name as provinsi','cities.name as kota','districts.name as kecamatan','alamats.*')
            ->where('alamats.user_id',$id_user)
            ->first();
        
        $data = [
            'invoice' => 'BJP'.Date('Ymdhi'),
            'cart' => $keranjangs,
            'alamat' => $alamat_user
        ];

        $invoice = 'BJP'.Date('Ymdhi');
        // $keranjang = $keranjangs;
        // $provinsi = $alamat_user;

        // dd($alamat_user);

        // return view('user.checkout')->with(compact('invoice','keranjangs','alamat_user'));
        
        return view('user.checkout')->with($data);
    }
}
