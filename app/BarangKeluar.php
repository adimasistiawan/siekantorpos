<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table= 'barang_keluar';
    protected $fillable= ['id','kode','kantor_id', 'user_id','tanggal','keterangan'];
    public function kantor()
    {
        return $this->belongsTo('App\Kantor','kantor_id','id');    
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');    
    }
}
