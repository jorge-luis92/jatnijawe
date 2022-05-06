<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
  protected $table = 'nivel';
  protected $primaryKey = 'id_nivel'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'rfc','grado_estudios',
 ];
}
