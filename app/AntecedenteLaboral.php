<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntecedenteLaboral extends Model
{
  protected $table = 'antecedentes_laborales';
  protected $primaryKey = 'id_antlab'; // or null
 //public $incrementing = false;
 protected $fillable = ['bandera_laboractual','lugar_labor_actual', 'bandera_coincidencia', 'ingreso_mensual', 'antiguedad',
 'trabajo_anterior', 'funcion_trabajo_anterior', 'id_egresado', 'periodo',];
}
