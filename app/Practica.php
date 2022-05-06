<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practica extends Model
{
  protected $table = 'practicas';
  protected $primaryKey = 'id_practicas'; // or null
 //public $incrementing = false;
 protected $fillable = ['matricula','clave_carrera', 'id_departamento', 'nombre_dependencia', 'titular', 'cargo_titular', 'fecha',
 'periodo', 'tipo',];
}
