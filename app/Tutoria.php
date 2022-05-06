<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutoria extends Model
{
  protected $table = 'tutorias';
 protected $fillable = ['matricula','periodo', 'acompaniamiento_tutor', 'desempenio_tutor', 'area_academico', 'area_emocional', 'area_salud', 'area_valores', 'area_relaciones',];
}
