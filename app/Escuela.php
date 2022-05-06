<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
  protected $table = 'escuelas';
  protected $primaryKey = 'clave_institucion'; // or null
  //public $incrementing = false;
  protected $fillable = ['clave_institucion', 'clave_escuela', 'nombre_escuela','id_direccion', 'dependencia_normativa', 'institucion_perteneciente',
  'director', 'pagina_web_escuela', 'responsable',];

}
