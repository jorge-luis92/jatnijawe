<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlumnoCurso extends Model
{
  protected $table = 'alumncur';
  //protected $primaryKey = 'ID'; // or null
//public $incrementing = false;
 protected $fillable = [
     'id', 'id_usr', 'id_curso', 'nombre', 'fecha','horas','creditos', 'tutor','status','area',
 ];
}
