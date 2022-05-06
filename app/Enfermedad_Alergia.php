<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enfermedad_Alergia extends Model
{
  protected $table = 'enfermedades_alergias';
  protected $primaryKey = 'id_enfermedad'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'nombre_enfermedadalergia', 'tipo_enfermedadalergia','descripcion', 'indicaciones','matricula', 'periodo',
 ];
}
