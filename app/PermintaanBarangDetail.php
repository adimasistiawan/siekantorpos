<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermintaanBarangDetail extends Model
{
    protected $table= 'permintaan_barang_detail';
    protected $fillable= ['id','permintaan_id','barang_id','jumlah_diminta','jumlah_dipenuhi'];
    
    public function barang()
    {
        return $this->belongsTo('App\Barang','barang_id','id');    
    }
}
