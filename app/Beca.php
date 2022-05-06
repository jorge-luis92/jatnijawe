<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beca extends Model
{
  protected $table = 'becas';
  protected $primaryKey = 'id_beca'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'nombre', 'tipo_beca', 'monto', 'matricula', 'bandera', 'periodo',
 ];
}
