<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
  protected $table = 'extracurriculares';
  protected $primaryKey = 'id_extracurricular'; // or null
 //public $incrementing = false;
 protected $fillable = [
     'id_extracurricular', 'nombre_ec','creditos', 'area','modalidad','cupo','lugar', 'fecha_inicio', 'fecha_fin',
     'hora_inicio', 'hora_fin', 'dias_sem', 'materiales', 'tutor', 'periodo', 'bandera', 'observaciones', 
 ];



   public function store(Request $request)
   {
       // Validate the request...

       $table = new Extracurricular;

       $table->nombre_ec = $request->nombre_ec;

       $table->save();
   }
}
