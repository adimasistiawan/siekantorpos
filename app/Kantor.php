<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kantor extends Model
{
    public $table = 'kantor';
    protected $fillable = ['nama','alamat','no_telepon','jenis','status'];
}
