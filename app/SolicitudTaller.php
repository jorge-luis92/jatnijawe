<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudTaller extends Model
{
  protected $table = 'solicitud_talleres';
  protected $primaryKey = 'num_solicitud'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'fecha_solicitud','nombre_taller', 'duracion', 'area', 'lugar', 'fecha_inicio', 'fecha_fin','hora_inicio',
     'hora_fin', 'dias_sem','descripcion', 'objetivos', 'justificacion', 'creditos', 'proyecto_final',
     'materiales',  'cupo', 'matricula', 'departamento', 'periodo', 'estado',
 ];
}
    
