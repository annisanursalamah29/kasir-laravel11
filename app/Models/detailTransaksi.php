<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\transaksi;
use App\Models\produk;

class detailTransaksi extends Model
{
    protected $table = 'detail_transaksis';
    protected $fillable = [
        'transaksi_id',
        'kode_produk',
        'jumlah',
        'harga_satuan',
        'subtotal'
    ];

    public function transaksi()
    {
        return $this->belongsTo(transaksi::class);
    }

    public function produk()
    {
        return $this->belongsTo(produk::class, 'kode_produk', 'kode_produk');
    }
}
