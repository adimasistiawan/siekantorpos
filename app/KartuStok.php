<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KartuStok extends Model
{
    protected $table= 'kartu_stok';
    protected $fillable= ['id','barang_id', 'tanggal','stok_awal','masuk','keluar','sisa'];
    public function barang()
    {
        return $this->belongsTo('App\Barang','barang_id','id');    
    }
}
