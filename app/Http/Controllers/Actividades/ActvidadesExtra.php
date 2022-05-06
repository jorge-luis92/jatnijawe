<?php
namespace App\Http\Controllers\Actividades;
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
class ActvidadesExtra extends Controller
{
    public function catalogos(){

      $usuario_actual=\Auth::user();
        $id=$usuario_actual->id_user;
       if($usuario_actual->tipo_usuario!='estudiante'){
        return redirect()->back();
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
        $id_persona = DB::table('personas')
        ->select('personas.id_persona')
        ->join('estudiantes', 'estudiantes.id_persona', '=', 'personas.id_persona')
        ->where('estudiantes.matricula', $id)
        ->take(1)
        ->first();

        $id_tutores = DB::table('tutores')
        ->select('tutores.id_tutor')->join('personas', 'personas.id_persona', '=' ,'tutores.id_persona')
        ->join('estudiantes', 'estudiantes.id_persona', '=' ,'personas.id_persona')->where('estudiantes.matricula', $id)->take(1)
        ->first();
        $now = new \DateTime();
        if(empty($id_tutores->id_tutor)){
        $result = DB::table('extracurriculares')
        ->select('extracurriculares.id_extracurricular',  'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
        'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.control_cupo', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
        'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.lugar', 'extracurriculares.hora_fin', 'tutores.id_tutor',
        'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
        ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
        ->where([['extracurriculares.control_cupo', '>', '0'], ['extracurriculares.bandera', '=', '1']])->whereDate('extracurriculares.fecha_inicio', '>', $now)
        ->orderBy('personas.nombre', 'asc')->simplePaginate(10);
    return view("estudiante/mis_actividades.catalogo_actividades")->with('dato', $result);
  }
  else {
    $result = DB::table('extracurriculares')
    ->select('extracurriculares.id_extracurricular',  'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
    'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.control_cupo', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
    'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.lugar', 'extracurriculares.hora_fin', 'tutores.id_tutor',
    'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
    ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
    ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
    ->where([['extracurriculares.control_cupo', '>', '0'], ['extracurriculares.bandera', '=', '1'], ['tutores.id_tutor', '!=', $id_tutores->id_tutor]])
    ->whereDate('extracurriculares.fecha_inicio', '>', $now)
    ->orderBy('personas.nombre', 'asc')
    ->simplePaginate(10);
return view("estudiante/mis_actividades.catalogo_actividades")->with('dato', $result);
  }
  }


    public function inscripcion_extra($id_extracurricular, $creditos){
      $extra= $id_extracurricular;
      $credito= $creditos;
      $usuario_actual=auth()->user();
      $id=$usuario_actual->id_user;
           $aa = DB::table('detalle_extracurriculares')
      ->select('detalle_extracurriculares.actividad')
      ->join('estudiantes', 'estudiantes.matricula', '=', 'detalle_extracurriculares.matricula')
        ->where([['estudiantes.matricula',$id], ['detalle_extracurriculares.actividad', $extra]])
      ->take(1)
      ->first();
if(empty($aa)){
  $periodo_semestre = DB::table('periodos')
  ->select('periodos.id_periodo')
  ->where('periodos.estatus', '=', 'actual')
  ->take(1)
  ->first();
 $periodo_semestre= $periodo_semestre->id_periodo;
 $result = DB::table('extracurriculares')
 ->select('extracurriculares.control_cupo')
->where('extracurriculares.id_extracurricular',$extra )
->take(1)
->first();
  $inscripcion = new Detalle_extracurricular;
  $inscripcion->matricula= $id;
  $inscripcion->actividad= $extra;
  $inscripcion->creditos= $credito;
  $inscripcion->estado= 'Cursando';
  $inscripcion->periodo= $periodo_semestre;
  $inscripcion->save();
       $reducir=($result->control_cupo)-1;
          DB::table('extracurriculares')
              ->where('extracurriculares.id_extracurricular',$extra )
              ->update(['control_cupo' => $reducir]);
      return redirect()->route('mis_actividades')->with('success','¡Inscripción Realizada correctamente!');
    }
    else {
        return redirect()->route('catalogo')->with('error','Ya estás inscrito en esta actividad!');
    }
  }

protected function envio_taller(Request $request){

$data=$request;
$usuario_actual=auth()->user();
$id=$usuario_actual->id_user;

        $fecha_inicio = DB::table('periodo_actualizacion')
        ->select('periodo_actualizacion.fecha_inicio')
        ->where('periodo_actualizacion.tipo', '=', 'taller')
        ->take(1)
        ->first();
        if(empty($fecha_inicio->fecha_inicio)){
          return redirect()->route('home_estudiante')->with('error', 'El periodo de envío de Solicitud de taller aún no empieza');
        }
        else {
          $fecha_inicio= $fecha_inicio ->fecha_inicio;
          $fecha_fin = DB::table('periodo_actualizacion')
          ->select('periodo_actualizacion.fecha_fin')
          ->where('periodo_actualizacion.tipo', '=', 'taller')
          ->take(1)
          ->first();
          $fecha_fin= $fecha_fin ->fecha_fin;
          $now = new \DateTime();
             $fechas_inicio =  date('d-m-Y', strtotime($fecha_inicio));
             $fechas_fin =  date('d-m-Y', strtotime($fecha_fin));
             $now =  date('d-m-Y');
             $actualizacion='';
            
          $periodo_semestre = DB::table('periodos')
->select('periodos.id_periodo')
->where('periodos.estatus', '=', 'actual')
->take(1)
->first();
$periodo_semestre= $periodo_semestre->id_periodo;

$detalles = DB::table('solicitud_talleres')
->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.matricula')
//->where('solicitud_talleres.matricula',$id)
->where([['solicitud_talleres.bandera','=', '1'], ['solicitud_talleres.matricula',$id],
['solicitud_talleres.periodo',$periodo_semestre]])
->take(1)
->first();

if(empty($detalles->matricula)){
$now = new \DateTime();
$taller=new SolicitudTaller;
$taller->fecha_solicitud=$now;
$taller->nombre_taller=$data['nombre_taller'];
$taller->duracion=$data['duracion'];
$taller->area=$data['area'];
$taller->lugar=$data['lugar'];
$taller->fecha_inicio=$data['fecha_inicio'];
$taller->fecha_fin=$data['fecha_fin'];
$taller->hora_inicio=$data['hora_inicio'];
$taller->hora_fin=$data['hora_fin'];
$taller->dias_sem=$data['dias_sem'];
$taller->descripcion=$data['descripcion'];
$taller->objetivos=$data['objetivos'];
$taller->justificacion=$data['justificacion'];
$taller->creditos=$data['creditos'];
$taller->proyecto_final=$data['propuesta'];
$taller->materiales=$data['materiales'];
$taller->cupo=$data['cupo'];
$taller->matricula=$id;
$taller->departamento='1';
$taller->periodo=$periodo_semestre;
$taller->estado='Pendiente';
$taller->save();
if($taller->save()){
return redirect()->route('solicitud_taller')->with('success','¡Solicitud enviada Correctamente, 
Te llegará una Notificación a tu correo sobre el Seguimiento a tu Solicitud, Es importante Verificar en tus Datos Personales si ya has actualizado tu correo!');
}
}
else {
  DB::table('solicitud_talleres')
      ->where('solicitud_talleres.num_solicitud', $detalles->num_solicitud)
      ->update(
          ['nombre_taller' => $data['nombre_taller'], 'duracion' => $data['duracion'], 'area' => $data['area'], 'lugar' => $data['lugar'],
           'fecha_inicio' => $data['fecha_inicio'], 'fecha_fin' => $data['fecha_fin'], 'hora_inicio' => $data['hora_inicio'],
           'hora_fin' => $data['hora_fin'], 'dias_sem' => $data['dias_sem'], 'descripcion' => $data['descripcion'],
           'objetivos' => $data['objetivos'], 'justificacion' => $data['justificacion'], 'creditos' => $data['creditos'],
           'proyecto_final' => $data['propuesta'], 'materiales' => $data['materiales'], 'cupo' => $data['cupo']]);
 return redirect()->route('solicitud_taller')->with('success','¡Actualización correcta!');
}
}
}

public function taller_finalizado_estudiante(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='estudiante'){
     return redirect()->back();
    }
      $id=$usuario_actual->id_user;
	   $lineamiento_checar = DB::table('users')
        ->select('users.check_lineamiento')
        ->where('users.id_user', $id)
        ->take(1)
        ->first();
		if($lineamiento_checar->check_lineamiento == 0){
			 return redirect()->route('lineamientos')
			 ->with('error', '¡Para poder usar los Servicios del Portal debes leer y aceptar los lineamientos del mismo!');
		}

      $periodo_semestre = DB::table('periodos')
      ->select('periodos.id_periodo')
      ->where('periodos.estatus', '=', 'actual')
      ->take(1)
      ->first();

    $id_tutores = DB::table('tutores')
    ->select('tutores.id_tutor')
    ->join('personas', 'personas.id_persona', '=' ,'tutores.id_persona')
    ->join('estudiantes', 'estudiantes.id_persona', '=' ,'personas.id_persona')
    ->where('estudiantes.matricula', $id)
    ->take(1)
    ->first();
    $now = new \DateTime();
    if(!empty($id_tutores)){
    $result = DB::table('extracurriculares')
    ->select('extracurriculares.id_extracurricular',  'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
    'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.control_cupo', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
    'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor',
    'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
    ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
    ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
    ->where([['extracurriculares.bandera', '=', '2'], ['tutores.id_tutor', $id_tutores->id_tutor]])
   //->whereDate('extracurriculares.fecha_inicio', '>=', $now)
    ->orderBy('personas.nombre', 'asc')
    ->simplePaginate(10);
  return  view ('estudiante/mis_actividades.talleres_finalizados_estudiante')->with('dato', $result);
}
else {
  return redirect()->route('home_estudiante')->with('error', 'Ningún taller Registrado');

}
}

}
