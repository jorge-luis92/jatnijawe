<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
  protected $table = 'telefonos';
  protected $primaryKey = 'id_telefono'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'tipo','lada','numero', 'extension','id_persona',
 ];
}
