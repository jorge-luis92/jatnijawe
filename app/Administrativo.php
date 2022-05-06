<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrativo extends Model
{
  protected $table = 'administrativos';
  protected $primaryKey = 'id_administrativo'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'puesto','id_persona','id_nivel',
 ];
}
