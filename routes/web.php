<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecordsController;
use App\Http\Controllers\TestimonialController;
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
//default Routes
Route::get('/',[ProductController::class,'index']);
Route::get('/login',function(){
  return view('login' ,['title'=>'Login']);
})->middleware('guest')->name('login');

Route::get('/register',function(){
  return view('register',['title'=>'Register']);
})->middleware('guest');

//custom Route
Route::group(['prefix'=>'client'],function(){
  
  Route::group(['middleware'=>'auth'],function(){
    Route::get('/cart',[CartController::class,'index'])->name('cart.index');
    Route::get('/checkout',[CartController::class,'checkout']);
    Route::post('/transaction',[TransactionController::class,'store']);
    Route::get('/profile',[TransactionController::class,'history']);
    Route::post('/kodetransaksi',[TransactionController::class,'kodetransaksi']);
    Route::put('/user/{id}',[UserController::class,'editProfile']);
  });
  Route::group(['prefix'=>'testimonial','middleware'=>'auth'],function(){
    Route::post('store',[TestimonialController::class,'store']);
  });
  Route::get('/category/{kategori}',[ProductController::class,'category']);
  Route::post('/search',[ProductController::class,'search']);
  Route::get('/home',[ProductController::class,'index'])->name('home');
  Route::get('/menu',[ProductController::class,'menu'])->name('menu');
  Route::get('/about',function(){
    return view('about',['title'=>'About']);
  })->name('about');

  Route::get('/menu/back',function(){
    return view('detail');
  });
});
Route::get('/logout',[AuthController::class,'logout']);
Route::group(['prefix'=>'/cart','middleware'=>'auth'],function(){
  Route::post('/add',[CartController::class,'store']);
  Route::delete('/delete/{id}',[CartController::class,'destroy']);
  Route::put('/edit/{id}',[CartController::class,'update']);
});


Route::group(['prefix'=>'user'],function(){
  Route::post('/register',[AuthController::class,'register']);
  Route::post('/login',[AuthController::class,'login']);
  Route::post('/logout',[AuthController::class,'logout']);
});


Route::group(['prefix'=>'admin','middleware'=>'RoleMeister:admin'],function(){
  Route::get('/dashboard',[TransactionController::class,'dashboard']);

  Route::group(['prefix'=>'backend'],function(){

      Route::group(['prefix'=>'product'],function(){
        Route::post('store',[ProductController::class,'store']);
        Route::put('/update/{id}',[ProductController::class,'update']);
        Route::delete('/delete/{id}',[ProductController::class,'destroy']);
      });
      Route::group(['prefix'=>'user'],function(){
        Route::post('store',[UserController::class,'store']);
        Route::put('/update/{id}',[UserController::class,'update']);
        Route::delete('/delete/{id}',[UserController::class,'destroy']);
        Route::get('/unblacklist/{id}',[UserController::class,'unblacklist']);
        Route::get('/blacklist/{id}',[UserController::class,'blacklist']);
      });
      Route::group(['prefix'=>'transaksi'],function(){
        Route::post('/search',[TransactionController::class,'search']);
      });
      Route::group(['prefix'=>'rekap'],function(){
      // Memproses rekap data
      Route::post('/rekap', [TransactionController::class, 'rekap'])->name('rekap.process');
      // Mengekspor hasil rekap ke PDF
      Route::post('/exportPDF', [TransactionController::class, 'exportPDF'])->name('rekap.exportPDF');


      });
  });

  Route::group(['prefix'=>'product'],function(){
      Route::get('index',[ProductController::class,'admin']);
      Route::get('add',[ProductController::class,'create']);
      Route::get('/edit/{id}',[ProductController::class,'edit']);
      Route::get('/kategori/{kategori}', [ProductController::class, 'kategori']);
  });
  Route::group(['prefix'=>'user'],function(){
    Route::get('index',[UserController::class,'index']);
    Route::get('add',[UserController::class,'create']);
    Route::get('/edit/{id}',[UserController::class,'edit']);
  });

  Route::group(['prefix'=>'transaksi'],function(){
    Route::get('index',[TransactionController::class,'index']);
    Route::get('/detail/{id}',[TransactionController::class,'detail']);
  });

  Route::group(['prefix'=>'rekap'],function(){
    Route::get('/index', [TransactionController::class, 'showForm'])->name('rekap.form');
    Route::get('data',[TransactionController::class,'showRecap']);

  });
});




Route::group(['prefix'=>'product'],function(){
  Route::get('/detail/{id}',[ProductController::class,'detail']);
});

#worker -----------------------------------------------------

Route::group(['prefix'=>'worker','middleware'=>'RoleMeister:worker'],function(){
  Route::get('/dashboard',[OrderController::class,'home']);
  Route::get('/order',[OrderController::class,'index']);
  Route::get('/konfirmasi',[TransactionController::class,'home']);
});

Route::group(['prefix'=>'order','middleware'=>'RoleMeister:worker'],function(){
  Route::get('/accept/{id}',[OrderController::class,'accept']);
  Route::get('/show/{id}',[OrderController::class,'orderan']);
  Route::get('/finish/{id}',[OrderController::class,'finish']);
  Route::delete('/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
  Route::get('/decline/{id}', [OrderController::class,'decline']);
  Route::get('/filter', [OrderController::class,'filter'])->name('order.filter');

});

Route::group(['prefix'=>'confirm','middleware'=>'RoleMeister:worker'],function(){
  Route::post('/search',[TransactionController::class,'findTransaction']);
  Route::get('/accept/{id}',[TransactionController::class,'accept']);
  Route::get('/decline/{id}',[TransactionController::class,'decline']);
 // Route::delete('/transaction/{id}', [TransactionController::class, 'destroy'])->name('transaction.destroy');
 Route::get('/worker/nota/{id}', [TransactionController::class, 'nota'])->name('nota.cetak');
});


