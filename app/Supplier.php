<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public $table = 'supplier';
    protected $fillable = ['nama','alamat','no_telepon'];
}
