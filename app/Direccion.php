<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
  protected $table = 'direcciones';
  protected $primaryKey = 'id_direccion'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'id_direccion', 'vialidad_principal', 'vialidad_derecha','vialidad_izquierda', 'vialidad_psterior', 'num_exterior',
     'num_interior', 'cp', 'localidad', 'municipio', 'entidad_federativa', 'asentamiento_humano',
 ];
}
