<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PracticaProfesional extends Model
{
     protected $table = 'practicas_profesionales';
    //  protected $primaryKey = ''; // or null
     //public $incrementing = false;
     protected $fillable = ['id_practicas','id_telefono', 'id_direccion', 'estatus_practica', 'periodo_practicas'];
}
