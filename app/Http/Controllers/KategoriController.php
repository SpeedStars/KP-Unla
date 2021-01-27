<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Categories;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function productByKategori($id)
    {
        $data = array(
            'products' => Product::where('categories_id',$id)->paginate(10),
            'categories' => Categories::FindOrFail($id)
        );
    
        return view('user.kategori',$data);
    }
}
