<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    //
    use HasFactory;
    protected $fillable = ['kode_sup','nama_sup','nama_perusahaan','no_tel_sup','alamat_sup'];
    protected $table ='supplier';
    public $timestamps = false;

    public function masuk(){
        return $this->hasOne('App/Models/masuk');
    }

    public function keluar(){
        return $this->hasOne('App/Models/keluar');
    }
}
