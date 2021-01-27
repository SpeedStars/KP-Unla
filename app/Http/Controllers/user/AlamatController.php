<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Province;
use App\City;
use App\District;
use App\Alamat;

class AlamatController extends Controller
{
    public function index()
    {
        $id_user = \Auth::user()->id;

        // $provinces = Province::orderBy('created_at', 'DESC')->get();
        $data['provinces'] = Province::all();
        $cekAlamat = DB::table('alamats')
                    ->where('user_id',$id_user)
                    ->count();

        if($cekAlamat > 0){
            $data['alamat'] = DB::table('alamats')
            ->join('districts','districts.id','=','alamats.district_id')
            ->join('cities','cities.id','=','districts.city_id')
            ->join('provinces','provinces.id','=','cities.province_id')
            ->select('provinces.name as provinsi','cities.name as kota','districts.name as kecamatan','alamats.*')
            ->where('alamats.user_id',$id_user)
            ->get();

            return view('user.alamatdata',$data);
        }else{
            return view('user.alamat',$data);
        }
    }

    public function ubah($id)
    {
        //menampilkan form edit alamat
        $data['provinces'] = Province::all();
        $data['id'] = $id;
        return view('user.ubahalamat',$data); 
    }

    public function update($id,Request $request)
    {
        //mengupdate alamat
        $alamat = Alamat::findOrFail($id);
        $alamat->province_id = $request->province_id;
        $alamat->city_id = $request->city_id;
        $alamat->district_id = $request->district_id;
        $alamat->save();
        return redirect()->route('user.alamat');

    }

    public function getCity()
    {
        //QUERY UNTUK MENGAMBIL DATA KOTA / KABUPATEN BERDASARKAN PROVINCE_ID
        $cities = City::where('province_id', request()->province_id)->get();
        //KEMBALIKAN DATANYA DALAM BENTUK JSON
        return response()->json(['status' => 'success', 'data' => $cities]);
    }

    public function getDistrict()
    {
        //QUERY UNTUK MENGAMBIL DATA KECAMATAN BERDASARKAN CITY_ID
        $districts = District::where('city_id', request()->city_id)->get();
        //KEMUDIAN KEMBALIKAN DATANYA DALAM BENTUK JSON
        return response()->json(['status' => 'success', 'data' => $districts]);
    }

    public function simpan(Request $request)
    {
        //menyimpan alamat user
        Alamat::create([
            'user_id'   => \Auth::user()->id,
            'province_id' => $request->province_id,
            'city_id'    => $request->city_id,
            'district_id' => $request->district_id
            
        ]);
        
        return redirect()->route('user.alamat');
    }
}
