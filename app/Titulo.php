<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Titulo extends Model
{
  protected $table = 'titulos';
  protected $primaryKey = 'id_titulo'; // or null
 //public $incrementing = false;
 protected $fillable = ['bandera_titulo','fecha_expedicion', 'modalidad_tit', 'motivos_notitulado', 'id_egresado',];
}
