<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){
        $data = Product::where('product','like','%'.$request->keyword.'%')->get();
        return view('menu',['type'=>'search','data'=>$data,'title'=>'Menu']);
    }
    public function detail($id){
        return view('detail',['title'=>'Detail','data'=>Product::find($id),'recommendation'=>Product::inRandomOrder()->where('status','=','open')->limit(4)->get()]);
    }
    public function index()
    {
        $testimonial = Testimonial::inRandomOrder()
        ->join('users','users.id','testimonials.userId')
        ->select('users.image','users.first_name','users.last_name','testimonials.testimoni')
        ->get();
        return view('index',['title'=>'Home','data'=>Product::inRandomOrder()->where('status','=','open')->limit(4)->get(),'testimonial'=>$testimonial]);
    }
    public function admin(){
        return view('admin.layout.products.index',['page'=>'product','data'=>Product::all(),'title'=>'Products']);
    }
    public function menu(){
        return view('menu',['type'=>'default','data'=>Product::where('status','=','open')->paginate(8),'title'=>'Menu']);
    }
    public function category($category){
        return view('menu',['type'=>'search','data'=>Product::where('category','=',$category)->get(),'title'=>'Menu']);

    }
    public function kategori($category)
    {    
        // Ambil produk berdasarkan kategori
        $products = Product::where('category', $category)->get();
        // Kirim data ke view
        return view('admin.layout.products.index', [
            'type' => 'search',
            'data' => $products,
            'title' => 'Menu',
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.layout.products.add',['page'=>'product','title'=>'Add Product']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'product'=>'required|max:255|min:2',
            'price'=>'required|max:255|min:3',
            'category'=>'required',
            'image'=>'required|image',
            'status'=>'required|in:open,closed',
            'description'=>'required'
        ],[
            'product.required'=>'Nama Produk Harus di masukan',
            'product.max'=>'Nama Produk Kepanjangan',
            'product.min'=>'Nama Produk terlalu Pendek',
            'price.required'=>'Harga Produk harus ditetapkan ',
            'price.max'=>'Harga Produk terlalu panjang!',
            'price.min'=>'Harga Produk terlalu pendek',
            'category'=>'kategori produk wajib di isi',
            'image.required'=>'Gambar Produk Wajib di isi',
            'image.image'=>'File yang anda Masukan bukan sebuah Gambar',
            'status.in'=>'Status yang anda masukan tidak Valid',
            'status.required'=>'Status Produk Wajib di isi',
            'description.required'=>'Deskripsi Produk wajib di isi',
            'description.max'=>'Deskripsi produk terlalu panjang'
        ]);
        if($request->hasFile('image')){
            $validate['image'] = $validate['image']->store('product', 'public');
            if(Product::create($validate)){
                return redirect('/admin/product/index')->with('success','Product : anda berhasil menambahkan produk dengan nama : '.$validate['product']);
            }else{
                return redirect('/admin/product/index')->with('failed','Produk dengan nama : '.$validate['product'].' tidak dapat ditambahakan');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product,$id)
    {
        return view('admin.layout.products.edit',['page'=>'product','data'=>Product::find($id),'title'=>'Edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    /** 
   * public function update(Request $request, Product $product,$id)
    * {
    *     $validate = $request->validate([
     *        'product'=>'required',
     *        'price'=>'required',
     *        'category'=>'required',
     *        'status'=>'required',
     *        'description'=>'required'
     *    ],[
     *        'product.required'=>'Nama Produk wajib di isi!',
     *        'price.required'=>'Harga Wajib di isi',
     *        'status.required'=>'Status produk wajib di isi',
     *        'description.required'=>"deskripsi produk wajib di isi"
     *    ]);
     *    $data = Product::find($id);
     *    if($request->hasFile('image')){
    *         $validate['image'] = $validate['image']->store('product');
     *        if(Storage::delete($data->image)){
     *            $data->product = $validate['product'];
     *            $data->image = $validate['image'];
     *            $data->price = $validate['price'];
     *            $data->status = $validate['status'];
     *            $data->description = $validate['description'];
     *            $data->category = $validate['category'];
     *            $data->save();
     *        }else{
       *          if(!Storage::disk('local')->has($data->image)){
       *              $data->product = $validate['product'];
       *              $data->image = $validate['image'];
       *              $data->price = $validate['price'];
       *              $data->status = $validate['status'];
       *              $data->description = $validate['description'];
       *              $data->category = $validate['category'];
       *              $data->save();
       *          }
        *     }
       *  }else{
       *      $data->product = $validate['product'];
      *       $data->price = $validate['price'];
      *       $data->status = $validate['status'];
    *         $data->description = $validate['description'];
            * $data->category = $validate['category'];
          *   $data->save();
        * }
      *   return redirect('/admin/product/index')->with('success','Data berhasil di update');

    * }
    */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'product' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'status' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048' // Validasi gambar jika ada
        ], [
            'product.required' => 'Nama Produk wajib di isi!',
            'price.required' => 'Harga Wajib di isi',
            'price.numeric' => 'Harga harus berupa angka',
            'category.required' => 'Kategori wajib di isi',
            'status.required' => 'Status produk wajib di isi',
            'description.required' => 'Deskripsi produk wajib di isi',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Gambar harus bertipe jpg, jpeg, png, atau gif',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB'
        ]);
    
        // Ambil data produk yang akan diedit berdasarkan ID
        $product = Product::find($id);
    
        // Jika tidak ditemukan produk dengan ID tersebut
        if (!$product) {
            return redirect('/admin/product/index')->with('error', 'Produk tidak ditemukan');
        }
    
        // Periksa apakah ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'product-' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'product/' . $filename;
    
            // Simpan file baru di storage
            $file->storeAs('public/product', $filename);
    
            // Hapus file gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
    
            // Update path gambar pada data yang akan diupdate
            $product->image = $filePath;
        }
    
        // Update data produk dengan informasi baru
        $product->product = $request->input('product');
        $product->price = $request->input('price');
        $product->category = $request->input('category');
        $product->status = $request->input('status');
        $product->description = $request->input('description');
        // Jika ada gambar baru, sudah diatur di atas
        $product->save();
    
        return redirect('/admin/product/index')->with('success', 'Data berhasil di update');
    }
    
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,$id)
    {
        $data = Product::find($id);
        if(Storage::delete($data->image)){
            if($data->delete()){
                return redirect('/admin/product/index')->with('success','Produk : Data berhasil di hapus');
            }else{
                return redirect('/admin/product/index')->with('failed','Produk Gagal Di hapus karena sebuah kesalahan');
            }
        }else{
            if(!Storage::disk('local')->has($data->image)){
                if($data->delete()){
                    return redirect('/admin/product/index')->with('success','Produk : Data berhasil di hapus');
                }
            }
        }
    }
}
