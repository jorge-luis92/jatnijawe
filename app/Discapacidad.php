<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discapacidad extends Model
{
  protected $table = 'discapacidades';
  protected $primaryKey = 'id_discapacidad'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'tipo', 'id_persona',
 ];
}
