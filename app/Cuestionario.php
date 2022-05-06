<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuestionario extends Model
{
  protected $table = 'cuestionarios';
  protected $primaryKey = 'id_cuestionario'; // or null
 //public $incrementing = false;
 protected $fillable = ['razon_carrera','bandera_posgrado', 'posgrado', 'otros_estudios', 'grado_satisfaccion', 'bandera_lamisma', 'la_misma', 'id_egresado', 'periodo',];
}
