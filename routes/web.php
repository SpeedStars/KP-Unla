<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/','user\WelcomeController@index')->name('home');
// Route::get('/home','user\WelcomeController@index')->name('home2');
Route::get('/about','user\WelcomeController@about')->name('about');
Route::get('/produk','user\ProdukController@index')->name('user.produk');
Route::get('/produk/cari','user\ProdukController@cari')->name('user.produk.cari');
Route::get('/kategori/{id}','KategoriController@productByKategori')->name('user.kategori');
Route::get('/produk/{id}','user\ProdukController@detail')->name('user.produk.detail');


// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' =>  ['auth','checkRole:admin']],function(){ 
    Route::get('/admin','DashboardController@index')->name('admin.dashboard');

    Route::get('/admin/categories','admin\CategoriesController@index')->name('admin.categories');
    Route::get('/admin/categories/tambah','admin\CategoriesController@tambah')->name('admin.categories.tambah');
    Route::post('/admin/categories/store','admin\CategoriesController@store')->name('admin.categories.store');
    Route::get('/admin/categories/edit/{id}','admin\CategoriesController@edit')->name('admin.categories.edit');
    Route::post('/admin/categories/update/{id}','admin\CategoriesController@update')->name('admin.categories.update');
    Route::get('/admin/categories/delete/{id}','admin\CategoriesController@delete')->name('admin.categories.delete');

    Route::get('/admin/product','admin\ProductController@index')->name('admin.product');
    Route::get('/admin/product/tambah','admin\ProductController@tambah')->name('admin.product.tambah');
    Route::post('/admin/product/store','admin\ProductController@store')->name('admin.product.store');
    Route::get('/admin/product/edit/{id}','admin\ProductController@edit')->name('admin.product.edit');
    Route::get('/admin/product/delete/{id}','admin\ProductController@delete')->name('admin.product.delete');
    Route::post('/admin/product/update/{id}','admin\ProductController@update')->name('admin.product.update');

    Route::get('/admin/transaksi','admin\TransaksiController@index')->name('admin.transaksi');
    Route::get('/admin/transaksi/telahbayar','admin\TransaksiController@telahbayar')->name('admin.transaksi.telahbayar');
    Route::get('/admin/transaksi/perludikirim','admin\TransaksiController@perludikirim')->name('admin.transaksi.perludikirim');
    Route::get('/admin/transaksi/kirim{id}','admin\TransaksiController@kirim')->name('admin.transaksi.kirim');
    Route::get('/admin/transaksi/dikirim','admin\TransaksiController@telahdikirim')->name('admin.transaksi.dikirim');
    Route::get('/admin/transaksi/detail/{id}','admin\TransaksiController@detail')->name('admin.transaksi.detail');
    Route::get('/admin/transaksi/konfirmasitrf/{id}','admin\TransaksiController@konfirmasitrf')->name('admin.transaksi.konfirmasitrf');
    Route::get('/admin/transaksi/konfirmasibyr/{id}','admin\TransaksiController@konfirmasibyr')->name('admin.transaksi.konfirmasibyr');
    Route::get('/admin/transaksi/selesai','admin\TransaksiController@selesai')->name('admin.transaksi.selesai');
    Route::get('/admin/transaksi/batalkan/{id}','admin\TransaksiController@batalkan')->name('admin.transaksi.batalkan');
    Route::get('/admin/transaksi/dibatalkan','admin\TransaksiController@batal')->name('admin.transaksi.dibatalkan');

    Route::get('/admin/transaksi/laporan','admin\TransaksiController@laporan')->name('admin.transaksi.laporan');

    Route::get('/admin/pelanggan','admin\PelangganController@index')->name('admin.pelanggan');

});


Route::group(['middleware' => ['auth','checkRole:customer']], function () {
    Route::post('/keranjang/simpan','user\KeranjangController@simpan')->name('user.keranjang.simpan');
    Route::get('/keranjang','user\KeranjangController@index')->name('user.keranjang');
    Route::post('/keranjang/update','user\KeranjangController@update')->name('user.keranjang.update');
    Route::get('/keranjang/delete/{id}','user\KeranjangController@delete')->name('user.keranjang.delete');

    Route::get('/alamat', 'user\AlamatController@index')->name('user.alamat');
    Route::post('/alamat/simpan','user\AlamatController@simpan')->name('user.alamat.simpan');
    Route::post('/alamat/update/{id}','user\AlamatController@update')->name('user.alamat.update');
    Route::get('/alamat/ubah/{id}','user\AlamatController@ubah')->name('user.alamat.ubah');

    Route::get('/checkout','user\CheckoutController@index')->name('user.checkout');

    Route::post('/order/simpan','user\OrderController@simpan')->name('user.order.simpan');
    Route::get('/order/bayar/{id}','user\OrderController@payment')->name('user.order.bayar');
    Route::get('/order','user\OrderController@index')->name('user.order');
    Route::get('/order/detail/{id}','user\OrderController@detail')->name('user.order.detail');
    Route::get('/order/pesananditerima/{id}','user\OrderController@pesananditerima')->name('user.order.pesananditerima');
    Route::get('/order/pesanandibatalkan/{id}','user\OrderController@pesanandibatalkan')->name('user.order.pesanandibatalkan');
    Route::get('/order/pembayaran/{id}','user\OrderController@pembayaran')->name('user.order.pembayaran');

    
});

Route::post('payments/notification', 'user\PaymentController@notification');
Route::get('payments/completed', 'user\PaymentController@completed');
Route::get('payments/failed', 'user\PaymentController@failed');
Route::get('payments/unfinish', 'user\PaymentController@unfinish');