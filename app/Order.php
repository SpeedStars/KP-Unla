<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['invoice','user_id','status_order_id','metode_pembayaran','subtotal','alamatlengkap','no_hp'];

    protected $dates = [
      'created_at',
      'updated_at',
      'date'
    ];

    public const BDB = '1';
    public const TDB = '2';

    public const STATUS_COLOR = [
      'Belum Di Bayar'  => '#FDF861',
      'Telah Di Bayar' => '#C1FB53',
      'Pesanan Di Terima' => '#84FB53',
      'Barang Di Kirim' => '#84FB53',
      'Barang Telah Sampai' => '#53FBF0',
      'Pesanan Di Batalkan'   => '#FB6356'
      
    ];
    
	public function isPaid()
	{
		return $this->payment_status == self::TDB;
    }
    
    public function unPaid()
	{
		return $this->payment_status == self::BDB;
    }

}
