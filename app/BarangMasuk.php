<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table= 'barang_masuk';
    protected $fillable= ['id','kode','supplier_id', 'user_id','tanggal','keterangan'];
    public function supplier()
    {
        return $this->belongsTo('App\Supplier','supplier_id','id');    
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');    
    }
}
