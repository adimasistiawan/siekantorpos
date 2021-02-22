<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenyesuaianStok extends Model
{
    protected $table= 'penyesuaian_stok';
    protected $fillable= ['id','barang_id', 'stok_sistem','stok_aktual','selisih'];
    public function barang()
    {
        return $this->belongsTo('App\Barang','barang_id','id');    
    }
}
