<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_extracurricular extends Model
{
  protected $table = 'detalle_extracurriculares';
  protected $primaryKey = 'id_detalle_extracurricular'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'id_detalle_extracurricular', 'matricula','actividad', 'creditos','estado', 'periodo',
 ];
}
