<?php
namespace App\Http\Controllers\Estudiante_Con;
use App\Http\Controllers\Controller;
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
use App\CodigoPostal;
use App\Practica;
use App\PracticaProfesional;
use App\ServicioSocial;
use App\Carrera;
use App\Escuela;
use App\Direccion;
use App\Tutoria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response as FacadeResponse;


//use Excel;

class EstudianteController extends Controller
{

  public function inicio_estudiante(){
    $usuario_actuales=\Auth::user();
     if($usuario_actuales->tipo_usuario!='estudiante'){
       return redirect()->back();
      }

    $usuario_actual=auth()->user();
	$id=$usuario_actual->id_user;
    if($usuario_actual->tipo_usuario == 'estudiante'){
      if($usuario_actual->bandera == '1'){
		  $lineamiento_checar = DB::table('users')
        ->select('users.check_lineamiento', 'users.imagenurl')
        ->where('users.id_user', $id)
        ->take(1)
        ->first();
		if($lineamiento_checar->check_lineamiento == 0){
			 return redirect()->route('lineamientos')
			 ->with('error', '¡Para poder usar los Servicios del Portal debes leer y aceptar los lineamientos del mismo!');
		}
		else{
			if(empty($lineamiento_checar->imagenurl)){
				$dataima= 'foto.png';
			}
			else{
				$dataima= $lineamiento_checar->imagenurl;
			}
		return view('estudiante.home_estudiante')->with('imagen', $dataima);
		}
 }
}
}

    public function dato_general()
    {
      $usuario_actual=auth()->user();
      $id=$usuario_actual->id_user;
       if($id->tipo_usuario!='estudiante'){
        return redirect()->back();
      }
      else{
        return view('estudiante/datos.datos_generales');
          }
  }

  public function dato_laboral(){
    $usuario_actual=auth()->user();
    $id=$usuario_actual->id_user;
     if($id->tipo_usuario!='estudiante'){
      return redirect()->back();
      }
  return view('estudiante/datos.datos_laborales');
}

public function dato_medico(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='estudiante'){
     return redirect()->back();
    }
return view('estudiante/datos.datos_medicos');
}

public function dato_personal(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='estudiante'){
     return redirect()->back();
    }
return view('estudiante/datos.datos_personales');
}

    public function activities(){
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
        if(empty($periodo_semestre->id_periodo)){
          return redirect()->route('home_estudiante')->with('error','Ninguna Actividad Registrada');
        }else {
        $result = DB::table('detalle_extracurriculares')
        ->select('detalle_extracurriculares.estado','extracurriculares.id_extracurricular',  'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
        'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.modalidad', 'extracurriculares.lugar', 'extracurriculares.fecha_inicio',
        'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor',
        'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
        ->join('extracurriculares', 'extracurriculares.id_extracurricular', '=', 'detalle_extracurriculares.actividad')
        ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
        ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
        ->where([['extracurriculares.bandera','=', '1'], ['detalle_extracurriculares.matricula','=', $id], ['detalle_extracurriculares.estado', '=', 'Cursando'],  ['detalle_extracurriculares.periodo', $periodo_semestre->id_periodo]])
        ->simplePaginate(10);
      return  view ('estudiante/mis_actividades.misactividades')->with('dato', $result);
    }
  }

        public function avance_horas(){
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
            $result = DB::table('detalle_extracurriculares')
            ->select('detalle_extracurriculares.estado','extracurriculares.id_extracurricular',  'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
            'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
            'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor',
            'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
            ->join('extracurriculares', 'extracurriculares.id_extracurricular', '=', 'detalle_extracurriculares.actividad')
            ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
            ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
            ->where([['detalle_extracurriculares.matricula','=', $id], ['detalle_extracurriculares.estado', '=', 'Acreditado'],])
            ->simplePaginate(10);

            $avance = DB::table('detalle_extracurriculares')
             ->where([['detalle_extracurriculares.matricula','=', $id], ['detalle_extracurriculares.estado', '=', 'Acreditado']])
             ->sum('detalle_extracurriculares.creditos');

          return  view ('estudiante/mis_actividades.avance_horas')->with('dato', $result)->with('av',$avance);
        }

    public function talleres_activos(){
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
        ->select('extracurriculares.id_extracurricular', 'extracurriculares.bandera', 'extracurriculares.dias_sem',
        'extracurriculares.nombre_ec', 'extracurriculares.tipo', 'extracurriculares.creditos', 'extracurriculares.area',
        'extracurriculares.control_cupo', 'extracurriculares.cupo','extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
		'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor', 
		'personas.nombre','personas.apellido_paterno', 'personas.apellido_materno' , 'extracurriculares.fecha_inicio',
        'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'extracurriculares.lugar')
        ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
        ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
        ->where([['extracurriculares.bandera', '=', '1'], ['tutores.id_tutor', $id_tutores->id_tutor], ['extracurriculares.periodo', $periodo_semestre->id_periodo]])
        ->orderBy('extracurriculares.created_at', 'asc')
        ->simplePaginate(10);

      return  view ('estudiante/mis_actividades.mis_talleres')->with('dato', $result);

    }
    else {
      return redirect()->route('home_estudiante')->with('error', 'Ningún taller activo');

    }
  }


    public function loginestudiantes(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='estudiante'){
         return redirect()->back();
        }
      return view('estudiante.login_studiante');
    }

    public function m_estudiantes(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='estudiante'){
         return redirect()->back();
        }
    return view('m_usuario/m_estudiante');
  }

  public function verDatos(){
     $usuario_actual=\Auth::user();
    return view('estudiantes/datos.hoja_datos')-with('s', $prueba);
  }
    public function generatePDF()
    {
      $usuario_actual=auth()->user();
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
  ->select('periodos.id_periodo', 'periodos.inicio', 'periodos.final')
  ->where('periodos.estatus', '=', 'actual')
  ->take(1)
  ->first();
       $usuario=auth()->user();
        $ids=$usuario->id_user;
        $id_persona = DB::table('estudiantes')
        ->select('estudiantes.id_persona')
        ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
        ->where('estudiantes.matricula',$ids)
        ->take(1)
        ->first();
          $id_persona= $id_persona->id_persona;
            $users = DB::table('estudiantes')
         ->select('estudiantes.matricula', 'estudiantes.materias_pendientes', 'estudiantes.horario_asesorias', 'estudiantes.semestre',
         'estudiantes.modalidad', 'estudiantes.estatus', 'estudiantes.grupo', 'personas.nombre', 'personas.apellido_paterno',
         'personas.apellido_materno', 'personas.fecha_nacimiento', 'personas.curp', 'personas.genero',
         'users.facebook', 'personas.tipo_sangre', 'users.email' )
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->join('users', 'users.id_persona', '=', 'personas.id_persona')
      ->where('estudiantes.matricula',$ids)
      ->take(1)
      ->first();
                         $direccion = DB::table('personas')
                         ->select('direcciones.vialidad_principal', 'direcciones.num_exterior', 'direcciones.cp', 'direcciones.localidad',
                         'direcciones.municipio', 'direcciones.entidad_federativa')
                         ->join('direcciones', 'direcciones.id_direccion', '=' , 'personas.id_direccion')
                         ->where('personas.id_persona',$id_persona)
                         ->take(1)
                         ->first();


           $num_local = DB::table('personas')
           ->select('telefonos.numero')
           ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
           ->where([['personas.id_persona',$id_persona], ['telefonos.tipo', '=', 'local']])
           ->take(1)
           ->first();

           $num_cel = DB::table('personas')
           ->select('telefonos.numero')
           ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
           ->where([['personas.id_persona',$id_persona], ['telefonos.tipo', '=', 'celular']])
           ->take(1)
           ->first();

           $actividad = DB::table('datos_externos')
           ->select('datos_externos.nombre_actividadexterna', 'datos_externos.tipo_actividadexterna', 'datos_externos.dias_sem',
           'datos_externos.hora_entrada', 'datos_externos.hora_salida', 'datos_externos.lugar')
           ->where([['datos_externos.matricula', $ids], ['datos_externos.bandera', '=', '1']])
           ->take(1)
           ->first();

           $lengua = DB::table('lenguas')
           ->select('lenguas.nombre_lengua')
           ->where('lenguas.id_persona', $id_persona)
           ->take(1)
           ->first();

           $emergencia_dato = DB::table('datos_emergencias')
           ->select('datos_emergencias.responsable')
           ->join('estudiantes', 'estudiantes.matricula', '=', 'datos_emergencias.matricula')
           ->where('estudiantes.matricula', $ids)
           ->take(1)
           ->first();
         //  $emergencia_dato= $emergencia_dato->responsable;
           $emergencia_dato= json_decode( json_encode($emergencia_dato), true);

           $emergencia_persona = DB::table('personas')
           ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
           ->where('personas.id_persona', $emergencia_dato)
           ->take(1)
           ->first();

           $parentesco = DB::table('datos_emergencias')
           ->select('datos_emergencias.parentesco')
           ->where('datos_emergencias.matricula', $ids)
           ->take(1)
           ->first();

           $num_emergencia = DB::table('personas')
           ->select('telefonos.numero')
           ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
           ->where([['personas.id_persona',$id_persona], ['telefonos.tipo', '=', 'emergencia']])
           ->take(1)
           ->first();

              $alergia = DB::table('estudiantes')
           ->select('enfermedades_alergias.nombre_enfermedadalergia', 'enfermedades_alergias.tipo_enfermedadalergia',
           'enfermedades_alergias.descripcion', 'enfermedades_alergias.indicaciones')
           ->join('enfermedades_alergias', 'estudiantes.matricula', '=', 'enfermedades_alergias.matricula')
           ->where([['estudiantes.matricula',$ids],['enfermedades_alergias.tipo_enfermedadalergia', '=', 'Alergia'], ['enfermedades_alergias.bandera', '=', '1']])
           ->take(1)
           ->first();

           $enfermedad = DB::table('estudiantes')
           ->select('enfermedades_alergias.nombre_enfermedadalergia', 'enfermedades_alergias.tipo_enfermedadalergia',
           'enfermedades_alergias.descripcion', 'enfermedades_alergias.indicaciones')
           ->join('enfermedades_alergias', 'estudiantes.matricula', '=', 'enfermedades_alergias.matricula')
           ->where([['estudiantes.matricula',$ids],['enfermedades_alergias.tipo_enfermedadalergia', '=', 'Enfermedad'], ['enfermedades_alergias.bandera', '=', '1']])
           ->take(1)
           ->first();

           $paper_orientation = 'letter';
           $customPaper = array(2.5,2.5,600,950);

        $pdf = PDF::loadView('estudiante/datos.hoja_datos',  ['data' =>  $users, 'di' => $direccion, 'nu_l' => $num_local,
         'nu_ce' => $num_cel, 'activ' => $actividad, 'emergencia_persona' => $emergencia_persona, 'parentesco' => $parentesco,
         'num_emergencia' => $num_emergencia, 'alergia' => $alergia, 'enfermedad' => $enfermedad, 'lengua' => $lengua, 'periodo' => $periodo_semestre])
      ->setPaper($customPaper,$paper_orientation);
        return $pdf->stream('hoja_datos_personales.pdf');


    }
    public function cuenta_estudiante(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='estudiante'){
         return redirect()->back();
        }
    return view('estudiante.configuracion_cuenta');
    }

    public function foto_perfil(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='estudiante'){
         return redirect()->back();
        }
    return view('estudiante.foto_perfil');
    }

  public function editar_actividades($id_externos)
  {
    $usuario_actual=\Auth::user();
    $externo= $id_externos;
     if($usuario_actual->tipo_usuario!='estudiante'){
      return redirect()->back();
    }
    else{
      return view('estudiante/datos.editar_externas')->with('e',$externo);
        }
}

  public function solicitud_taller(){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='estudiante'){
       return redirect()->back();
      }
        $id=$usuario_actual->id_user;
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
        $id_persona= json_decode( json_encode($id_persona), true);
        $users = DB::table('estudiantes')
        ->select('estudiantes.semestre', 'estudiantes.modalidad', 'personas.edad', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
        ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
        ->where('estudiantes.matricula',$id)
        ->take(1)
        ->first();

        $num_cel = DB::table('personas')
        ->select('telefonos.numero')
        ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
        ->where([['personas.id_persona',$id_persona], ['telefonos.tipo', '=', 'celular']])
        ->take(1)
        ->first();

        $fecha_inicio = DB::table('periodo_actualizacion')
        ->select('periodo_actualizacion.estado')
        ->where([['periodo_actualizacion.tipo', '=', 'taller'], ['periodo_actualizacion.estado', '=', 'Activo']])
        ->take(1)
        ->first();
        if(empty($fecha_inicio->estado)){
          return redirect()->route('home_estudiante')->with('error', 'El nuevo periodo de Solicitudes para dar un Taller aún no empieza');
        }
        else {
                  
               $detalles_de_s = DB::table('solicitud_talleres')
          ->select('solicitud_talleres.estado', 'solicitud_talleres.bandera')
          ->where([['solicitud_talleres.matricula', $id], ['solicitud_talleres.periodo',$periodo_semestre->id_periodo], ['solicitud_talleres.bandera', '=', '1']])
          ->take(1)
          ->first();
          if(empty($detalles_de_s->estado)){
            $detalles = DB::table('solicitud_talleres')
            ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.duracion', 'solicitud_talleres.fecha_solicitud', 'solicitud_talleres.nombre_taller', 'solicitud_talleres.descripcion',
            'solicitud_talleres.objetivos', 'solicitud_talleres.lugar', 'solicitud_talleres.justificacion', 'solicitud_talleres.creditos', 'solicitud_talleres.area',
            'solicitud_talleres.proyecto_final', 'solicitud_talleres.cupo', 'solicitud_talleres.matricula', 'solicitud_talleres.departamento',
            'solicitud_talleres.estado', 'solicitud_talleres.fecha_inicio', 'solicitud_talleres.fecha_fin', 'solicitud_talleres.hora_inicio',
            'solicitud_talleres.hora_fin', 'solicitud_talleres.dias_sem', 'solicitud_talleres.materiales' )
            //->where('solicitud_talleres.matricula',$id)
            ->where([['solicitud_talleres.matricula',$id], ['solicitud_talleres.bandera', '=', '9']])
            ->take(1)
            ->first();
            return view('estudiante/mis_actividades.solicitud_taller')
            ->with('u',$users)->with('num_c', $num_cel)->with('taller', $detalles)->with('hola', $detalles_de_s)
			->with('success', 'Antes de enviar la Solicitud Verifica tu Correo en Datos Personales');
          }
            if(($detalles_de_s->estado) == 'Pendiente'){
              $detalles = DB::table('solicitud_talleres')
              ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.duracion', 'solicitud_talleres.fecha_solicitud', 'solicitud_talleres.nombre_taller', 'solicitud_talleres.descripcion',
              'solicitud_talleres.objetivos', 'solicitud_talleres.lugar', 'solicitud_talleres.justificacion', 'solicitud_talleres.creditos', 'solicitud_talleres.area',
              'solicitud_talleres.proyecto_final', 'solicitud_talleres.cupo', 'solicitud_talleres.matricula', 'solicitud_talleres.departamento',
              'solicitud_talleres.estado', 'solicitud_talleres.fecha_inicio', 'solicitud_talleres.fecha_fin', 'solicitud_talleres.hora_inicio',
              'solicitud_talleres.hora_fin', 'solicitud_talleres.dias_sem', 'solicitud_talleres.materiales' )
              //->where('solicitud_talleres.matricula',$id)
              ->where([['solicitud_talleres.matricula',$id], ['solicitud_talleres.bandera', '=', '1'] , ['solicitud_talleres.periodo',$periodo_semestre->id_periodo]])
              ->take(1)
              ->first();
              return view('estudiante/mis_actividades.solicitud_taller')
              ->with('u',$users)->with('num_c', $num_cel)->with('taller', $detalles);
          }

          if(($detalles_de_s->estado) == 'Aprobado'){
              return redirect()->route('mi_taller')->with('error', 'Actualmente cuentas con un Taller Activo');
        }

        if(($detalles_de_s->estado) == 'Acreditado'){
            return redirect()->route('home_estudiante')->with('error', 'Solo puedes gestionar un taller por Semestre');
      }
	  
	   if(($detalles_de_s->estado) == 'Cancelado'){
            return redirect()->route('home_estudiante')->with('error', 'Tu taller fue cancelado, Solo puedes gestionar un taller por Semestre');
      }
}
}
 public function solicitud_practicasP(){
     $usuario_actuales=\Auth::user();
      if($usuario_actuales->tipo_usuario!='estudiante'){
      return redirect()->back();
       }

     $usuario_actual=auth()->user();
     $id=$usuario_actual->id_user;
  $validar = DB::table('estudiantes')
     ->select('estudiantes.semestre', 'estudiantes.estatus')
     ->where('estudiantes.matricula',$id)
     ->take(1)
     ->first();
     $periodo_semestre = DB::table('periodos')
     ->select('periodos.id_periodo')
     ->where('periodos.estatus', '=', 'actual')
     ->take(1)
     ->first();
     if((($validar->semestre) >= 4 ) && (($validar->estatus) == 'REGULAR')){
       $practicas_dependencia = DB::table('practicas')
       ->select('practicas.id_practicas', 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
       'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->join('personas', 'personas.id_persona', '=', 'practicas.titular')
       ->where([['practicas.matricula',$id], ['practicas.tipo', '=', 'PRACTICAS']])
       ->take(1)
       ->first();

     $id_persona = DB::table('estudiantes')
     ->select('estudiantes.id_persona')
     ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
     ->where('estudiantes.matricula',$id)
     ->take(1)
     ->first();
       $id_persona= json_decode( json_encode($id_persona), true);

       $users = DB::table('estudiantes')
       ->select('estudiantes.matricula', 'estudiantes.semestre', 'estudiantes.modalidad', 'estudiantes.estatus', 'estudiantes.grupo', 'estudiantes.fecha_ingreso',
                'personas.nombre', 'personas.id_persona', 'personas.edad', 'personas.apellido_paterno', 'personas.apellido_materno', 'personas.fecha_nacimiento',
                'personas.curp', 'personas.genero')
       ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
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
  if(empty($practicas_dependencia->id_practicas)){
         $practicas_dependencia = DB::table('practicas')
         ->select('practicas.id_practicas', 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
         'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
         ->join('personas', 'personas.id_persona', '=', 'practicas.titular')
         ->where([['practicas.matricula',$id], ['practicas.tipo', '=', 'PRACTICASw']])
         ->take(1)
         ->first();
        if(empty($practicas_dependencia->id_practicas)){
          $datos_di=null;        }
        else {
      $datos_di = DB::table('practicas_profesionales')
      ->select('practicas_profesionales.id_practicas','practicas_profesionales.periodo_practicas', 'direcciones.vialidad_principal',
               'direcciones.num_exterior', 'direcciones.localidad', 'direcciones.cp', 'direcciones.municipio')
      ->join('direcciones', 'direcciones.id_direccion', '=', 'practicas_profesionales.id_direccion')
      ->where('practicas_profesionales.id_practicas',$practicas_dependencia->id_practicas)
      ->take(1)
      ->first();        }
        $escuela_r = DB::table('carreras')
        ->select('carreras.carrera')
        ->take(1)
        ->first();
   return view('estudiante/servicios.solicitud_practicas')
   ->with('u',$users)->with('d', $direccion)->with('cel', $num_cel)->with('valor_d', $valor_direccion)
   ->with('dependencia_p', $practicas_dependencia)->with('datos_practicas', $datos_di)
   ->with('cel_dep', $num_prac)->with('carreras', $escuela_r);
 }
else {
  $datos_de = DB::table('practicas_profesionales')
  ->select('practicas_profesionales.id_practicas', 'practicas_profesionales.estatus_practica', 'practicas_profesionales.periodo_practicas', 'direcciones.vialidad_principal',
           'direcciones.num_exterior', 'direcciones.localidad', 'direcciones.cp', 'direcciones.municipio')
  ->join('direcciones', 'direcciones.id_direccion', '=', 'practicas_profesionales.id_direccion')
  ->where('practicas_profesionales.id_practicas',$practicas_dependencia->id_practicas)
  ->take(1)
  ->first();
 if(($datos_de->estatus_practica) == 'Pendiente'){
        $practicas_dependencia = DB::table('practicas')
        ->select('practicas.id_practicas', 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
        'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
        ->join('personas', 'personas.id_persona', '=', 'practicas.titular')
        ->where([['practicas.matricula',$id], ['practicas.tipo', '=', 'PRACTICAS']])
        ->take(1)
        ->first();
       if(empty($practicas_dependencia->id_practicas)){
         $datos_di=null;        }
       else {
     $datos_di = DB::table('practicas_profesionales')
     ->select('practicas_profesionales.id_practicas','practicas_profesionales.periodo_practicas', 'direcciones.vialidad_principal',
              'direcciones.num_exterior', 'direcciones.localidad', 'direcciones.cp', 'direcciones.municipio')
     ->join('direcciones', 'direcciones.id_direccion', '=', 'practicas_profesionales.id_direccion')
     ->where('practicas_profesionales.id_practicas',$practicas_dependencia->id_practicas)
     ->take(1)
     ->first();        }
       $escuela_r = DB::table('carreras')
       ->select('carreras.carrera')
       ->take(1)
       ->first();
  return view('estudiante/servicios.solicitud_practicas')
  ->with('u',$users)->with('d', $direccion)->with('cel', $num_cel)->with('valor_d', $valor_direccion)
  ->with('dependencia_p', $practicas_dependencia)->with('datos_practicas', $datos_di)
  ->with('cel_dep', $num_prac)->with('carreras', $escuela_r);
}
if(($datos_de->estatus_practica) == 'Cursando'){
       $practicas_dependencia = DB::table('practicas')
       ->select('practicas.id_practicas', 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
       'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->join('personas', 'personas.id_persona', '=', 'practicas.titular')
       ->where([['practicas.matricula',$id], ['practicas.tipo', '=', 'PRACTICAS']])
       ->take(1)
       ->first();
      if(empty($practicas_dependencia->id_practicas)){
        $datos_di=null;        }
      else {
    $datos_di = DB::table('practicas_profesionales')
    ->select('practicas_profesionales.id_practicas','practicas_profesionales.periodo_practicas', 'direcciones.vialidad_principal',
             'direcciones.num_exterior', 'direcciones.localidad', 'direcciones.cp', 'direcciones.municipio')
    ->join('direcciones', 'direcciones.id_direccion', '=', 'practicas_profesionales.id_direccion')
    ->where('practicas_profesionales.id_practicas',$practicas_dependencia->id_practicas)
    ->take(1)
    ->first();        }
      $escuela_r = DB::table('carreras')
      ->select('carreras.carrera')
      ->take(1)
      ->first();
 return view('estudiante/servicios.solicitud_practicas')
 ->with('u',$users)->with('d', $direccion)->with('cel', $num_cel)->with('valor_d', $valor_direccion)
 ->with('dependencia_p', $practicas_dependencia)->with('datos_practicas', $datos_di)
 ->with('cel_dep', $num_prac)->with('carreras', $escuela_r);
}
if(($datos_de->estatus_practica) == 'Cancelado'){
       $practicas_dependencia = DB::table('practicas')
       ->select('practicas.id_practicas', 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
       'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
       ->join('personas', 'personas.id_persona', '=', 'practicas.titular')
       ->where([['practicas.matricula',$id], ['practicas.tipo', '=', 'sdsd']])
       ->take(1)
       ->first();
      if(empty($practicas_dependencia->id_practicas)){
        $datos_di=null;        }
      else {
    $datos_di = DB::table('practicas_profesionales')
    ->select('practicas_profesionales.id_practicas','practicas_profesionales.periodo_practicas', 'direcciones.vialidad_principal',
             'direcciones.num_exterior', 'direcciones.localidad', 'direcciones.cp', 'direcciones.municipio')
    ->join('direcciones', 'direcciones.id_direccion', '=', 'practicas_profesionales.id_direccion')
    ->where('practicas_profesionales.id_practicas',$practicas_dependencia->id_practicas)
    ->take(1)
    ->first();        }
      $escuela_r = DB::table('carreras')
      ->select('carreras.carrera')
      ->take(1)
      ->first();
 return view('estudiante/servicios.solicitud_practicas')
 ->with('u',$users)->with('d', $direccion)->with('cel', $num_cel)->with('valor_d', $valor_direccion)
 ->with('dependencia_p', $practicas_dependencia)->with('datos_practicas', $datos_di)
 ->with('cel_dep', $num_prac)->with('carreras', $escuela_r);
}
if(($datos_de->estatus_practica) == 'Finalizado'){
       return redirect()->route('solicitud_servicioSocial')->with('success', 'Has concluido satisfactoriamente tus Prácticas Profesionales, Ya puedes rellenar tus datos de Servicio Social');
}
}
}
 else{
  return redirect()->route('home_estudiante')->with('error','No cumples con los requisitos para realizar Prácticas Profesionales');}
 }
   public function solicitud_servicioSocial(){
     $usuario_actual=auth()->user();
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
     $validar = DB::table('estudiantes')
        ->select('estudiantes.semestre', 'estudiantes.estatus')
        ->where('estudiantes.matricula',$id)
        ->take(1)
        ->first();
        $periodo_semestre = DB::table('periodos')
        ->select('periodos.id_periodo')
        ->where('periodos.estatus', '=', 'actual')
        ->take(1)
        ->first();

        $practicas_dependencia = DB::table('practicas')
        ->select('practicas.id_practicas')
        ->where([['practicas.matricula',$id], ['practicas.tipo', '=', 'PRACTICAS']])
        ->take(1)
        ->first();
      
       if(empty($practicas_dependencia->id_practicas)){
         $estado_p= 'nada';
       }
      else {
     $datos_di = DB::table('practicas_profesionales')
     ->select('practicas_profesionales.estatus_practica')
     ->where('practicas_profesionales.id_practicas',$practicas_dependencia->id_practicas)
     ->take(1)
     ->first();
	 $estado_p= $datos_di->estatus_practica;
       }
	   $servicio_dependencia = DB::table('practicas')
        ->select('practicas.id_practicas')
        ->where([['practicas.matricula',$id], ['practicas.tipo', '=', 'SERVICIO']])
        ->take(1)
        ->first();
		if(empty($servicio_dependencia->id_practicas)){
         $estado_s= 'nada';
       }
       else {
     $datos_dis = DB::table('servicio_sociales')
     ->select('servicio_sociales.estatus_servicio')
     ->where('servicio_sociales.id_practicas',$servicio_dependencia->id_practicas)
     ->take(1)
     ->first();
	 if(empty($datos_dis)){
		 $estado_s="nada";
	 }
	 else{
		  $estado_s= $datos_dis->estatus_servicio;
	   }}
	       
		   if($estado_s == 'Finalizado' ){
			   return redirect()->route('home_estudiante')->with('success','Has concluido Satisfactoriamente tus Prácticas Profesionales Y Servicio Social, no es necesario que actualices datos');
		   }else{
        if((($validar->semestre) >= 7) && ($estado_p == 'Finalizado') ){
     $id_persona = DB::table('estudiantes')
     ->select('estudiantes.id_persona')
     ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
     ->where('estudiantes.matricula',$id)
     ->take(1)
     ->first();
       //$id_persona= json_decode( json_encode($id_persona), true);

       $users = DB::table('estudiantes')
       ->select('estudiantes.matricula', 'estudiantes.semestre', 'estudiantes.fecha_ingreso', 'estudiantes.modalidad', 'estudiantes.estatus', 'estudiantes.grupo',
                'personas.nombre', 'personas.id_persona', 'personas.edad', 'personas.apellido_paterno', 'personas.apellido_materno', 'personas.fecha_nacimiento',
                'personas.curp', 'personas.genero')
       ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
       ->where('estudiantes.matricula',$id)
       ->take(1)
       ->first();

       $now = new \DateTime();

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
         ->where([['personas.id_persona',$users->id_persona], ['telefonos.tipo', '=', 'celular']])
         ->take(1)
         ->first();

         $valor_direccion = DB::table('direcciones')->max('id_direccion');

         $practicas_dependencia = DB::table('practicas')
         ->select('practicas.id_practicas', 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
         'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
         ->join('personas', 'personas.id_persona', '=', 'practicas.titular')
         ->where([['practicas.matricula',$id], ['practicas.tipo', '=', 'SERVICIO']])
         ->take(1)
         ->first();

        if(empty($practicas_dependencia->id_practicas)){
          $datos_di=null;
        }
        else {
      $datos_di = DB::table('servicio_sociales')
      ->select('servicio_sociales.id_practicas', 'servicio_sociales.procentaje_avance', 'servicio_sociales.estatus_servicio')
      ->where('servicio_sociales.id_practicas',$practicas_dependencia->id_practicas)
      ->take(1)
      ->first();
        }

        $escuela_r = DB::table('carreras')
        ->select('carreras.carrera')
        ->take(1)
        ->first();


   return view('estudiante/servicios.solicitud_serviciosocial')
   ->with('u',$users)->with('d', $direccion)->with('cel', $num_cel)
   ->with('valor_d', $valor_direccion)->with('datos_practicas', $datos_di)
   ->with('carreras', $escuela_r)->with('dependencia_p', $practicas_dependencia);
 }
   else {
     return redirect()->route('home_estudiante')->with('error','No cumples con los requisitos para llenar los datos de SERVICIO SOCIAL');
   }
		   }
   }

   /*TUTORIAS*/
   


 /*SEGUIMIENTO A EGRESADOS
     public function generales_egresado()
     {
     return view('estudiante\seguimiento_egresados.generales_egresado');
     }

     public function cuestionario_egresado()
     {
     return view('estudiante\seguimiento_egresados.cuestionario_egresado');
     }

     public function antecedentes_laborales()
     {
       return view('estudiante\seguimiento_egresados.antecedentes_laborales');
     }
*/
     public function lineamientos()
     {
       return view('estudiante.lineamientos');
     }

     public function equipamientosalon()
     {
       return view('estudiante/lineamientos.equipamiento-salon');
     }

public function enviar_solicitud_practicas(Request $request){
     $data= $request;
     $usuario_actual=auth()->user();
     $id=$usuario_actual->id_user;

     $periodo_semestre = DB::table('periodos')
     ->select('periodos.id_periodo')
     ->where('periodos.estatus', '=', 'actual')
     ->take(1)
     ->first();

     $id_persona = DB::table('estudiantes')
     ->select('estudiantes.id_persona', 'estudiantes.modalidad')
     ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
     ->where('estudiantes.matricula',$id)
     ->take(1)
     ->first();
     $validar = DB::table('estudiantes')
        ->select('estudiantes.semestre', 'estudiantes.estatus', 'estudiantes.modalidad')
        ->where('estudiantes.matricula',$id)
        ->take(1)
        ->first();

     $existe_solicitud = DB::table('practicas')
                         ->select('practicas.matricula')
                         ->where([['practicas.matricula', $id], ['practicas.tipo', '=','PRACTICAS']])
                         ->take(1)
                         ->first();
     if(empty($existe_solicitud->matricula)){
        $codigo=CodigoPostal::find($data['codigo_postal']);
       if(!empty($codigo->cp)){

         if(($validar->modalidad) == 'SEMI ESCOLARIZADA'){
          $modalidad = 'MIXTA';
         }

         if(($validar->modalidad) == 'ESCOLARIZADA'){
          $modalidad = 'ESCOLARIZADA';
         }
         if(($validar->modalidad) == 'SEMIESCOLARIZADA'){
          $modalidad = 'MIXTA';
         }

       $nombre_carreras = DB::table('carreras')
       ->select('carreras.clave_carrera')
       ->where('carreras.modalidad', '=', $modalidad)
       ->take(1)
       ->first();

       $codigo_de = DB::table('codigos_postales')->select('codigos_postales.municipio')
                             ->where('codigos_postales.cp', $data['codigo_postal'])
                             ->take(1)
                             ->first();
        
        $now = new \DateTime();
		  
       $cla_per= $id."120819"."065203";
	   $usuario_busqueda=Persona::find($cla_per);
	   if(empty($usuario_busqueda)){
       $persona= new Persona;
       $persona->id_persona=$cla_per;
       $persona->nombre= $data['nombre_titular'];
       $persona->apellido_paterno= $data['apellido_paterno_titular'];
       $persona->apellido_materno=$data['apellido_materno_titular'];
       $persona->save();}
	   
      $id_direccion_pr= $id."130819".$nombre_carreras->clave_carrera."065210";
	  	   $usuario_direc=Direccion::find($id_direccion_pr);
	   if(empty($usuario_direc)){
      $direccion_p = new Direccion;
      $direccion_p->id_direccion=$id_direccion_pr;
      $direccion_p->vialidad_principal=$data['calle_p'];
      $direccion_p->num_exterior=$data['numero_p'];
      $direccion_p->cp=$data['codigo_postal'];
      $direccion_p->localidad=$data['colonia_p'];
      $direccion_p->municipio=$codigo_de->municipio;
      $direccion_p->save();
	   }

       $practicas = new Practica;
       $practicas->matricula=$id;
       $practicas->clave_carrera=$nombre_carreras->clave_carrera;
       $practicas->id_departamento=3;
       $practicas->nombre_dependencia= $data['institucion'];
       $practicas->titular=$cla_per;
       $practicas->cargo_titular=$data['cargo_responsable'];
       $practicas->fecha=$now;
       $practicas->periodo=$periodo_semestre->id_periodo;
       $practicas->tipo='PRACTICAS';
       $practicas->save();

       $profesionales = new PracticaProfesional;
       $profesionales->id_practicas=$practicas->id_practicas;
       $profesionales->id_direccion=$id_direccion_pr;
       $profesionales->estatus_practica='Pendiente';
       $profesionales->periodo_practicas=$data['duracion'];
       $profesionales->save();

       DB::table('telefonos')
           ->Insert(
               ['numero' => $data['telefono'], 'tipo' => 'practicas', 'id_persona' => $id_persona->id_persona]);

               DB::table('estudiantes')
                   ->where('estudiantes.matricula', $id)
                   ->update(['egresado' => $data['egresado'], 'fecha_ingreso' => $data['fecha_ingreso']]);
 return redirect()->route('solicitud_practicasP')->with('success','¡Solicitud Enviada Correctamente, Pasar a la Coordinación de Prácticas y Servicio Social por tu Carta de presentación!');
}else {
  return redirect()->back()->withInput(Input::all())->with('error','¡El código postal que ingreso no existe!');
}
   }   else {

     $codigo_de = DB::table('codigos_postales')->select('codigos_postales.municipio', 'codigos_postales.estado')
                           ->where('codigos_postales.cp', $data['codigo_postal'])
                           ->take(1)
                           ->first();
     $practicas_dependencia = DB::table('practicas')
     ->select('practicas.id_practicas', 'practicas.titular')
     ->take(1)
     ->where([['practicas.matricula',$id], ['practicas.tipo', '=', 'PRACTICAS'] ])
     ->first();

     $practicas_pro = DB::table('practicas_profesionales')
     ->select('practicas_profesionales.id_direccion')
     ->where('practicas_profesionales.id_practicas',$practicas_dependencia->id_practicas)
     ->take(1)
     ->first();

     $tel_cel = DB::table('personas')
      ->select('telefonos.numero')
      ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
      ->where([['telefonos.id_persona',$id_persona->id_persona], ['telefonos.tipo', '=', 'practicas']])
      ->first();
      if (empty($tel_cel)) {
        DB::table('telefonos')
            ->Insert(
                ['numero' => $data['telefono'], 'tipo' => 'practicas', 'id_persona' => $id_persona->id_persona]);
      }
      else {
        DB::table('telefonos')
            ->where([['telefonos.id_persona',$id_persona->id_persona], ['telefonos.tipo', '=', 'practicas']])
            ->update(
              ['numero' => $data['telefono']]);
      }

     DB::table('practicas')
         ->where([['practicas.id_practicas',$practicas_dependencia->id_practicas], ['practicas.matricula',$id]])
         ->update(['nombre_dependencia' => $data['institucion'], 'cargo_titular' => $data['cargo_responsable']]);
     DB::table('personas')
         ->where('personas.id_persona', $practicas_dependencia->titular)
         ->update(['nombre' => $data['nombre_titular'], 'apellido_paterno' => $data['apellido_paterno_titular'] ,
         'apellido_materno' => $data['apellido_materno_titular']]);

           $codigo=CodigoPostal::find($data['codigo_postal']);
           if(!empty($codigo->cp)){
             $now = new \DateTime();
             DB::table('direcciones')
                 ->where('direcciones.id_direccion', $practicas_pro->id_direccion)
                 ->update(
                   ['vialidad_principal' => $data['calle_p'], 'num_exterior' => $data['numero_p'],
                    'localidad' =>  $data['colonia_p'],  'municipio' => $codigo_de->municipio,
                         'entidad_federativa' =>$codigo_de->estado, 'cp' => $data['codigo_postal'], 'updated_at' => $now]);
           }else {
               return redirect()->back()->withInput(Input::all())->with('error','¡El código postal que ingreso no existe!');
           }

           DB::table('practicas_profesionales')
               ->where('practicas_profesionales.id_practicas',$practicas_dependencia->id_practicas)
               ->update(['periodo_practicas' => $data['duracion']]);
               DB::table('estudiantes')
                   ->where('estudiantes.matricula', $id)
                   ->update(['egresado' => $data['egresado'], 'fecha_ingreso' => $data['fecha_ingreso']]);

         return redirect()->route('solicitud_practicasP')->with('success','¡La solicitud se ha actualizado correctamente!');

    }

    }


public function enviar_solicitud_servicio(Request $request){
     $data= $request;
     $usuario_actual=auth()->user();
     $id=$usuario_actual->id_user;

     $periodo_semestre = DB::table('periodos')
     ->select('periodos.id_periodo')
     ->where('periodos.estatus', '=', 'actual')
     ->take(1)
     ->first();

     $id_persona = DB::table('estudiantes')
     ->select('estudiantes.id_persona', 'estudiantes.modalidad')
     ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
     ->where('estudiantes.matricula',$id)
     ->take(1)
     ->first();
     $validar = DB::table('estudiantes')
        ->select('estudiantes.semestre', 'estudiantes.estatus', 'estudiantes.modalidad')
        ->where('estudiantes.matricula',$id)
        ->take(1)
        ->first();

     $existe_solicitud = DB::table('practicas')
                         ->select('practicas.matricula')
                         ->where([['practicas.matricula', $id], ['practicas.tipo', '=','SERVICIO']])
                         ->take(1)
                         ->first();
     if(empty($existe_solicitud->matricula)){
       if(($validar->modalidad) == 'SEMI ESCOLARIZADA'){
        $modalidad = 'MIXTA';
       }

       if(($validar->modalidad) == 'ESCOLARIZADA'){
        $modalidad = 'ESCOLARIZADA';
       }
       if(($validar->modalidad) == 'SEMIESCOLARIZADA'){
        $modalidad = 'MIXTA';
       }

       $nombre_carreras = DB::table('carreras')
       ->select('carreras.clave_carrera')
       ->where('carreras.modalidad', '=', $modalidad)
       ->take(1)
       ->first();

       $cla_per= $id."120819"."065203".$id;
	   
	   $usuario_busqueda=Persona::find($cla_per);
       if(empty($usuario_busqueda)){
	   $persona= new Persona;
       $persona->id_persona=$cla_per;
       $persona->nombre= $data['nombre_titular'];
       $persona->apellido_paterno= $data['apellido_paterno_titular'];
       $persona->apellido_materno=$data['apellido_materno_titular'];
       $persona->save();
	   }
	  
          $now = new \DateTime();

       $practicas = new Practica;
       $practicas->matricula=$id;
       $practicas->clave_carrera=$nombre_carreras->clave_carrera;
       $practicas->id_departamento=3;
       $practicas->nombre_dependencia= $data['institucion'];
       $practicas->titular=$cla_per;
       $practicas->cargo_titular=$data['cargo_responsable'];
       $practicas->fecha=$now;
       $practicas->periodo=$periodo_semestre->id_periodo;
       $practicas->tipo='SERVICIO';
       $practicas->save();

       $profesionales = new ServicioSocial;
       $profesionales->id_practicas=$practicas->id_practicas;
       $profesionales->estatus_servicio='Cursando';
       $profesionales->procentaje_avance=$data['avance'];
       $profesionales->save();

    return redirect()->back()->with('success','¡Datos cargados Correctamente!');
   }
   else {
     $practicas_dependencia = DB::table('practicas')
     ->select('practicas.id_practicas', 'practicas.titular')
     ->where([['practicas.matricula',$id], ['practicas.tipo', '=', 'SERVICIO']])
     ->take(1)
     ->first();

$practicas_serv = DB::table('servicio_sociales')
     ->select('servicio_sociales.id_practicas')
     ->where('servicio_sociales.id_practicas', '=', $practicas_dependencia->id_practicas)
     ->take(1)
     ->first();
	 if(empty($practicas_serv->id_practicas)){
	  $profesionales = new ServicioSocial;
       $profesionales->id_practicas=$practicas_dependencia->id_practicas;
       $profesionales->estatus_servicio='Cursando';
       $profesionales->procentaje_avance=$data['avance'];
	 $profesionales->save();}

     DB::table('practicas')
         ->where([['practicas.id_practicas',$practicas_dependencia->id_practicas], ['practicas.matricula',$id]])
         ->update(['nombre_dependencia' => $data['institucion'], 'cargo_titular' => $data['cargo_responsable']]);

     DB::table('personas')
         ->where('personas.id_persona', $practicas_dependencia->titular)
         ->update(['nombre' => $data['nombre_titular'], 'apellido_paterno' => $data['apellido_paterno_titular'] ,
         'apellido_materno' => $data['apellido_materno_titular']]);


           DB::table('servicio_sociales')
               ->where('servicio_sociales.id_practicas',$practicas_dependencia->id_practicas)
               ->update(['procentaje_avance' => $data['avance']]);

         return redirect()->route('solicitud_servicioSocial')->with('success','¡Datos actualizados correctamente!');
   }
}

 public function download($file_name) 
 { 
 $file_path =  public_path('/lineamientos_es/'.$file_name); 
 return response()->download($file_path); 
 }
 
 public function aceptacion(Request $request){
    $usuario_actual=auth()->user();
	$id=$usuario_actual->id_user;
	 $data = $request;
	 DB::table('users')
               ->where('users.id_user',$id)
               ->update(['check_lineamiento' => $data['lineamiento_aceptado']]);
	 return redirect()->route('home_estudiante')->with('success','¡Gracias por Aceptar los lineamientos!');
 }
 
 
 public function tutorias(){
  $usuario_actuales=\Auth::user();
   if($usuario_actuales->tipo_usuario!='estudiante'){
     return redirect()->back();
    }
    $usuario_actual=auth()->user();
    $id=$usuario_actual->id_user;

 $fecha_inicio = DB::table('periodo_actualizacion')
        ->select('periodo_actualizacion.estado')
        ->where([['periodo_actualizacion.tipo', '=', 'encuesta'], ['periodo_actualizacion.estado', '=', 'Activo']])
        ->take(1)
        ->first();
        if(empty($fecha_inicio->estado)){
          return redirect()->route('home_estudiante')->with('error', 'El nuevo periodo para contestar la encuesta aún no empieza');
        }
        else {
  $periodo_semestre = DB::table('periodos')
  ->select('periodos.id_periodo')
  ->where('periodos.estatus', '=', 'actual')
  ->take(1)
  ->first();

  $buscar_encuesta = DB::table('tutorias')
                     ->select('tutorias.matricula')
                     ->where([['tutorias.matricula', $id], ['tutorias.periodo', $periodo_semestre->id_periodo]])
                     ->take(1)
                     ->first();
    if(empty($buscar_encuesta)){
      return view('estudiante.tutorias');
    }
    else {
      return redirect()->route('home_estudiante')->with('error','¡Ya has contestado la encuesta, el próximo semestre podrás contestarla de nuevo!');
    }
		}
}


public function encuesta_tuto(Request $request){
  $data= $request;
  $usuario_actual=auth()->user();
  $id=$usuario_actual->id_user;

$periodo_semestre = DB::table('periodos')
->select('periodos.id_periodo')
->where('periodos.estatus', '=', 'actual')
->take(1)
->first();

if(empty($data['tutor'])){
  $tutor_c= 0;
}
else {
  $tutor_c= 1;
}
  DB::table('tutorias')
      ->Insert(
          ['matricula' => $id, 'periodo' => $periodo_semestre->id_periodo, 'acompaniamiento_tutor' =>$tutor_c,
           'desempenio_tutor' => $data['desempenio'], 'area_academico' => $data['area_academico'], 'area_emocional' => $data['area_emocional'],
           'area_salud' => $data['area_salud'], 'area_valores' => $data['area_valores'], 'area_relaciones' => $data['area_relaciones']]);

           return redirect()->route('home_estudiante')->with('success','¡Gracias por tomarte el tiempo para contestar la encuesta, tú opinión es muy importante!');
}

}
