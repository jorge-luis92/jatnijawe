<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodigoPostal extends Model
{
  protected $table = 'codigos_postales';
  protected $primaryKey = 'cp'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'colonia', 'municipio','estado',
 ];
}
