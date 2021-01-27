<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Categories;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $product = DB::table('products')
                    ->join('categories', 'categories.id', '=', 'products.categories_id')
                    ->select('products.*', 'categories.name as nama_kategori')
                    ->get();
        $data = array(
            'products' => $product
        );
        // dd($product);

        return view('admin.product.index', $data);
    }

    public function tambah()
    {
        $data = array(
            'categories' => Categories::all(),
        );

        return view('admin.product.tambah', $data);
    }

    public function store(Request $request)
    {
        if($request->file('image')){

            $file = $request->file('image')->store('imageproduct', 'public');
            
            Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'weight' => $request->weight,
                'categories_id' => $request->categories_id,
                'image' => $file,
            ]);
            
            return redirect()->route('admin.product')->with('status', 'Berhasil Menambah Produk');
        }
    }

    public function edit($id)
    {
        $data = array(
            'product' => Product::FindOrFail($id),
            'categories' => Categories::all(),
        );

        return view('admin.product.edit', $data);
    }

    public function update($id, Request $request)
    {
        $product = Product::FindOrFail($id);

        if($request->file('image')){
            Storage::delete('public/'.$product->image);
            $file = $request->file('image')->store('imageproduct', 'public');
            $product->image = $file;
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->weight = $request->weight;
        $product->categories_id = $request->categories_id;
        $product->stock = $request->stock;

        $product->save();

        return redirect()->route('admin.product')->with('status', 'Berhasil Mengubah Data');
    }

    public function delete($id)
    {
        $product = Product::FindOrFail($id);
        Product::destroy($id);
        Storage::delete('public'.$product->image);

        return redirect()->route('admin.product')->with('status', 'Berhasil Menghapus Data');
    }
}
