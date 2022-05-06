<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FechaActualizacion extends Model
{
  protected $table = 'periodo_actualizacion';
  protected $primaryKey = 'id_actualizacion'; // or null
 //public $incrementing = false;
 protected $fillable = ['fecha_inicio','fecha_fin',];
}
