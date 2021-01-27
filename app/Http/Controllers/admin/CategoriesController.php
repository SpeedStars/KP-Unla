<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Categories;

class CategoriesController extends Controller
{
    public function index()
    {
        $data = array(
            'categories' => Categories::all()
        );

        return view('admin.categories.index', $data);
    }

    public function tambah()
    {
        return view('admin.categories.tambah');
    }

    public function store(Request $request)
    {
        Categories::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.categories')->with('status', 'Berhasil Menambahkan Kategori');
    }

    public function edit($id)
    {
        $data = array(
            'categories' => $categories = Categories::FindOrFail($id)
        );

        return view('admin.categories.edit', $data);
    }

    public function update($id, Request $request)
    {
        $categories = Categories::FindOrFail($id);
        $categories->name = $request->name;

        $categories->save();

        return redirect()->route('admin.categories')->with('status', 'Berhasil Mengubah Data');
    }

    public function delete($id)
    {
        Categories::destroy($id);

        return redirect()->route('admin.categories')->with('status', 'Berhasil Menghapus Data');
    }
}
