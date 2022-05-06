<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datos_emergencia extends Model
{
  protected $table = 'datos_emergencia';
  protected $primaryKey = 'id_de'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'responsable', 'parentesco', 'matricula', 'periodo',
 ];
}
