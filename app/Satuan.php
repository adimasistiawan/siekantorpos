<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    public $table = 'satuan';
    protected $fillable = ['nama'];
}
