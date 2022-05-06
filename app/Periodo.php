<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
  protected $table = 'periodos';
  protected $primaryKey = 'id_periodo'; // or null
 //public $incrementing = false;
 protected $fillable = ['inicio','final', 'estatus',];
}
