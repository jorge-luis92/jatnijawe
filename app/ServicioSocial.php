<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioSocial extends Model
{
  protected $table = 'servicio_sociales';
  //protected $primaryKey = 'id_periodo'; // or null
 //public $incrementing = false;
 protected $fillable = ['id_practicas','estatus_servicio', 'procentaje_avance',];
}
