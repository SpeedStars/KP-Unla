<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Categories;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function index()
    {
        $kategori = DB::table('categories')
                    ->join('products','products.categories_id','=','categories.id')
                    ->select(DB::raw('count(products.categories_id) as jumlah, categories.*'))
                    ->groupBy('categories.id')
                    ->get();
        $data = array(
            'products' => Product::paginate(10),
            'categories' => $kategori,
        );

        return view('user.produk', $data);
    }

    public function detail($id)
    {
        $data = array(
            'products' => Product::FindOrFail($id)
        );

        return view('user.produkdetail', $data);
    }

    public function cari(Request $request)
    {
        $product = Product::where('name','like','%' . $request->cari. '%')->paginate(10);
        $total = Product::where('name','like','%' . $request->cari. '%')->count();
        $data = array(
            'products' => $product,
            'cari' => $request->cari,
            'total' => $total
        );

        return view('user.cariproduk', $data);
    }
}
