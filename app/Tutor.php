<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
  protected $table = 'tutores';
  protected $primaryKey = 'id_tutor'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'procedencia_interna','procedencia_externa','id_persona', 'id_nivel', 'periodo',
 ];
}
