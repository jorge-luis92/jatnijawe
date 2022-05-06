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
use App\Notificacion;
use App\Alumno;
use App\AlumnoCurso;
use App\Periodo;
use App\SolicitudTaller;
use App\Mail\CorreccionDeSolicitudDeTaller;
use App\Mail\AprobacionDeSolicitudDeTaller;
use App\Mail\RechazoDeSolicitudDeTaller;
use App\Mail\CancelacionTaller;
use App\Mail\AcreditacionTaller;
use Illuminate\Support\Facades\DB;
use Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class Notificaciones extends Controller
{
    public function solicitud_correcion($id_matricula){
      $matricula= $id_matricula;
      $periodo_semestre = DB::table('periodos')
      ->select('periodos.id_periodo')
      ->where('periodos.estatus', '=', 'actual')
      ->take(1)
      ->first();
      $datos_correo= DB::table('users')
       ->select('users.email', 'personas.nombre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->join('personas', 'users.id_persona', '=' , 'personas.id_persona')
       ->where('users.id_user', $matricula)
       ->take(1)
       ->first();
       $datos_taller= DB::table('solicitud_talleres')
        ->select('solicitud_talleres.nombre_taller')
        ->join('periodos', 'periodos.id_periodo', '=', 'solicitud_talleres.periodo')
      //  ->where('solicitud_talleres.matricula', $matricula)
      ->where([['solicitud_talleres.matricula', $matricula], ['periodos.estatus', '=', 'actual'], ['solicitud_talleres.estado', '=', 'Pendiente']])
      ->take(1)
      ->first();

      return view('mails.notificacioncorrecion')
      ->with('datos_estudiante', $datos_correo)
      ->with('estudiante_matricula', $matricula)
      ->with('datos_taller', $datos_taller);
    }

    public function enviar_correccion(Request $request){
      $data= $request;
      $periodo_semestre = DB::table('periodos')
      ->select('periodos.id_periodo')
      ->where('periodos.estatus', '=', 'actual')
      ->take(1)
      ->first();
      $datos_correo= DB::table('users')
       ->select('users.email', 'users.id_user', 'personas.nombre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->join('personas', 'users.id_persona', '=' , 'personas.id_persona')
       ->where('users.id_user', $data['matricula'])
       ->take(1)
       ->first();

       $datos_taller= DB::table('solicitud_talleres')
        ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.nombre_taller')
        ->join('periodos', 'periodos.id_periodo', '=', 'solicitud_talleres.periodo')
        ->where([['solicitud_talleres.matricula',  $data['matricula']], ['periodos.estatus', '=', 'actual'], ['solicitud_talleres.estado', '=', 'Pendiente']])
        ->take(1)
        ->first();

        try {
          Mail::to($datos_correo->email)
          ->send(new CorreccionDeSolicitudDeTaller($datos_correo, $data, $datos_taller));
   } catch (Exception $e) {
       report($e);
       redirect()->back()->with('error', 'Hubo un error al tratar de enviar el correo!');
      // return redirect()->route('mis_actividades')->with('success','¡Inscripción Realizada correctamente!');
      }


       $notificacion = new Notificacion;
       $notificacion->matricula= $data['matricula'];
       $notificacion->num_solicitud= $datos_taller->num_solicitud;
       $notificacion->asunto= $data['asunto'];
       $notificacion->mensaje= $data['contenido'];
       $notificacion->estatus= 'enviado';
       $notificacion->save();

          return redirect()->route('notificaciones_enviadas')->with('success','¡Notificación Enviada Correctamente!');
    }

    public function solicitud_rechazo($id_matricula){
      $matricula= $id_matricula;

      $datos_taller= DB::table('solicitud_talleres')
       ->select('solicitud_talleres.nombre_taller')
       ->join('periodos', 'periodos.id_periodo', '=', 'solicitud_talleres.periodo')
       ->where([['solicitud_talleres.matricula', $matricula], ['periodos.estatus', '=', 'actual'], ['solicitud_talleres.estado', '=', 'Pendiente']])
         ->take(1)
       ->first();

      $datos_correo= DB::table('users')
       ->select('users.email', 'personas.nombre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->join('personas', 'users.id_persona', '=' , 'personas.id_persona')
       ->where('users.id_user', $matricula)
       ->take(1)
       ->first();

      return view('mails.notificacionrechazo')
      ->with('datos_estudiante', $datos_correo)
      ->with('estudiante_matricula', $matricula)
      ->with('datos_taller', $datos_taller);
    }

    public function enviar_rechazo(Request $request){
      $data= $request;
      $datos_correo= DB::table('users')
       ->select('users.email', 'users.id_user', 'personas.nombre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->join('personas', 'users.id_persona', '=' , 'personas.id_persona')
       ->where('users.id_user', $data['matricula'])
       ->take(1)
       ->first();

       $datos_taller= DB::table('solicitud_talleres')
        ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.nombre_taller')
        ->join('periodos', 'periodos.id_periodo', '=', 'solicitud_talleres.periodo')
        ->where('solicitud_talleres.matricula',  $data['matricula'])
        ->where([['solicitud_talleres.matricula', $data['matricula']], ['periodos.estatus', '=', 'actual'], ['solicitud_talleres.estado', '=', 'Pendiente']])
        ->take(1)
        ->first();

        $periodo_semestre = DB::table('periodos')
        ->select('periodos.id_periodo')
        ->where('periodos.estatus', '=', 'actual')
        ->take(1)
        ->first();
        $periodo_semestre= $periodo_semestre->id_periodo;
              try {
      Mail::to($datos_correo->email)
      ->send(new RechazoDeSolicitudDeTaller($datos_correo, $data, $datos_taller));

    } catch (Exception $e) {
        report($e);
           redirect()->back()->with('error', 'Hubo un error al tratar de enviar el correo!');
        //return false;
    }

    DB::table('solicitud_talleres')
        ->where([['solicitud_talleres.matricula', $data['matricula']], ['solicitud_talleres.estado', '=', 'Pendiente'],
        ['solicitud_talleres.periodo', $periodo_semestre]])
        //->where('solicitud_talleres.matricula', $data['matricula'])
        ->update(
          ['estado' => 'Rechazado', 'bandera' => '0']);

    $notificacion = new Notificacion;
    $notificacion->matricula= $data['matricula'];
    $notificacion->num_solicitud= $datos_taller->num_solicitud;
    $notificacion->asunto= $data['asunto'];
    $notificacion->mensaje= $data['contenido'];
    $notificacion->estatus= 'enviado';
    $notificacion->save();

          return redirect()->route('notificaciones_enviadas')->with('success','¡Notificación Enviada Correctamente!');
    }

    public function solicitud_aceptada($id_matricula){
      $matricula= $id_matricula;

      $datos_taller= DB::table('solicitud_talleres')
       ->select('solicitud_talleres.nombre_taller')
       ->join('periodos', 'periodos.id_periodo', '=', 'solicitud_talleres.periodo')
       ->where([['solicitud_talleres.matricula', $matricula], ['periodos.estatus', '=', 'actual'], ['solicitud_talleres.estado', '=', 'Pendiente']])
       ->take(1)
       ->first();

      $datos_correo= DB::table('users')
       ->select('users.email', 'personas.nombre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->join('personas', 'users.id_persona', '=' , 'personas.id_persona')
       ->where('users.id_user', $matricula)
       ->take(1)
       ->first();

      return view('mails.notificacionaprobado')
      ->with('datos_estudiante', $datos_correo)
      ->with('estudiante_matricula', $matricula)
      ->with('datos_taller', $datos_taller);
    }

    public function enviar_aprobacion(Request $request){
      $data= $request;

      $datos_correo= DB::table('users')
       ->select('users.email', 'users.id_user', 'personas.nombre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->join('personas', 'users.id_persona', '=' , 'personas.id_persona')
       ->where('users.id_user', $data['matricula'])
       ->take(1)
       ->first();

       $periodo_semestre = DB::table('periodos')
       ->select('periodos.id_periodo')
       ->where('periodos.estatus', '=', 'actual')
       ->take(1)
       ->first();

       $datos_taller= DB::table('solicitud_talleres')
        ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.nombre_taller')
        ->join('periodos', 'periodos.id_periodo', '=', 'solicitud_talleres.periodo')
        ->where([['solicitud_talleres.matricula', $data['matricula']], ['periodos.estatus', '=', 'actual'], ['solicitud_talleres.estado', '=', 'Pendiente']])
        ->take(1)
        ->first();
          try {
            Mail::to($datos_correo->email)
            ->send(new AprobacionDeSolicitudDeTaller($datos_correo, $data, $datos_taller));
          } catch (Exception $e) {
              report($e);
                 redirect()->back()->with('error', 'Hubo un error al tratar de enviar el correo!');
              //return false;
          }
      $result = DB::table('solicitud_talleres')
      ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.fecha_solicitud', 'solicitud_talleres.nombre_taller', 'solicitud_talleres.area',
               'solicitud_talleres.creditos', 'solicitud_talleres.lugar', 'solicitud_talleres.cupo', 'solicitud_talleres.estado',
               'solicitud_talleres.lugar', 'solicitud_talleres.fecha_inicio', 'solicitud_talleres.fecha_fin', 'solicitud_talleres.hora_inicio',
               'solicitud_talleres.hora_fin', 'solicitud_talleres.dias_sem', 'solicitud_talleres.materiales')
      ->join('estudiantes', 'solicitud_talleres.matricula', '=', 'estudiantes.matricula')
      ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
       ->join('periodos', 'periodos.id_periodo', '=', 'solicitud_talleres.periodo')
       ->where([['solicitud_talleres.matricula', $data['matricula']], ['periodos.estatus', '=', 'actual'], ['solicitud_talleres.estado', '=', 'Pendiente']])
       ->take(1)
       ->first();

      $persona_id = DB::table('estudiantes')
      ->select('estudiantes.id_persona')
      ->where('estudiantes.matricula', $data['matricula'])
      ->take(1)
      ->first();
    //  $persona_id= json_decode( json_encode($persona_id), true);
      $modali = DB::table('estudiantes')
      ->select('estudiantes.modalidad')
      ->where('estudiantes.matricula', $data['matricula'])
      ->take(1)
      ->first();
      $bus_adm = DB::table('administrativos')
      ->select('administrativos.id_administrativo')
      ->join('personas', 'personas.id_persona', '=', 'administrativos.id_persona')
      ->where('personas.id_persona',$persona_id->id_persona)
      ->take(1)
      ->first();
        //  $bus_adm = $bus_adm->id_administrativo;
     if(empty($bus_adm->id_administrativo)){

      $administrativo=new Administrativo;
      $administrativo->id_persona=$persona_id->id_persona;
      $administrativo->save();

      $bus_adm = DB::table('administrativos')
      ->select('administrativos.id_administrativo')
      ->join('personas', 'personas.id_persona', '=', 'administrativos.id_persona')
      ->where('personas.id_persona',$persona_id->id_persona)
      ->take(1)
      ->first();
      $bus_adm = $bus_adm->id_administrativo;

      $nivel = new Nivel();
      $nivel ->id_administrativo= $bus_adm;
      $nivel ->grado_estudios='estudiante';
      $nivel ->save();

      $bus_nivel = DB::table('nivel')
      ->select('nivel.id_nivel')
      ->join('administrativos', 'nivel.id_administrativo', '=', 'administrativos.id_administrativo')
      ->where('administrativos.id_administrativo',$bus_adm)
      ->take(1)
      ->first();

      $tutor = new Tutor();
      $tutor ->procedencia_interna= 'FACULTAD DE IDIOMAS';
      $tutor ->procedencia_externa= 'FACULTAD DE IDIOMAS';
      $tutor ->id_persona= $persona_id->id_persona ;
      $tutor ->id_nivel= $bus_nivel->id_nivel;
      $tutor->periodo=$periodo_semestre->id_periodo;
      $tutor->save();

      $now = new \DateTime();
     $periodo_semestre= $periodo_semestre->id_periodo;
      DB::table('extracurriculares')
      ->Insert(['nombre_ec' => $result->nombre_taller, 'tipo' => 'Taller', 'creditos' => $result->creditos, 'area'=> $result->area,
     'modalidad'=> $modali->modalidad,  'cupo'=> $result->cupo, 'lugar'=> $result->lugar, 'fecha_inicio'=> $result->fecha_inicio,
     'fecha_fin'=> $result->fecha_fin,  'hora_inicio'=> $result->hora_inicio,  'hora_fin'=> $result->hora_fin, 'dias_sem'=> $result->dias_sem,
     'materiales'=> $result->materiales,  'tutor'=> $tutor->id_tutor, 'periodo'=> $periodo_semestre, 'control_cupo'=> $result->cupo,
     'created_at'=> $now, 'updated_at'=> $now]);
    }
    else {
      $id_tutores = DB::table('tutores')
      ->select('tutores.id_tutor')
      ->join('personas', 'personas.id_persona', '=' ,'tutores.id_persona')
      ->join('estudiantes', 'estudiantes.id_persona', '=' ,'personas.id_persona')
      ->where('estudiantes.matricula', $data['matricula'])
      ->take(1)
      ->first();
      $now = new \DateTime();
     $periodo_semestre= $periodo_semestre->id_periodo;
      DB::table('extracurriculares')
      ->Insert(['nombre_ec' => $result->nombre_taller, 'tipo' => 'Taller', 'creditos' => $result->creditos, 'area'=> $result->area,
     'modalidad'=> $modali->modalidad,  'cupo'=> $result->cupo, 'lugar'=> $result->lugar, 'fecha_inicio'=> $result->fecha_inicio,
     'fecha_fin'=> $result->fecha_fin,  'hora_inicio'=> $result->hora_inicio,  'hora_fin'=> $result->hora_fin, 'dias_sem'=> $result->dias_sem,
     'materiales'=> $result->materiales,  'tutor'=> $id_tutores->id_tutor, 'periodo'=> $periodo_semestre, 'control_cupo'=> $result->cupo,
     'created_at'=> $now, 'updated_at'=> $now]);
    }

     DB::table('solicitud_talleres')
         ->where([['solicitud_talleres.matricula', $data['matricula']], ['solicitud_talleres.periodo', $periodo_semestre],
         ['solicitud_talleres.estado', '=', 'Pendiente']])
         ->update(
           ['estado' => 'Aprobado']);

    $notificacion = new Notificacion;
    $notificacion->matricula= $data['matricula'];
    $notificacion->num_solicitud= $datos_taller->num_solicitud;
    $notificacion->asunto= $data['asunto'];
    $notificacion->mensaje= $data['contenido'];
    $notificacion->estatus= 'enviado';
    $notificacion->save();

          return redirect()->route('notificaciones_enviadas')->with('success','¡Notificación Enviada Correctamente!');
    }

    public function enviadas_notifaciones(){

      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
        $result = DB::table('notificaciones')
      ->select('notificaciones.asunto', 'notificaciones.matricula', 'notificaciones.mensaje', 'notificaciones.created_at',
      'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'solicitud_talleres.nombre_taller', 'users.email')
       ->join('solicitud_talleres', 'solicitud_talleres.num_solicitud', '=' , 'notificaciones.num_solicitud')
       ->join('estudiantes', 'estudiantes.matricula', '=', 'notificaciones.matricula')
    //  ->join('solicitud_talleres', 'solicitud_talleres.num_solicitud', '=' , 'estudiantes.matricula')
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
	  ->join('users', 'users.id_persona', '=' , 'personas.id_persona')
      ->where('notificaciones.estatus', '=', 'enviado')
      ->orderBy('notificaciones.created_at', 'desc')
        ->simplePaginate(10);
    return view('personal_administrativo/formacion_integral.notificaciones_enviadas')->with('data', $result);

    }

    public function cancelacion_aprobado($id_extracurricular, $matricula){

      $data= $id_extracurricular;
      $matricula_estudiante = $matricula;

      $datos_correo= DB::table('users')
       ->select('users.email', 'personas.nombre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->join('personas', 'users.id_persona', '=' , 'personas.id_persona')
       ->where('users.id_user', $matricula_estudiante)
       ->take(1)
       ->first();

      $result = DB::table('extracurriculares')
      ->select('extracurriculares.id_extracurricular', 'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
      'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
      'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor',
      'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
      ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
      ->where([['extracurriculares.bandera', '=', '1'], ['extracurriculares.id_extracurricular',$data ]])
      ->take(1)
      ->first();
      //return view('personal_administrativo/formacion_integral/gestion_talleres.desactivar_extra_estudiante')->with('dato', $data)->with('datos', $result);


      return view('mails.notificacioncancelacion')
      ->with('datos_estudiante', $datos_correo)->
      with('estudiante_matricula', $matricula_estudiante)
        ->with('datos_taller', $result);
    }

    public function enviar_cancelacion(Request $request){
      $data= $request;
      $periodo_semestre = DB::table('periodos')
      ->select('periodos.id_periodo')
      ->where('periodos.estatus', '=', 'actual')
      ->take(1)
      ->first();
      $periodo_semestre=$periodo_semestre->id_periodo;
      $datos_correo= DB::table('users')
       ->select('users.email', 'users.id_user', 'personas.nombre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->join('personas', 'users.id_persona', '=' , 'personas.id_persona')
       ->where('users.id_user', $data['matricula'])
       ->take(1)
       ->first();

       $datos_taller = DB::table('extracurriculares')
       ->select('extracurriculares.id_extracurricular', 'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
       'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
       'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor',
       'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
       ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
       ->where([['extracurriculares.bandera', '=', '1'], ['extracurriculares.id_extracurricular', $data['id_extracurricular'] ]])
       ->take(1)
       ->first();
       $result = DB::table('solicitud_talleres')
       ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.fecha_solicitud', 'solicitud_talleres.nombre_taller', 'solicitud_talleres.area',
                'solicitud_talleres.creditos', 'solicitud_talleres.lugar', 'solicitud_talleres.cupo', 'solicitud_talleres.estado',
                'solicitud_talleres.lugar', 'solicitud_talleres.fecha_inicio', 'solicitud_talleres.fecha_fin', 'solicitud_talleres.hora_inicio',
                'solicitud_talleres.hora_fin', 'solicitud_talleres.dias_sem', 'solicitud_talleres.materiales')
       ->join('estudiantes', 'solicitud_talleres.matricula', '=', 'estudiantes.matricula')
       ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
        ->join('periodos', 'periodos.id_periodo', '=', 'solicitud_talleres.periodo')
        ->where([['solicitud_talleres.matricula', $data['matricula']], ['periodos.estatus', '=', 'actual'], ['solicitud_talleres.estado', '=', 'Aprobado']])
        ->take(1)
        ->first();

        try {
          Mail::to($datos_correo->email)
          ->send(new CancelacionTaller($datos_correo, $data, $datos_taller));
   } catch (Exception $e) {
       report($e);
       redirect()->back()->with('error', 'Hubo un error al tratar de enviar el correo!');
      // return redirect()->route('mis_actividades')->with('success','¡Inscripción Realizada correctamente!');
      }

      DB::table('solicitud_talleres')
      ->where([['solicitud_talleres.matricula', $data['matricula']], ['solicitud_talleres.periodo', $periodo_semestre]])
      ->update( ['estado' => 'Cancelado']);


      DB::table('extracurriculares')
          ->where('extracurriculares.id_extracurricular', $data['id_extracurricular'])
          ->update(
            ['bandera' => '3', 'observaciones' => $data['observaciones']]);

       $notificacion = new Notificacion;
       $notificacion->matricula= $data['matricula'];
       $notificacion->num_solicitud= $result->num_solicitud;
       $notificacion->asunto= $data['asunto'];
       $notificacion->mensaje= $data['contenido'];
       $notificacion->estatus= 'enviado';
       $notificacion->save();

          return redirect()->route('notificaciones_enviadas')->with('success','¡Notificación Enviada Correctamente!');
    }
    /*************************************/

    public function acreditacion_aprobado($id_extracurricular, $matricula){

      $data= $id_extracurricular;
      $matricula_estudiante = $matricula;

      $datos_correo= DB::table('users')
       ->select('users.email', 'personas.nombre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->join('personas', 'users.id_persona', '=' , 'personas.id_persona')
       ->where('users.id_user', $matricula_estudiante)
       ->take(1)
       ->first();

      $result = DB::table('extracurriculares')
      ->select('extracurriculares.id_extracurricular', 'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
      'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
      'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor',
      'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
      ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
      ->where([['extracurriculares.bandera', '=', '1'], ['extracurriculares.id_extracurricular',$data ]])
      ->take(1)
      ->first();
      //return view('personal_administrativo/formacion_integral/gestion_talleres.desactivar_extra_estudiante')->with('dato', $data)->with('datos', $result);


      return view('mails.notificacion_acreditacion')
      ->with('datos_estudiante', $datos_correo)->
      with('estudiante_matricula', $matricula_estudiante)
        ->with('datos_taller', $result);
    }

    public function enviar_acreditacion(Request $request){
      $data= $request;
      $periodo_semestre = DB::table('periodos')
      ->select('periodos.id_periodo')
      ->where('periodos.estatus', '=', 'actual')
      ->take(1)
      ->first();
      $periodo_semestre= $periodo_semestre->id_periodo;

      $datos_correo= DB::table('users')
       ->select('users.email', 'users.id_user', 'personas.nombre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->join('personas', 'users.id_persona', '=' , 'personas.id_persona')
       ->where('users.id_user', $data['matricula'])
       ->take(1)
       ->first();

       $datos_taller = DB::table('extracurriculares')
       ->select('extracurriculares.id_extracurricular', 'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
       'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
       'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor',
       'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
       ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
       ->where([['extracurriculares.bandera', '=', '1'], ['extracurriculares.id_extracurricular',$data['id_extracurricular'] ]])
       ->take(1)
       ->first();
       $creditos_taller= ($datos_taller->creditos) * 2;
       $datos_solicitud = DB::table('solicitud_talleres')
        ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.nombre_taller')
        ->join('periodos', 'periodos.id_periodo', '=', 'solicitud_talleres.periodo')
        ->where([['solicitud_talleres.matricula', $data['matricula']], ['periodos.estatus', '=', 'actual'], ['solicitud_talleres.estado', '=', 'Aprobado']])
        ->take(1)
        ->first();

        try {
          Mail::to($datos_correo->email)
          ->send(new AcreditacionTaller($datos_correo, $data, $datos_taller));
   } catch (Exception $e) {
       report($e);
       redirect()->back()->with('error', 'Hubo un error al tratar de enviar el correo!');
      // return redirect()->route('mis_actividades')->with('success','¡Inscripción Realizada correctamente!');
      }
      DB::table('solicitud_talleres')
          ->where([['solicitud_talleres.matricula', $data['matricula']], ['solicitud_talleres.periodo', $periodo_semestre]])
          ->update(['estado' => 'Acreditado']);

      DB::table('extracurriculares')
          ->where('extracurriculares.id_extracurricular', $data['id_extracurricular'])
          ->update(['bandera' => '2', 'observaciones' => $data['observaciones']]);

            $inscripcion = new Detalle_extracurricular;
            $inscripcion->matricula= $data['matricula'];
            $inscripcion->actividad= $data['id_extracurricular'];
            $inscripcion->creditos= $creditos_taller;
            $inscripcion->estado= 'Acreditado';
            $inscripcion->periodo= $periodo_semestre;
            $inscripcion->save();

       $notificacion = new Notificacion;
       $notificacion->matricula= $data['matricula'];
       $notificacion->num_solicitud= $datos_solicitud->num_solicitud;
       $notificacion->asunto= $data['asunto'];
       $notificacion->mensaje= $data['contenido'];
       $notificacion->estatus= 'enviado';
       $notificacion->save();

          return redirect()->route('notificaciones_enviadas')->with('success','¡Notificación Enviada Correctamente!');
    }

}
