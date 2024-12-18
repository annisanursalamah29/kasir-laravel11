<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\detailTransaksi;

class transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = [
        'tanggal',
        'total_harga',
        'jumlah_bayar',
        'kembalian'
    ];

    public function detail()
    {
        return $this->hasMany(detailTransaksi::class);
    }
}
