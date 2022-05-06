<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
  protected $table = 'estudiantes';
  protected $primaryKey = 'matricula'; // or null
 public $incrementing = false;
 protected $fillable = [
     'matricula', 'modalidad','fecha_ingreso', 'semestre','grupo','estatus','bachillerato_origen',
     'id_persona', 'sede', 'periodo', 'materias_pendientes', 'egresado',
 ];




}
