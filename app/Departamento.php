<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
  protected $fillable = [
      'id_departamento','departamento','periodo',
  ];
}
