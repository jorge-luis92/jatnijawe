<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
  protected $table = 'notificaciones';
//  protected $primaryKey = 'id_nivel'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'matricula','num_solicitud', 'asunto','mensaje', 'estatus',
 ];
}
