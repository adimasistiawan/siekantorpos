<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangKeluarDetail extends Model
{
    protected $table= 'barang_keluar_detail';
    protected $fillable= ['id','barangkeluar_id', 'barang_id','jumlah'];
    public function barang()
    {
        return $this->belongsTo('App\Barang','barang_id','id');    
    }
}
