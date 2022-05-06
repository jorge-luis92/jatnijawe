<?php
namespace App\Http\Controllers;
use App\User;
use App\Estudiante;
use App\Persona;
use App\Lengua;
use App\Beca;
use App\Direccion;
use App\Datos_externo;
use App\Enfermedad_Alergia;
use App\Datos_emergencia;
use App\Discapacidad;
use App\CodigoPostal;
use Illuminate\Support\Facades\DB;
use Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class ActualizacionesEstudiante extends Controller
{
  public function actualizacion_actividades(Request $request)
  {
    $data=$request;
  $usuario_actual=auth()->user();
  $id=$usuario_actual->id_user;
  $now = new \DateTime();
  $periodo_semestre = DB::table('periodos')
  ->select('periodos.id_periodo')
  ->where('periodos.estatus', '=', 'actual')
  ->take(1)
  ->first();
  $periodo_semestre = $periodo_semestre->id_periodo;
if($data['nombre_actividadexterna'] == null){
  return redirect()->route('otras_actividades')->with('success','¡Datos actualizados correctamente!');
}
else{
  $bus_act = DB::table('datos_externos')
  ->select('datos_externos.nombre_actividadexterna', 'datos_externos.hora_entrada', 'datos_externos.hora_salida',
   'datos_externos.tipo_actividadexterna')
  ->where('datos_externos.matricula',$id)
  ->get();

  DB::table('datos_externos')
      ->updateOrInsert(
          ['nombre_actividadexterna' => $data['nombre_actividadexterna'], 'tipo_actividadexterna' => $data['tipo_actividadexterna'],
           'dias_sem'=>  $data['dias_sem'], 'hora_entrada'=>  $data['hora_entrada'], 'hora_salida'=>  $data['hora_salida'],
           'lugar'=>  $data['lugar'], 'matricula'=>  $id, 'periodo' => $periodo_semestre, 'created_at' => $now, 'updated_at' => $now]);
      return redirect()->route('otras_actividades')->with('success','¡Datos actualizados correctamente!');
}
}

public function desactivar_lengua($id_beca){
  $valor=$id_beca;
  DB::table('becas')
      ->where('becas.id_beca', $valor)
      ->update(['bandera' => '0']);
      return redirect()->route('datos_general')->with('success','¡Datos actualizados correctamente!');

}

public function act_actividades(Request $request){
  $data = $request;
  $externos=$data['id_externos'];
  DB::table('datos_externos')
      ->where('datos_externos.id_externos', $externos)
      ->update(
          ['dias_sem' => $data['dias_sem'], 'hora_entrada' => $data['hora_entrada'], 'hora_salida' => $data['hora_salida']]);
      return redirect()->route('otras_actividades')->with('success','¡Datos actualizados correctamente!');
}

public function desactivar_act($id_externos){
  $valor=$id_externos;
  DB::table('datos_externos')
      ->where('datos_externos.id_externos', $valor)
      ->update(
          ['bandera' => '0']);
      return redirect()->route('otras_actividades')->with('success','¡Datos actualizados correctamente!');

}

public function act_datos_personales(Request $request)
{

  $usuario_actual=auth()->user();
  $id=$usuario_actual->id_user;
  $data = $request;

$now = new \DateTime();
$periodo_semestre = DB::table('periodos')
->select('periodos.id_periodo')
->where('periodos.estatus', '=', 'actual')
->take(1)
->first();
  $id_persona = DB::table('estudiantes')
  ->select('estudiantes.id_persona')
  ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
  ->where('estudiantes.matricula',$id)
  ->take(1)
  ->first();
  $id_persona = $id_persona->id_persona;

    $direccion = DB::table('personas')
    ->select('personas.id_direccion')
    ->join('direcciones', 'direcciones.id_direccion', '=', 'personas.id_direccion')
    ->where('personas.id_persona',$id_persona)
    ->take(1)
    ->first();

    $tels = DB::table('personas')
     ->select('telefonos.id_persona')
     ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
     ->where('personas.id_persona',$id_persona)
     ->first();

$codigo=CodigoPostal::find($data['cp']);
if(!empty($codigo->cp)){
if(empty($direccion) or empty($tels)){

  $ultima_d = DB::table('direcciones')
     ->sum('direcciones.id_direccion');
     if(empty($ultima_d)){
       $ultima_d=1;
     }
     else {
       $ultima_d=$ultima_d+1;
     }

     $valor_direccion = DB::table('direcciones')->max('id_direccion');
     $id_direc=intval($id)*3;
     $codigo_de = DB::table('codigos_postales')->select('codigos_postales.municipio', 'codigos_postales.estado')
                           ->where('codigos_postales.cp', $data['cp'])
                           ->take(1)
                           ->first();

$id_direccion= DB::table('direcciones')
      ->updateOrInsert(
          ['id_direccion' => $id_direc ,'vialidad_principal' => $data['vialidad_principal'], 'num_exterior' => $data['num_exterior'],
          'cp' => $data['cp'], 'localidad' =>  $data['localidad'], 'municipio' => $codigo_de->municipio,
               'entidad_federativa' =>$codigo_de->estado,  'created_at' => $now, 'updated_at' => $now]);


      DB::table('personas')
          ->where('personas.id_persona',$id_persona)
          ->update(['id_direccion' => $id_direc]);
     if($data['tel_local'] == null){
          DB::table('telefonos')
              ->updateOrInsert(
                    ['numero' => $data['tel_celular'], 'tipo' => 'celular', 'id_persona' => $id_persona]);
            }
    else {
      DB::table('telefonos')
          ->Insert(
              ['numero' => $data['tel_celular'], 'tipo' => 'local', 'id_persona' => $id_persona]);
          DB::table('telefonos')
              ->Insert(
                  ['numero' => $data['tel_celular'], 'tipo' => 'celular', 'id_persona' => $id_persona]);
    }

          return redirect()->route('datos_personal')->with('success','¡Datos actualizados correctamente!');
}
else {

  $tels_l = DB::table('personas')
   ->select('telefonos.id_persona')
   ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
   ->where([['personas.id_persona', $id_persona], ['telefonos.tipo', '=', 'local']])
   ->first();
if(empty($tels_l)){
 DB::table('telefonos')
            ->Insert(
                ['numero' => $data['tel_local'], 'tipo' => 'local', 'id_persona' => $id_persona]);
}
else{
 DB::table('telefonos')
            ->Insert(
                ['numero' => $data['tel_local'], 'tipo' => 'local', 'id_persona' => $id_persona]);
}

  $direccion = DB::table('personas')
  ->select('personas.id_direccion')
  ->join('direcciones', 'direcciones.id_direccion', '=', 'personas.id_direccion')
  ->where('personas.id_persona',$id_persona)
  ->take(1)
  ->first();

$direcciones= $direccion->id_direccion;
$codigo_de = DB::table('codigos_postales')->select('codigos_postales.municipio', 'codigos_postales.estado')
                      ->where('codigos_postales.cp', $data['cp'])
                      ->take(1)
                      ->first();
  DB::table('direcciones')
      ->where('direcciones.id_direccion', $direcciones)
      ->update(
        ['vialidad_principal' => $data['vialidad_principal'], 'num_exterior' => $data['num_exterior'],
         'localidad' =>  $data['localidad'],  'municipio' => $codigo_de->municipio,
              'entidad_federativa' =>$codigo_de->estado, 'cp' => $data['cp'], 'updated_at' => $now]);
              DB::table('users')
                  ->where('users.id_user', $id)
                  ->update(
                    ['email' => $data['email'], 'facebook' => $data['facebook']]);

          if($data['tel_local'] == null){
             DB::table('telefonos')
                ->where([['telefonos.id_persona', $id_persona], ['telefonos.tipo', '=', 'celular']])
                 ->update(['numero' => $data['tel_celular']]);

               }
       else {
         DB::table('telefonos')
             ->where([['telefonos.id_persona', $id_persona], ['telefonos.tipo', '=', 'local']])
             ->update(['numero' => $data['tel_local']]);

             DB::table('telefonos')
             ->where([['telefonos.id_persona', $id_persona], ['telefonos.tipo', '=', 'celular']])
             ->update(['numero' => $data['tel_celular']]);

       }
        DB::table('telefonos')
            ->where([['telefonos.id_persona',$id_persona], ['telefonos.tipo', '=', 'local']])
            ->update(
              ['numero' => $data['tel_local']]);
              DB::table('telefonos')
                  ->where([['telefonos.id_persona',$id_persona], ['telefonos.tipo', '=', 'celular']])
                  ->update(
                    ['numero' => $data['tel_celular']]);

      return redirect()->route('datos_personal')->with('success','¡Datos actualizados correctamente!');
}}
return redirect()->route('datos_personal')->with('error','¡El código postal que ingreso no existe!');
//return redirect()->back()->withInput(Input::all())->with('error','¡El código postasl que ingreso no existe!');
  }

  public function act_datos_medicos(Request $request)
  {
    $usuario_actual=auth()->user();
    $id=$usuario_actual->id_user;
    $now = new \DateTime();
    $periodo_semestre = DB::table('periodos')
    ->select('periodos.id_periodo')
    ->where('periodos.estatus', '=', 'actual')
    ->take(1)
    ->first();
    $periodo_semestre= $periodo_semestre->id_periodo;
    $ultima = DB::table('personas')
       ->sum('personas.id_persona');
       if(empty($ultima)){
         $ultima=1;
       }
       else {
         $ultima=$ultima+1;
       }

    $id_prueba= $ultima;
    $data = $request;

    $id_persona = DB::table('estudiantes')
    ->select('estudiantes.id_persona')
    ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
    ->where('estudiantes.matricula',$id)
    ->take(1)
    ->first();
    $id_persona = $id_persona->id_persona;


      DB::table('personas')
          ->where('personas.id_persona',$id_persona)
          ->update(
            ['tipo_sangre' => $data['tipo_sangre']]);

        $emergencia_a = DB::table('estudiantes')
        ->select('datos_emergencias.matricula')
        ->join('datos_emergencias', 'datos_emergencias.matricula', '=', 'estudiantes.matricula')
        ->where('estudiantes.matricula',$id)
        ->take(1)
        ->first();

      if(empty($emergencia_a)){
        $persona=new Persona;
        $persona->id_persona=$id_prueba;
        $persona->nombre=$data['nombre'];
        $persona->apellido_paterno=$data['apellido_paterno'];
        $persona->apellido_materno=$data['apellido_materno'];
        $persona->periodo=$periodo_semestre;
        $persona->save();

         $id_guardado = $persona->id_persona;

      DB::table('datos_emergencias')
          ->where('datos_emergencias.matricula',$id)
          ->Insert(
            ['responsable' => $id_guardado, 'parentesco' => $data['parentesco'], 'matricula' => $id, 'periodo' => $periodo_semestre, 'created_at' => $now, 'updated_at' => $now]);
        }
        else{
          //$emergencia_dato= json_decode( json_encode($emergencia_dato), true);
          $responsable_emergencia = DB::table('datos_emergencias')
          ->select('datos_emergencias.responsable')
          ->where('datos_emergencias.matricula',$id)
          ->take(1)
          ->first();
           $responsable_emergencia= json_decode( json_encode($responsable_emergencia), true);
           DB::table('personas')
               ->where('personas.id_persona',$responsable_emergencia)
               ->update(
                 ['nombre' => $data['nombre'], 'apellido_paterno' => $data['apellido_paterno'], 'apellido_materno' => $data['apellido_materno']]);

          DB::table('datos_emergencias')
              ->where('datos_emergencias.matricula',$id)
              ->update(
                ['parentesco' => $data['parentesco']]);
        }

      $emer = DB::table('personas')
      ->select('telefonos.numero')
      ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
      ->where([['telefonos.id_persona',$id_persona], ['telefonos.tipo', '=', 'emergencia']])
      ->take(1)
      ->first();

      $dis = DB::table('personas')
      ->select('discapacidades.id_persona')
      ->join('discapacidades', 'discapacidades.id_persona', '=', 'personas.id_persona')
      ->where('discapacidades.id_persona',$id_persona)
      ->take(1)
      ->first();

      if(empty($emer)){
          DB::table('telefonos')
          //    ->where([['telefonos.id_persona',$id_persona], ['telefonos.tipo', '=', 'emergencia'],])
              ->Insert(
                ['tipo' => 'emergencia', 'numero' => $data['tel_emergencia'], 'id_persona' => $id_persona,
                'created_at' => $now , 'updated_at' => $now]);
        }
        else {
          DB::table('telefonos')
              ->where([['telefonos.id_persona',$id_persona], ['telefonos.tipo', '=', 'emergencia']])
              ->update(
                ['numero' => $data['tel_emergencia']]);
        }

          if($data['nombre_enf_ale'] == null){

             if(empty($dis)){
               DB::table('discapacidades')
                   //->where('discapacidades.id_persona',$dis)
                   ->Insert(
                     ['tipo' => $data['tipo_discapacidad'], 'id_persona' => $id_persona,
                     'periodo' => $periodo_semestre, 'created_at' => $now, 'updated_at' => $now]);
             }else {
                 if($data['tipo_discapacidad'] == null){
                     return redirect()->route('datos_medico')->with('success','¡Datos actualizados correctamente!');
                 }
                 else {
                      DB::table('discapacidades')
                    ->where('discapacidades.id_persona',$id_persona)
                    ->update(
                      ['tipo' => $data['tipo_discapacidad']]);}
    }
            return redirect()->route('datos_medico')->with('success','¡Datos actualizados correctamente!');
          }
        else {
        DB::table('enfermedades_alergias')
        //    ->where([['telefonos.id_persona',$id_persona], ['telefonos.tipo', '=', 'emergencia'],])
            ->Insert(
              ['nombre_enfermedadalergia' => $data['nombre_enf_ale'], 'tipo_enfermedadalergia' => $data['tipo_enfer'],
              'descripcion' => $data['des_enf_ale'], 'indicaciones' => $data['ind_enf_ale'], 'matricula' => $id,
              'periodo' => $periodo_semestre, 'created_at' => $now, 'updated_at' => $now]);
            $dis = DB::table('personas')
            ->select('discapacidades.id_persona')
            ->join('discapacidades', 'discapacidades.id_persona', '=', 'personas.id_persona')
            ->where('discapacidades.id_persona',$id_persona)
            ->take(1)
            ->first();
             if(empty($dis)){
               DB::table('discapacidades')
                   //->where('discapacidades.id_persona',$dis)
                   ->Insert(
                     ['tipo' => $data['tipo_discapacidad'], 'id_persona' => $id_persona,
                     'periodo' => $periodo_semestre, 'created_at' => $now, 'updated_at' => $now]);
             }else {
               if($data['tipo_discapacidad'] == null){
                   return redirect()->route('datos_medico')->with('success','¡Datos actualizados correctamente!');
               }else {
                          DB::table('discapacidades')
                    ->where('discapacidades.id_persona',$dis)
                    ->update(
                      ['tipo' => $data['tipo_discapacidad']]);
    }}

          }

  return redirect()->route('datos_medico')->with('success','¡Datos actualizados correctamente!');




    }
}
