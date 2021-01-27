<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {   
        // dd($year);

        // $pendapatanperhari = DB::table('orders')
        //                 ->select(DB::raw('SUM(subtotal) as penghasilan'))
        //                 ->where('status_order_id',5)
        //                 ->whereDate('created_at', Carbon::today())
        //                 ->first();
        // dd($pendapatanperhari);
        // $transaksi = DB::table('orders')
        //                 ->select(DB::raw('COUNT(id) as total_order'))
        //                 ->first();
        // $pelanggan = DB::table('users')
        //                 ->select(DB::raw('COUNT(id) as total_user'))
        //                 ->where('role','=','customer')
        //                 ->first();
        $order_terbaru  = DB::table('orders')
                        ->join('status_orders','status_orders.id','=','orders.status_order_id')
                        ->join('users','users.id','=','orders.user_id')
                        ->select('orders.*','status_orders.name','users.name as nama_pemesan')
                        ->limit(10)
                        ->orderBy('created_at','DESC')
                        ->get();
        // $total = DB::table('payments')
        //                 ->where('status','=','success')
        //                 ->sum('subtotal');
        $pendapatanhariini = DB::table('orders')
                    ->where('status_order_id','=',5)
                    ->whereDate('created_at', Carbon::today())
                    ->sum('subtotal');

        $pendapatanbulanini = DB::table('orders')
                    ->where('status_order_id','=',5)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->sum('subtotal');

        $pendapatantahunini = DB::table('orders')
                    ->where('status_order_id','=',5)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->sum('subtotal');

        $data = array(
            // 'pendapatan' => $pendapatanperhari,
            // 'transaksi'  => $transaksi,
            // 'pelanggan'  => $pelanggan,
            'order_baru' => $order_terbaru,
            'hariini'      => $pendapatanhariini,
            'bulanini'      => $pendapatanbulanini,
            'tahunini'      => $pendapatantahunini
        );

        // dd($data);

        return view('admin/dashboard',$data);
    }
}
