<?php
namespace App\Http\Controllers;
use App\User;
use App\Estudiante;
use App\Persona;
use App\Administrativo;
use App\Nivel;
use App\Periodo;
use App\FechaActualizacion;
use App\Departamento;
use App\Dpto_Administrativo;
use Illuminate\Support\Facades\DB;
use Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use PDF;
use Dompdf\Dompdf;
use App\Extracurricular;
use App\Detalle_extracurricular;
use App\Telefono;
use App\Tutor;


class AdminController extends Controller
{
    //
    public function home_admin(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='5'){
         return redirect()->back();
        //  return redirect('perfiles')->with('error','Acceso Denegado');
        }
        return view('personal_administrativo/admin_sistema.home_admin');
      }

      public function registro_estudiante(){
        $usuario_actual=\Auth::user();
         if($usuario_actual->tipo_usuario!='5'){
           return redirect()->back();
          //  return redirect()->back()->with('error','Acceso Denegado');
          }
        return view('personal_administrativo/admin_sistema.registro_estudiante');
      }

      public function busqueda_estudiante(){
        $usuario_actual=\Auth::user();
         if($usuario_actual->tipo_usuario!='5'){
           return redirect()->back();
          }
        return view('personal_administrativo/admin_sistema.busqueda_estudiante');
      }

      public function estudiante_activo(){
        $usuario_actual=\Auth::user();
         if($usuario_actual->tipo_usuario!='5'){
           return redirect()->back();
          }
        $est = DB::table('estudiantes')
        ->select('estudiantes.matricula', 'estudiantes.semestre', 'users.updated_at', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'users.bandera')
        ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
        ->join('users', 'users.id_persona', '=', 'personas.id_persona')
        ->where('users.bandera', '=', '1')
         ->orderBy('users.updated_at', 'asc')
        ->simplePaginate(10);

        return view('personal_administrativo/admin_sistema.estudiante_activo')->with('estudiante', $est);
      }

      public function estudiante_inactivo(){
        $usuario_actual=\Auth::user();
         if($usuario_actual->tipo_usuario!='5'){
           return redirect()->back();
          }
        $est = DB::table('estudiantes')
        ->select('estudiantes.matricula', 'estudiantes.semestre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'users.id_user', 'users.bandera')
        ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
        ->join('users', 'users.id_persona', '=', 'personas.id_persona')
        ->where('users.bandera', '=', '0')
         ->orderBy('estudiantes.semestre', 'asc')
        ->simplePaginate(10);

        return view('personal_administrativo/admin_sistema.estudiante_inactivo')->with('estudiante', $est);
      }

      public function registro_coordinador(){
        $usuario_actual=\Auth::user();
         if($usuario_actual->tipo_usuario!='5'){
           return redirect()->back();
          }
        $dep = DB::table('departamentos')
        ->select('departamentos.id_departamento', 'departamentos.departamento')
        ->get();
      return view('personal_administrativo/admin_sistema.registro_coordinador')->with('de', $dep);
    }

      public function registrar_coordinador(Request $request){
        $usuario_actuales=\Auth::user();
         if($usuario_actuales->tipo_usuario!='5'){
           return redirect()->back();
          }

        $this->validate($request, [
          'nombre' => ['required', 'string', 'max:25'],
          'apellido_paterno' => ['required', 'string', 'max:25'],
          'curp' => ['required', 'string', 'min:18','max:18'],
          'edad' => ['required', 'string', 'max:70'],
          'genero' => ['required', 'string'],
         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);


$data = $request;
if($data['edad'] >17){
  $periodo_semestre = DB::table('periodos')
  ->select('periodos.id_periodo')
  ->where('periodos.estatus', '=', 'actual')
  ->take(1)
  ->first();
 $periodo_semestre= $periodo_semestre->id_periodo;
        $id_prueba= random_int(1, 532986) +232859 * 123 -43 +(random_int(1, 1234));
        $password= $data['apellido_paterno'];
        $persona=new Persona;
        $persona->id_persona=$id_prueba;
        $persona->nombre=$data['nombre'];
        $persona->apellido_paterno=$data['apellido_paterno'];
        $persona->apellido_materno=$data['apellido_materno'];
        $persona->curp=$data['curp'];
        $persona->fecha_nacimiento=$data['fecha_nacimiento'];
        $persona->edad=$data['edad'];
        $persona->genero=$data['genero'];
        $persona->periodo=$periodo_semestre;
        $persona->save();

        if($persona->save()){
          $administrativo=new Administrativo;
          $administrativo->puesto=$data['puesto'];
          $administrativo->id_persona=$id_prueba;
          $administrativo->save();

          if($administrativo->save()){
            $bus_adm = DB::table('administrativos')
            ->select('administrativos.id_administrativo')
            ->join('personas', 'personas.id_persona', '=', 'administrativos.id_persona')
            ->where('personas.id_persona',$id_prueba)
            ->take(1)
            ->first();
             $bus_adm = $bus_adm->id_administrativo;
            $depto_admin=new Dpto_Administrativo;
            $depto_admin->id_departamento=$data['departamento'];
            $depto_admin->id_administrativo=$bus_adm;
            $depto_admin->periodo=$periodo_semestre;
            $depto_admin->save();

              if($depto_admin->save()){
                $nivel = new Nivel();
                $nivel ->id_administrativo= $bus_adm;
                $nivel ->grado_estudios=$data['grado_estudios'];
              //  $nivel ->rfc=$data['curp'];
                $nivel ->save();

              if($nivel->save()){
            $user=new User;
            $user->id_user=$id_prueba;
            $user->username=$data['username'];
            $user->email=$data['email'];
            $user->password = Hash::make($data['password']);
            $user->tipo_usuario=$data['departamento'];
            $user->id_persona=$id_prueba;
            $user->periodo=$periodo_semestre;
            $user->save();
              if($user->save()){
            return redirect()->route('home_admin')->with('success','¡Datos registrados correctamente!');
          }else{
           return redirect()->route('home_admin')->with('error','error en la creacion');
          }
        }}}}
              }
              else{
                return redirect()->route('home_admin')->with('error','El usuario debe ser mayor de edad');
              }

      }

      public function Busqueda(Request $request){
        $usuario_actual=\Auth::user();
         if($usuario_actual->tipo_usuario!='5'){
           return redirect()->back();
          }

        $q = $request->get('q');
        if($q != null){
        $user = Estudiante::where( 'estudiantes.matricula', 'LIKE', '%' . $q . '%' )
        ->where('users.bandera', '=', '1')
                            ->orWhere ( 'estudiantes.semestre', 'LIKE', '%' . $q . '%' )
                            ->orWhere ( 'estudiantes.modalidad', 'LIKE', '%' . $q . '%' )
                            ->orWhere( 'personas.nombre', 'LIKE', '%' . $q . '%' )
                            ->orWhere ( 'personas.apellido_paterno', 'LIKE', '%' . $q . '%' )
                            ->orWhere ( 'personas.apellido_materno', 'LIKE', '%' . $q . '%' )
                            ->orWhere ( 'users.email', 'LIKE', '%' . $q . '%' )
                            ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
                            ->join('users', 'users.id_persona', '=', 'personas.id_persona')
                            ->simplePaginate(10);


      if (count ($user) > 0 ) {
            return view ( 'personal_administrativo/admin_sistema.busqueda_estudiante' )->withDetails ($user )->withQuery ($q);
    }
  else{
  return redirect()->route('busqueda_estudiante')->with('error','¡Sin resultados!');
  }}  else{
        return redirect()->route('busqueda_estudiante')->with('error','¡Sin resultados!');
    }

    }

    public function busqueda_aux(Request $request){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='4'){
         return redirect()->back();
        }
      $q = $request->get('q');
      if($q != null){
      $user = Estudiante::where( 'estudiantes.matricula', 'LIKE', '%' . $q . '%' )
	                      ->where('users.bandera', '=', '1')
                          ->orWhere ( 'estudiantes.semestre', 'LIKE', '%' . $q . '%' )
                          ->orWhere ( 'estudiantes.modalidad', 'LIKE', '%' . $q . '%' )
                          ->orWhere( 'personas.nombre', 'LIKE', '%' . $q . '%' )
                          ->orWhere ( 'personas.apellido_paterno', 'LIKE', '%' . $q . '%' )
                          ->orWhere ( 'personas.apellido_materno', 'LIKE', '%' . $q . '%' )
                          ->orWhere ( 'users.email', 'LIKE', '%' . $q . '%' )
                          ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
                          ->join('users', 'users.id_persona', '=', 'personas.id_persona')
                          ->simplePaginate(10);
                          $est = DB::table('users')
                          ->where('users.bandera', '=', '1')
                          ->get();


    if ((count ($user) > 0 ) && ($est != null )){
          return view ( 'personal_administrativo/auxiliar_administrativo.busqueda_estudiante_aux' )->withDetails ($user )->withQuery ($q);
  }
  else{
  return redirect()->route('busqueda_estudiante_aux')->with('error','¡Sin resultados!');
  }}  else{
      return redirect()->route('busqueda_estudiante_aux')->with('error','¡Sin resultados!');
  }

  }

      public function activar_estudiante($id_user){

        $valor=$id_user;
        DB::table('users')
            ->where('users.id_user', $valor)
            ->update(['bandera' => '1']);
            return redirect()->route('busqueda_estudiante')->with('success','¡El estudiante ha sido Activado!');

      }

      public function desactivar_estudiante($id_user){
        $valor=$id_user;
        DB::table('users')
            ->where('users.id_user', $valor)
            ->update(
                ['bandera' => '0']);
            return redirect()->route('estudiante_inactivo')->with('success','¡El estudiante ha sido desactivado!');

      }

      public function activar_estudiante_aux($id_user){

        $valor=$id_user;
        DB::table('users')
            ->where('users.id_user', $valor)
            ->update(['bandera' => '1']);
            return redirect()->route('busqueda_estudiante_aux')->with('success','¡El estudiante ha sido Activado!');

      }

      public function desactivar_estudiante_aux($id_user){
        $valor=$id_user;
        DB::table('users')
            ->where('users.id_user', $valor)
            ->update(
                ['bandera' => '0']);
            return redirect()->route('estudiante_inactivo_aux')->with('success','¡El estudiante ha sido desactivado!');

      }
      public function busqueda_coordinador(){
        $usuario_actual=\Auth::user();
         if($usuario_actual->tipo_usuario!='5'){
           return redirect()->back();
          }
        return view('personal_administrativo/admin_sistema.busqueda_coordinador');
      }

      public function coordinador_activo(){
        $usuario_actual=\Auth::user();
        $id=$usuario_actual->id_user;
         if($usuario_actual->tipo_usuario!='5'){
           return redirect()->back();
          }
          $users = DB::table('administrativos')
          ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'users.id_user', 'users.username',
          'users.email','administrativos.puesto')
          ->join('personas', 'personas.id_persona', '=', 'administrativos.id_persona')
          ->join('users', 'personas.id_persona', '=', 'users.id_persona')
          ->where([['administrativos.puesto','!=', ''], ['users.bandera', '=', '1'] , ['users.id_user', '!=', $id]])
          ->orderBy('personas.nombre', 'asc')
          ->simplePaginate(8);
        return view('personal_administrativo/admin_sistema.coordinador_activo')->with('coordi', $users);
      }

      public function coordinador_inactivo(){
        $usuario_actual=\Auth::user();
         if($usuario_actual->tipo_usuario!='5'){
           return redirect()->back();
          }
          $users = DB::table('administrativos')
          ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'users.id_user', 'users.username',
          'users.email', 'administrativos.puesto')
          ->join('personas', 'personas.id_persona', '=', 'administrativos.id_persona')
          ->join('users', 'personas.id_persona', '=', 'users.id_persona')
          ->where([['administrativos.puesto','!=', ''], ['users.bandera', '=', '0']])
          ->orderBy('personas.nombre', 'asc')
          ->simplePaginate(8);


        return view('personal_administrativo/admin_sistema.coordinador_inactivo')->with('coordi', $users);
      }


        public function editar_estudiante($matricula){
          $ids=$matricula;
                    $datos = DB::table('estudiantes')
                    ->select('estudiantes.matricula', 'estudiantes.fecha_ingreso','estudiantes.semestre', 'estudiantes.modalidad',
                    'estudiantes.estatus', 'estudiantes.grupo','personas.nombre', 'personas.apellido_paterno','estudiantes.grupo',
                    'personas.apellido_materno','personas.fecha_nacimiento','personas.curp', 'personas.genero','estudiantes.estatus',
                    'personas.lugar_nacimiento','personas.edad', 'personas.tipo_sangre', 'estudiantes.bachillerato_origen')
                    ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
                    ->where('estudiantes.matricula',$ids)
                    ->take(1)
                    ->first();
                  $ema = DB::table('users')
                  ->select('users.email')->where('users.id_user', $ids)->take(1)->first();
         return view('personal_administrativo/admin_sistema.editar_estudiante')->with('users', $datos)->with('emails', $ema);
          }

          protected function activar_cordinador($id_user){
            $valor=$id_user;
            DB::table('users')
                ->where('users.id_user', $valor)
                ->update(
                    ['bandera' => '1']);
                return redirect()->route('coordinador_activo')->with('success','¡El Coordinador ha sido Activado!');
          }

          protected function desactivar_cordinador($id_user){
            $valor=$id_user;
            DB::table('users')
                ->where('users.id_user', $valor)
                ->update(
                    ['bandera' => '0']);
                return redirect()->route('coordinador_inactivo')->with('success','¡El Coordinador ha sido Desactivado!');
          }

          public function nuevo_periodo(){
            $usuario_actual=\Auth::user();
             if($usuario_actual->tipo_usuario!='5'){
               return redirect()->back();
              }
            $periodos = DB::table('periodos')
            ->select('periodos.inicio', 'periodos.final', 'periodos.estatus', 'periodos.created_at')
            ->orderBy('periodos.estatus', 'asc')
            ->simplePaginate(7);
      return view('personal_administrativo/admin_sistema.nuevo_periodo')->with('guardados', $periodos);
    }

protected function crear_periodo(Request $request){
$data = $request;
$buscar_periodo = DB::table('periodos')
->select('periodos.id_periodo', 'periodos.final')
->where('periodos.estatus', '=',  'actual')
->take(1)
->first();

if(empty($buscar_periodo->id_periodo)){
$periodo=new Periodo;
$periodo->inicio=$data['inicio'];
$periodo->final=$data['final'];
$periodo->estatus='actual';
$periodo->save();

return redirect()->route('nuevo_periodo')->with('success','¡Periodo agregado correctamente!');
}
else{
  $buscar_periodos = DB::table('periodos')
  ->select('periodos.id_periodo', 'periodos.final')
  ->where('periodos.estatus', '=',  'actual')
  ->take(1)
  ->first();
  DB::table('periodos')
        ->where('periodos.id_periodo', $buscar_periodos->id_periodo)
        ->update(['estatus' => 'anterior']);

        $periodo=new Periodo;
        $periodo->inicio=$data['inicio'];
        $periodo->final=$data['final'];
        $periodo->estatus='actual';
        $periodo->save();

        DB::table('users')
                    ->update(['check_lineamiento' => '0']);
      return redirect()->route('nuevo_periodo')->with('success','Periodo agregado correctamente!');
}

}


protected function nueva_actualizacion(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='5'){
     return redirect()->back();
    }

    $id_clave = DB::table('periodo_actualizacion')
    ->select('periodo_actualizacion.fecha_inicio', 'periodo_actualizacion.fecha_fin')
    ->where('periodo_actualizacion.tipo', '=', 'estudiante')
    ->take(1)
    ->first();

/*    $fecha_inicio = DB::table('periodo_actualizacion')
    ->select('periodo_actualizacion.fecha_inicio')
    ->where('periodo_actualizacion.tipo', '=', 'estudiante')
    ->take(1)
    ->first();
    $fecha_inicio= $fecha_inicio ->fecha_inicio;

    $fecha_fin = DB::table('periodo_actualizacion')
    ->select('periodo_actualizacion.fecha_fin')
    ->where('periodo_actualizacion.tipo', '=', 'estudiante')
    ->take(1)
    ->first();
    $fecha_fin= $fecha_fin ->fecha_fin;
    $now = new \DateTime();
       $fechas_inicio =  date('d-m-Y', strtotime($fecha_inicio));
       $fechas_fin =  date('d-m-Y', strtotime($fecha_fin));
       $now =  date('d-m-Y');
       $actualizacion='';
       if (($now >= $fechas_inicio) && ($now <= $fechas_fin)){
         $actualizacion = 'SI';
}
else {
     $actualizacion = 'NO';
}*/
$actualizacion= 'NO';
  return view('personal_administrativo/admin_sistema.fecha_actualizacion')->with('fechas', $id_clave)->with('ss', $actualizacion);

}

protected function crear_fecha(Request $request){
  $data = $request;
  $id_clave = DB::table('periodo_actualizacion')
  ->select('periodo_actualizacion.id_actualizacion')
  ->where('periodo_actualizacion.tipo', 'estudiante')
  ->take(1)
  ->first();
  if(empty($id_clave)){
    $nueva_ac = new FechaActualizacion;
    $nueva_ac->fecha_inicio=$data['fecha_inicio'];
    $nueva_ac->fecha_fin=$data['fecha_fin'];
    $nueva_ac->tipo='estudiante';
    $nueva_ac->save();

    if($nueva_ac->save()){
      return redirect()->route('agregar_fecha')->with('success','¡Fechas agregadas Correctamente!');
    }
  }
  else {
    $id_clave = $id_clave->id_actualizacion;
    DB::table('periodo_actualizacion')
        //->where('periodo_actualizacion.id_actualizacion', $id_clave)
        ->where([['periodo_actualizacion.id_actualizacion', $id_clave], ['periodo_actualizacion.tipo', '=', 'estudiante']])
        ->update(['fecha_inicio' => $data['fecha_inicio'], 'fecha_fin' => $data['fecha_fin']]);
        return redirect()->route('agregar_fecha')->with('success','¡Fechas actualizadas Correctamente!');
  }
}

protected function restablecimiento($matricula){

  $id= $matricula;
    $user_password= Hash::make($id);
    DB::table('users')
      ->where('users.id_user', $id)
      ->update(
          ['password' => $user_password]);
      return redirect()->route('busqueda_estudiante')->with('success','¡La contraseña se ha restablecido correctamente!');
}

public function generar($matricula)
{
  $usuario_actual=auth()->user();
   if($usuario_actual->tipo_usuario!='5'){
     return redirect()->back();
    }

  $periodo_semestre = DB::table('periodos')
->select('periodos.id_periodo', 'periodos.inicio', 'periodos.final')
->where('periodos.estatus', '=', 'actual')
->take(1)
->first();
    $ids=$matricula;
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
         'users.facebook', 'personas.tipo_sangre', 'users.email', 'users.imagenurl')
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

    $pdf = PDF::loadView('estudiante/datos.hoja_datos_ad',  ['data' =>  $users, 'di' => $direccion, 'nu_l' => $num_local,
     'nu_ce' => $num_cel, 'activ' => $actividad, 'emergencia_persona' => $emergencia_persona, 'parentesco' => $parentesco,
     'num_emergencia' => $num_emergencia, 'alergia' => $alergia, 'enfermedad' => $enfermedad, 'lengua' => $lengua, 'periodo' => $periodo_semestre])
  ->setPaper($customPaper,$paper_orientation);
    return $pdf->stream('hoja_datos_personales.pdf');


}

  public function cuenta_administrador(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='5'){
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
	
	
    return view('personal_administrativo/admin_sistema.configuracion_cuenta_admin')->with('datos_usuario', $users);
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
            return redirect()->route('cuenta_admin')->with('success','Contraseña Actualizada Correctamente');
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
            return redirect()->route('cuenta_admin')->with('success','El nombre de usuario se ha actualizado correctamente');
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
            return redirect()->route('cuenta_admin')->with('success','El correo se ha actualizado correctamente');
          }

      }
	  
	  	   public function datos_personales_admin(Request $request){
			   	  $usuario_actual=auth()->user();
	$id=$usuario_actual->id_user;
	$data = $request;
   DB::table('personas')
      ->where('personas.id_persona', $id)
      ->update([ 'nombre' => $data['nombre'] ,'apellido_paterno' => $data['apellido_paterno'], 'apellido_materno' => $data['apellido_materno'],
                'genero' => $data['genero']]);
          
            return redirect()->route('cuenta_admin')->with('success','Datos actualizados correctamente');
         
      }
	  
	  protected function restablecimiento_coor($id_user){

  $id= $id_user;
  $nueva_con= "JATWEB";
    $user_password= Hash::make($nueva_con);
    DB::table('users')
      ->where('users.id_user', $id)
      ->update(
          ['password' => $user_password]);
      return redirect()->route('coordinador_activo')->with('success','¡La contraseña se ha restablecido correctamente! Contraseña asignada: JATWEB');
}


}
