<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Storage;
use Illuminate\Support\Facades\Auth;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response as FacadeResponse;


class GenerarPdf extends Controller
{
  protected function pdf_solicitud_taller_estudiante($matricula){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='1'){
      return redirect()->back();
    }
  $id=$matricula;
  $id_persona = DB::table('estudiantes')
  ->select('estudiantes.id_persona', )
  ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
  ->where('estudiantes.matricula',$id)
  ->take(1)
  ->first();

  $users = DB::table('estudiantes')
   ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'personas.edad', 'estudiantes.semestre',  'estudiantes.modalidad')
  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
  ->where('estudiantes.matricula',$id)
  ->take(1)
  ->first();

  $num_cel = DB::table('personas')
  ->select('telefonos.numero')
  ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
  ->where([['personas.id_persona',$id_persona->id_persona], ['telefonos.tipo', '=', 'celular']])
  ->take(1)
  ->first();

  $detalles = DB::table('solicitud_talleres')
  ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.duracion', 'solicitud_talleres.fecha_solicitud', 'solicitud_talleres.nombre_taller', 'solicitud_talleres.descripcion',
  'solicitud_talleres.objetivos', 'solicitud_talleres.justificacion', 'solicitud_talleres.creditos', 'solicitud_talleres.area',
  'solicitud_talleres.proyecto_final', 'solicitud_talleres.cupo', 'solicitud_talleres.matricula', 'solicitud_talleres.departamento',
  'solicitud_talleres.estado', 'solicitud_talleres.fecha_inicio', 'solicitud_talleres.fecha_fin', 'solicitud_talleres.hora_inicio',
  'solicitud_talleres.hora_fin', 'solicitud_talleres.dias_sem', 'solicitud_talleres.materiales' )
  ->where([['solicitud_talleres.matricula',$id], ['solicitud_talleres.estado','=', 'Pendiente'], ['solicitud_talleres.bandera','=', '1'] ])
  ->take(1)
  ->first();

      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('estudiante/mis_actividades.pdf_solicitud', ['data' =>  $detalles, 'nu_ce' => $num_cel, 'datos' =>  $users])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('solicitud_taller.pdf');
   $paper_orientation = 'letter';
   $customPaper = array(2.5,2.5,600,950);
  }

  protected function descarga_taller(){
    $usuario_actual=\Auth::user();

     if($usuario_actual->tipo_usuario!='estudiante'){
      return redirect()->back();
    }
    $usuario_actual=auth()->user();
    $id=$usuario_actual->id_user;
    $periodo_semestre = DB::table('periodos')
    ->select('periodos.id_periodo')
    ->where('periodos.estatus', '=', 'actual')
    ->take(1)
    ->first();

    $id_persona = DB::table('estudiantes')
    ->select('estudiantes.id_persona', )
    ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
    ->where('estudiantes.matricula',$id)
    ->take(1)
    ->first();

    $users = DB::table('estudiantes')
     ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'personas.edad', 'estudiantes.semestre','estudiantes.modalidad')
    ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
    ->where('estudiantes.matricula',$id)
    ->take(1)
    ->first();

    $num_cel = DB::table('personas')
    ->select('telefonos.numero')
    ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
    ->where([['personas.id_persona',$id_persona->id_persona], ['telefonos.tipo', '=', 'celular']])
    ->take(1)
    ->first();

    $detalles = DB::table('solicitud_talleres')
    ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.matricula', 'solicitud_talleres.estado')
    ->where([['solicitud_talleres.matricula',$id],['solicitud_talleres.bandera', '=', '1' ], ['solicitud_talleres.periodo', $periodo_semestre->id_periodo]])
    ->take(1)
    ->first();

    if(empty($detalles->estado)){
      return redirect()->route('solicitud_taller')->with('error','¡Para descargar la solicitud, primero tienes que enviarla!');
    }
    else {
      if(($detalles->estado) == 'Pendiente'){

  $detalles = DB::table('solicitud_talleres')
  ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.duracion', 'solicitud_talleres.fecha_solicitud', 'solicitud_talleres.nombre_taller', 'solicitud_talleres.descripcion',
  'solicitud_talleres.objetivos', 'solicitud_talleres.justificacion', 'solicitud_talleres.creditos', 'solicitud_talleres.area',
  'solicitud_talleres.proyecto_final', 'solicitud_talleres.cupo', 'solicitud_talleres.matricula', 'solicitud_talleres.departamento',
  'solicitud_talleres.estado', 'solicitud_talleres.fecha_inicio', 'solicitud_talleres.fecha_fin', 'solicitud_talleres.hora_inicio',
  'solicitud_talleres.hora_fin', 'solicitud_talleres.dias_sem', 'solicitud_talleres.materiales' )
   ->where([['solicitud_talleres.matricula',$id],['solicitud_talleres.bandera', '=', '1' ], ['solicitud_talleres.periodo', $periodo_semestre->id_periodo]])
   ->take(1)
  ->first();

      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('estudiante/mis_actividades.pdf_solicitud', ['data' =>  $detalles, 'nu_ce' => $num_cel, 'datos' =>  $users])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('solicitud_taller.pdf');
   $paper_orientation = 'letter';
   $customPaper = array(2.5,2.5,600,950);
}

if(($detalles->estado) == 'Rechazado'){
    return redirect()->route('solicitud_taller')->with('error','¡Para descargar la solicitud, primero tienes que enviarla!');
}
if(($detalles->estado) == 'Aprobado'){
    return redirect()->route('mi_taller')->with('error','¡Puedes descargar los detalles del Taller desde aquí!');
}
if(($detalles->estado) == 'Acreditado'){
    return redirect()->route('home_estudiante')->with('error','¡Solo puedes descargar la solicitud en el transcurso del Taller!');
}
if(($detalles->estado) == 'Cancelado'){
    return redirect()->route('home_estudiante')->with('error','¡No se encontró ninguna solicitud activa!');
}
}
  }

  protected function pdf_apro_taller_estudiante($matricula){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='1'){
      return redirect()->back();
    }
  $id=$matricula;
  $id_persona = DB::table('estudiantes')
  ->select('estudiantes.id_persona', )
  ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
  ->where('estudiantes.matricula',$id)
  ->take(1)
  ->first();

  $users = DB::table('estudiantes')
   ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'personas.edad', 'estudiantes.semestre', 'estudiantes.modalidad')
  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
  ->where('estudiantes.matricula',$id)
  ->take(1)
  ->first();

  $num_cel = DB::table('personas')
  ->select('telefonos.numero')
  ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
  ->where([['personas.id_persona',$id_persona->id_persona], ['telefonos.tipo', '=', 'celular']])
  ->take(1)
  ->first();

  $detalles = DB::table('solicitud_talleres')
  ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.duracion', 'solicitud_talleres.fecha_solicitud', 'solicitud_talleres.nombre_taller', 'solicitud_talleres.descripcion',
  'solicitud_talleres.objetivos', 'solicitud_talleres.justificacion', 'solicitud_talleres.creditos', 'solicitud_talleres.area',
  'solicitud_talleres.proyecto_final', 'solicitud_talleres.cupo', 'solicitud_talleres.matricula', 'solicitud_talleres.departamento',
  'solicitud_talleres.estado', 'solicitud_talleres.fecha_inicio', 'solicitud_talleres.fecha_fin', 'solicitud_talleres.hora_inicio',
  'solicitud_talleres.hora_fin', 'solicitud_talleres.dias_sem', 'solicitud_talleres.materiales' )
  ->where('solicitud_talleres.matricula',$id)
  ->take(1)
  ->first();

      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('estudiante/mis_actividades.pdf_solicitud', ['data' =>  $detalles, 'nu_ce' => $num_cel, 'datos' =>  $users])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('solicitud_taller.pdf');
   $paper_orientation = 'letter';
   $customPaper = array(2.5,2.5,600,950);
  }

  protected function descargar_lista_taller($id_taller){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='estudiante'){
      return redirect()->back();
    }
      $id=$usuario_actual->id_user;
      $id_extra= $id_taller;
      $id_tutores = DB::table('tutores')
      ->select('tutores.id_tutor')
      ->join('personas', 'personas.id_persona', '=' ,'tutores.id_persona')
      ->join('estudiantes', 'estudiantes.id_persona', '=' ,'personas.id_persona')
      ->where('estudiantes.matricula', $id)
      ->take(1)
      ->first();

	  
	    $periodo_semestre = DB::table('periodos')
      ->select('periodos.id_periodo', 'periodos.inicio', 'periodos.final')
      ->where('periodos.estatus', '=', 'actual')
      ->take(1)
      ->first();

      $result = DB::table('extracurriculares')
      ->select('telefonos.numero', 'estudiantes.matricula','extracurriculares.nombre_ec', 'personas.nombre',
               'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('detalle_extracurriculares', 'detalle_extracurriculares.actividad', '=', 'extracurriculares.id_extracurricular')
      ->join('estudiantes', 'estudiantes.matricula', '=', 'detalle_extracurriculares.matricula')
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
      ->where([['extracurriculares.bandera', '=' , '1'], ['extracurriculares.tutor', $id_tutores->id_tutor], 
	  ['detalle_extracurriculares.actividad', $id_extra], ['detalle_extracurriculares.estado', '=', 'Cursando'], 
	  ['detalle_extracurriculares.periodo', $periodo_semestre->id_periodo], ['telefonos.tipo', '=', 'celular']])
      ->get();

      $datos_extra = DB::table('extracurriculares')
      ->select('extracurriculares.nombre_ec', 'extracurriculares.fecha_inicio', 'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio',
                'extracurriculares.hora_fin', 'extracurriculares.lugar', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('tutores', 'tutores.id_tutor', '=', 'extracurriculares.tutor')
      ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
      ->where([['extracurriculares.bandera', '=' , '1'], ['extracurriculares.tutor', $id_tutores->id_tutor], ['extracurriculares.id_extracurricular', $id_extra], ['extracurriculares.periodo', $periodo_semestre->id_periodo]])
      ->take(1)
      ->first();
      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('estudiante/mis_actividades.listadeasistencia', ['dato' =>  $result, 
   'datos_extra' => $datos_extra , 'periodo' => $periodo_semestre])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('lista_asistencia.pdf');
   $paper_orientation = 'letter';
   $customPaper = array(2.5,2.5,600,950);
  }
  
  protected function lista_estudiante_taller($id_taller,$matricula){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='1'){
      return redirect()->back();
    }
      $id=$matricula;
      $id_extra= $id_taller;
      $id_tutores = DB::table('tutores')
      ->select('tutores.id_tutor')
      ->join('personas', 'personas.id_persona', '=' ,'tutores.id_persona')
      ->join('estudiantes', 'estudiantes.id_persona', '=' ,'personas.id_persona')
      ->where('estudiantes.matricula', $id)
      ->take(1)
      ->first();

	  
	    $periodo_semestre = DB::table('periodos')
      ->select('periodos.id_periodo', 'periodos.inicio', 'periodos.final')
      ->where('periodos.estatus', '=', 'actual')
      ->take(1)
      ->first();

      $result = DB::table('extracurriculares')
      ->select('telefonos.numero', 'estudiantes.matricula','extracurriculares.nombre_ec', 'personas.nombre',
               'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('detalle_extracurriculares', 'detalle_extracurriculares.actividad', '=', 'extracurriculares.id_extracurricular')
      ->join('estudiantes', 'estudiantes.matricula', '=', 'detalle_extracurriculares.matricula')
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
      ->where([['extracurriculares.bandera', '=' , '1'], ['extracurriculares.tutor', $id_tutores->id_tutor], 
	  ['detalle_extracurriculares.actividad', $id_extra], ['detalle_extracurriculares.estado', '=', 'Cursando'], 
	  ['detalle_extracurriculares.periodo', $periodo_semestre->id_periodo], ['telefonos.tipo', '=', 'celular']])
	  ->orderBy('personas.nombre', 'asc')
      ->get();

      $datos_extra = DB::table('extracurriculares')
      ->select('extracurriculares.nombre_ec', 'extracurriculares.fecha_inicio', 'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio',
                'extracurriculares.hora_fin', 'extracurriculares.lugar', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('tutores', 'tutores.id_tutor', '=', 'extracurriculares.tutor')
      ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
      ->where([['extracurriculares.bandera', '=' , '1'], ['extracurriculares.tutor', $id_tutores->id_tutor], ['extracurriculares.id_extracurricular', $id_extra], ['extracurriculares.periodo', $periodo_semestre->id_periodo]])
      ->take(1)
      ->first();
      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('estudiante/mis_actividades.listadeasistencia', ['dato' =>  $result, 
   'datos_extra' => $datos_extra , 'periodo' => $periodo_semestre])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('lista_asistencia.pdf');
   $paper_orientation = 'letter';
   $customPaper = array(2.5,2.5,600,950);
  }

  protected function descargar_lista_tallerista($id_taller){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='tallerista'){
      return redirect()->back();
    }
      $id=$usuario_actual->id_user;
      $id_extra= $id_taller;
      $id_tutores = DB::table('tutores')
      ->select('tutores.id_tutor')
      ->join('personas', 'personas.id_persona', '=' ,'tutores.id_persona')
      ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
      ->where('users.id_user', $id)
      ->take(1)
      ->first();

       $periodo_semestre = DB::table('periodos')
      ->select('periodos.id_periodo', 'periodos.inicio', 'periodos.final')
      ->where('periodos.estatus', '=', 'actual')
      ->take(1)
      ->first();

      $result = DB::table('extracurriculares')
      ->select('telefonos.numero','estudiantes.matricula','extracurriculares.nombre_ec', 'personas.nombre',
               'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('detalle_extracurriculares', 'detalle_extracurriculares.actividad', '=', 'extracurriculares.id_extracurricular')
      ->join('estudiantes', 'estudiantes.matricula', '=', 'detalle_extracurriculares.matricula')
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
      ->where([['extracurriculares.bandera', '=' , '1'], ['extracurriculares.tutor', $id_tutores->id_tutor], 
	  ['detalle_extracurriculares.actividad', $id_extra], ['detalle_extracurriculares.estado', '=', 'Cursando'], 
	  ['detalle_extracurriculares.periodo', $periodo_semestre->id_periodo], ['telefonos.tipo', '=', 'celular']])
	   ->orderBy('personas.nombre', 'asc')
      ->get();

      $datos_extra = DB::table('extracurriculares')
      ->select('extracurriculares.nombre_ec', 'extracurriculares.fecha_inicio', 'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio',
                'extracurriculares.hora_fin', 'extracurriculares.lugar', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('tutores', 'tutores.id_tutor', '=', 'extracurriculares.tutor')
      ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
      ->where([['extracurriculares.bandera', '=' , '1'], ['extracurriculares.tutor', $id_tutores->id_tutor], 
	  ['extracurriculares.id_extracurricular', $id_extra], ['extracurriculares.periodo', $periodo_semestre->id_periodo] ])
      ->take(1)
      ->first();
      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('estudiante/mis_actividades.listadeasistencia', ['dato' =>  $result, 
   'datos_extra' => $datos_extra , 'periodo' => $periodo_semestre])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('lista_asistencia.pdf');
   $paper_orientation = 'letter';
   $customPaper = array(2.5,2.5,600,950);
  }

  protected function descarga_taller_act($id_taller){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='estudiante'){
      return redirect()->back();
    }
    $usuario_actual=auth()->user();
    $id=$usuario_actual->id_user;
    $id_extra = $id_taller;

    $periodo_semestre = DB::table('periodos')
    ->select('periodos.id_periodo')
    ->where('periodos.estatus', '=', 'actual')
    ->take(1)
    ->first();

    $id_persona = DB::table('estudiantes')
    ->select('estudiantes.id_persona', )
    ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
    ->where('estudiantes.matricula',$id)
    ->take(1)
    ->first();

    $users = DB::table('estudiantes')
     ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'personas.edad', 'estudiantes.semestre', 'estudiantes.modalidad')
    ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
    ->where('estudiantes.matricula',$id)
    ->take(1)
    ->first();

    $num_cel = DB::table('personas')
    ->select('telefonos.numero')
    ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
    ->where([['personas.id_persona',$id_persona->id_persona], ['telefonos.tipo', '=', 'celular']])
    ->take(1)
    ->first();

  $detalles = DB::table('solicitud_talleres')
  ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.duracion', 'solicitud_talleres.fecha_solicitud', 'solicitud_talleres.nombre_taller', 'solicitud_talleres.descripcion',
  'solicitud_talleres.objetivos', 'solicitud_talleres.justificacion', 'solicitud_talleres.creditos', 'solicitud_talleres.area',
  'solicitud_talleres.proyecto_final', 'solicitud_talleres.cupo', 'solicitud_talleres.matricula', 'solicitud_talleres.departamento',
  'solicitud_talleres.estado', 'solicitud_talleres.fecha_inicio', 'solicitud_talleres.fecha_fin', 'solicitud_talleres.hora_inicio',
  'solicitud_talleres.hora_fin', 'solicitud_talleres.dias_sem', 'solicitud_talleres.materiales' )
  ->where([['solicitud_talleres.matricula',$id], ['solicitud_talleres.periodo',$periodo_semestre->id_periodo]])
  ->take(1)
  ->first();

      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('estudiante/mis_actividades.pdf_solicitud', ['data' =>  $detalles, 'nu_ce' => $num_cel, 'datos' =>  $users])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('solicitud_taller.pdf');
   $paper_orientation = 'letter';
   $customPaper = array(2.5,2.5,600,950);
}


public function probado(){

  $paper_orientation = 'letter';
    $customPaper = array(2.5,2.5,600,950);
$data ="hola";
 $pdf = PDF::loadView('pruebaso', ['data' =>  $data])
->setPaper($customPaper,$paper_orientation);
 return $pdf->stream('solicitud_taller.pdf');
 $paper_orientation = 'letter';
 $customPaper = array(2.5,2.5,600,950);
}

protected function lista_talleres_re($id_taller,$tutor){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='1'){
      return redirect()->back();
    }
      $id_tutor=$tutor;
      $id_extra= $id_taller;
     	  
	    $periodo_semestre = DB::table('periodos')
      ->select('periodos.id_periodo', 'periodos.inicio', 'periodos.final')
      ->where('periodos.estatus', '=', 'actual')
      ->take(1)
      ->first();

      $result = DB::table('extracurriculares')
      ->select('telefonos.numero', 'estudiantes.matricula','extracurriculares.nombre_ec', 'personas.nombre',
               'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('detalle_extracurriculares', 'detalle_extracurriculares.actividad', '=', 'extracurriculares.id_extracurricular')
      ->join('estudiantes', 'estudiantes.matricula', '=', 'detalle_extracurriculares.matricula')
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
      ->where([['extracurriculares.bandera', '=' , '1'], ['extracurriculares.tutor', $id_tutor], 
	  ['detalle_extracurriculares.actividad', $id_extra], ['detalle_extracurriculares.estado', '=', 'Cursando'], 
	  ['detalle_extracurriculares.periodo', $periodo_semestre->id_periodo], ['telefonos.tipo', '=', 'celular']])
       ->orderBy('personas.nombre', 'asc')
      ->get();

      $datos_extra = DB::table('extracurriculares')
      ->select('extracurriculares.nombre_ec', 'extracurriculares.fecha_inicio', 'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio',
                'extracurriculares.hora_fin', 'extracurriculares.lugar', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('tutores', 'tutores.id_tutor', '=', 'extracurriculares.tutor')
      ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
      ->where([['extracurriculares.bandera', '=' , '1'], ['extracurriculares.tutor', $id_tutor], ['extracurriculares.id_extracurricular', $id_extra], ['extracurriculares.periodo', $periodo_semestre->id_periodo]])
      ->take(1)
      ->first();
      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('estudiante/mis_actividades.listadeasistencia', ['dato' =>  $result, 
   'datos_extra' => $datos_extra , 'periodo' => $periodo_semestre])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('lista_asistencia.pdf');
   $paper_orientation = 'letter';
   $customPaper = array(2.5,2.5,600,950);
  }

protected function lista_conferencia_re($id_taller,$tutor){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='1'){
      return redirect()->back();
    }
      $id_tutor=$tutor;
      $id_extra= $id_taller;
     
	    $periodo_semestre = DB::table('periodos')
      ->select('periodos.id_periodo', 'periodos.inicio', 'periodos.final')
      ->where('periodos.estatus', '=', 'actual')
      ->take(1)
      ->first();

      $result = DB::table('extracurriculares')
      ->select('telefonos.numero', 'estudiantes.matricula','extracurriculares.nombre_ec', 'personas.nombre',
               'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('detalle_extracurriculares', 'detalle_extracurriculares.actividad', '=', 'extracurriculares.id_extracurricular')
      ->join('estudiantes', 'estudiantes.matricula', '=', 'detalle_extracurriculares.matricula')
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
      ->where([['extracurriculares.bandera', '=' , '1'], ['extracurriculares.tutor', $id_tutor], 
	  ['detalle_extracurriculares.actividad', $id_extra], ['detalle_extracurriculares.estado', '=', 'Cursando'], 
	  ['detalle_extracurriculares.periodo', $periodo_semestre->id_periodo], ['telefonos.tipo', '=', 'celular']])
	  ->orderBy('personas.nombre', 'asc')
      ->get();

      $datos_extra = DB::table('extracurriculares')
      ->select('extracurriculares.nombre_ec', 'extracurriculares.fecha_inicio', 'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio',
                'extracurriculares.hora_fin', 'extracurriculares.lugar', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('tutores', 'tutores.id_tutor', '=', 'extracurriculares.tutor')
      ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
      ->where([['extracurriculares.bandera', '=' , '1'], ['extracurriculares.tutor', $id_tutor], ['extracurriculares.id_extracurricular', $id_extra], ['extracurriculares.periodo', $periodo_semestre->id_periodo]])
      ->take(1)
      ->first();
      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('estudiante/mis_actividades.listados', ['dato' =>  $result, 
   'datos_extra' => $datos_extra , 'periodo' => $periodo_semestre])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('lista_asistencia.pdf');
   $paper_orientation = 'letter';
   $customPaper = array(2.5,2.5,600,950);
  }

public function descarga_practicas()
{
  $usuario_actual=auth()->user();
   if($usuario_actual->tipo_usuario!='estudiante'){
     return redirect()->back();
    }

   $usuario=auth()->user();
    $id=$usuario->id_user;
	
	 $lineamiento_checar = DB::table('users')
        ->select('users.check_lineamiento')
        ->where('users.id_user', $id)
        ->take(1)
        ->first();
		if($lineamiento_checar->check_lineamiento == 0){
			 return redirect()->route('lineamientos')
			 ->with('error', '¡Para poder usar los Servicios del Portal debes leer y aceptar los lineamientos del mismo!');
		}

    $id_persona = DB::table('estudiantes')
    ->select('estudiantes.id_persona')
    ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
    ->where('estudiantes.matricula',$id)
    ->take(1)
    ->first();
      $id_persona= json_decode( json_encode($id_persona), true);

      $users = DB::table('estudiantes')
         ->select('estudiantes.matricula', 'estudiantes.materias_pendientes', 'estudiantes.horario_asesorias',
         'estudiantes.semestre', 'estudiantes.modalidad', 'estudiantes.estatus', 'estudiantes.grupo',
         'personas.nombre', 'personas.apellido_paterno','personas.apellido_materno', 'users.email', 'personas.edad',
         'personas.id_persona', 'personas.fecha_nacimiento', 'personas.curp', 'personas.genero',
         'estudiantes.egresado', 'estudiantes.fecha_ingreso')
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->join('users', 'users.id_persona', '=', 'personas.id_persona')
      ->where('estudiantes.matricula',$id)
      ->take(1)
      ->first();

        $direccion = DB::table('personas')
        ->select('direcciones.vialidad_principal', 'direcciones.num_exterior', 'direcciones.cp', 'direcciones.localidad',
        'direcciones.municipio', 'direcciones.entidad_federativa')
        ->join('direcciones', 'direcciones.id_direccion', '=', 'personas.id_direccion')
        ->where('personas.id_persona',$users->id_persona)
        ->take(1)
        ->first();


        $num_cel = DB::table('personas')
        ->select('telefonos.numero')
        ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
        ->where([['personas.id_persona',$id_persona], ['telefonos.tipo', '=', 'celular']])
        ->take(1)
        ->first();

         $num_prac = DB::table('personas')
         ->select('telefonos.numero')
         ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
         ->where([['personas.id_persona',$id_persona], ['telefonos.tipo', '=', 'practicas']])
         ->take(1)
         ->first();
        $valor_direccion = DB::table('direcciones')->max('id_direccion');

        $practicas_dependencia = DB::table('practicas')
        ->select('practicas.id_practicas', 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
        'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
        ->join('personas', 'personas.id_persona', '=', 'practicas.titular')
        ->where([['practicas.matricula',$id], ['practicas.tipo', '=', 'PRACTICAS']])
        ->take(1)
        ->first();
       if(empty($practicas_dependencia->id_practicas)){
         $datos_di=null; }
       else {
     $datos_di = DB::table('practicas_profesionales')
     ->select('practicas_profesionales.id_practicas','practicas_profesionales.periodo_practicas', 'direcciones.vialidad_principal',
              'direcciones.num_exterior', 'direcciones.localidad', 'direcciones.cp', 'direcciones.municipio')
     ->join('direcciones', 'direcciones.id_direccion', '=', 'practicas_profesionales.id_direccion')
     ->where('practicas_profesionales.id_practicas',$practicas_dependencia->id_practicas)
     ->take(1)
     ->first();}
       $escuela_r = DB::table('carreras')
       ->select('carreras.carrera')
       ->take(1)
       ->first();
       if(($users->modalidad) == 'SEMI ESCOLARIZADA'){
         $modalidad = 'SEMIESCOLARIZADA';
       }

       if(($users->modalidad) == 'SEMIESCOLARIZADA'){
          $modalidad = 'SEMIESCOLARIZADA';
       }
       if(($users->modalidad) == 'ESCOLARIZADA'){
          $modalidad = 'ESCOLARIZADA';
       }
if($users->egresado == 0){
     $paper_orientation = 'letter';
     $customPaper = array(2.5,2.5,600,950);

  $pdf = PDF::loadView('estudiante/servicios.pdf_solicitud_practica',  ['data' =>  $users, 'di' => $direccion,
  'nu_ce' => $num_cel, 'numero_prac' => $num_prac , 'datos_practicas' => $practicas_dependencia,
  'direccion_pra' => $datos_di, 'carreras' => $escuela_r, 'modalidad' => $modalidad])
->setPaper($customPaper,$paper_orientation);
  return $pdf->stream('solicitud_practicas.pdf');}
  else {
    $paper_orientation = 'letter';
    $customPaper = array(2.5,2.5,600,950);

 $pdf = PDF::loadView('estudiante/servicios.pdf_egresado',  ['data' =>  $users, 'di' => $direccion,
 'nu_ce' => $num_cel, 'numero_prac' => $num_prac , 'datos_practicas' => $practicas_dependencia,
 'direccion_pra' => $datos_di, 'carreras' => $escuela_r, 'modalidad' => $modalidad])
->setPaper($customPaper,$paper_orientation);
 return $pdf->stream('solicitud_practicas.pdf');
  }
    }

    public function descarga_practicas_es($matricula)
    {
      $usuario_actual=auth()->user();
       if($usuario_actual->tipo_usuario!='3'){
         return redirect()->back();
        }

        $id=$matricula;

        $id_persona = DB::table('estudiantes')
        ->select('estudiantes.id_persona')
        ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
        ->where('estudiantes.matricula',$id)
        ->take(1)
        ->first();
          $id_persona= json_decode( json_encode($id_persona), true);

          $users = DB::table('estudiantes')
             ->select('estudiantes.matricula', 'estudiantes.materias_pendientes', 'estudiantes.horario_asesorias',
             'estudiantes.semestre', 'estudiantes.modalidad', 'estudiantes.estatus', 'estudiantes.grupo',
             'personas.nombre', 'personas.apellido_paterno','personas.apellido_materno', 'users.email', 'personas.edad',
             'personas.id_persona', 'personas.fecha_nacimiento', 'personas.curp', 'personas.genero',
             'estudiantes.egresado', 'estudiantes.fecha_ingreso')
          ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
          ->join('users', 'users.id_persona', '=', 'personas.id_persona')
          ->where('estudiantes.matricula',$id)
          ->take(1)
          ->first();

            $direccion = DB::table('personas')
            ->select('direcciones.vialidad_principal', 'direcciones.num_exterior', 'direcciones.cp', 'direcciones.localidad',
            'direcciones.municipio', 'direcciones.entidad_federativa')
            ->join('direcciones', 'direcciones.id_direccion', '=', 'personas.id_direccion')
            ->where('personas.id_persona',$users->id_persona)
            ->take(1)
            ->first();


            $num_cel = DB::table('personas')
            ->select('telefonos.numero')
            ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
            ->where([['personas.id_persona',$id_persona], ['telefonos.tipo', '=', 'celular']])
            ->take(1)
            ->first();

             $num_prac = DB::table('personas')
             ->select('telefonos.numero')
             ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
             ->where([['personas.id_persona',$id_persona], ['telefonos.tipo', '=', 'practicas']])
             ->take(1)
             ->first();
            $valor_direccion = DB::table('direcciones')->max('id_direccion');

            $practicas_dependencia = DB::table('practicas')
            ->select('practicas.id_practicas', 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
            'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
            ->join('personas', 'personas.id_persona', '=', 'practicas.titular')
            ->where([['practicas.matricula',$id], ['practicas.tipo', '=', 'PRACTICAS']])
            ->take(1)
            ->first();
           if(empty($practicas_dependencia->id_practicas)){
             $datos_di=null; }
           else {
         $datos_di = DB::table('practicas_profesionales')
         ->select('practicas_profesionales.id_practicas','practicas_profesionales.periodo_practicas', 'direcciones.vialidad_principal',
                  'direcciones.num_exterior', 'direcciones.localidad', 'direcciones.cp', 'direcciones.municipio')
         ->join('direcciones', 'direcciones.id_direccion', '=', 'practicas_profesionales.id_direccion')
         ->where('practicas_profesionales.id_practicas',$practicas_dependencia->id_practicas)
         ->take(1)
         ->first();}
           $escuela_r = DB::table('carreras')
           ->select('carreras.carrera')
           ->take(1)
           ->first();
           if(($users->modalidad) == 'SEMI ESCOLARIZADA'){
             $modalidad = 'SEMIESCOLARIZADA';
           }

           if(($users->modalidad) == 'SEMIESCOLARIZADA'){
              $modalidad = 'SEMIESCOLARIZADA';
           }
           if(($users->modalidad) == 'ESCOLARIZADA'){
              $modalidad = 'ESCOLARIZADA';
           }
           if($users->egresado == 0){
                $paper_orientation = 'letter';
                $customPaper = array(2.5,2.5,600,950);

             $pdf = PDF::loadView('estudiante/servicios.pdf_solicitud_practica',  ['data' =>  $users, 'di' => $direccion,
             'nu_ce' => $num_cel, 'numero_prac' => $num_prac , 'datos_practicas' => $practicas_dependencia,
             'direccion_pra' => $datos_di, 'carreras' => $escuela_r, 'modalidad'=> $modalidad])
           ->setPaper($customPaper,$paper_orientation);
             return $pdf->stream('solicitud_practicas.pdf');}
             else {
               $paper_orientation = 'letter';
               $customPaper = array(2.5,2.5,600,950);

            $pdf = PDF::loadView('estudiante/servicios.pdf_egresado',  ['data' =>  $users, 'di' => $direccion,
            'nu_ce' => $num_cel, 'numero_prac' => $num_prac , 'datos_practicas' => $practicas_dependencia,
            'direccion_pra' => $datos_di, 'carreras' => $escuela_r, 'modalidad'=> $modalidad])
           ->setPaper($customPaper,$paper_orientation);
            return $pdf->stream('solicitud_practicas.pdf');
             }
        }

        public function carta_noventa($matricula)
        {  $usuario_actual=auth()->user();
           if($usuario_actual->tipo_usuario!='3'){
             return redirect()->back(); }
               $ids=$usuario_actual->id_user;
            $id=$matricula;
              $users = DB::table('estudiantes')
                 ->select('estudiantes.matricula', 'estudiantes.materias_pendientes', 'estudiantes.horario_asesorias',
                 'estudiantes.semestre', 'estudiantes.modalidad', 'estudiantes.estatus', 'estudiantes.grupo',
                 'personas.nombre', 'personas.apellido_paterno','personas.apellido_materno', 'users.email', 'personas.edad',
                 'personas.id_persona', 'personas.fecha_nacimiento', 'personas.curp', 'personas.genero',
                 'estudiantes.egresado', 'estudiantes.fecha_ingreso')
              ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
              ->join('users', 'users.id_persona', '=', 'personas.id_persona')
              ->where('estudiantes.matricula',$id)
              ->take(1)
              ->first();

              if(($users->modalidad) == 'SEMI ESCOLARIZADA'){
                $modalidad = 'SEMIESCOLARIZADA';
              }

              if(($users->modalidad) == 'SEMIESCOLARIZADA'){
                 $modalidad = 'SEMIESCOLARIZADA';
              }
              if(($users->modalidad) == 'ESCOLARIZADA'){
                 $modalidad = 'ESCOLARIZADA';
              }
			  
			  $semes = $users->semestre;
               $sepoct="";
			   if($semes == 7){
			       $sepoct= "séptimo";
			   }
			   
			   if($semes == 8){
				   $sepoct = "octavo";
			   }
              $practicas_dependencia = DB::table('practicas')
              ->select('practicas.id_practicas')
              ->where([['practicas.matricula',$id], ['practicas.tipo', '=', 'SERVICIO']])
              ->take(1)
              ->first();
             if(empty($practicas_dependencia->id_practicas)){
               $datos_di=null; }
             else {
               $datos_di = DB::table('servicio_sociales')
               ->select('servicio_sociales.id_practicas','servicio_sociales.procentaje_avance')
               ->where('servicio_sociales.id_practicas',$practicas_dependencia->id_practicas)
               ->take(1)
               ->first();}

               $datos_coordi = DB::table('users')
               ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'personas.genero')
               ->join('personas', 'personas.id_persona', '=', 'users.id_persona')
               ->where('users.id_user',$ids)
               ->take(1)
               ->first();
			   
			   $laelgen= "";
			   $laelcor = "";
			   $sicor = "";
			   if(($datos_coordi->genero) == "F"){
			       $laelgen= "La";
			   $laelcor = "COORDINADORA";
			   $sicor = "Coordinadora";
			   }
			    if(($datos_coordi->genero) == "M"){
			      $laelgen= "El";
			   $laelcor = "COORDINADOR";
			   $sicor = "Coordinador";
			   }
                    $paper_orientation = 'letter';
                    $customPaper = array(2.5,2.5,600,950);
   $pdf = PDF::loadView('personal_administrativo/servicios.carta_90',  ['data' =>  $users, 'datos_di' => $datos_di,
   'modalidad' => $modalidad, 'datos_coordinadora' => $datos_coordi, 'semest' => $sepoct, 'gencor' => $laelgen, 
   'elcor' => $laelcor, 'mincor' => $sicor])
               ->setPaper($customPaper,$paper_orientation);
                 return $pdf->stream('carta_90_porciento.pdf');


            }
			
			


public function liberado(){

  $paper_orientation = 'letter';
    $customPaper = array(2.5,2.5,600,950);
$data ="hola";
 $pdf = PDF::loadView('liberacion', ['data' =>  $data])
->setPaper($customPaper,$paper_orientation);
 return $pdf->stream('carta_liberacion.pdf');
 $paper_orientation = 'letter';
 $customPaper = array(2.5,2.5,600,950);
}

public function noventa(){

  $paper_orientation = 'letter';
    $customPaper = array(2.5,2.5,600,950);
$data ="hola";
 $pdf = PDF::loadView('noventa', ['data' =>  $data])
->setPaper($customPaper,$paper_orientation);
 return $pdf->stream('carta_90_porciento.pdf');
 $paper_orientation = 'letter';
 $customPaper = array(2.5,2.5,600,950);
}

public function solicitud_de_p(){

  $paper_orientation = 'letter';
    $customPaper = array(2.5,2.5,600,950);
$data ="hola";
 $pdf = PDF::loadView('detalle', ['data' =>  $data])
->setPaper($customPaper,$paper_orientation);
 return $pdf->stream('solicitud_practicas.pdf');
 $paper_orientation = 'letter';
 $customPaper = array(2.5,2.5,600,950);
}


}

