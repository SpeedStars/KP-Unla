<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;

class WelcomeController extends Controller
{
    public function index()
    {
        $data = array(
            'products' => DB::table('products')->limit(10)->get(),
        );

        return view('user.welcome', $data);
    }

    public function about()
    {
        return view('user.about');
    }
}
