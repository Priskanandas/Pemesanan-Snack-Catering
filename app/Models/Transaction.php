<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = "transactions";
    protected $fillable = [
        'date',
        'userId',
        'orderId',
        'grandtotal',
        'statusorder',
        'metodePembayaran',
        'pengambilan',
        'TanggalPengambilan',
        'bukti',
        'kodetransaksi',
        'token',
        'status',
        'penerima',
        'DeskripsiPemesanan',
        'recap'
    ];
    public function order(){
        return $this->hasOne('App\Models\Order');
}
}