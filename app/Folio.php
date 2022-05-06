<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folio extends Model
{
  protected $table = 'folios';
//  protected $primaryKey = 'id_nivel'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'matricula','num_folio', 'fecha',
 ];
}
