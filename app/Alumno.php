<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
  protected $table = 'alumnos';
  //protected $primaryKey = 'ID'; // or null
//public $incrementing = false;
 protected $fillable = [
     'ID', 'rfc', 'nombre', 'sexo', 'lengua','curso','semestre', 'modalidad', 
 ];
}
