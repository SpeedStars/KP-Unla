<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Order;
use App\DetailOrder;

class OrderController extends Controller
{
    public function index()
    {
        
        $user_id = \Auth::user()->id;

        $order = DB::table('orders')
                    ->join('status_orders','status_orders.id','=','orders.status_order_id')
                    ->select('orders.*','status_orders.name')
                    ->where('orders.status_order_id',1)
                    ->where('orders.user_id',$user_id)->get();
        $dicek = DB::table('orders')
                    ->join('status_orders','status_orders.id','=','orders.status_order_id')
                    ->select('orders.*','status_orders.name')
                    ->where('orders.status_order_id','!=',1)
                    ->Where('orders.status_order_id','!=',5)
                    ->Where('orders.status_order_id','!=',6)
                    ->where('orders.user_id',$user_id)->get();
        $histori = DB::table('orders')
                    ->join('status_orders','status_orders.id','=','orders.status_order_id')
                    ->select('orders.*','status_orders.name')
                    ->where('orders.status_order_id','!=',1)
                    ->Where('orders.status_order_id','!=',2)
                    ->Where('orders.status_order_id','!=',3)
                    ->Where('orders.status_order_id','!=',4)
                    ->where('orders.user_id',$user_id)->get();
        $data = array(
            'order' => $order,
            'dicek' => $dicek,
            'histori'=> $histori,
        );

        // $count = DB::table('orders')->where('user_id',$user_id)->count();
        // if($count = 0){
        //     return view('user.order.order');
        // }else{
        //     $this->_generatePaymentToken();

        //     $url = DB::table('orders')->where('orders.user_id',$user_id)->first();

        //     // return view('user.order.order',$data);
        //     return view('user.order.order')->with(compact('order','dicek','histori','url'));
        // }
        // $this->_generatePaymentToken();

        // $url = DB::table('orders')->where('orders.user_id',$user_id)->first();

        return view('user.order.order',$data);
        // return view('user.order.order')->with(compact('order','dicek','histori','url'));
    }

    public function simpan(Request $request)
    {
        $cek_invoice = DB::table('orders')->where('invoice',$request->invoice)->count();
        if($cek_invoice < 1){
            $userid = \Auth::user()->id;
            if($request->metode_pembayaran == 'byr'){
                Order::create([
                    'invoice' => $request->invoice,
                    'user_id' => $userid,
                    'status_order_id' => 1,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'subtotal'=> $request->subtotal,
                    'alamatlengkap' => $request->alamatlengkap,
                    'no_hp' => $request->no_hp
                ]);
            }else{
                Order::create([
                    'invoice' => $request->invoice,
                    'user_id' => $userid,
                    'status_order_id' => 1,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'subtotal'=> $request->subtotal,
                    'alamatlengkap' => $request->alamatlengkap,
                    'no_hp' => $request->no_hp
                ]);
            }

            $order = DB::table('orders')->where('invoice',$request->invoice)->first();
        
            $barang = DB::table('keranjangs')->where('user_id',$userid)->get();
            foreach($barang as $brg){
                Detailorder::create([
                    'order_id' => $order->id,
                    'product_id' => $brg->products_id,
                    'qty' => $brg->qty,
                ]);
            }
            DB::table('keranjangs')->where('user_id',$userid)->delete();

            return redirect()->route('user.order')->with(['success' => 'Pemesanan Berhasil Silahkan Melakukan Pembayaran']);

        }else{
            return redirect()->route('user.keranjang');
        }
    }

    public function pesanandibatalkan($id)
    {
        $order = Order::findOrFail($id);
        $order->status_order_id = 6;
        $order->save();

        return redirect()->route('user.order')->with(['success' => 'Pemesanan Berhasil Dibatalkan']);
    }

    public function pesananditerima($id)
    {
        $order = Order::findOrFail($id);
        $order->status_order_id = 5;
        $order->save();

        return redirect()->route('user.order')->with(['success' => 'Terima Kasih Telah Melakukan Pembelian Di Toko Kami']);
    }

    public function detail($id)
    {
        $detail_order = DB::table('detail_orders')
                            ->join('products','products.id','=','detail_orders.product_id')
                            ->join('orders','orders.id','=','detail_orders.order_id')
                            ->select('products.name as nama_produk','products.image','detail_orders.*','products.price','orders.*')
                            ->where('detail_orders.order_id','=',$id)
                            ->get();
        $order = DB::table('orders')
                    ->join('users','users.id','=','orders.user_id')
                    ->join('status_orders','status_orders.id','=','orders.status_order_id')
                    ->select('orders.*','users.name as nama_pelanggan','status_orders.name as status')
                    ->where('orders.id',$id)
                    ->first();
        $detail_payment = DB::table('payments')
                            ->join('orders','orders.invoice','=','payments.invoice')
                            ->select('payments.*')
                            ->where('payments.invoice',$order->invoice)
                            ->first();
        // dd($detail_order);
        $data = array(
        'detail' => $detail_order,
        'payment' => $detail_payment,
        'order'  => $order
        );
        // dd($data);
        return view('user.order.detail',$data);
    }

    public function payment($id)
    {
        
        $harga = DB::table('orders')->where('id',$id)->get();
        
        $name = \Auth::user()->name;
        $email = \Auth::user()->email;
        $thisid = $id;

        $this->_generatePaymentToken($thisid);

        $url = DB::table('orders')->where('id',$thisid)->first();
        // dd($url);
        
        return view('user.order.bayar')->with(compact('url','name','email','harga'));
    }

    public function PaymentGateway()
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
    }

    public function _generatePaymentToken($thisid)
	{
        $user_id = \Auth::user()->id;

        $this->PaymentGateway();
        
        // $order = DB::table('orders')
        //             ->join('status_orders','status_orders.id','=','orders.status_order_id')
        //             ->select('orders.*','status_orders.name')
        //             ->where('orders.status_order_id',1)
        //             ->where('orders.user_id',$user_id)->first();

        $order = DB::table('orders')->where('id',$thisid)->first();
        // dd($order);

		$customerDetails = [
			'first_name' => \Auth::user()->name,
			'email' => \Auth::user()->email,
			'phone' => $order->no_hp,
        ];
        
        $transaction_details = array(
            'order_id' => $order->invoice,
            'gross_amount' => $order->subtotal, // no decimal allowed for creditcard
        );

		$params = [
			'enable_payments' => ['credit_card', 'mandiri_clickpay', 'cimb_clicks',
            'bca_klikbca', 'bca_klikpay', 'bri_epay', 'echannel', 'permata_va',
            'bca_va', 'bni_va', 'other_va', 'gopay', 'indomaret',
            'danamon_online', 'akulaku'],
			'transaction_details' => $transaction_details,
			'customer_details' => $customerDetails,
			'expiry' => [
				'start_time' => date('Y-m-d H:i:s T'),
				'unit' => 'days',
				'duration' => '7',
			],
        ]; 

        $snap = \Midtrans\Snap::createTransaction($params);
        // $invoice = $order->invoice;
        // dd($invoice);
        $ordertok = Order::where('id',$thisid)->first();

        // dd($ordertok);
        
		if ($snap) {
			$ordertok->payment_token = $snap->token;
			$ordertok->payment_url = $snap->redirect_url;
			$ordertok->save();
        }
	}
}
