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
use App\Practica;
use App\Folio;
use App\PracticaProfesional;
use App\ServicioSocial;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ServiciosController extends Controller
{
public function home_servicios(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='3'){
     return redirect()->back();
    //  return redirect('perfiles')->with('error','Acceso Denegado');
    }
return view('personal_administrativo/servicios.home_servicios');
}
public function solicitudes_practicas(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='3'){
     return redirect()->back();
    }
    $usuario_actual=auth()->user();
    $id=$usuario_actual->id_user;
    $practicas = DB::table('practicas')
                        ->select('practicas.id_practicas', 'practicas.matricula', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
                                 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
                                 'practicas_profesionales.estatus_practica', 'practicas_profesionales.periodo_practicas')
                        ->join('practicas_profesionales', 'practicas_profesionales.id_practicas', '=', 'practicas.id_practicas')
                        ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
                        ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
                        ->where([['practicas.tipo', '=','PRACTICAS'], ['practicas_profesionales.estatus_practica', '=','Pendiente']])
						->orderBy('practicas.created_at', 'desc')
                        ->simplePaginate(10);

return view('personal_administrativo/servicios/practicasp.solicitudes_practicas')->with('practicas', $practicas);
}
  public function busqueda_solicitudes_pr(Request $request){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='3'){
       return redirect()->back();
      }
    $q = $request->get('q');
    if($q != null){
    $user = Practica::select('practicas.id_practicas', 'practicas.matricula', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
                                 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
                                 'practicas_profesionales.estatus_practica', 'practicas_profesionales.periodo_practicas')
                        ->join('practicas_profesionales', 'practicas_profesionales.id_practicas', '=', 'practicas.id_practicas')
                        ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
                        ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
						 ->where( 'estudiantes.matricula', 'LIKE', '%' . $q . '%' )
                        ->where([['practicas.tipo', '=','PRACTICAS'], ['practicas_profesionales.estatus_practica', '=','Pendiente']])
						->orderBy('practicas.created_at', 'asc')
                        ->simplePaginate(10);
                        $est = DB::table('users')
                        ->where('users.bandera', '=', '1')
                        ->get();
  if ((count ($user) > 0 ) && ($est != null )){
$practicas = DB::table('practicas')
                        ->select('practicas.id_practicas', 'practicas.matricula', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
                                 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
                                 'practicas_profesionales.estatus_practica', 'practicas_profesionales.periodo_practicas')
                        ->join('practicas_profesionales', 'practicas_profesionales.id_practicas', '=', 'practicas.id_practicas')
                        ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
                        ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
                        ->where([['practicas.tipo', '=','PRACTICAS'], ['practicas_profesionales.estatus_practica', '=','Pendiente']])
						->orderBy('practicas.created_at', 'asc')
                        ->simplePaginate(10);

return view('personal_administrativo/servicios/practicasp.solicitudes_practicas')
->withDetails ($user )
->withQuery ($q)
->with('estudiante', $est)->with('practicas', $practicas);

}
else{
return redirect()->route('solicitudes_practicas')->with('error','¡Sin resultados!');
}}  else{
    return redirect()->route('solicitudes_practicas')->with('error','¡Sin resultados!');
  }}

public function solicitudes_cancelados(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='3'){
     return redirect()->back();
    }
    $usuario_actual=auth()->user();
    $id=$usuario_actual->id_user;
    $practicas = DB::table('practicas')
                        ->select('practicas.id_practicas', 'practicas.matricula', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
                                 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
                                 'practicas_profesionales.estatus_practica', 'practicas_profesionales.periodo_practicas')
                        ->join('practicas_profesionales', 'practicas_profesionales.id_practicas', '=', 'practicas.id_practicas')
                        ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
                        ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
                        ->where([['practicas.tipo', '=','PRACTICAS'], ['practicas_profesionales.estatus_practica', '=','Cancelado']])
                        ->simplePaginate(7);

return view('personal_administrativo/servicios/practicasp.cancelados')->with('practicas', $practicas);
}
public function aprobar_pr($id_practicas){
$id_practica= $id_practicas;

DB::table('practicas_profesionales')
    ->where('practicas_profesionales.id_practicas', $id_practica)
    ->update(
        ['estatus_practica' => 'Cursando']);

  return redirect()->route('estudiantes_activosPP')->with('success','Aprobado Correctamente');

      }




      public function aprobar_se($id_practicas){
      $id_practica= $id_practicas;

      DB::table('servicio_sociales')
          ->where('servicio_sociales.id_practicas', $id_practica)
          ->update(
              ['estatus_servicio' => 'Finalizado']);

        return redirect()->route('expedientes_servicio_social')->with('success','Aprobado Correctamente');

            }

            public function cancelar_se($id_practicas){
            $id_practica= $id_practicas;

            DB::table('practicas_profesionales')
                ->where('practicas_profesionales.id_practicas', $id_practica)
                ->update(
                    ['estatus_practica' => 'Pendiente']);

              return redirect()->route('solicitudes_practicas')->with('success','Cancelado Correctamente, Puede editar nuevamente la Solicitud');

                  }

public function solicitudes_serviciosocial(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='3'){
     return redirect()->back();
    //  return redirect('perfiles')->with('error','Acceso Denegado');
    }

    $sociales = DB::table('practicas')
                        ->select('practicas.matricula', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
                                 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha', 'servicio_sociales.estatus_servicio')
                        ->join('servicio_sociales', 'servicio_sociales.id_practicas', '=', 'practicas.id_practicas')
                        ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
                        ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
                        ->where([['practicas.tipo', '=','SERVICIO'], ['servicio_sociales.estatus_servicio', '=','Finalizado']])
                        ->simplePaginate(7);
return view('personal_administrativo/servicios/servicios.solicitudes_serviciosocial')->with('sociales', $sociales);
}

  public function busqueda_expedientes_ss(Request $request){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='3'){
       return redirect()->back();
      }
    $q = $request->get('q');
    if($q != null){
    $user = Practica::select('practicas.matricula', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
                                 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha', 'servicio_sociales.estatus_servicio')
                        ->join('servicio_sociales', 'servicio_sociales.id_practicas', '=', 'practicas.id_practicas')
                        ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
                        ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
						->where( 'estudiantes.matricula', 'LIKE', '%' . $q . '%' )
                        ->where([['practicas.tipo', '=','SERVICIO'], ['servicio_sociales.estatus_servicio', '=','Finalizado']])
						->orderBy('personas.nombre', 'asc')
                        ->simplePaginate(10);
                        $est = DB::table('users')
                        ->where('users.bandera', '=', '1')
                        ->get();
  if ((count ($user) > 0 ) && ($est != null )){
  $sociales = DB::table('practicas')
                        ->select('practicas.matricula', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
                                 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha', 'servicio_sociales.estatus_servicio')
                        ->join('servicio_sociales', 'servicio_sociales.id_practicas', '=', 'practicas.id_practicas')
                        ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
                        ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
                        ->where([['practicas.tipo', '=','SERVICIO'], ['servicio_sociales.estatus_servicio', '=','Finalizado']])
						 ->orderBy('personas.nombre', 'asc')
                        ->simplePaginate(7);

return view('personal_administrativo/servicios/servicios.solicitudes_serviciosocial')
->withDetails ($user )
->withQuery ($q)
->with('estudiante', $est)->with('sociales', $sociales);

}
else{
return redirect()->route('expedientes_servicio_social')->with('error','¡Sin resultados!');
}}  else{
    return redirect()->route('expedientes_servicio_social')->with('error','¡Sin resultados!');
  }}


public function estudiantes_activosPP(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='3'){
     return redirect()->back();
        }

  $practicas = DB::table('practicas')
  ->select('practicas.id_practicas', 'practicas.matricula', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
           'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
           'practicas_profesionales.estatus_practica', 'practicas_profesionales.periodo_practicas')
  ->join('practicas_profesionales', 'practicas_profesionales.id_practicas', '=', 'practicas.id_practicas')
  ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
  ->where([['practicas.tipo', '=','PRACTICAS'], ['practicas_profesionales.estatus_practica', '=','Cursando']])
  ->orderBy('personas.nombre', 'asc')
  ->simplePaginate(10);

return view('personal_administrativo/servicios/practicasp.estudiantes_activospp')->with('practicas', $practicas);
}

  public function busqueda_activos_pr(Request $request){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='3'){
       return redirect()->back();
      }
    $q = $request->get('q');
    if($q != null){
    $user = Practica::select('practicas.id_practicas', 'practicas.matricula', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
           'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
           'practicas_profesionales.estatus_practica', 'practicas_profesionales.periodo_practicas')
  ->join('practicas_profesionales', 'practicas_profesionales.id_practicas', '=', 'practicas.id_practicas')
  ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
   ->where( 'estudiantes.matricula', 'LIKE', '%' . $q . '%' )
  ->where([['practicas.tipo', '=','PRACTICAS'], ['practicas_profesionales.estatus_practica', '=','Cursando']])
  ->orderBy('personas.nombre', 'asc')
                        ->simplePaginate(10);
                        $est = DB::table('users')
                        ->where('users.bandera', '=', '1')
                        ->get();
  if ((count ($user) > 0 ) && ($est != null )){
$practicas = DB::table('practicas')
  ->select('practicas.id_practicas', 'practicas.matricula', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
           'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
           'practicas_profesionales.estatus_practica', 'practicas_profesionales.periodo_practicas')
  ->join('practicas_profesionales', 'practicas_profesionales.id_practicas', '=', 'practicas.id_practicas')
  ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
  ->where([['practicas.tipo', '=','PRACTICAS'], ['practicas_profesionales.estatus_practica', '=','Cursando']])
  ->orderBy('personas.nombre', 'asc')
   ->simplePaginate(10);

return view('personal_administrativo/servicios/practicasp.estudiantes_activospp')
->withDetails ($user )
->withQuery ($q)
->with('estudiante', $est)->with('practicas', $practicas);

}
else{
return redirect()->route('estudiantes_activosPP')->with('error','¡Sin resultados!');
}}  else{
    return redirect()->route('estudiantes_activosPP')->with('error','¡Sin resultados!');
  }}

public function estudiantes_activosSS(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='3'){
     return redirect()->back();
    //  return redirect('perfiles')->with('error','Acceso Denegado');
    }

    $sociales = DB::table('practicas')
                        ->select('practicas.matricula', 'practicas.id_practicas', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
                                 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
								 'servicio_sociales.estatus_servicio')
                        ->join('servicio_sociales', 'servicio_sociales.id_practicas', '=', 'practicas.id_practicas')
                        ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
                        ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
                        ->where([['practicas.tipo', '=','SERVICIO'], ['servicio_sociales.estatus_servicio', '=','Cursando']])
						 ->orderBy('personas.nombre', 'asc')
                        ->simplePaginate(10);
return view('personal_administrativo/servicios/servicios.estudiantes_activosss')->with('sociales', $sociales);
}

  public function busqueda_activos_ss(Request $request){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='3'){
       return redirect()->back();
      }
    $q = $request->get('q');
    if($q != null){
    $user = Practica::select('practicas.matricula', 'practicas.id_practicas', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
                                 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha', 'servicio_sociales.estatus_servicio')
                        ->join('servicio_sociales', 'servicio_sociales.id_practicas', '=', 'practicas.id_practicas')
                        ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
                        ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
						 ->where( 'estudiantes.matricula', 'LIKE', '%' . $q . '%' )
                        ->where([['practicas.tipo', '=','SERVICIO'], ['servicio_sociales.estatus_servicio', '=','Cursando']])
					    ->orderBy('personas.nombre', 'asc')
                        ->simplePaginate(10);
                        $est = DB::table('users')
                        ->where('users.bandera', '=', '1')
                        ->get();
  if ((count ($user) > 0 ) && ($est != null )){
$sociales = DB::table('practicas')
                        ->select('practicas.matricula', 'practicas.id_practicas', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
                                 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha', 'servicio_sociales.estatus_servicio')
                        ->join('servicio_sociales', 'servicio_sociales.id_practicas', '=', 'practicas.id_practicas')
                        ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
                        ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
                        ->where([['practicas.tipo', '=','SERVICIO'], ['servicio_sociales.estatus_servicio', '=','Cursando']])
						 ->orderBy('personas.nombre', 'asc')
                        ->simplePaginate(10);

return view('personal_administrativo/servicios/servicios.estudiantes_activosss')
->withDetails ($user )
->withQuery ($q)
->with('estudiante', $est)->with('sociales', $sociales);

}
else{
return redirect()->route('estudiantes_activos_ss')->with('error','¡Sin resultados!');
}}  else{
    return redirect()->route('estudiantes_activos_ss')->with('error','¡Sin resultados!');
  }}



public function egresado_registrado(){

        $usuario_actuales=\Auth::user();
         if($usuario_actuales->tipo_usuario!='3'){
           return redirect()->back();
          }
        $usuario_actual=auth()->user();
        $id=$usuario_actual->id_user;

        $est = DB::table('estudiantes')
        ->select('estudiantes.matricula', 'estudiantes.semestre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno',  'personas.genero', 'users.id_user', 'users.bandera')
        ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
        ->join('users', 'users.id_persona', '=', 'personas.id_persona')
        ->where([['estudiantes.egresado', '=', '1']])
         ->orderBy('estudiantes.matricula', 'asc')
        ->simplePaginate(4);
return view('personal_administrativo/servicios/seguimientoe.egresado_registrado')->with('estudiante', $est);
}

public function antecedentes_laborales_egresado(){
return view('personal_administrativo/servicios/seguimientoe.antecedentes_laborales_egresado');
}

public function cuestionario_egresado_ver(){
return view('personal_administrativo/servicios/seguimientoe.cuestionario_egresado_ver');
}

public function generales_egresado_ver($matricula){

  $usuario_actuales=\Auth::user();
   if($usuario_actuales->tipo_usuario!='3'){
     return redirect()->back();
    }
  $usuario_actual=auth()->user();

  $id=$matricula;
  $users = DB::table('estudiantes')
  ->select('estudiantes.matricula', 'estudiantes.bachillerato_origen', 'estudiantes.semestre', 'estudiantes.modalidad', 'estudiantes.estatus', 'estudiantes.grupo',
           'personas.nombre', 'personas.apellido_paterno', 'personas.edad',  'personas.apellido_materno', 'personas.fecha_nacimiento',
           'personas.curp', 'personas.genero')
  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
  ->where('estudiantes.matricula',$id)
  ->take(1)
  ->first();

  $correo =  DB::table('users')
  ->select('users.email')
  ->where('users.id_user',$id)
  ->take(1)
  ->first();

  $id_persona = DB::table('estudiantes')
  ->select('estudiantes.id_persona')
  ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
  ->where('estudiantes.matricula',$id)
  ->take(1)
  ->first();
    $id_persona= json_decode( json_encode($id_persona), true);
    $lenguas_r = DB::table('personas')
    ->select('lenguas.id_lengua', 'lenguas.nombre_lengua', 'lenguas.tipo')
    ->join('lenguas', 'lenguas.id_persona', '=', 'personas.id_persona')
    ->where('personas.id_persona',$id_persona)
    ->simplePaginate(7 );

    $enf_ale = DB::table('estudiantes')
    ->select('enfermedades_alergias.nombre_enfermedadalergia', 'enfermedades_alergias.tipo_enfermedadalergia',
    'enfermedades_alergias.descripcion', 'enfermedades_alergias.indicaciones')
    ->join('enfermedades_alergias', 'estudiantes.matricula', '=', 'enfermedades_alergias.matricula')
    //->where('estudiantes.matricula',$id)
    ->where([['estudiantes.matricula',$id], ['enfermedades_alergias.bandera', '=', '1'],])
    ->simplePaginate(7);

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

$num_emergencia = DB::table('personas')
->select('telefonos.numero')
->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
->where([['personas.id_persona',$id_persona], ['telefonos.tipo', '=', 'emergencia']])
->take(1)
->first();

$datos_pro = DB::table('egresados')
->select('egresados.generacion', 'egresados.promedio_final')
->where('egresados.matricula', $id)
->take(1)
->first();

$id_clave = DB::table('escuelas')
->select('escuelas.nombre_escuela')
->take(1)
->first();

return view('personal_administrativo/servicios/seguimientoe.generales_egresado_ver')
->with('u', $users)->with('l', $lenguas_r)->with('ea', $enf_ale)->with('nl',$num_local)
->with('nc',$num_cel)->with('ne',$num_emergencia)->with('email', $correo)->with('pro', $datos_pro)->with('escuela', $id_clave);

}


public function estudiantes_expedientes(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='3'){
     return redirect()->back();
        }

  $practicas = DB::table('practicas')
  ->select('practicas.id_practicas', 'practicas.matricula', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
           'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
           'practicas_profesionales.estatus_practica', 'practicas_profesionales.periodo_practicas')
  ->join('practicas_profesionales', 'practicas_profesionales.id_practicas', '=', 'practicas.id_practicas')
  ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
  ->where([['practicas.tipo', '=','PRACTICAS'], ['practicas_profesionales.estatus_practica', '=','Finalizado']])
   ->orderBy('personas.nombre', 'asc')
  ->simplePaginate(7);

return view('personal_administrativo/servicios/practicasp.expedientes')->with('practicas', $practicas);
}
  public function busqueda_expedientes_pr(Request $request){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='3'){
       return redirect()->back();
      }
    $q = $request->get('q');
    if($q != null){
    $user = Practica::select('practicas.id_practicas', 'practicas.matricula', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
           'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
           'practicas_profesionales.estatus_practica', 'practicas_profesionales.periodo_practicas')
  ->join('practicas_profesionales', 'practicas_profesionales.id_practicas', '=', 'practicas.id_practicas')
  ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
   ->where( 'estudiantes.matricula', 'LIKE', '%' . $q . '%' )
  ->where([['practicas.tipo', '=','PRACTICAS'], ['practicas_profesionales.estatus_practica', '=','Finalizado']])
  ->orderBy('personas.nombre', 'asc')
  ->simplePaginate(10);

                        $est = DB::table('users')
                        ->where('users.bandera', '=', '1')
                        ->get();
  if ((count ($user) > 0 ) && ($est != null )){
 $practicas = DB::table('practicas')
  ->select('practicas.id_practicas', 'practicas.matricula', 'personas.nombre', 'personas.apellido_paterno',  'personas.apellido_materno',
           'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
           'practicas_profesionales.estatus_practica', 'practicas_profesionales.periodo_practicas')
  ->join('practicas_profesionales', 'practicas_profesionales.id_practicas', '=', 'practicas.id_practicas')
  ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
  ->where([['practicas.tipo', '=','PRACTICAS'], ['practicas_profesionales.estatus_practica', '=','Finalizado']])
  ->simplePaginate(10);

 return view('personal_administrativo/servicios/practicasp.expedientes')
->withDetails ($user )
->withQuery ($q)
->with('estudiante', $est)->with('practicas', $practicas);

}
else{
return redirect()->route('expedientes_practicas_profesionales')->with('error','¡Sin resultados!');
}}  else{
    return redirect()->route('expedientes_practicas_profesionales')->with('error','¡Sin resultados!');
  }}



public function folio($matriculas, $actividad){
  $matricula= $matriculas;
  $id_ac =$actividad;

  $datos_correo= DB::table('users')
   ->select('users.email', 'personas.nombre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
   ->join('personas', 'users.id_persona', '=' , 'personas.id_persona')
   ->where('users.id_user', $matricula)
   ->take(1)
   ->first();

  return view('personal_administrativo/servicios.carta_pre')
  ->with('datos_estudiante', $datos_correo)
  ->with('estudiante_matricula', $matricula)
  ->with('estudiante_actividad', $id_ac);

}

public function crear_folio(Request $request){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='3'){
     return redirect()->back();
        }
        $id=$usuario_actual->id_user;
  $data = $request;
   $now = new \DateTime();

          $users = DB::table('estudiantes')
          ->select('estudiantes.matricula', 'estudiantes.semestre', 'estudiantes.modalidad', 'estudiantes.estatus', 'estudiantes.grupo', 'estudiantes.fecha_ingreso',
                   'personas.nombre', 'personas.id_persona', 'personas.edad', 'personas.apellido_paterno', 'personas.apellido_materno', 'personas.fecha_nacimiento',
                   'personas.curp', 'personas.genero')
          ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
          ->where('estudiantes.matricula',$data['matricula'])
          ->take(1)
          ->first();

          $practicas_dependencia = DB::table('practicas')
          ->select('practicas.id_practicas', 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
          'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
          ->join('personas', 'personas.id_persona', '=', 'practicas.titular')
          ->where([['practicas.matricula',$data['matricula']], ['practicas.tipo', '=', 'PRACTICAS']])
          ->take(1)
          ->first();

   $datos_di = DB::table('practicas_profesionales')
   ->select('practicas_profesionales.id_practicas','practicas_profesionales.periodo_practicas', 'direcciones.vialidad_principal',
            'direcciones.num_exterior', 'direcciones.localidad', 'direcciones.cp', 'direcciones.municipio')
   ->join('direcciones', 'direcciones.id_direccion', '=', 'practicas_profesionales.id_direccion')
   ->where([['practicas_profesionales.id_practicas', $data['id_practicas']], ['practicas_profesionales.estatus_practica', '=', 'Cursando']])
   ->take(1)
   ->first();

   $datos_coordi = DB::table('users')
   ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
   ->join('personas', 'personas.id_persona', '=', 'users.id_persona')
   ->where('users.id_user',$id)
   ->take(1)
   ->first();

$folio_n = $data['num_folio'];
if(($users->modalidad) == 'ESCOLARIZADA'){
  $horas = 100;
  $modalidad = 'ESCOLARIZADA';
}
if(($users->modalidad) == 'SEMIESCOLARIZADA'){
  $horas = 100;
  $modalidad = 'SEMIESCOLARIZADA';

}
elseif (($users->modalidad) == 'SEMI ESCOLARIZADA') {
    $horas = 80;
    $modalidad = 'SEMIESCOLARIZADA';

}

$paper_orientation = 'letter';
$customPaper = array(2.5,2.5,600,950);
$pdf = PDF::loadView('personal_administrativo/servicios.carta_presentacion_pp',  ['data' =>  $users,
'numero' => $folio_n, 'datos_de' => $practicas_dependencia, 'periodo' => $datos_di, 'hora' => $horas, 'modalidad' => $modalidad, 'datos_coordinadora' => $datos_coordi])
->setPaper($customPaper,$paper_orientation);
return $pdf->stream('carta_de_presentacion.pdf');


}

public function fecha_p( $actividad, $matriculas, $periodo){
  $matricula= $matriculas;
  $id_ac =$actividad;
  $periodo_p= $periodo;

  $datos_correo= DB::table('users')
   ->select('users.email', 'personas.nombre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
   ->join('personas', 'users.id_persona', '=' , 'personas.id_persona')
   ->where('users.id_user', $matricula)
   ->take(1)
   ->first();

      $datos_di = DB::table('practicas_profesionales')
      ->select('practicas_profesionales.fecha_inicio', 'practicas_profesionales.fecha_fin')
      ->where([['practicas_profesionales.id_practicas', $id_ac], ['practicas_profesionales.estatus_practica', '=', 'Cursando']])
      ->take(1)
      ->first();

  return view('personal_administrativo/servicios.carta_li')
  ->with('datos_estudiante', $datos_correo)
  ->with('estudiante_matricula', $matricula)
  ->with('estudiante_actividad', $id_ac)
  ->with('periodo_p', $periodo_p)->with('fechas_de', $datos_di);

}

public function crear_fecha_s( Request $request){
  $data= $request;

  DB::table('practicas_profesionales')
      ->where('practicas_profesionales.id_practicas', $data['id_practicas'])
      ->update(
          ['fecha_inicio' => $data['fecha_inicio'], 'fecha_fin' => $data['fecha_fin']]);

            return redirect()->route('estudiantes_activosPP')->with('success','Fechas Ingresadas Correctamente');
}

public function fecha_pr( $actividad, $matriculas, $periodo){
  $matricula= $matriculas;
  $id_ac =$actividad;
  $periodo_p= $periodo;

  $datos_correo= DB::table('users')
   ->select('users.email', 'personas.nombre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
   ->join('personas', 'users.id_persona', '=' , 'personas.id_persona')
   ->where('users.id_user', $matricula)
   ->take(1)
   ->first();

      $datos_di = DB::table('practicas_profesionales')
      ->select('practicas_profesionales.fecha_inicio', 'practicas_profesionales.fecha_fin')
      ->where([['practicas_profesionales.id_practicas', $id_ac], ['practicas_profesionales.estatus_practica', '=', 'Finalizado']])
      ->take(1)
      ->first();

  return view('personal_administrativo/servicios.carta_lib')
  ->with('datos_estudiante', $datos_correo)
  ->with('estudiante_matricula', $matricula)
  ->with('estudiante_actividad', $id_ac)
  ->with('periodo_p', $periodo_p)->with('fechas_de', $datos_di);

}

public function crear_fecha_es( Request $request){
  $data= $request;

  DB::table('practicas_profesionales')
      ->where('practicas_profesionales.id_practicas', $data['id_practicas'])
      ->update(
          ['fecha_inicio' => $data['fecha_inicio'], 'fecha_fin' => $data['fecha_fin']]);

            return redirect()->route('expedientes_practicas_profesionales')->with('success','Fechas Actualizadas Correctamente');
}



public function acreditar_se($id_practicas,$matriculas){
  $usuario_actual=auth()->user();
    if($usuario_actual->tipo_usuario!='3'){
      return redirect()->back(); }
        $ids=$usuario_actual->id_user;
$id_practica= $id_practicas;
$matricula = $matriculas;

$datos_di = DB::table('practicas_profesionales')
->select('practicas_profesionales.fecha_inicio','practicas_profesionales.fecha_fin')
->where([['practicas_profesionales.id_practicas',$id_practica], ['practicas_profesionales.estatus_practica', '=', 'Cursando']])
->take(1)
->first();

if(empty($datos_di->fecha_inicio)){
  return redirect()->route('estudiantes_activosPP')->with('error','Para poder generar la carta de liberación, primero debe ingresar las fechas de realización de la misma');
}

          $users = DB::table('estudiantes')
          ->select('estudiantes.matricula', 'estudiantes.semestre', 'estudiantes.modalidad', 'estudiantes.estatus', 'estudiantes.grupo', 'estudiantes.fecha_ingreso',
                   'personas.nombre', 'personas.id_persona', 'personas.edad', 'personas.apellido_paterno', 'personas.apellido_materno', 'personas.fecha_nacimiento',
                   'personas.curp', 'personas.genero')
          ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
          ->where('estudiantes.matricula', $matricula)
          ->take(1)
          ->first();

          $practicas_dependencia = DB::table('practicas')
          ->select('practicas.id_practicas', 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
          'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
          ->join('personas', 'personas.id_persona', '=', 'practicas.titular')
          ->where([['practicas.matricula',$matricula], ['practicas.tipo', '=', 'PRACTICAS']])
          ->take(1)
          ->first();

   $datos_di = DB::table('practicas_profesionales')
   ->select('practicas_profesionales.id_practicas','practicas_profesionales.periodo_practicas', 'direcciones.vialidad_principal',
            'direcciones.num_exterior', 'direcciones.localidad', 'direcciones.cp', 'direcciones.municipio',
            'practicas_profesionales.fecha_inicio', 'practicas_profesionales.fecha_fin')
   ->join('direcciones', 'direcciones.id_direccion', '=', 'practicas_profesionales.id_direccion')
   ->where([['practicas_profesionales.id_practicas', $id_practica], ['practicas_profesionales.estatus_practica', '=', 'Cursando']])
   ->take(1)
   ->first();

  DB::table('practicas_profesionales')
       ->where('practicas_profesionales.id_practicas', $id_practica)
       ->update(
           ['estatus_practica' => 'Finalizado']);

  //   return redirect()->route('expedientes_practicas_profesionales')->with('success','Acreditado Correctamente');
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
$pdf = PDF::loadView('personal_administrativo/servicios.carta_liberacion_pp',  ['data' =>  $users,
'datos_de' => $practicas_dependencia, 'periodo' => $datos_di,
 'datos_coordinadora' => $datos_coordi, 'director' => $datos_director])
->setPaper($customPaper,$paper_orientation);
return $pdf->stream('carta_de_presentacion.pdf');
      }

public function pdf_se($id_practicas,$matriculas){
  $usuario_actual=auth()->user();
    if($usuario_actual->tipo_usuario!='3'){
      return redirect()->back(); }
        $ids=$usuario_actual->id_user;
$id_practica= $id_practicas;
$matricula = $matriculas;

$datos_di = DB::table('practicas_profesionales')
->select('practicas_profesionales.fecha_inicio','practicas_profesionales.fecha_fin')
->where([['practicas_profesionales.id_practicas',$id_practica], ['practicas_profesionales.estatus_practica', '=', 'Finalizado']])
->take(1)
->first();

if(empty($datos_di->fecha_inicio)){
  return redirect()->route('estudiantes_activosPP')->with('error','Para poder generar la carta de liberación, primero debe ingresar las fechas de realización de la misma');
}

          $users = DB::table('estudiantes')
          ->select('estudiantes.matricula', 'estudiantes.semestre', 'estudiantes.modalidad', 'estudiantes.estatus', 'estudiantes.grupo', 'estudiantes.fecha_ingreso',
                   'personas.nombre', 'personas.id_persona', 'personas.edad', 'personas.apellido_paterno', 'personas.apellido_materno', 'personas.fecha_nacimiento',
                   'personas.curp', 'personas.genero')
          ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
          ->where('estudiantes.matricula', $matricula)
          ->take(1)
          ->first();

          $practicas_dependencia = DB::table('practicas')
          ->select('practicas.id_practicas', 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
          'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
          ->join('personas', 'personas.id_persona', '=', 'practicas.titular')
          ->where([['practicas.matricula',$matricula], ['practicas.tipo', '=', 'PRACTICAS']])
          ->take(1)
          ->first();

   $datos_di = DB::table('practicas_profesionales')
   ->select('practicas_profesionales.id_practicas','practicas_profesionales.periodo_practicas', 'direcciones.vialidad_principal',
            'direcciones.num_exterior', 'direcciones.localidad', 'direcciones.cp', 'direcciones.municipio',
            'practicas_profesionales.fecha_inicio', 'practicas_profesionales.fecha_fin')
   ->join('direcciones', 'direcciones.id_direccion', '=', 'practicas_profesionales.id_direccion')
   ->where([['practicas_profesionales.id_practicas', $id_practica], ['practicas_profesionales.estatus_practica', '=', 'Finalizado']])
   ->take(1)
   ->first();

  //   return redirect()->route('expedientes_practicas_profesionales')->with('success','Acreditado Correctamente');
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
$pdf = PDF::loadView('personal_administrativo/servicios.carta_liberacion_pp',  ['data' =>  $users,
'datos_de' => $practicas_dependencia, 'periodo' => $datos_di,
 'datos_coordinadora' => $datos_coordi, 'director' => $datos_director])
->setPaper($customPaper,$paper_orientation);
return $pdf->stream('carta_de_liberacion.pdf');
      }

	  public function detalles_serv($id_matricula){

		  $id= $id_matricula;

		   $users = DB::table('estudiantes')
       ->select('estudiantes.matricula', 'estudiantes.semestre', 'estudiantes.fecha_ingreso', 'estudiantes.modalidad', 'estudiantes.estatus', 'estudiantes.grupo',
                'personas.nombre', 'personas.id_persona', 'personas.edad', 'personas.apellido_paterno', 'personas.apellido_materno', 'personas.fecha_nacimiento',
                'personas.curp', 'personas.genero')
       ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
       ->where('estudiantes.matricula',$id)
       ->take(1)
       ->first();


         $num_cel = DB::table('personas')
         ->select('telefonos.numero')
         ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
         ->where([['personas.id_persona',$users->id_persona], ['telefonos.tipo', '=', 'celular']])
         ->take(1)
         ->first();

		  $practicas_dependencia = DB::table('practicas')
         ->select('practicas.id_practicas', 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
         'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
         ->join('personas', 'personas.id_persona', '=', 'practicas.titular')
         ->where([['practicas.matricula',$id], ['practicas.tipo', '=', 'SERVICIO']])
         ->take(1)
         ->first();

		  $datos_di = DB::table('servicio_sociales')
      ->select('servicio_sociales.id_practicas', 'servicio_sociales.procentaje_avance')
      ->where('servicio_sociales.id_practicas',$practicas_dependencia->id_practicas)
      ->take(1)
      ->first();
return view('personal_administrativo/servicios/servicios.detalles_ser')
   ->with('u',$users)->with('cel', $num_cel)->with('datos_practicas', $datos_di)
    ->with('dependencia_p', $practicas_dependencia);
	  }

	 public function info_practicas(){

  // PRACTICAS PROFESIONALES
// CU
//ESCOLARIZADA
$tot_P_E_M = DB::table('practicas_profesionales')
      ->join('practicas', 'practicas.id_practicas', '=' , 'practicas_profesionales.id_practicas')
	  ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
	  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->where([['practicas_profesionales.estatus_practica', '=', 'Cursando'],
	           ['practicas.tipo', '=', 'PRACTICAS'],
			   ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
               ['estudiantes.sede','=','CU'], ['personas.genero', '=', 'M']
					])
      ->count();

$tot_P_E_F = DB::table('practicas_profesionales')
      ->join('practicas', 'practicas.id_practicas', '=' , 'practicas_profesionales.id_practicas')
	  ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
	  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->where([['practicas_profesionales.estatus_practica', '=', 'Cursando'],
	           ['practicas.tipo', '=', 'PRACTICAS'],
			   ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
               ['estudiantes.sede','=','CU'], ['personas.genero', '=', 'F']
					])
      ->count();

$tot_P_E = $tot_P_E_M + $tot_P_E_F;
//SEMIESCOLARIZADA
  $tot_P_S_M = DB::table('practicas_profesionales')
      ->join('practicas', 'practicas.id_practicas', '=' , 'practicas_profesionales.id_practicas')
	  ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
	  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->where([['practicas_profesionales.estatus_practica', '=', 'Cursando'],
	           ['practicas.tipo', '=', 'PRACTICAS'],
			   ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
               ['estudiantes.sede','=','CU'], ['personas.genero', '=', 'M']
					])
      ->count();

$tot_P_S_F = DB::table('practicas_profesionales')
      ->join('practicas', 'practicas.id_practicas', '=' , 'practicas_profesionales.id_practicas')
	  ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
	  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->where([['practicas_profesionales.estatus_practica', '=', 'Cursando'],
	           ['practicas.tipo', '=', 'PRACTICAS'],
			   ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
               ['estudiantes.sede','=','CU'], ['personas.genero', '=', 'F']
					])
      ->count();


$tot_P_S = $tot_P_S_M + $tot_P_S_F ;
//--------------------------------------------------------------------------------------------------------------//

$tot_S_E_M = DB::table('servicio_sociales')
      ->join('practicas', 'practicas.id_practicas', '=' , 'servicio_sociales.id_practicas')
	  ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
	  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->where([['servicio_sociales.estatus_servicio', '=', 'Cursando'],
	           ['practicas.tipo', '=', 'SERVICIO'],
			   ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
               ['estudiantes.sede','=','CU'], ['personas.genero', '=', 'M']
					])
      ->count();




$tot_S_E_F = DB::table('servicio_sociales')
      ->join('practicas', 'practicas.id_practicas', '=' , 'servicio_sociales.id_practicas')
	  ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
	  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->where([['servicio_sociales.estatus_servicio', '=', 'Cursando'],
	           ['practicas.tipo', '=', 'SERVICIO'],
			   ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
               ['estudiantes.sede','=','CU'], ['personas.genero', '=', 'F']
					])
      ->count();

$tot_S_E = $tot_S_E_M + $tot_S_E_F;
//SEMIESCOLARIZADA
$tot_S_S_M = DB::table('servicio_sociales')
      ->join('practicas', 'practicas.id_practicas', '=' , 'servicio_sociales.id_practicas')
    ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
    ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->where([['servicio_sociales.estatus_servicio', '=', 'Cursando'],
             ['practicas.tipo', '=', 'SERVICIO'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
               ['estudiantes.sede','=','CU'], ['personas.genero', '=', 'M']
          ])
      ->count();

$tot_S_S_F = DB::table('servicio_sociales')
      ->join('practicas', 'practicas.id_practicas', '=' , 'servicio_sociales.id_practicas')
    ->join('estudiantes', 'estudiantes.matricula', '=', 'practicas.matricula')
    ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->where([['servicio_sociales.estatus_servicio', '=', 'Cursando'],
             ['practicas.tipo', '=', 'SERVICIO'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
               ['estudiantes.sede','=','CU'], ['personas.genero', '=', 'F']
          ])
      ->count();

$tot_S_S = $tot_S_S_M + $tot_S_S_F;
//--------------------------------------------------------------------------------------------------------------//



  return view ('personal_administrativo/servicios/info_practicas')
  //CU
  //PRACTICAS
  ->with('tot_P_E_M', $tot_P_E_M)
  ->with('tot_P_E_F', $tot_P_E_F)
  ->with('tot_P_E', $tot_P_E)
  ->with('tot_P_S_M', $tot_P_S_M)
  ->with('tot_P_S_F', $tot_P_S_F)
  ->with('tot_P_S', $tot_P_S)

  //SERVICIO SOCIAL
  ->with('tot_S_E_M', $tot_S_E_M)
  ->with('tot_S_E_F', $tot_S_E_F)
  ->with('tot_S_E', $tot_S_E)
  ->with('tot_S_S_M', $tot_S_S_M)
  ->with('tot_S_S_F', $tot_S_S_F)
  ->with('tot_S_S', $tot_S_S)
  ;

}


public function cuenta_ppssocial(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='3'){
         return redirect()->back();
        }

		  $usuario_actual=auth()->user();
	$id=$usuario_actual->id_user;

	 $users = DB::table('personas')
                  ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'personas.genero')
                  ->join('users', 'personas.id_persona', '=', 'users.id_persona')
                  ->where('users.id_persona',$id)
                  ->take(1)
                  ->first();


    return view('personal_administrativo/servicios.configuracion_cuenta_servicios')->with('datos_usuario', $users);
    }


 public function changePassword(Request $request){

          if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
              // The passwords matches
              return redirect()->back()->with("error","Su contraseña actual no coincide con la contraseña que proporcionó. Inténtalo de nuevo.");
          }

          if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
              //Current password and new password are same
              return redirect()->back()->with("error","La nueva contraseña no puede ser la misma que su contraseña actual. Por favor, elija una contraseña diferente.");
          }

          $validatedData = $request->validate([
              'current-password' => 'required',
              'new-password' => 'required|string|min:8|confirmed',
          ]);

          //Change Password
          $user = Auth::user();
          $user->password = bcrypt($request->get('new-password'));
          $user->save();

          if($user->save()){
            return redirect()->route('cuenta_ppssocial')->with('success','Contraseña Actualizada Correctamente');
          }

      }


 public function changeuser(Request $request){
 $this->validate($request, [
      'username' => ['required', 'string', 'max:255', 'unique:users'],
          ]);

    $data = $request;

          //Change Password
          $user = Auth::user();
          $user->username = $data['username'];
          $user->save();

          if($user->save()){
            return redirect()->route('cuenta_ppssocial')->with('success','El nombre de usuario se ha actualizado correctamente');
          }

      }

	   public function changemail(Request $request){
 $this->validate($request, [
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          ]);

    $data = $request;

          //Change Password
          $user = Auth::user();
		   $user->email = $data['email'];
          $user->save();

          if($user->save()){
            return redirect()->route('cuenta_ppssocial')->with('success','El correo se ha actualizado correctamente');
          }

      }

	  	   public function datos_personales_ppssocial(Request $request){
			   	  $usuario_actual=auth()->user();
	$id=$usuario_actual->id_user;
	$data = $request;
   DB::table('personas')
      ->where('personas.id_persona', $id)
      ->update([ 'nombre' => $data['nombre'] ,'apellido_paterno' => $data['apellido_paterno'], 'apellido_materno' => $data['apellido_materno'],
                'genero' => $data['genero']]);

            return redirect()->route('cuenta_ppssocial')->with('success','Datos actualizados correctamente');


      }


}
