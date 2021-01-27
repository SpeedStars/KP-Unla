<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Order;
use App\Payment;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        $order = DB::table('orders')
                    ->join('status_orders','status_orders.id','=','orders.status_order_id')
                    ->join('users','users.id','=','orders.user_id')
                    ->select('orders.*','status_orders.name','users.name as nama_pemesan')
                    ->where('orders.status_order_id',1)
                    ->get();
        $data = array(
            'orderbaru' => $order
        );

        return view('admin.transaksi.index',$data);
    }

    public function detail($id)
    {
        $detail_order = DB::table('detail_orders')
                            ->join('products','products.id','=','detail_orders.product_id')
                            ->join('orders','orders.id','=','detail_orders.order_id')
                            ->select('products.name as nama_produk','products.image','detail_orders.*','products.price','orders.*')
                            ->where('detail_orders.order_id',$id)
                            ->get();
        $inv = DB::table('orders')
                        ->select('orders.invoice as inv')
                        ->where('orders.id','=',$id)
                        ->first();
                        // dd($inv);
        $detail_payment = DB::table('payments')
                            ->join('orders','orders.invoice','=','payments.invoice')
                            ->select('payments.*')
                            ->where('payments.invoice',$inv->inv)
                            ->first();
        $order = DB::table('orders')
                    ->join('users','users.id','=','orders.user_id')
                    ->join('status_orders','status_orders.id','=','orders.status_order_id')
                    ->select('orders.*','users.name as nama_pelanggan','status_orders.name as status')
                    ->where('orders.id',$id)
                    ->first();
        $data = array(
            'detail' => $detail_order,
            'payment' => $detail_payment,
            'order'  => $order
        );
        // dd($data);

        return view('admin.transaksi.detail',$data);
    }

    public function telahbayar()
    {
        $order = DB::table('orders')
                    ->join('status_orders','status_orders.id','=','orders.status_order_id')
                    ->join('users','users.id','=','orders.user_id')
                    ->join('payments','payments.invoice','=','orders.invoice')
                    ->select('orders.*','orders.id as order_id','status_orders.name','users.name as nama_pemesan','payments.*')
                    ->where('orders.status_order_id',2)
                    ->get()
                    ->toArray();
        $data = array(
            'telahbayar' => $order
        );
        // $id = $data->id;
        // dd($data);

        return view('admin.transaksi.telahbayar',$data);
    }

    public function perludikirim()
    {
        $order = DB::table('orders')
                    ->join('status_orders','status_orders.id','=','orders.status_order_id')
                    ->join('users','users.id','=','orders.user_id')
                    ->join('payments','payments.invoice','=','orders.invoice')
                    ->select('orders.*','orders.id as order_id','status_orders.name','users.name as nama_pemesan','payments.*')
                    ->where('orders.status_order_id',3)
                    ->get()
                    ->toArray();
        $data = array(
            'perlukirim' => $order
        );
        // dd($data);

        return view('admin.transaksi.perludikirim',$data);
    }

    public function telahdikirim()
    {
        $order = DB::table('orders')
                    ->join('status_orders','status_orders.id','=','orders.status_order_id')
                    ->join('users','users.id','=','orders.user_id')
                    ->join('payments','payments.invoice','=','orders.invoice')
                    ->select('orders.*','orders.id as order_id','status_orders.name','users.name as nama_pemesan','payments.*')
                    ->where('orders.status_order_id',4)
                    ->get()
                    ->toArray();
        $data = array(
            'telahkirim' => $order
        );

        return view('admin.transaksi.dikirim',$data);
    }

    public function selesai()
    {
        $order = DB::table('orders')
                    ->join('status_orders','status_orders.id','=','orders.status_order_id')
                    ->join('users','users.id','=','orders.user_id')
                    ->join('payments','payments.invoice','=','orders.invoice')
                    ->select('orders.*','orders.id as order_id','status_orders.name','users.name as nama_pemesan','payments.*')
                    ->where('orders.status_order_id',5)
                    ->get()
                    ->toArray();
        $data = array(
            'selesai' => $order
        );

        return view('admin.transaksi.selesai',$data);
    }

    public function batal()
    {
        $order = DB::table('orders')
                    ->join('status_orders','status_orders.id','=','orders.status_order_id')
                    ->join('users','users.id','=','orders.user_id')
                    ->select('orders.*','status_orders.name','users.name as nama_pemesan')
                    ->where('orders.status_order_id',6)
                    ->get();
        $data = array(
            'batal' => $order
        );
        // dd($order);

        return view('admin.transaksi.dibatalkan',$data);
    }

    public function konfirmasitrf($id)
    {
        $order = Order::findOrFail($id);
        $order->status_order_id = 3;
        $order->save();

        return redirect()->route('admin.transaksi.perludikirim')->with('status','Berhasil Mengonfirmasi Pembayaran Pesanan');
    }

    public function konfirmasibyr($id)
    {
        $order = Order::findOrFail($id);
        $order->status_order_id = 5;
        $order->save();

        $paymentParams = [
			'invoice' => $order->invoice,
            'subtotal' => $order->subtotal,
			'method' => 'langsung',
			'status' => 'success',
			'token' => '',
			'payloads' => NULL,
			'payment_type' => 'cash',
			'va_number' => '',
			'vendor_name' => '',
			'biller_code' => '',
			'bill_key' => ''
        ];

		$payment = Payment::create($paymentParams);
		// $payment = Payment::updateOrCreate($paymentParams);

        return redirect()->route('admin.transaksi.selesai')->with('status','Berhasil Mengonfirmasi Pembayaran Pesanan');
    }

    public function kirim($id)
    {
        $order = Order::findOrFail($id);
        $order->status_order_id = 4;
        $order->save();
        return redirect()->route('admin.transaksi.dikirim')->with('status','Berhasil Mengubah Status Kirim');
    }

    public function batalkan($id)
    {
        $order = Order::findOrFail($id);
        $order->status_order_id = 6;
        $order->save();

        return redirect()->route('admin.transaksi.dibatalkan')->with(['status' => 'Pemesanan Berhasil Dibatalkan']);
    }

    public function laporan()
    {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

        if (request()->date != '') {
            $date = explode(' - ' ,request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }

        $order = DB::table('orders')
                    ->join('users','users.id','=','orders.user_id')
                    ->join('alamats','alamats.user_id','=','orders.user_id')
                    ->join('districts','districts.id','=','alamats.district_id')
                    ->join('cities','cities.id','=','districts.city_id')
                    ->join('provinces','provinces.id','=','cities.province_id')
                    ->select('orders.*','users.name','provinces.name as provinsi','cities.name as kota','districts.name as kecamatan')
                    ->where('orders.status_order_id','=',5)
                    ->whereBetween('orders.created_at',[$start, $end])
                    ->get();

        $data = array(
            'order' => $order
        );
        // dd($data);

        return view('admin/transaksi/laporan',$data);
    }
}
