<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lengua extends Model
{
  protected $table = 'lenguas';
  protected $primaryKey = 'id_lengua'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'nombre_lengua','tipo','id_persona', 'periodo',
 ];
}
