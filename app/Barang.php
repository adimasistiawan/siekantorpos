<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    public $table = 'barang';
    protected $fillable = ['nama','satuan_id','stok','status'];
    public function satuan()
    {
        return $this->belongsTo('App\Satuan','satuan_id','id');    
    }
}
