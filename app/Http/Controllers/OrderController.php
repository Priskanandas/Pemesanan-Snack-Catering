<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function finish($id){
        $kodeOrder = Order::find($id)->kodeOrder;
        $pesanan  = Order::where('kodeOrder','=',$kodeOrder)->update(['status'=>'ready']);
        return redirect('/worker/order')->with('success','Pesanan Sudah selesai di kerjakan !');
    }

    public function orderan($id){
        // Ambil kodeOrder dari tabel orders
        $kodeOrder = Order::find($id)->kodeOrder;
        
        // Join tabel orders dengan tabel products dan transactions
        $data = Order::join('products', 'products.id', '=', 'orders.productId')
            ->join('transactions', 'transactions.kodetransaksi', '=', 'orders.kodetransaksi')
            ->where('orders.kodeOrder', '=', $kodeOrder)
            ->select('orders.*', 'products.product','products.image', 'products.price', 'transactions.TanggalPengambilan',
                     'transactions.date','transactions.penerima','transactions.DeskripsiPemesanan',
                     'transactions.metodePembayaran','transactions.pengambilan')
            ->get();
      

        // Ambil status dari tabel orders
        $status = Order::find($id)->status;
        
        // Kirim data ke view
        return view('Worker.layouts.order-list', [
            'data' => $data,
            'title' => 'Daftar Pesanan',
            'id' => $id,
            'status' => $status
        ]);
    }

    public function accept($id){
        $data =Order::find($id)->kodeOrder;
        $pesanan  = Order::where('kodeOrder','=',$data)->update(['status'=>'working']);
        return redirect('/worker/order')->with('success','Pesanan sudah diterima Selamat bekerja !');
    }
    public function home(){
        return view("Worker.dashboard",['title'=>'Dashboard']);
    }
    public function index()
    {
        // Mengambil data transaksi terbaru dengan status pesanan terbaru
        $data = Transaction::join('users', 'users.id', '=', 'transactions.userId')
                            ->leftJoin('orders', 'transactions.kodetransaksi', '=', 'orders.kodetransaksi')
                            ->select('transactions.id', 'transactions.status as statusTransaksi', 'transactions.kodetransaksi', 'transactions.penerima', 'transactions.date as tanggalTransaksi', 'users.first_name', 'users.last_name', 'users.username', 'users.email', DB::raw('MAX(orders.created_at) as latestOrderDate'), DB::raw('MAX(orders.status) as orderStatus'))
                            ->groupBy('transactions.id', 'transactions.status', 'transactions.kodetransaksi', 'transactions.penerima', 'transactions.date', 'users.first_name', 'users.last_name', 'users.username', 'users.email')
                            ->orderBy('transactions.created_at', 'desc')
                            ->get();
    
        return view('admin.layout.transaksi.index', [
            'title' => 'Transaksi',
            'data' => $data,
            'page' => 'transaksi'
        ]);
    }
    
    public function filter(Request $request)
    {
// Ambil parameter dari permintaan
$filterByDate = $request->input('filter_by_date');
$sortOrder = in_array($request->input('sort_order'), ['asc', 'desc']) ? $request->input('sort_order') : 'asc';
$status = $request->input('status');

// Mulai query
$query = Order::join('products', 'products.id', '=', 'orders.productId')
    ->join('transactions', 'transactions.kodetransaksi', '=', 'orders.kodetransaksi')
    ->select('orders.*', 'products.product', 'products.image', 'products.price', 'transactions.TanggalPengambilan',
             'transactions.date', 'transactions.penerima', 'transactions.DeskripsiPemesanan');

// Tambahkan filter berdasarkan status jika ada
if ($status) {
    $query->where('orders.status', $status);
}

// Tambahkan pengurutan berdasarkan filter
if ($filterByDate == 'transaction_date') {
    $query->orderBy('transactions.date', $sortOrder);
} elseif ($filterByDate == 'pickup_date') {
    $query->orderBy('transactions.TanggalPengambilan', $sortOrder);
}

// Ambil data dengan pengurutan dan filter
$data = $query->get();

    
        // Kirim data ke view
        return view('Worker.layouts.pesanan', [
            'data' => $data,
            'title' => 'Daftar Pesanan'
        ]);
    }
    public function decline($id)
{
    // Temukan pesanan berdasarkan ID
    $order = Order::find($id);
    
    // Periksa apakah pesanan ditemukan
    if ($order) {
        // Ubah status pesanan menjadi "ditolak"
        $order->status = 'ditolak';
        $order->save();
        
        // Redirect kembali ke halaman pesanan dengan pesan sukses
        return redirect('/worker/order')->with('success', 'Pesanan berhasil ditolak.');
    } else {
        // Jika pesanan tidak ditemukan, kembali ke halaman pesanan dengan pesan error
        return redirect('/worker/order')->with('error', 'Gagal menolak pesanan. Pesanan tidak ditemukan.');
    }
}

    public function destroy($id)
    {
       //  Menggunakan operasi DB untuk menghapus pesanan berdasarkan ID
        $order = Order::find($id);
        
        if ($order) {
           $order->delete(); // Hapus pesanan
            return redirect('/worker/order')->with('success', 'Pesanan berhasil dihapus.');
        } else {
           return redirect('/worker/order')->with('error', 'Gagal menghapus pesanan. Pesanan tidak ditemukan.');
        }
    }
    
}

