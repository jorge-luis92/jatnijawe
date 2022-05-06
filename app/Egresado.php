<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egresado extends Model
{
  protected $table = 'egresados';
  protected $primaryKey = 'id_egresado'; // or null
 //public $incrementing = false;
 protected $fillable = ['matricula','clave_institucion', 'generacion', 'promedio_final', 'periodo'];
}
