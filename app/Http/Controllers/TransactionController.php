<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
#guest Models
use App\Models\Product;
use App\Models\Records;
use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PDF;
#----------------------
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function kodetransaksi(Request $request){
        $msg = [
            'password.required'=>'Password Wajib Di isi',
            'password.string'=>'Format Password Anda Salah',
        ];
        $validate = $request->validate([
            'password'=>'required',
            'username'=>'required',
            'email'=>'required',
            'idtransaksi'=>'required|string'
        ],$msg);
        if(Auth::attempt(['username'=>$validate['username'],'password'=>$validate['password'],'email'=>$validate['email']])){
            $data = Transaction::find($validate['idtransaksi'])->kodetransaksi;
            return redirect('/client/profile')->with('kode',$data);            
        }else{
            return redirect('/client/profile')->with('error','Data yang masukan tidak tepat');
        }
    }
    public function history(){
    
        // Mengambil daftar transaksi belum terkonfirmasi
        $belum = Transaction::latest()
                            ->where('userId','=',Auth::user()->id)
                            ->where('status','=','no')
                            ->get();
    
        // Mengambil daftar transaksi sudah terkonfirmasi
        $sudah = Transaction::where('userId','=',Auth::user()->id)
                            ->where('status','=','ok')
                            ->get();
        
    // Mengambil status order terkait untuk transaksi yang sudah ada
    $statusOrder = Transaction::join('orders', 'transactions.kodetransaksi', '=', 'orders.kodetransaksi')
                                ->where('transactions.userId', Auth::user()->id)
                                ->select('transactions.id', 'orders.status')
                                ->get();

    return view('profile', [
        'title' => 'Profile',
        'belum' => $belum,
        'sudah' => $sudah,
        'statusorder' => $statusOrder, // Mengirimkan status order ke view

        ]);
    }
    
    public function dashboard()
    {
        // Menghitung jumlah pengguna
        $userCount = User::count();
        
        // Menghitung jumlah produk
        $productCount = Product::count();
        
        // Menghitung jumlah transaksi
        $transactionCount = Transaction::count();
        
        // Ambil bulan dan tahun saat ini
        $currentMonth = date('F Y'); // Format nama bulan dan tahun (e.g., August 2024)
        $monthNames = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];
    
        // Mengubah nama bulan ke bahasa Indonesia
        $monthEnglish = date('F');
        $currentMonthInIndonesian = $monthNames[$monthEnglish] . ' ' . date('Y');
    
        // Ambil data produk berdasarkan bulan ini
        $data = Transaction::join('orders', 'orders.kodetransaksi', '=', 'transactions.kodetransaksi')
                            ->join('products', 'orders.productId', '=', 'products.id')
                            ->selectRaw('products.product, SUM(orders.quantity) as total')
                            ->whereRaw('DATE_FORMAT(transactions.created_at, "%Y-%m") = ?', [date('Y-m')])
                            ->groupBy('products.product')
                            ->orderBy('total', 'desc') // Urutkan berdasarkan total penjualan (descending)
                            ->get();
    
        return view('admin.index', [
            'page' => 'dashboard',
            'title' => 'Dashboard',
            'data' => $data, // Mengirim data bulanan ke view
            'userCount' => $userCount,
            'productCount' => $productCount,
            'transactionCount' => $transactionCount,
            'month' => $currentMonthInIndonesian // Mengirim bulan saat ini dalam bahasa Indonesia ke view
        ]);
    }
    
    
   // Menampilkan halaman dengan form rekap
   public function showForm()
   {
       return view('admin.layout.rekap.index', ['title' => 'Rekap Transaksi']);
   }

   // Memproses rekap data
   public function rekap(Request $request)
   {
       $validated = $request->validate([
           'start_date' => 'required|date',
           'end_date' => 'required|date|after_or_equal:start_date',
       ]);
   
       $startDate = $validated['start_date'];
       $endDate = $validated['end_date'];
   
       // Ambil data transaksi dari database menggunakan model Eloquent
       $transactions = Transaction::whereBetween('date', [$startDate, $endDate])
           ->get()
           ->groupBy('date');
   
       $rekap = [];
       $totalPendapatan = 0;
   
       foreach ($transactions as $date => $items) {
           $totalGrandtotal = $items->sum('grandtotal');
           $itemsWithOkStatus = $items->where('status', 'ok');

           $status = $items->first()->status; // Mengambil status dari salah satu item di tanggal tersebut
   
           $rekap[$date] = [
               'total' => $totalGrandtotal,
               'status' => $status,
           ];
                   // Hitung total pendapatan hanya dari transaksi dengan status 'ok'
       $totalPendapatan += $itemsWithOkStatus->sum('grandtotal');
       }
   
       // Tambahkan tanggal yang tidak memiliki transaksi dengan status '-'
       $datePeriod = new \DatePeriod(
           new \DateTime($startDate),
           new \DateInterval('P1D'),
           new \DateTime($endDate . ' +1 day')
       );
   
       foreach ($datePeriod as $date) {
           $formattedDate = $date->format('Y-m-d');
           if (!isset($rekap[$formattedDate])) {
               $rekap[$formattedDate] = [
                   'total' => 0,
                   'status' => '-', // Status '-' untuk tanggal tanpa data
               ];
           }
       }
   
       ksort($rekap);
   
       // Hitung total pendapatan
       $totalPendapatan = array_sum(array_column($rekap, 'total'));
   
       // Simpan data ke sesi
       session()->put('rekap_data', $rekap);
       session()->put('start_date', $startDate);
       session()->put('end_date', $endDate);
       session()->put('totalPendapatan', $totalPendapatan);
   
       return redirect()->route('rekap.form')->with('success', 'Data berhasil direkap.');
   }
       // Mengekspor hasil rekap ke PDF
       public function exportPDF()
       {
           // Cek apakah data rekap ada di sesi
           if (!session()->has('rekap_data')) {
               return redirect()->route('rekap.form')->with('failed', 'Data rekap tidak ditemukan.');
           }
       
           // Ambil data rekap dan informasi terkait dari sesi
           $rekap = session('rekap_data');
           $startDate = session('start_date');
           $endDate = session('end_date');
           $totalPendapatan = session('totalPendapatan');
       
           // Filter data untuk hanya menyertakan status 'Sudah diterima'
           $filteredRekap = array_filter($rekap, function($item) {
               return $item['status'] === 'ok'; // Hanya menyertakan status 'ok' (Sudah diterima)
           });
       
           // Generate PDF
           $pdf = PDF::loadView('admin.layout.rekap.rekappdf', [
               'rekap' => $filteredRekap,
               'start_date' => $startDate,
               'end_date' => $endDate,
               'totalPendapatan' => $totalPendapatan,
           ]);
       
           // Buat nama file dengan tanggal periode
           $filename = 'rekap_transaksi_' . $startDate . '_s_d_' . $endDate . '.pdf';
       
           // Download PDF
           return $pdf->stream($filename);
       }
       
    
    public function detail($id){
        // Mengambil data transaksi dan informasi terkait
      $data = Transaction::join('users','users.id','=','transactions.userId')
                           ->where('transactions.id','=',$id)
                           ->select(
                                    'transactions.bukti',
                                    'transactions.kodetransaksi',
                                    'users.first_name',
                                    'users.last_name',
                                    'users.username',
                                    'transactions.pengambilan',
                                    'transactions.TanggalPengambilan',
                                    'transactions.status as statusTransaksi',
                                    'transactions.penerima',
                                    'transactions.DeskripsiPemesanan',
                                    'transactions.date',
                                    'transactions.metodePembayaran',
                                    'transactions.grandtotal as subtotal')
                           ->first();
                           // Periksa apakah data ditemukan
    //if (!$data) {
      //  abort(404); // Atau berikan penanganan khusus jika data tidak ditemukan
    //}
    // Mengambil produk yang dibeli dalam transaksi
      $product = Transaction::join('orders','transactions.kodetransaksi','=','orders.kodetransaksi')
                            ->join('products','orders.productId','=','products.id')
                            ->where('transactions.id','=',$id)
                            ->select('products.image','products.product','orders.quantity')
                            ->get();

    // Mengambil status order terkait (jika diperlukan)
     $statusOrder = Transaction::join('orders','transactions.kodetransaksi','=','orders.kodetransaksi')                  
                            ->where('transactions.id','=',$id)
                            ->select('orders.status')
                            ->get();                  
    // Menghitung total pembelian berdasarkan kode transaksi
    $kodetransaksi = Transaction::find($id)->kodetransaksi;
     $countProduct = Transaction::where('transactions.kodetransaksi','=',$kodetransaksi)
                                ->join('orders','transactions.kodetransaksi','=','orders.kodetransaksi')
                                ->groupBy('transactions.kodetransaksi')
                                ->selectRaw('sum(quantity) as quantity,transactions.kodetransaksi')
                                //->get();                               
                                ->sum('orders.quantity');
      return view('admin.layout.transaksi.detail',['totalPembelian'=>$countProduct,'statusorder'=>$statusOrder,'data'=>$data,'product'=>$product,'page'=>'transaksi','title'=>"Detail"]);
    }



    public function search(Request $request)
    {
        // Validasi input pencarian
        $request->validate([
            'search' => 'nullable|string',
            'status_pembayaran' => 'nullable|string',
            'status_order' => 'nullable|string'
        ]);
    
        // Mulai query
        $query = Transaction::join('users', 'users.id', '=', 'transactions.userId')
            ->select('transactions.status as statusTransaksi', 'transactions.kodetransaksi', 'transactions.penerima', 'transactions.date as tanggalTransaksi', 'users.first_name', 'users.last_name', 'users.username', 'users.email', 'transactions.id as idTransaksi')
            ->orderBy('transactions.created_at', 'desc');
    
        // Filter berdasarkan status pembayaran
        if ($request->filled('status_pembayaran')) {
            $statusPembayaran = $request->input('status_pembayaran');
            $query->where('transactions.status', $statusPembayaran);
        }
    
        // Filter berdasarkan status order
        if ($request->filled('status_order')) {
            $statusOrder = $request->input('status_order');
            $query->join('orders', 'transactions.kodetransaksi', '=', 'orders.kodetransaksi')
                  ->where('orders.status', $statusOrder);
        }
    
        // Filter berdasarkan kata kunci pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('users.username', 'like', '%' . $search . '%')
                  ->orWhere('users.first_name', 'like', '%' . $search . '%')
                  ->orWhere('users.last_name', 'like', '%' . $search . '%')
                  ->orWhere('transactions.penerima', 'like', '%' . $search . '%')
                  ->orWhere('transactions.kodetransaksi', 'like', '%' . $search . '%');
            });
        }
    
        // Ambil data hasil query
        $data = $query->get();
    
        // Ambil status order terbaru
        $statusOrder = Order::select('status', 'kodetransaksi')
            ->whereIn('kodetransaksi', $data->pluck('kodetransaksi'))
            ->orderBy('created_at', 'desc')
            ->groupBy('kodetransaksi')
            ->get()
            ->keyBy('kodetransaksi');
    
        return view('admin.layout.transaksi.index', [
            'title' => 'Transaksi',
            'data' => $data,
            'statusorder' => $statusOrder,
            'page' => 'transaksi'
        ]);
    }
    
                           

    public function index(Request $request)
    {
        $query = Transaction::join('users', 'users.id', '=', 'transactions.userId')
            ->select('transactions.status as statusTransaksi', 'transactions.kodetransaksi', 'transactions.penerima', 'transactions.date as tanggalTransaksi', 'users.first_name', 'users.last_name', 'users.username', 'users.email', 'transactions.id as idTransaksi')
            ->orderBy('transactions.created_at', 'desc');
    
        // Filter berdasarkan status pembayaran
        if ($request->has('status_pembayaran')) {
            $statusPembayaran = $request->input('status_pembayaran');
            if ($statusPembayaran === 'ok') {
                $query->where('transactions.status', 'ok');
            } elseif ($statusPembayaran === 'not_ok') {
                $query->where('transactions.status', '!=', 'ok');
            }
        }
    
        // Filter berdasarkan status order
        if ($request->has('status_order')) {
            $statusOrder = $request->input('status_order');
            $query->join('orders', 'transactions.kodetransaksi', '=', 'orders.kodetransaksi')
                  ->where('orders.status', $statusOrder);
        }
    
        $data = $query->get();
    
        // Ambil status order terbaru
        $statusOrder = Order::select('status', 'kodetransaksi')
            ->whereIn('kodetransaksi', $data->pluck('kodetransaksi'))
            ->orderBy('created_at', 'desc')
            ->groupBy('kodetransaksi')
            ->get()
            ->keyBy('kodetransaksi');
    
        return view('admin.layout.transaksi.index', [
            'title' => 'Transaksi',
            'data' => $data,
            'statusorder' => $statusOrder,
            'page' => 'transaksi'
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function home(){
        $title = 'Cari Kode';
        return view('Worker.layouts.payment',compact('title'));
    }
    public function accept($id){
        $data = Transaction::find($id);
        $data->status = 'ok';
        $data->save();
        return redirect('/worker/konfirmasi')->with('success','Anda Telah mengkonfirmasi Proses transaksi ini!');
    }
    public function decline($id){
        $data = Transaction::find($id);
        $data->status= 'no';
        $data->save();
        return redirect('/worker/konfirmasi')->with('success','Proses Pengiriman Bukti transaksi akan di kirim kembali !');
    }
    public function findTransaction(Request $request){

        
            $validate = $request->validate([
                'code' => 'required'
            ]);
            $statusTransaksi= Transaction::where('kodetransaksi','=',$validate['code'])->first();
            // Ambil data transaksi berdasarkan kode transaksi
            $data = Transaction::join('users', 'users.id', '=', 'transactions.userId')
                                ->join('orders', 'transactions.kodetransaksi', '=', 'orders.kodetransaksi')
                                ->where('transactions.kodetransaksi', '=', $validate['code'])
                                ->select(
                                    'transactions.kodetransaksi',
                                    'transactions.bukti',
                                    'transactions.id',
                                    'users.first_name',
                                    'users.last_name',
                                    'users.username',
                                    'transactions.penerima',
                                    'orders.status as statusOrder',
                                    'transactions.grandtotal as subtotal',
                                    'transactions.metodePembayaran',
                                    'transactions.pengambilan',
                                    'transactions.TanggalPengambilan',
                                    'transactions.DeskripsiPemesanan',
                                    'transactions.date'

                                )
                                ->first();
            // Mengambil produk yang dibeli dalam transaksi
      $product = Transaction::join('orders','transactions.kodetransaksi','=','orders.kodetransaksi')
      ->join('products','orders.productId','=','products.id')
      ->where('transactions.kodetransaksi', '=', $validate['code'])
      ->select('products.image','products.product','orders.quantity')
      ->get();
            // Jika data tidak ditemukan, kembalikan view dengan pesan error
            if (empty($data)) {
                return view('Worker.layouts.confirmation-form', ['title' => 'Konfirmasi', 'error' => '404']);
            }
        
            // Hitung total item dalam transaksi berdasarkan kode transaksi
            $totalItem = Order::where('kodetransaksi', '=', $data->kodetransaksi)->sum('quantity');
        
            // Kirim data ke view confirmation-form
            return view('Worker.layouts.confirmation-form', [
                'data' => $data,
                'title' => 'Konfirmasi',
                'pesanan' => $totalItem,
                'statusTransaksi' => $statusTransaksi,
                'product'=>$product
            ]);
        }
        public function nota($id)
        {
            // Ambil transaksi beserta orders dan produk terkait
            $transaction = Transaction::join('orders', 'transactions.kodetransaksi', '=', 'orders.kodetransaksi')
                ->join('products', 'orders.productId', '=', 'products.id')
                ->where('transactions.id', '=', $id)
                ->select('transactions.*', 'products.price', 'products.product', 'orders.quantity','orders.subtotal')
                ->get(); // Mengambil data dari tabel transactions, orders, dan products
        
            if ($transaction->isEmpty()) {
                return redirect('/worker/konfirmasi')->with('error', 'Transaksi tidak ditemukan');
            }
            // Hitung total dari kolom subtotal
             $total = $transaction->sum('subtotal'); // Ganti 'subtotal' jika nama kolom berbeda
			// Format nomor nota
			$nomerNota = 'TRX-' . str_pad($id, 6, '0', STR_PAD_LEFT);
				
            // Generate PDF
            $pdf = \PDF::loadView('Worker.layouts.nota', ['transactions' => $transaction, 'total' => $total,'nomerNota' => $nomerNota]);
            $pdf->setPaper('A6', 'potrait');
            // Return the PDF download response
            return $pdf->stream('nota-transaksi-' . $nomerNota . '.pdf');
        }
        
        
        
        
    public function store(Request $request)
    {
        
        $id = Auth::user()->id;
        $validate = $request->validate([
            'penerima'=>'required|max:255',
            'DeskripsiPemesanan'=>'required|max:255',
            'metodePembayaran'=>'required|in:cash,virtual',
            'pengambilan'=>'required|in:kasir,drive',
            'TanggalPengambilan' => 'required|date_format:Y-m-d\TH:i',

        ],);
        $grandtotal = Cart::where('userId','=' ,$id)->sum('subtotal');
        $token = Str::random(4);
        $kodetransaksi = Str::random(5);
        $tanggalPengambilan = date('Y-m-d H:i:s', strtotime($validate['TanggalPengambilan']));
        if($validate['metodePembayaran'] == 'virtual' && $request->hasFile('bukti')){
            $message = ['bukti.image'=>'File yang anda masukan Harus berupa Image'];
            $validateImage = $request->validate(['bukti'=>'image'],$message);
            $fileName = $validateImage['bukti']->store('bukti_transaksi', 'public');
            $transaksi = [
                'date'=>date('Y-m-d'),
                'userId'=>$id, 'grandtotal'=>$grandtotal,
                'metodePembayaran'=>$validate['metodePembayaran'],
                'pengambilan'=>$validate['pengambilan'],
                'TanggalPengambilan' => $tanggalPengambilan,
                'bukti'=>$fileName,
                'kodetransaksi'=>$kodetransaksi,
                'token'=>$token,
                'status'=>'no',
                'penerima'=>$validate['penerima'],
                'DeskripsiPemesanan'=>$validate['DeskripsiPemesanan'],
                'recap'=>'false'
            ];

            if(Transaction::create($transaksi)){
                $data = Cart::where('userId','=',$id)->get();
                foreach ($data as $key) {
                    $pesanan = [
                        'kodeOrder'=>Str::random(5),
                        'kodetransaksi'=>$kodetransaksi,
                        'userId'=>$key->userId,
                        'productId'=>$key->productId,
                        'quantity'=>$key->quantity,
                        'subtotal'=>$key->subtotal
                    ];
                    $records = [
                        'userId'=>$key->userId,
                        'productId'=>$key->productId,
                        'quantity'=>$key->quantity,
                        'subtotal'=>$key->subtotal
                    ];
                     if(Order::create($pesanan)){
                        if(Records::create($records)){
                            Cart::find($key->id)->delete();
                        }
                     }
                }
            }
        }else if($validate['metodePembayaran'] == 'cash' && !$request->hasFile('bukti')){
            $data = [
                'date'=>date('Y-m-d'),
                'userId'=>$id,
                'grandtotal'=>$grandtotal,
                'metodePembayaran'=>$validate['metodePembayaran'],
                'pengambilan'=>$validate['pengambilan'],
                'TanggalPengambilan' => $tanggalPengambilan,
                'bukti'=>'-',
                'kodetransaksi'=>$kodetransaksi,
                'token'=>Str::random(4),
                'status'=>'no',
                'penerima'=>$validate['penerima'],
                'DeskripsiPemesanan'=>$validate['DeskripsiPemesanan'],
                'recap'=>'false'
            ];
            if(Transaction::create($data)){
                $data = Cart::where('userId','=',$id)->get();
                $kodeOrder=Str::random(5);
                foreach ($data as $key) {
                    $records = [
                        'userId'=>$key->userId,
                        'productId'=>$key->productId,
                        'quantity'=>$key->quantity,
                        'subtotal'=>$key->subtotal
                    ];
                    $pesanan = [
                        'kodeOrder'=>$kodeOrder,
                        'kodetransaksi'=>$kodetransaksi,
                        'userId'=>$key->userId,
                        'productId'=>$key->productId,
                        'quantity'=>$key->quantity,
                        'subtotal'=>$key->subtotal
                    ];
                    if(Order::create($pesanan)){
                        if(Records::create($records)){
                            Cart::find($key->id)->delete();
                        }
                    }
                }
             }
        }
        return view('waiting',['title'=>'Waiting','token'=>$token,'kodetransaksi'=>$kodetransaksi,'method'=>$validate['metodePembayaran']]);

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */

   // public function destroy($id)
//{
  //  $transaction = Transaction::find($id);
    //
    //if (!$transaction) {
      //  return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
    //}

    // Hapus terlebih dahulu data terkait seperti orders dan records
    //Order::where('kodetransaksi', $transaction->kodetransaksi)->delete();
    //Records::where('userId', $transaction->userId)->delete();

    // Hapus transaksi itu sendiri
    //$transaction->delete();

    //return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
//}

}
