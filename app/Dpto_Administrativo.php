<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dpto_Administrativo extends Model
{
  protected $table = 'dpto_admtvos';
  //protected $primaryKey = 'id_administrativo'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'id_departamento','id_administrativo','periodo',
 ];
}
