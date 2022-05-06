<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
  protected $table = 'carreras';
  protected $primaryKey = 'clave_carrera'; // or null
  //public $incrementing = false;
  protected $fillable = ['clave_carrera', 'clave_institucion', 'facultad', 'carrera', 'modalidad'];

}
