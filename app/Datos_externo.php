<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datos_externo extends Model
{
  protected $table = 'datos_externos';
  protected $primaryKey = 'id_externos'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'nombre_actividadexterna', 'tipo_actividadexterna','dias_sem', 'hora_entrada','hora_salida','lugar',
     'matricula', 'periodo',
 ];




}
