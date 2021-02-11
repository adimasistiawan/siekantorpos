<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermintaanBarang extends Model
{
    protected $table= 'permintaan_barang_detail';
    protected $fillable= ['id','tanggal_diminta','tanggal_dipenuhi','kantor_id','diminta_oleh','dipenuhi_oleh','status'];
    
    public function kantor()
    {
        return $this->belongsTo('App\Kantor','kantor_id','id');    
    }

    public function diminta()
    {
        return $this->belongsTo('App\User','diminta_oleh','id');    
    }

    public function dipenuhi()
    {
        return $this->belongsTo('App\User','dipenuhi_oleh','id');    
    }

}
