<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangMasukDetail extends Model
{
    protected $table= 'barang_masuk_detail';
    protected $fillable= ['id','barangmasuk_id', 'barang_id','jumlah'];
    public function barang()
    {
        return $this->belongsTo('App\Barang','barang_id','id');    
    }
}
