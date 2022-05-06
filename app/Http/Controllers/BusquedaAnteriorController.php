<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Extracurricular;
use App\Detalle_extracurricular;
use App\Estudiante;
use App\Persona;
use App\Administrativo;
use App\Nivel;
use App\Departamento;
use App\Dpto_Administrativo;
use App\Telefono;
use App\Tutor;
use App\Alumno;
use App\AlumnoCurso;
use App\SolicitudTaller;
use Illuminate\Support\Facades\DB;
use Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use PDF;
use Dompdf\Dompdf;

class BusquedaAnteriorController extends Controller
{
  public function vista_atras()
  {
  return view('personal_administrativo/formacion_integral.busqueda_atras');
  }


  protected function anteriores_busqueda(Request $request){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='1'){
       return redirect('perfiles');
      }

    $q = $request->get('q');
    if($q != null){
    $user = Alumno::where( 'alumnos.nombre', 'LIKE', '%' . $q . '%' )
                        ->orWhere ( 'alumnos.ID', 'LIKE', '%' . $q . '%' )
                        ->simplePaginate(10);


    if (count($user) > 0 ) {
        return view ( 'personal_administrativo/formacion_integral.busqueda_atras' )->withDetails ($user )->withQuery ($q);
  }
  else{
  return redirect()->route('busqueda_atras')->with('error','¡Sin resultados!');
  }}  else{
      return redirect()->route('busqueda_atras')->with('error','¡Sin resultados!');
  }
  }

  protected function ver_avance($ID){

    $id_usr=$ID;

    $result = DB::table('alumcur')
    ->select('alumcur.nombre', 'alumcur.creditos', 'alumcur.tutor', 'alumcur.status', 'alumcur.fecha', 'alumcur.area')
    ->where([['alumcur.id_usr','=', $id_usr], ['alumcur.status', '=', 'si'],])
    ->orderBy('alumcur.nombre', 'asc')
    ->simplePaginate(10);

    $academicas = DB::table('alumcur')
     ->where([['alumcur.id_usr', '=', $id_usr], ['alumcur.status', 'LIKE', 'si'], ['alumcur.area', '=', 'ACADEMICA']])
      ->sum('alumcur.creditos');
    $culturales = DB::table('alumcur')
     ->where([['alumcur.id_usr', '=', $id_usr], ['alumcur.status', '=', 'si'], ['alumcur.area', '=', 'CULTURAL']])
     ->sum('alumcur.creditos');
    $deportivas = DB::table('alumcur')
    ->where([['alumcur.id_usr', '=', $id_usr], ['alumcur.status', '=', 'si'], ['alumcur.area', '=', 'DEPORTIVA']])
    ->sum('alumcur.creditos');

    $sumas = $academicas + $culturales + $deportivas;

    $nombre = DB::table('alumnos')
    ->select('alumnos.nombre')
    ->where('alumnos.ID',$id_usr)
    ->take(1)
    ->first();

  return  view ('personal_administrativo/formacion_integral.avance_pasado')
  ->with('dato', $result)
  ->with('aca',$academicas)
  ->with('cul',$culturales)
  ->with('dep',$deportivas)
  ->with('suma',$sumas)
  ->with('estudiante', $nombre);
  }

  protected function constancia_par($ID){
    $id_usr=$ID;
    $datos_estudiante = DB::table('alumnos')
    ->select('alumnos.nombre')
    ->where('alumnos.ID',$id_usr)
    ->take(1)
    ->first();
    $academicas = DB::table('alumcur')
     ->select('alumcur.nombre', 'alumcur.id_curso')
     ->where([['alumcur.id_usr', '=', $id_usr], ['alumcur.status', '=', 'si'], ['alumcur.area', '=', 'ACADEMICA']])
     ->orderBy('alumcur.nombre', 'asc')
      ->get();
    $culturales = DB::table('alumcur')
    ->select('alumcur.nombre')
    ->where([['alumcur.id_usr', '=', $id_usr], ['alumcur.status', '=', 'si'], ['alumcur.area', '=', 'CULTURAL']])
    ->orderBy('alumcur.nombre', 'asc')
     ->get();
    $deportivas = DB::table('alumcur')
    ->select('alumcur.nombre')
    ->where([['alumcur.id_usr', '=', $id_usr], ['alumcur.status', '=', 'si'], ['alumcur.area', '=', 'DEPORTIVA']])
    ->orderBy('alumcur.nombre', 'asc')
     ->get();

    $paper_orientation = 'letter';
    $customPaper = array(2.5,2.5,600,950);
	$pdf = app('dompdf.wrapper');
    $pdf->getDomPDF()->set_option("enable_php", true);
    $pdf = PDF::loadView('personal_administrativo/formacion_integral/constancias_anteriores.constancia_parcial', ['data' =>  $datos_estudiante,
    'aca' => $academicas, 'cul' => $culturales, 'dep' => $deportivas])
    ->setPaper($customPaper,$paper_orientation);

    return $pdf->stream('constancia_parcial.pdf');
  }

  protected function constancia_val($ID){
 $usuario_actual=auth()->user();
    if($usuario_actual->tipo_usuario!='1'){
      return redirect()->back(); }
        $ids=$usuario_actual->id_user;
    $id_usr=$ID;
    $datos_estudiante = DB::table('alumnos')
    ->select('alumnos.nombre')
    ->where('alumnos.ID',$id_usr)
    ->take(1)
    ->first();
    $academicas = DB::table('alumcur')
     ->select('alumcur.nombre', 'alumcur.id_curso')
     ->where([['alumcur.id_usr', '=', $id_usr], ['alumcur.status', '=', 'si'], ['alumcur.area', '=', 'ACADEMICA']])
     ->sum('alumcur.creditos');

    $culturales = DB::table('alumcur')
    ->select('alumcur.nombre')
    ->where([['alumcur.id_usr', '=', $id_usr], ['alumcur.status', '=', 'si'], ['alumcur.area', '=', 'CULTURAL']])
    ->sum('alumcur.creditos');

    $deportivas = DB::table('alumcur')
    ->select('alumcur.nombre')
    ->where([['alumcur.id_usr', '=', $id_usr], ['alumcur.status', '=', 'si'], ['alumcur.area', '=', 'DEPORTIVA']])
    ->sum('alumcur.creditos');
    $sumas = $academicas + $culturales + $deportivas;

  $datos_coordi = DB::table('users')
  ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
  ->join('personas', 'personas.id_persona', '=', 'users.id_persona')
  ->where('users.id_user',$ids)
  ->take(1)
  ->first();

  $id_persona_pl = DB::table('users')
  ->select('users.id_persona')
  ->join('personas', 'personas.id_persona', '=', 'users.id_persona')
  ->where('users.tipo_usuario', '=', '2')
  ->take(1)
  ->first();

    $id_persona_pl= $id_persona_pl->id_persona;
    $id_admin = DB::table('administrativos')
    ->select('administrativos.id_administrativo')
    ->where('administrativos.id_persona', $id_persona_pl)
    ->take(1)
    ->first();

    $id_admin= $id_admin->id_administrativo;

  $id_directores = DB::table('escuelas')
  ->select('escuelas.director')
  ->where('escuelas.responsable', $id_admin)
  ->take(1)
  ->first();
  $id_directores= json_decode( json_encode($id_directores), true);

  $datos_director = DB::table('personas')
  ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
  ->where('personas.id_persona',$id_directores )
  ->take(1)
  ->first();
    $paper_orientation = 'letter';
    $customPaper = array(2.5,2.5,600,950);

    $pdf = PDF::loadView('personal_administrativo/formacion_integral/constancias_anteriores.constancia_oficial', ['data' =>  $datos_estudiante,
    'aca' => $academicas, 'cul' => $culturales, 'dep' => $deportivas, 'suma' => $sumas, 'datos_coordinadora' => $datos_coordi, 'director' => $datos_director])
    ->setPaper($customPaper,$paper_orientation);
    return $pdf->stream('constancia_parcial.pdf');

  }

  protected function constancia_valida($ID){
  $id=$ID;
    $datos_estudiante = DB::table('estudiantes')
     ->select('estudiantes.modalidad', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
    ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
    ->where('estudiantes.matricula',$id)
    ->take(1)
    ->first();

  $academicas = DB::table('detalle_extracurriculares')
   ->join('extracurriculares', 'extracurriculares.id_extracurricular', '=', 'detalle_extracurriculares.actividad')
   ->where([['detalle_extracurriculares.matricula', '=', $id], ['detalle_extracurriculares.estado', '=', 'Acreditado'], ['extracurriculares.area', 'LIKE', 'ACADEMICA'],])
    ->sum('detalle_extracurriculares.creditos');
  $culturales = DB::table('detalle_extracurriculares')
   ->join('extracurriculares', 'extracurriculares.id_extracurricular', '=', 'detalle_extracurriculares.actividad')
   ->where([['detalle_extracurriculares.matricula', '=', $id], ['detalle_extracurriculares.estado', '=', 'Acreditado'], ['extracurriculares.area', '=', 'CULTURAL'],])
   ->sum('detalle_extracurriculares.creditos');
  $deportivas = DB::table('detalle_extracurriculares')
  ->join('extracurriculares', 'extracurriculares.id_extracurricular', '=', 'detalle_extracurriculares.actividad')
  ->where([['detalle_extracurriculares.matricula', '=', $id], ['detalle_extracurriculares.estado', '=', 'Acreditado'], ['extracurriculares.area', '=', 'DEPORTIVA'],])
  ->sum('detalle_extracurriculares.creditos');
  $sumas = $academicas + $culturales + $deportivas;
  if(($datos_estudiante->modalidad) == 'ESCOLARIZADA'){
  if($academicas >= 80 && $sumas >= 200){
      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('personal_administrativo/formacion_integral/constancias_anteriores.constancia_oficial', ['data' =>  $datos_estudiante,
   'aca' => $academicas, 'cul' => $culturales, 'dep' => $deportivas, 'suma' => $sumas])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('constancia_oficial.pdf');
 }
 else{
   return redirect()->route('busqueda_estudiante_fi')->with('error','¡El Estudiante no cumple con los requisitos para generar la constancia!');
 }
}else {
  if(($datos_estudiante->modalidad) == 'SEMI ESCOLARIZADA'){
  if($academicas >= 80 && $sumas >= 200){
      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('personal_administrativo/formacion_integral/constancias_anteriores.constancia_oficial', ['data' =>  $datos_estudiante,
   'aca' => $academicas, 'cul' => $culturales, 'dep' => $deportivas, 'suma' => $sumas])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('constancia_oficial.pdf');
 }
 else{
   return redirect()->route('busqueda_estudiante_fi')->with('error','¡El Estudiante no cumple con los requisitos para generar la constancia!');
 }
}
  }
}


public function vista_atras_es()
{
  $usuario_actual=\Auth::user();
  $id=$usuario_actual->id_user;
   if($usuario_actual->tipo_usuario!='estudiante'){
     return redirect('perfiles');
    }
	 $lineamiento_checar = DB::table('users')
        ->select('users.check_lineamiento')
        ->where('users.id_user', $id)
        ->take(1)
        ->first();
		if($lineamiento_checar->check_lineamiento == 0){
			 return redirect()->route('lineamientos')
			 ->with('error', '¡Para poder usar los Servicios del Portal debes leer y aceptar los lineamientos del mismo!');
		}
return view('estudiante.busqueda_de');
}


protected function anteriores_busqueda_es(Request $request){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='estudiante'){
     return redirect('perfiles');
    }

  $q = $request->get('q');
  if($q != null){
  $user = Alumno::where( 'alumnos.nombre', 'LIKE', '%' . $q . '%' )
                      ->orWhere ( 'alumnos.ID', 'LIKE', '%' . $q . '%' )
                      ->simplePaginate(10);


  if (count($user) > 0 ) {
      return view ( 'estudiante.busqueda_de' )->withDetails ($user )->withQuery ($q);
}
else{
return redirect()->route('registro_anterior')->with('error','¡Sin resultados!');
}}  else{
    return redirect()->route('registro_anterior')->with('error','¡Sin resultados!');
}
}

protected function ver_avance_es($ID){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='estudiante'){
     return redirect('perfiles');
    }

  $id_usr=$ID;

  $result = DB::table('alumcur')
  ->select('alumcur.nombre', 'alumcur.creditos', 'alumcur.tutor', 'alumcur.status', 'alumcur.fecha', 'alumcur.area')
  ->where([['alumcur.id_usr','=', $id_usr], ['alumcur.status', '=', 'si'],])
  ->orderBy('alumcur.nombre', 'asc')
  ->simplePaginate(10);

  $academicas = DB::table('alumcur')
   ->where([['alumcur.id_usr', '=', $id_usr], ['alumcur.status', 'LIKE', 'si'], ['alumcur.area', '=', 'ACADEMICA']])
    ->sum('alumcur.creditos');
  $culturales = DB::table('alumcur')
   ->where([['alumcur.id_usr', '=', $id_usr], ['alumcur.status', '=', 'si'], ['alumcur.area', '=', 'CULTURAL']])
   ->sum('alumcur.creditos');
  $deportivas = DB::table('alumcur')
  ->where([['alumcur.id_usr', '=', $id_usr], ['alumcur.status', '=', 'si'], ['alumcur.area', '=', 'DEPORTIVA']])
  ->sum('alumcur.creditos');

  $sumas = $academicas + $culturales + $deportivas;

  $nombre = DB::table('alumnos')
  ->select('alumnos.nombre')
  ->where('alumnos.ID',$id_usr)
  ->take(1)
  ->first();

return  view ('estudiante.avance_estu')
->with('dato', $result)
->with('aca',$academicas)
->with('cul',$culturales)
->with('dep',$deportivas)
->with('suma',$sumas)
->with('estudiante', $nombre);
}

}
