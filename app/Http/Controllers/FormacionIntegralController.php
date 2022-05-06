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
use App\FechaActualizacion;
use App\Periodo;
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
use App\Tutoria;

class FormacionIntegralController extends Controller
{
  protected function getRegister()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
        return view('personal_administrativo/formacion_integral/gestion_tallerista.create');
    }

  protected function postRegister(Request $request)

 {
  $this->validate($request, [
    'id' => ['required', 'string', 'max:60', 'unique:users'],
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    'password' => ['required', 'string', 'min:8', 'confirmed'],
    'tipo_usuario' => ['required', 'string', 'max:255'],
  ]);


  $data = $request;


  $user=new User;
  $user->id_user=$data['id'];
  $user->name=$data['name'];
  $user->email=$data['email'];
  $user->password=Hash::make($data['password']);
  $user->tipo_usuario=$data['tipo_usuario'];

  if($user->save()){
    return redirect()->route('registros_talleristas')->with('success','Usuario Registrado Correctamente');
  }

}

  public function inicio_formacion()
  {
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='1'){
       return redirect()->back();
      }
    return view('personal_administrativo/formacion_integral/home_formacion');
    }

    public function cuenta_formaciones(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
    return view('personal_administrativo/formacion_integral.configuracion_cuenta');
    }
    public function read(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
    return view('personal_administrativo/formacion_integral/gestion_tallerista.read');
    }

    public function busqueda_estudiante_fi()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
    return view('personal_administrativo/formacion_integral.busqueda_estudiante_fi');
    }

    public function registrar_tutor()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
    return view('personal_administrativo/formacion_integral/gestion_tutores.registrar_tutor');
    }

    public function busqueda_tutor()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
      $result = DB::table('personas')
      ->select('personas.nombre', 'personas.edad', 'personas.apellido_paterno', 'personas.apellido_materno', 'tutores.bandera',
      'tutores.procedencia_interna', 'tutores.id_tutor' , 'tutores.procedencia_externa','nivel.grado_estudios', 'telefonos.numero')
      ->join('tutores', 'personas.id_persona', '=', 'tutores.id_persona')
      ->join('nivel', 'tutores.id_nivel', '=', 'nivel.id_nivel')
      ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
      ->where([['tutores.bandera', '=', '1'], ['telefonos.tipo', '=', 'celular'], ['nivel.grado_estudios', '!=', 'estudiante']])
      //->orderBy('personas.apellido_paterno', 'asc')
      ->simplePaginate(7);


    return view('personal_administrativo/formacion_integral/gestion_tutores.busqueda_tutor')->with('re', $result);
    }

    public function tutor_activo()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
    return view('personal_administrativo/formacion_integral/gestion_tutores.tutor_activo');
    }

    public function tutor_inactivo()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
      $result = DB::table('personas')
      ->select('personas.nombre', 'personas.edad', 'personas.apellido_paterno', 'personas.apellido_materno', 'tutores.bandera',
      'tutores.procedencia_interna', 'tutores.id_tutor',  'tutores.procedencia_externa','nivel.grado_estudios', 'telefonos.numero')
      ->join('tutores', 'personas.id_persona', '=', 'tutores.id_persona')
      ->join('nivel', 'tutores.id_nivel', '=', 'nivel.id_nivel')
      ->join('telefonos', 'telefonos.id_persona', '=', 'personas.id_persona')
      ->where([['tutores.bandera', '=', '0'], ['telefonos.tipo', '=', 'celular'],])
      //->orderBy('personas.apellido_paterno', 'asc')
      ->simplePaginate(7);
    return view('personal_administrativo/formacion_integral/gestion_tutores.tutor_inactivo')->with('re', $result);
    }

    public function registro_extracurricular()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
    return view('personal_administrativo/formacion_integral/gestion_talleres.registro_extracurricular');
    }

    public function registro_taller()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
      $result = DB::table('personas')
      ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'tutores.id_tutor')
      ->join('tutores', 'personas.id_persona', '=', 'tutores.id_persona')
      ->join('nivel', 'nivel.id_nivel', '=', 'tutores.id_nivel')
      ->where([['nivel.grado_estudios', '!=', 'estudiante'], ['tutores.bandera', '=', '1']])
      ->orderBy('personas.nombre', 'asc')
      ->get();
    return view('personal_administrativo/formacion_integral/gestion_talleres.registro_taller')->with('taller', $result);
    }

    public function registrar_taller(Request $request)
    {
      $this->validate($request, [
        'nombre_ec' => ['required', 'string', 'max:100'],
        'creditos' => ['required', 'string', 'max:100'],
        'area' => ['required', 'string', 'max:25'],
        'modalidad' => ['required', 'string', 'max:30'],
        'cupo' => ['required', 'string', 'max:200'],
        'lugar' => ['required', 'string', 'max:100'],
      ]);

      $data = $request;
      $periodo_semestre = DB::table('periodos')
      ->select('periodos.id_periodo')
      ->where('periodos.estatus', '=', 'actual')
      ->take(1)
      ->first();
      $now = new \DateTime();
     $periodo_semestre= $periodo_semestre->id_periodo;
      DB::table('extracurriculares')
      ->Insert(['nombre_ec' => $data['nombre_ec'], 'tipo' => 'Taller', 'creditos' => $data['creditos'], 'area'=> $data['area'],
     'modalidad'=> $data['modalidad'],  'cupo'=> $data['cupo'], 'lugar'=> $data['lugar'], 'fecha_inicio'=> $data['fecha_inicio'],
     'fecha_fin'=> $data['fecha_fin'],  'hora_inicio'=> $data['hora_inicio'],  'hora_fin'=> $data['hora_fin'],
     'dias_sem'=> $data['dias_sem'],  'materiales'=> $data['materiales'],  'tutor'=> $data['tutor'],
     'periodo'=> $periodo_semestre, 'control_cupo'=> $data['cupo'], 'created_at'=> $now, 'updated_at'=> $now]);
return redirect()->route('actividades_registradas')->with('success','Taller Registrado Correctamente');
    }


    public function registrar_conferencia(Request $request)
    {
      $this->validate($request, [
        'nombre_ec' => ['required', 'string', 'max:100'],
        'lugar' => ['required', 'string', 'max:100'],
        'creditos' => ['required', 'string', 'max:100'],
        'area' => ['required', 'string', 'max:25'],
        'modalidad' => ['required', 'string', 'max:30'],
        'cupo' => ['required', 'string', 'max:200'],
        'lugar' => ['required', 'string', 'max:100'],
      ]);

      $data = $request;
      $now = new \DateTime();
      $periodo_semestre = DB::table('periodos')
      ->select('periodos.id_periodo')
      ->where('periodos.estatus', '=', 'actual')
      ->take(1)
      ->first();
     $periodo_semestre= $periodo_semestre->id_periodo;
      DB::table('extracurriculares')
          ->Insert(
              ['nombre_ec' => $data['nombre_ec'], 'tipo' => 'Conferencia', 'creditos' => $data['creditos'], 'area'=> $data['area'],
               'modalidad'=> $data['modalidad'],  'cupo'=> $data['cupo'], 'lugar'=> $data['lugar'], 'fecha_inicio'=> $data['fecha_inicio'],
               'fecha_fin'=> $data['fecha_inicio'], 'hora_inicio'=> $data['hora_inicio'], 'hora_fin'=> $data['hora_fin'],
             'tutor'=> $data['tutor'], 'periodo'=> $periodo_semestre, 'control_cupo'=> $data['cupo'], 'created_at'=> $now, 'updated_at'=> $now]);
      return redirect()->route('actividades_registradas')->with('success','Conferencia Registrada Correctamente');
    }

    public function registro_conferencia()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }

      $result = DB::table('personas')
      ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'tutores.id_tutor')
      ->join('tutores', 'personas.id_persona', '=', 'tutores.id_persona')
      ->join('nivel', 'nivel.id_nivel', '=', 'tutores.id_nivel')
      ->where([['nivel.grado_estudios', '!=', 'estudiante'], ['tutores.bandera', '=', '1']])
      ->orderBy('personas.nombre', 'asc')
      ->get();
    return view('personal_administrativo/formacion_integral/gestion_talleres.registro_conferencia')->with('taller', $result);
    }

    public function actividades_registradas()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
      $result = DB::table('extracurriculares')
      ->select('extracurriculares.id_extracurricular', 'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
      'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
      'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor',
      'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'extracurriculares.lugar', 'extracurriculares.cupo', 
	  'extracurriculares.control_cupo' )
      ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
      ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
      ->join('nivel', 'nivel.id_nivel', '=', 'tutores.id_nivel')
      ->where([['extracurriculares.bandera', '=', '1'] , ['extracurriculares.tipo', '=', 'Taller'] , ['nivel.grado_estudios', '!=', 'estudiante']])
       ->orderBy('extracurriculares.nombre_ec', 'asc')
      ->simplePaginate(10);

    return view('personal_administrativo/formacion_integral/gestion_talleres.actividades_registradas')->with('dato', $result);
    }

    public function confe_registradas()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
      $result = DB::table('extracurriculares')
      ->select('extracurriculares.id_extracurricular', 'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
      'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
      'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor',
      'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'extracurriculares.lugar', 'extracurriculares.cupo', 
	  'extracurriculares.control_cupo')
      ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
      ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
      ->join('nivel', 'nivel.id_nivel', '=', 'tutores.id_nivel')
      ->where([['extracurriculares.bandera', '=', '1'] , ['extracurriculares.tipo', '=', 'Conferencia'] , ['nivel.grado_estudios', '!=', 'estudiante']])
       ->orderBy('extracurriculares.nombre_ec', 'asc')
      ->simplePaginate(10);

    return view('personal_administrativo/formacion_integral/gestion_talleres.conferencias_registradas')->with('dato', $result);
    }


    public function actividades_finalizadas()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }

        $result = DB::table('extracurriculares')
        ->select('extracurriculares.id_extracurricular', 'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
        'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
        'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.observaciones', 'extracurriculares.hora_fin', 'tutores.id_tutor',
        'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
        ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
        ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
        ->where([['extracurriculares.bandera', '=', '2']])
         ->orderBy('extracurriculares.nombre_ec', 'asc')
        ->simplePaginate(20);
    return view('personal_administrativo/formacion_integral/gestion_talleres.actividades_finalizadas_general')->with('dato', $result);
    }

    public function actividades_desactivadas()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }

        $periodo_semestre = DB::table('periodos')
        ->select('periodos.id_periodo')
        ->where('periodos.estatus', '=', 'actual')
        ->take(1)
        ->first();

        $result = DB::table('extracurriculares')
        ->select('extracurriculares.id_extracurricular', 'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
        'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
        'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.observaciones', 'extracurriculares.hora_fin', 'tutores.id_tutor',
        'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
        ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
        ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
        ->where([['extracurriculares.bandera', '=', '3']])
         ->orderBy('extracurriculares.created_at', 'desc')
        ->simplePaginate(10);

    return view('personal_administrativo/formacion_integral/gestion_talleres.actividades_desactivadas_general')->with('dato', $result);
    }

    public function solicitudes()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
        $result = DB::table('solicitud_talleres')
      ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.fecha_solicitud', 'solicitud_talleres.nombre_taller', 'solicitud_talleres.descripcion',
      'solicitud_talleres.objetivos', 'solicitud_talleres.justificacion', 'solicitud_talleres.creditos',
      'solicitud_talleres.proyecto_final', 'solicitud_talleres.cupo', 'solicitud_talleres.estado','solicitud_talleres.matricula', 'solicitud_talleres.departamento',
      'solicitud_talleres.estado', 'estudiantes.matricula', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('estudiantes', 'solicitud_talleres.matricula', '=', 'estudiantes.matricula')
      ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
       ->join('periodos', 'periodos.id_periodo', '=', 'solicitud_talleres.periodo')
    //  ->where('solicitud_talleres.estado', '=', 'pendiente')
      ->where([['solicitud_talleres.estado', '=', 'pendiente'], ['periodos.estatus', '=', 'actual']])
      ->orderBy('solicitud_talleres.created_at', 'desc')
        ->simplePaginate(10);
    return view('personal_administrativo/formacion_integral/gestion_talleres.solicitudes')->with('data', $result);
    }

    public function asignar_taller()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
    return view('personal_administrativo/formacion_integral/gestion_talleres.asignar_taller');
    }

    public function actividades_asignadas()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
    return view('personal_administrativo/formacion_integral/gestion_talleres.actividades_asignadas');
    }

    public function registro_tallerista()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
      $result = DB::table('personas')
      ->select('personas.id_persona', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'tutores.id_tutor')
      ->join('tutores', 'personas.id_persona', '=', 'tutores.id_persona')
      ->where('tutores.bandera', '=', '1')
      ->orderBy('personas.nombre', 'asc')
      ->get();
    return view('personal_administrativo/formacion_integral/gestion_tallerista.registro_tallerista')->with('taller', $result);
    }

    public function registrar_talleristas(Request $request)
    {
      $this->validate($request, [
        'id_persona' => ['required', 'string', 'max:60', 'unique:users'],
        'username' => ['required', 'string', 'max:25', 'unique:users'],
        'password' => ['required', 'string', 'max:25'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      ]);
      $data = $request;
      $periodo_semestre = DB::table('periodos')
      ->select('periodos.id_periodo')
      ->where('periodos.estatus', '=', 'actual')
      ->take(1)
      ->first();
     $periodo_semestre= $periodo_semestre->id_periodo;

      $user=new User;
      $user->id_user=$data['id_persona'];
      $user->username=$data['username'];
      $user->email=$data['email'];
      $user->password = Hash::make($data['password']);
      $user->tipo_usuario='tallerista';
      $user->id_persona=$data['id_persona'];
      $user->periodo=$periodo_semestre;
      $user->save();
      if($user->save()){
    return redirect()->route('tallerista_activo')->with('success','¡Datos registrados correctamente!');
  }
else{
return redirect()->route('registro_tallerista')->with('error','error en la creacion');
}
    }

    public function tallerista_activo()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
      $result = DB::table('personas')
      ->select('users.id_user','users.created_at' ,'users.username', 'users.email',  'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'nivel.rfc')
      ->join('tutores', 'personas.id_persona', '=', 'tutores.id_persona')
      ->join('nivel', 'tutores.id_nivel', '=', 'nivel.id_nivel')
      ->join('users', 'personas.id_persona', '=', 'users.id_persona')
      //->where(['users.bandera', '=', '1'])
      ->where([['users.bandera','=', '1'], ['users.tipo_usuario', '=', 'tallerista'],])
    //  ->orderBy('personas.nombre', 'asc')
	 ->orderBy('users.created_at', 'desc')
      ->simplePaginate(7);
    return view('personal_administrativo/formacion_integral/gestion_tallerista.tallerista_activo')->with('re', $result);
    }

    public function tallerista_inactivo()
    {
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
      $result = DB::table('personas')
      ->select('users.id_user', 'users.bandera', 'users.username', 'users.email', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'nivel.rfc')
      ->join('tutores', 'personas.id_persona', '=', 'tutores.id_persona')
      ->join('nivel', 'tutores.id_nivel', '=', 'nivel.id_nivel')
      ->join('users', 'personas.id_persona', '=', 'users.id_persona')
      //->where('users.bandera', '=', '0')
      ->where([['users.bandera','=', '0'], ['users.tipo_usuario', '=', 'tallerista'],])
      ->orderBy('personas.nombre', 'asc')
      ->simplePaginate(7);
    return view('personal_administrativo/formacion_integral/gestion_tallerista.tallerista_inactivo')->with('re', $result);
    }

    public function activar_tallerista($id_user){

      $valor=$id_user;
      DB::table('users')
          ->where('users.id_user', $valor)
          ->update(
              ['bandera' => '1']);
          return redirect()->route('tallerista_activo')->with('success','¡El Tallerista ha sido Activado!');

    }

    public function desactivar_tallerista($id_user){
      $valor=$id_user;
      DB::table('users')
          ->where('users.id_user', $valor)
          ->update(
              ['bandera' => '0']
          );
          return redirect()->route('tallerista_inactivo')->with('success','¡El Tallerista ha sido desactivado!');

    }

    public function activar_tutor($id_tutor){

      $valor=$id_tutor;
      DB::table('tutores')
          ->where('tutores.id_tutor', $valor)
          ->update(
              ['bandera' => '1']);
          return redirect()->route('busqueda_tutor')->with('success','¡El Tutor ha sido Activado!');

    }

    public function desactivar_tutor($id_tutor){
      $valor=$id_tutor;
      DB::table('tutores')
          ->where('tutores.id_tutor', $valor)
          ->update(
              ['bandera' => '0']
          );
          return redirect()->route('tutor_inactivo')->with('success','¡El Tutor ha sido desactivado!');

    }

    public function busqueda_fi(Request $request){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect('perfiles');
        }
      $est = DB::table('users')
      ->where('users.bandera', '=', '1')
      ->get();

      $q = $request->get('q');
      if($q != null){
      $user = Estudiante::where( 'estudiantes.matricula', 'LIKE', '%' . $q . '%' )
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

      if ((count ($user) > 0 ) && ($est != null)){
          return view ( 'personal_administrativo/formacion_integral.busqueda_estudiante_fi' )->withDetails ($user )->withQuery ($q);
    }
  else{
    return redirect()->route('busqueda_estudiante_fi')->with('error','¡Sin resultados!');
  }}  else{
        return redirect()->route('busqueda_estudiante_fi')->with('error','¡Sin resultados!');
    }
  }

    public function registrar_tutor_fi(Request $request){
      $usuario_actuales=\Auth::user();
       if($usuario_actuales->tipo_usuario!='1'){
         return redirect('perfiles');
        }

      $this->validate($request, [
        'nombre' => ['required', 'string', 'max:25'],
]);

      $data = $request;
      $id_prueba= random_int(1, 532986) +232859 * 123 -43 +(random_int(1, 1234));
      $password= $data['apellido_paterno'];
      $persona=new Persona;
    //  $persona->id_persona=$data['curp'];
    $periodo_semestre = DB::table('periodos')
    ->select('periodos.id_periodo')
    ->where('periodos.estatus', '=', 'actual')
    ->take(1)
    ->first();
   $periodo_semestre= $periodo_semestre->id_periodo;
     $persona->id_persona=$id_prueba;
      $persona->nombre=$data['nombre'];
      $persona->apellido_paterno=$data['apellido_paterno'];
      $persona->apellido_materno=$data['apellido_materno'];
    //  $persona->curp=$data['curp'];
    // $persona->curp=$id_prueba;
      //$persona->fecha_nacimiento=$data['fecha_nacimiento'];
    //  $persona->edad=$data['edad'];
      $persona->genero=$data['genero'];
      $persona->periodo=$periodo_semestre;
      $persona->save();

      if($persona->save()){
        $administrativo=new Administrativo;
      //  $administrativo->id_persona=$data['curp'];
       $administrativo->id_persona=$id_prueba;
        $administrativo->save();

        if($administrativo->save()){
          $bus_adm = DB::table('administrativos')
          ->select('administrativos.id_administrativo')
          ->join('personas', 'personas.id_persona', '=', 'administrativos.id_persona')
          //->where('personas.id_persona',$data['curp'])
          ->where('personas.id_persona',$id_prueba)
          ->take(1)
          ->first();
           $bus_adm = $bus_adm->id_administrativo;
              $nivel = new Nivel();
              $nivel ->id_administrativo= $bus_adm;
              $nivel ->grado_estudios=$data['grado_estudios'];
            //  $nivel ->rfc=$data['curp'];
            $nivel ->rfc=$id_prueba;
              $nivel ->save();
           if($nivel->save()){
             $bus_nivel = DB::table('nivel')
             ->select('nivel.id_nivel')
             ->join('administrativos', 'nivel.id_administrativo', '=', 'administrativos.id_administrativo')
             ->where('administrativos.id_administrativo',$bus_adm)
             ->take(1)
             ->first();
                $bus_nivel = $bus_nivel->id_nivel;
               $tutor = new Tutor();
                $tutor ->procedencia_interna= $data['procedencia_interna'];
                $tutor ->procedencia_externa= $data['procedencia_externa'];
              //  $tutor ->id_persona= $data['curp'];
              $tutor ->id_persona= $id_prueba;
                $tutor ->id_nivel= $bus_nivel;
                $tutor->periodo=$periodo_semestre;
                $tutor->save();
            if($tutor->save()){
              $tel = new Telefono();
              $tel->tipo='celular';
              $tel->numero=$data['tel_celular'];
             $tel->id_persona=$id_prueba;
             $tel->save();
                if($tel->save()){
          return redirect()->route('inicio_formacion')->with('success','¡Datos registrados correctamente!');
        }}}}}
      //}
    else{
     return redirect()->route('inicio_formacion')->with('error','error en la creacion');
    }
    }

    protected function anteriores($matricula){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
        $matriculas=$matricula;
        $result = DB::table('personas')
        ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'tutores.id_tutor')
        ->join('tutores', 'personas.id_persona', '=', 'tutores.id_persona')
        ->join('nivel', 'nivel.id_nivel', '=', 'tutores.id_nivel')
        ->where([['nivel.grado_estudios', '!=', 'estudiante'], ['tutores.bandera', '=', '1']])
        ->orderBy('personas.nombre', 'asc')
        ->get();

        $datos_est = DB::table('personas')
        ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'estudiantes.matricula')
        ->join('estudiantes', 'estudiantes.id_persona', '=', 'personas.id_persona')
        ->where('estudiantes.matricula', $matriculas)
        ->take(1)
        ->first();

        $resultado = DB::table('extracurriculares')
        ->select('extracurriculares.id_extracurricular', 'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
        'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
        'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor',
        'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'extracurriculares.observaciones')
        ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
        ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
        ->join('nivel', 'nivel.id_nivel', '=', 'tutores.id_nivel')
        ->where([['extracurriculares.bandera', '=', '2'] ,  ['nivel.grado_estudios', '!=', 'estudiante']])
         ->orderBy('extracurriculares.nombre_ec', 'asc')
        ->get();

      return view('personal_administrativo/formacion_integral.registro_estudiantes')
      ->with('taller', $result)->with('uno', $matriculas)->with('extra', $resultado)->with('estudiante_da',$datos_est);
    }


    public function registro_hora(Request $request){
      $data = $request;
  $periodo_semestre = DB::table('periodos')
  ->select('periodos.id_periodo')
  ->where('periodos.estatus', '=', 'actual')
  ->take(1)
  ->first();
 $periodo_semestre= $periodo_semestre->id_periodo;
 $busqueda = DB::table('detalle_extracurriculares')
->select('detalle_extracurriculares.actividad')
->join('estudiantes', 'estudiantes.matricula', '=', 'detalle_extracurriculares.matricula')
 ->where([['estudiantes.matricula', '=', $data['matricula']], ['detalle_extracurriculares.actividad', '=', $data['extra']],
          ['detalle_extracurriculares.periodo', '=', $periodo_semestre], ['detalle_extracurriculares.estado', '=', 'Acreditado']])
->take(1)
->first();
if(empty($busqueda->actividad)){
 $resultado = DB::table('extracurriculares')
 ->select('extracurriculares.creditos')
 ->where([['extracurriculares.id_extracurricular', $data['extra']] , ['extracurriculares.bandera', '=', '2']])
 ->take(1)
 ->first();
  $inscripcion = new Detalle_extracurricular;
  $inscripcion->matricula= $data['matricula'];
  $inscripcion->actividad= $data['extra'];;
  $inscripcion->creditos= $resultado->creditos;
  $inscripcion->estado= 'Acreditado';
  $inscripcion->periodo= $periodo_semestre;
  $inscripcion->save();
      return redirect()->back()->with('success','Registro de Horas Realizada correctamente!');}
      else {return redirect()->back()->with('error','¡El estudiante ya se encuentra registrado!');}
    }

    protected function ver_avance($matricula){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
      $id=$matricula;
      $result = DB::table('detalle_extracurriculares')
      ->select('detalle_extracurriculares.actividad', 'detalle_extracurriculares.estado','extracurriculares.id_extracurricular',  'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
      'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
      'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor',
      'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('extracurriculares', 'extracurriculares.id_extracurricular', '=', 'detalle_extracurriculares.actividad')
      ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
      ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
      ->where([['detalle_extracurriculares.matricula','=', $id], ['detalle_extracurriculares.estado', '=', 'Acreditado']])
      ->orderBy('extracurriculares.nombre_ec', 'asc')
      ->simplePaginate(10);

      $academicas = DB::table('detalle_extracurriculares')
       ->join('extracurriculares', 'extracurriculares.id_extracurricular', '=', 'detalle_extracurriculares.actividad')
       ->where([['detalle_extracurriculares.matricula', '=', $id], ['detalle_extracurriculares.estado', '=', 'Acreditado'], ['extracurriculares.area', '=', 'ACADEMICA']])
        ->sum('detalle_extracurriculares.creditos');
      $culturales = DB::table('detalle_extracurriculares')
       ->join('extracurriculares', 'extracurriculares.id_extracurricular', '=', 'detalle_extracurriculares.actividad')
       ->where([['detalle_extracurriculares.matricula', '=', $id], ['detalle_extracurriculares.estado', '=', 'Acreditado'], ['extracurriculares.area', '=', 'CULTURAL']])
       ->sum('detalle_extracurriculares.creditos');
      $deportivas = DB::table('detalle_extracurriculares')
      ->join('extracurriculares', 'extracurriculares.id_extracurricular', '=', 'detalle_extracurriculares.actividad')
      ->where([['detalle_extracurriculares.matricula', '=', $id], ['detalle_extracurriculares.estado', '=', 'Acreditado'], ['extracurriculares.area', '=', 'DEPORTIVA']])
      ->sum('detalle_extracurriculares.creditos');
      $sumas = $academicas + $culturales + $deportivas;
      $datos_estudiante = DB::table('estudiantes')
       ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->where('estudiantes.matricula',$id)
      ->take(1)
      ->first();


    return  view ('personal_administrativo/formacion_integral.avance_estudiante')->with('dato', $result)
    ->with('aca',$academicas)
    ->with('cul',$culturales)
    ->with('dep',$deportivas)
    ->with('suma',$sumas)
    ->with('mat',$id)
    ->with('datos_es',$datos_estudiante);
    }

protected function acreditar_estudiantes($actividad, $matricula){
$act=$actividad;
$mat=$matricula;

  DB::table('detalle_extracurriculares')
        ->where([['detalle_extracurriculares.matricula','=', $mat], ['detalle_extracurriculares.actividad', '=', $act],])
        ->update(
          ['estado' => 'Acreditado']
      );
      return redirect()->route('inicio_formacion')->with('success','¡Acreditación Correcta!');
}

protected function constancia_par($matricula){
  $id=$matricula;
  $datos_estudiante = DB::table('estudiantes')
   ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
  ->where('estudiantes.matricula',$id)
  ->take(1)
  ->first();

  $academicas = DB::table('detalle_extracurriculares')
  ->select('extracurriculares.nombre_ec')
   ->join('extracurriculares', 'extracurriculares.id_extracurricular', '=', 'detalle_extracurriculares.actividad')
   ->where([['detalle_extracurriculares.matricula', '=', $id], ['detalle_extracurriculares.estado', '=', 'Acreditado'], ['extracurriculares.area', '=', 'ACADEMICA'],])
   ->orderBy('extracurriculares.nombre_ec', 'asc')
   ->get();

  $culturales = DB::table('detalle_extracurriculares')
   ->select('extracurriculares.nombre_ec')
   ->join('extracurriculares', 'extracurriculares.id_extracurricular', '=', 'detalle_extracurriculares.actividad')
   ->where([['detalle_extracurriculares.matricula', '=', $id], ['detalle_extracurriculares.estado', '=', 'Acreditado'], ['extracurriculares.area', '=', 'CULTURAL'],])
   ->orderBy('extracurriculares.nombre_ec', 'asc')
   ->get();

  $deportivas = DB::table('detalle_extracurriculares')
  ->select('extracurriculares.nombre_ec')
  ->join('extracurriculares', 'extracurriculares.id_extracurricular', '=', 'detalle_extracurriculares.actividad')
  ->where([['detalle_extracurriculares.matricula', '=', $id], ['detalle_extracurriculares.estado', '=', 'Acreditado'], ['extracurriculares.area', '=', 'DEPORTIVA'],])
  ->orderBy('extracurriculares.nombre_ec', 'asc')
  ->get();

  $paper_orientation = 'letter';
  $customPaper = array(2.5,2.5,600,950);

  $pdf = PDF::loadView('personal_administrativo/formacion_integral.constanciaParcial', ['data' =>  $datos_estudiante,
  'aca' => $academicas, 'cul' => $culturales, 'dep' => $deportivas])
  ->setPaper($customPaper,$paper_orientation);
  return $pdf->stream('constancia_parcial.pdf');

}

protected function constancia_val($matricula){
$usuario_actual=auth()->user();
    if($usuario_actual->tipo_usuario!='1'){
      return redirect()->back(); }
        $ids=$usuario_actual->id_user;
$id=$matricula;
  $datos_estudiante = DB::table('estudiantes')
   ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'estudiantes.modalidad')
  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
  ->where('estudiantes.matricula',$id)
  ->take(1)
  ->first();
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
if(($datos_estudiante->modalidad) == 'ESCOLARIZADA'){
$academicas = DB::table('detalle_extracurriculares')
 ->join('extracurriculares', 'extracurriculares.id_extracurricular', '=', 'detalle_extracurriculares.actividad')
 ->where([['detalle_extracurriculares.matricula', '=', $id], ['detalle_extracurriculares.estado', '=', 'Acreditado'], ['extracurriculares.area', '=', 'ACADEMICA'],])
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
if($academicas >= 80 && $sumas >= 200){

    $paper_orientation = 'letter';
    $customPaper = array(2.5,2.5,600,950);

 $pdf = PDF::loadView('personal_administrativo/formacion_integral.constanciaOficial', ['data' =>  $datos_estudiante,
 'aca' => $academicas, 'cul' => $culturales, 'dep' => $deportivas, 'suma' => $sumas, 'datos_coordinadora' => $datos_coordi, 'director' => $datos_director])
->setPaper($customPaper,$paper_orientation);
 return $pdf->stream('constancia_oficial.pdf');
}
else{
  return redirect()->route('busqueda_estudiante_fi')->with('error','¡El Estudiante no cumple con los requisitos para generar la constancia!');
}
}
else{
if((($datos_estudiante->modalidad) == 'SEMI ESCOLARIZADA') or ($datos_estudiante->modalidad) == 'SEMIESCOLARIZADA'){
  $academicas = DB::table('detalle_extracurriculares')
   ->join('extracurriculares', 'extracurriculares.id_extracurricular', '=', 'detalle_extracurriculares.actividad')
   ->where([['detalle_extracurriculares.matricula', '=', $id], ['detalle_extracurriculares.estado', '=', 'Acreditado'], ['extracurriculares.area', '=', 'ACADEMICA'],])
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
if($academicas >= 56 && $sumas >= 140){

      $paper_orientation = 'letter';
      $customPaper = array(2.5,2.5,600,950);

   $pdf = PDF::loadView('personal_administrativo/formacion_integral.constanciaOficial', ['data' =>  $datos_estudiante,
   'aca' => $academicas, 'cul' => $culturales, 'dep' => $deportivas, 'suma' => $sumas, 'datos_coordinadora' => $datos_coordi, 'director' => $datos_director])
  ->setPaper($customPaper,$paper_orientation);
   return $pdf->stream('constancia_oficial.pdf');
}
else{
return redirect()->route('busqueda_estudiante_fi')->with('error','¡El Estudiante no cumple con los requisitos para generar la constancia!');
}
}
}
}
protected function desactivar_extracurricular(Request $request){
$id_extra= $request;
  DB::table('extracurriculares')
      ->where('extracurriculares.id_extracurricular', $id_extra)
      ->update(
          ['bandera' => '0', $id_extra['observaciones']]
      );
      return redirect()->route('actividades_desactivadas_general')->with('success','¡Actividad Desactivada!');


}

protected function actualizar_fechas_solicitud(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }

    
      $fecha_inicio = DB::table('periodo_actualizacion')
      ->select('periodo_actualizacion.estado')
      ->where('periodo_actualizacion.tipo', '=', 'taller')
      ->take(1)
      ->first();

    
    return view('personal_administrativo/formacion_integral.fecha_de_talleres')->with('estatus_t', $fecha_inicio);
}

protected function fecha_taller(Request $request){
  $data = $request;
  $id_clave = DB::table('periodo_actualizacion')
  ->select('periodo_actualizacion.id_actualizacion')
  ->where('periodo_actualizacion.tipo', 'taller')
  ->take(1)
  ->first();

  if(empty($id_clave)){
    $nueva_ac = new FechaActualizacion;
    $nueva_ac->fecha_inicio=$data['fecha_inicio'];
    $nueva_ac->fecha_fin=$data['fecha_fin'];
    $nueva_ac->tipo='taller';
    $nueva_ac->save();

    if($nueva_ac->save()){
      return redirect()->route('fecha_solicitud')->with('success','¡Fechas agregadas Correctamente!');
    }
  }
  else {
    $id_clave = $id_clave->id_actualizacion;
    DB::table('periodo_actualizacion')
        //->where('periodo_actualizacion.id_actualizacion', $id_clave)
        ->where([['periodo_actualizacion.id_actualizacion', $id_clave], ['periodo_actualizacion.tipo', '=', 'taller']])
        ->update(['estado' => $data['estado']]);
        return redirect()->route('fecha_solicitud')->with('success','¡Periodo actualizado Correctamente!');
  }
}

public function taller_aprobado()
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }

    $periodo_semestre = DB::table('periodos')
    ->select('periodos.id_periodo')
    ->where('periodos.estatus', '=', 'actual')
    ->take(1)
    ->first();

    $result = DB::table('extracurriculares')
    ->select('estudiantes.matricula', 'extracurriculares.id_extracurricular', 'extracurriculares.created_at',  'extracurriculares.cupo',
	'extracurriculares.nombre_ec', 'extracurriculares.fecha_inicio','extracurriculares.fecha_fin', 'personas.nombre', 'personas.apellido_paterno',
	'personas.apellido_materno',  'extracurriculares.control_cupo', 'extracurriculares.fecha_inicio',
        'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor', 'extracurriculares.dias_sem', 'extracurriculares.lugar')
    ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
    ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
    ->join('estudiantes', 'estudiantes.id_persona', '=', 'personas.id_persona')
    ->join('users', 'users.id_persona', '=', 'personas.id_persona')
    //->where([['extracurriculares.periodo', $periodo_semestre->id_periodo],['extracurriculares.bandera', '=', '1'],
    //['users.tipo_usuario', '=', 'estudiante']])
	->where([['extracurriculares.bandera', '=', '1'],['users.tipo_usuario', '=', 'estudiante']])
     ->orderBy('extracurriculares.nombre_ec', 'asc')
    ->simplePaginate(10);
	

return view('personal_administrativo/formacion_integral/gestion_talleres.talleres_aprobados_estudiante')->with('data', $result);
}

public function taller_acreditado()
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
    $result = DB::table('solicitud_talleres')
  ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.fecha_solicitud', 'solicitud_talleres.nombre_taller', 'solicitud_talleres.descripcion',
  'solicitud_talleres.objetivos', 'solicitud_talleres.justificacion', 'solicitud_talleres.creditos',
  'solicitud_talleres.proyecto_final', 'solicitud_talleres.cupo', 'solicitud_talleres.estado','solicitud_talleres.matricula', 'solicitud_talleres.departamento',
  'solicitud_talleres.estado', 'estudiantes.matricula', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
  ->join('estudiantes', 'solicitud_talleres.matricula', '=', 'estudiantes.matricula')
  ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
   ->join('periodos', 'periodos.id_periodo', '=', 'solicitud_talleres.periodo')
  ->where('solicitud_talleres.estado', '=', 'Acreditado')
//  ->where([['solicitud_talleres.estado', '=', 'pendiente'], ['periodos.estatus', '=', 'actual']])
  ->orderBy('solicitud_talleres.created_at', 'desc')
    ->simplePaginate(10);
return view('personal_administrativo/formacion_integral/gestion_talleres.taller_acreditado')->with('data', $result);
}

public function taller_can_estudiante()
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
    $result = DB::table('extracurriculares')
    ->select('estudiantes.matricula', 'extracurriculares.id_extracurricular', 'extracurriculares.created_at', 'extracurriculares.nombre_ec', 'extracurriculares.fecha_inicio',
    'extracurriculares.fecha_fin', 'extracurriculares.observaciones', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
    ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
    ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
    ->join('estudiantes', 'estudiantes.id_persona', '=', 'personas.id_persona')
    ->join('users', 'users.id_persona', '=', 'personas.id_persona')
    ->where([['extracurriculares.bandera', '=', '3'] , ['users.tipo_usuario', '=', 'estudiante']])
     ->orderBy('extracurriculares.created_at', 'desc')
    ->simplePaginate(10);

return view('personal_administrativo/formacion_integral/gestion_talleres.taller_cancelado')->with('data', $result);
}

public function taller_rec_estudiante()
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
    $result = DB::table('solicitud_talleres')
  ->select('solicitud_talleres.num_solicitud', 'solicitud_talleres.fecha_solicitud', 'solicitud_talleres.nombre_taller', 'solicitud_talleres.descripcion',
  'solicitud_talleres.objetivos', 'solicitud_talleres.justificacion', 'solicitud_talleres.creditos',
  'solicitud_talleres.proyecto_final', 'solicitud_talleres.cupo', 'solicitud_talleres.estado','solicitud_talleres.matricula', 'solicitud_talleres.departamento',
  'solicitud_talleres.estado', 'estudiantes.matricula', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
  ->join('estudiantes', 'solicitud_talleres.matricula', '=', 'estudiantes.matricula')
  ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
   ->join('periodos', 'periodos.id_periodo', '=', 'solicitud_talleres.periodo')
  ->where('solicitud_talleres.estado', '=', 'Rechazado')
//  ->where([['solicitud_talleres.estado', '=', 'pendiente'], ['periodos.estatus', '=', 'actual']])
  ->orderBy('solicitud_talleres.created_at', 'desc')
    ->simplePaginate(10);
return view('personal_administrativo/formacion_integral/gestion_talleres.taller_rechazado')->with('data', $result);
}

public function taller_desactivado($id_extracurricular)
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
    $data=$id_extracurricular;
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


    return view('personal_administrativo/formacion_integral/gestion_talleres.cancelar_taller')
    ->with('datos_taller', $result);
}


public function cancel_actividad(Request $request){
$data= $request;

DB::table('extracurriculares')
    ->where('extracurriculares.id_extracurricular', $data['id_extracurricular'])
    ->update(
      ['bandera' => '3', 'observaciones' => $data['observaciones']]);

        return redirect()->route('actividades_desactivadas_general')->with('success','¡Taller Cancelado Correctamente!');

}

public function actividades_cancel()
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
  $result = DB::table('extracurriculares')
  ->select('extracurriculares.id_extracurricular', 'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
  'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
  'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor',
  'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'extracurriculares.observaciones')
  ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
  ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
  ->join('nivel', 'nivel.id_nivel', '=', 'tutores.id_nivel')
  ->where([['extracurriculares.bandera', '=', '3'] ,  ['nivel.grado_estudios', '!=', 'estudiante']])
   ->orderBy('extracurriculares.created_at', 'desc')
  ->simplePaginate(10);

return view('personal_administrativo/formacion_integral/gestion_talleres.actividades_desactivadas_general')->with('dato', $result);
}


public function finalizar_taller_f(Request $request){
$data= $request;
DB::table('extracurriculares')
    ->where('extracurriculares.id_extracurricular', $data['id_extracurricular'])
    ->update(
      ['bandera' => '2', 'observaciones' => $data['observaciones']]);

        return redirect()->route('actividades_finalizadas_general')->with('success','¡Actividad Acreditada Correctamente!');
}


protected function gestion_estudiante_taller($id_extracurricular){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
  $usuario_actual=auth()->user();
  $id=$usuario_actual->id_user;
  $id_extra = $id_extracurricular;
return view('personal_administrativo/formacion_integral/gestion_talleres.grupo_estudiante')->with('dato', $result);
}

public function registro_actividad()
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
  $result = DB::table('personas')
  ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'tutores.id_tutor')
  ->join('tutores', 'personas.id_persona', '=', 'tutores.id_persona')
  ->join('nivel', 'nivel.id_nivel', '=', 'tutores.id_nivel')
  ->where([['nivel.grado_estudios', '!=', 'estudiante'], ['tutores.bandera', '=', '1']])
  ->orderBy('personas.nombre', 'asc')
  ->get();
return view('personal_administrativo/formacion_integral/registrar_actividad')->with('taller', $result);
}

public function registro_actividad_es(Request $request)
{
  $this->validate($request, [
    'nombre_ec' => ['required', 'string', 'max:100'],
    'creditos' => ['required', 'string', 'max:100'],
    'area' => ['required', 'string', 'max:25'],
    'modalidad' => ['required', 'string', 'max:30'],
    'cupo' => ['required', 'string', 'max:200'],
    'lugar' => ['required', 'string', 'max:100'],
  ]);

  $data = $request;
  $periodo_semestre = DB::table('periodos')
  ->select('periodos.id_periodo')
  ->where('periodos.estatus', '=', 'actual')
  ->take(1)
  ->first();
  $now = new \DateTime();
 $periodo_semestre= $periodo_semestre->id_periodo;
  DB::table('extracurriculares')
  ->Insert(['nombre_ec' => $data['nombre_ec'], 'tipo' => $data['tipo'], 'creditos' => $data['creditos'], 'area'=> $data['area'],
 'modalidad'=> $data['modalidad'],  'cupo'=> $data['cupo'], 'lugar'=> $data['lugar'], 'fecha_inicio'=> $data['fecha_inicio'],
 'fecha_fin'=> $data['fecha_fin'],  'hora_inicio'=> $data['hora_inicio'],  'hora_fin'=> $data['hora_fin'],
 'dias_sem'=> $data['dias_sem'],  'materiales'=> $data['materiales'],  'tutor'=> $data['tutor'],
 'periodo'=> $periodo_semestre, 'control_cupo'=> $data['cupo'], 'bandera'=> '2',  'created_at'=> $now, 'updated_at'=> $now]);
return redirect()->route('actividades_finalizadas_general')->with('success','Actividad Registrada Correctamente');
}

public function editar_taller_re($extra)
{
  $id_extracurricular = $extra;
   $result = DB::table('extracurriculares')
  ->select('extracurriculares.id_extracurricular', 'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.cupo',
  'extracurriculares.creditos', 'extracurriculares.materiales', 'extracurriculares.lugar', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
  'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin' , 'extracurriculares.control_cupo')
   ->where([['extracurriculares.id_extracurricular', '=', $id_extracurricular]])
  ->take(1)
  ->first();
  
return view('personal_administrativo/formacion_integral/gestion_talleres.editar_taller')
->with('dato', $result)->with('id_extra', $id_extracurricular);
}

public function actualizar_taller_re(Request $request)
{
  $this->validate($request, [
    'nombre_ec' => ['required', 'string', 'max:100'],
    'creditos' => ['required', 'string', 'max:100'],
    'lugar' => ['required', 'string', 'max:200'],
  ]);

  $data = $request;
  
   $result = DB::table('extracurriculares')
  ->select('extracurriculares.cupo', 'extracurriculares.control_cupo')
   ->where('extracurriculares.id_extracurricular', '=', $data['id_extracurricular'])
  ->take(1)
  ->first();
  
  $nuevo_cupo = ($result->cupo)+ $data['aumento'];
  $nuevo_control_cupo = ($result->control_cupo)+$data['aumento'];
  
DB::table('extracurriculares')
    ->where('extracurriculares.id_extracurricular', $data['id_extracurricular'])
    ->update(['nombre_ec' =>  $data['nombre_ec'], 'creditos' => $data['creditos'] , 'cupo' => $nuevo_cupo, 
	          'control_cupo' => $nuevo_control_cupo, 'lugar' => $data['lugar'], 
	         'fecha_inicio' =>  $data['fecha_inicio'], 'fecha_fin' =>  $data['fecha_fin'] , 'hora_inicio' =>  $data['hora_inicio'], 
             'hora_fin' =>  $data['hora_fin'] , 'dias_sem' =>  $data['dias_sem'] , 'materiales' =>  $data['materiales']]);
return redirect()->back()->with('success','Actualizado Correctamente');
}

public function editar_conferencia_re($extra)
{
  $id_extracurricular = $extra;
   $result = DB::table('extracurriculares')
  ->select('extracurriculares.id_extracurricular', 'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.cupo',
  'extracurriculares.creditos', 'extracurriculares.materiales', 'extracurriculares.lugar', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
  'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin' , 'extracurriculares.control_cupo')
   ->where([['extracurriculares.id_extracurricular', '=', $id_extracurricular]])
  ->take(1)
  ->first();
  
return view('personal_administrativo/formacion_integral/gestion_talleres.editar_conferencia')
->with('dato', $result)->with('id_extra', $id_extracurricular);
}

public function actualizar_conferencia_re(Request $request)
{
  $this->validate($request, [
    'nombre_ec' => ['required', 'string', 'max:100'],
    'creditos' => ['required', 'string', 'max:100'],
       'lugar' => ['required', 'string', 'max:200'],
  ]);

  $data = $request;
  
   $result = DB::table('extracurriculares')
  ->select('extracurriculares.cupo', 'extracurriculares.control_cupo')
  ->where('extracurriculares.id_extracurricular', '=', $data['id_extracurricular'])
  ->take(1)
  ->first();
  
  $nuevo_cupo = ($result->cupo)+ $data['aumento'];
  $nuevo_control_cupo = ($result->control_cupo)+$data['aumento'];
  
  
DB::table('extracurriculares')
    ->where('extracurriculares.id_extracurricular', $data['id_extracurricular'])
    ->update(['nombre_ec' =>  $data['nombre_ec'], 'creditos' => $data['creditos'],'cupo' => $nuevo_cupo, 
	          'control_cupo' => $nuevo_control_cupo, 'lugar' => $data['lugar'], 
	         'fecha_inicio' =>  $data['fecha_inicio'], 'fecha_fin' =>  $data['fecha_fin'] , 'hora_inicio' =>  $data['hora_inicio'], 
             'hora_fin' =>  $data['hora_fin'] , 'dias_sem' =>  $data['dias_sem'] , 'materiales' =>  $data['materiales']]);
return redirect()->back()->with('success','Actualizado Correctamente');
}

public function detalles_taller_estudiantes($id_act)
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
	
	$id_extra = $id_act;
	
	 $result = DB::table('extracurriculares')
    ->select('estudiantes.matricula', 'extracurriculares.id_extracurricular', 'extracurriculares.created_at',  'extracurriculares.cupo',
	'extracurriculares.nombre_ec', 'extracurriculares.fecha_inicio','extracurriculares.fecha_fin', 'personas.nombre', 'personas.apellido_paterno',
	'personas.apellido_materno',  'extracurriculares.control_cupo', 'extracurriculares.fecha_inicio',  'extracurriculares.modalidad',
        'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'extracurriculares.dias_sem', 
		'extracurriculares.lugar', 'extracurriculares.materiales', 'extracurriculares.area', 'extracurriculares.creditos')
    ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
    ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
    ->join('estudiantes', 'estudiantes.id_persona', '=', 'personas.id_persona')
    ->join('users', 'users.id_persona', '=', 'personas.id_persona')
    //->where([['extracurriculares.periodo', $periodo_semestre->id_periodo],['extracurriculares.bandera', '=', '1'],
    //['users.tipo_usuario', '=', 'estudiante']])
	->where('extracurriculares.id_extracurricular', $id_extra)
     ->take(1)
     ->first();
	 
	 
return view('personal_administrativo/formacion_integral/detalles_taller_formacion')->with('detalles', $result);
}

public function detalles_taller_talleristas($id_act)
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
	
	$id_extra = $id_act;
	
	 $result = DB::table('extracurriculares')
    ->select('extracurriculares.id_extracurricular', 'extracurriculares.created_at',  'extracurriculares.cupo',
	'extracurriculares.nombre_ec', 'extracurriculares.fecha_inicio','extracurriculares.fecha_fin', 'personas.nombre', 'personas.apellido_paterno',
	'personas.apellido_materno',  'extracurriculares.control_cupo', 'extracurriculares.fecha_inicio', 'extracurriculares.modalidad',
        'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'tutores.id_tutor', 'extracurriculares.hora_fin', 'extracurriculares.dias_sem', 
		'extracurriculares.lugar', 'extracurriculares.materiales' , 'extracurriculares.area', 'extracurriculares.creditos')
    ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
    ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
	->where('extracurriculares.id_extracurricular', $id_extra)
     ->take(1)
     ->first();
	 
	 
return view('personal_administrativo/formacion_integral/detalles_taller_tallerista')->with('detalles', $result);
}

public function detalles_taller_conferencias($id_act)
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
	
	$id_extra = $id_act;
	
	 $result = DB::table('extracurriculares')
    ->select('extracurriculares.id_extracurricular', 'extracurriculares.created_at',  'extracurriculares.cupo',
	'extracurriculares.nombre_ec', 'extracurriculares.fecha_inicio','extracurriculares.fecha_fin', 'personas.nombre', 'personas.apellido_paterno',
	'personas.apellido_materno',  'extracurriculares.control_cupo', 'extracurriculares.fecha_inicio', 'extracurriculares.modalidad',
        'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'tutores.id_tutor', 'extracurriculares.hora_fin', 'extracurriculares.dias_sem', 
		'extracurriculares.lugar', 'extracurriculares.materiales' , 'extracurriculares.area', 'extracurriculares.creditos')
    ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
    ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
	->where('extracurriculares.id_extracurricular', $id_extra)
     ->take(1)
     ->first();
	 
	 
return view('personal_administrativo/formacion_integral/detalles_taller_con')->with('detalles', $result);
}

public function inscritos_taller($id_taller,$tutor, $matricula)
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
       $id_extra= $id_taller;
	   $id_tutor=$tutor;
	   $id_matricula = $matricula;
     
	    $periodo_semestre = DB::table('periodos')
      ->select('periodos.id_periodo', 'periodos.inicio', 'periodos.final')
      ->where('periodos.estatus', '=', 'actual')
      ->take(1)
      ->first();

      $result = DB::table('extracurriculares')
      ->select('extracurriculares.id_extracurricular','estudiantes.matricula','extracurriculares.nombre_ec', 'personas.nombre', 
'personas.apellido_paterno', 'personas.apellido_materno' , 'detalle_extracurriculares.estado')
      ->join('detalle_extracurriculares', 'detalle_extracurriculares.actividad', '=', 'extracurriculares.id_extracurricular')
      ->join('estudiantes', 'estudiantes.matricula', '=', 'detalle_extracurriculares.matricula')
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->where([['extracurriculares.bandera', '=' , '1'], ['extracurriculares.tutor', $id_tutor], 
	  ['detalle_extracurriculares.actividad', $id_extra], ['detalle_extracurriculares.estado', '=', 'Cursando'], 
	  ['detalle_extracurriculares.periodo', $periodo_semestre->id_periodo]])
	  ->orderBy('personas.nombre', 'asc')
      ->get();
 


      $resultado = DB::table('extracurriculares')
      ->select('extracurriculares.nombre_ec')
      ->where('extracurriculares.id_extracurricular', $id_extra)
      ->take(1)
      ->first();

return view('personal_administrativo/formacion_integral.gestion_taller')
->with('data', $result)->with('detalle', $resultado)->with('matricula', $id_matricula)->with('id_extracurricular', $id_extra);
	
}

public function desactivar_estudiante_taller($id_taller,$matricula)
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
       $id_extra= $id_taller;
	   $id_matricula=$matricula;
     DB::table('detalle_extracurriculares')
         ->where([['detalle_extracurriculares.matricula', $id_matricula], ['detalle_extracurriculares.actividad', $id_extra]])
         ->update(
             ['estado' => 'Cancelado']);
 return redirect()->back()->with('success', 'Se ha desactivado al Estudiante de la Actividad Extracurricular!');

}

public function eliminar_estudiante_taller($id_taller,$matricula)
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
       $id_extra= $id_taller;
	   $id_matricula=$matricula;
     DB::table('detalle_extracurriculares')
         ->where([['detalle_extracurriculares.matricula', $id_matricula], ['detalle_extracurriculares.actividad', $id_extra]])
		 ->take(1)
         ->delete();
            
 return redirect()->back()->with('success', 'Se ha eliminado el registro de la Actividad Extracurricular!');
}


public function acreditar_estudiante_taller($id_taller,$matricula)
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
       $id_extra= $id_taller;
	   $id_matricula=$matricula;
     DB::table('detalle_extracurriculares')
         ->where([['detalle_extracurriculares.matricula', $id_matricula], ['detalle_extracurriculares.actividad', $id_extra]])
         ->update(
            ['estado' => 'Acreditado']);
 return redirect()->back()->with('success', '¡Se ha Acreditado al Estudiante Correctamente!');

}

public function desacreditar_estudiante_taller($id_taller,$matricula)
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
       $id_extra= $id_taller;
	   $id_matricula=$matricula;
     DB::table('detalle_extracurriculares')
         ->where([['detalle_extracurriculares.matricula', $id_matricula], ['detalle_extracurriculares.actividad', $id_extra]])
         ->update(
            ['estado' => 'NA']);
 return redirect()->back()->with('success', 'Actualización de estatus Correctamente');

}

public function inscritos_taller_t($id_taller,$tutor)
{
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
       $id_extra= $id_taller;
	   $id_tutor=$tutor;
     
	    $periodo_semestre = DB::table('periodos')
      ->select('periodos.id_periodo', 'periodos.inicio', 'periodos.final')
      ->where('periodos.estatus', '=', 'actual')
      ->take(1)
      ->first();

      $result = DB::table('extracurriculares')
      ->select('extracurriculares.id_extracurricular','estudiantes.matricula','extracurriculares.nombre_ec', 'personas.nombre', 
'personas.apellido_paterno', 'personas.apellido_materno' , 'detalle_extracurriculares.estado')
      ->join('detalle_extracurriculares', 'detalle_extracurriculares.actividad', '=', 'extracurriculares.id_extracurricular')
      ->join('estudiantes', 'estudiantes.matricula', '=', 'detalle_extracurriculares.matricula')
      ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
      ->where([['extracurriculares.bandera', '=' , '1'], ['extracurriculares.tutor', $id_tutor], 
	  ['detalle_extracurriculares.actividad', $id_extra], ['detalle_extracurriculares.estado', '=', 'Cursando'], 
	  ['detalle_extracurriculares.periodo', $periodo_semestre->id_periodo]])
	  ->orderBy('personas.nombre', 'asc')
      ->get();
 


      $resultado = DB::table('extracurriculares')
      ->select('extracurriculares.nombre_ec')
      ->where('extracurriculares.id_extracurricular', $id_extra)
      ->take(1)
      ->first();

return view('personal_administrativo/formacion_integral.gestion_taller_con')
->with('data', $result)->with('detalle', $resultado)->with('id_extracurricular', $id_extra);
	
}

protected function registro_colaborador($matricula){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }
    $matriculas=$matricula;
    $result = DB::table('personas')
    ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'tutores.id_tutor')
    ->join('tutores', 'personas.id_persona', '=', 'tutores.id_persona')
    ->join('nivel', 'nivel.id_nivel', '=', 'tutores.id_nivel')
    ->where([['nivel.grado_estudios', '!=', 'estudiante'], ['tutores.bandera', '=', '1']])
    ->orderBy('personas.nombre', 'asc')
    ->get();

    $datos_est = DB::table('personas')
    ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'estudiantes.matricula')
    ->join('estudiantes', 'estudiantes.id_persona', '=', 'personas.id_persona')
    ->where('estudiantes.matricula', $matriculas)
    ->take(1)
    ->first();

     $resultado = DB::table('extracurriculares')
        ->select('extracurriculares.id_extracurricular', 'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
        'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
        'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor',
        'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'extracurriculares.observaciones')
        ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
        ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
        ->join('nivel', 'nivel.id_nivel', '=', 'tutores.id_nivel')
        ->where([['extracurriculares.bandera', '=', '2'] ,  ['nivel.grado_estudios', '!=', 'estudiante']])
         ->orderBy('extracurriculares.nombre_ec', 'asc')
        ->get();

  return view('personal_administrativo/formacion_integral.colaborador')
  ->with('taller', $result)->with('uno', $matriculas)->with('extra', $resultado)->with('estudiante_da',$datos_est);
}


public function registro_hora_co(Request $request){
  $data = $request;
$periodo_semestre = DB::table('periodos')
->select('periodos.id_periodo')
->where('periodos.estatus', '=', 'actual')
->take(1)
->first();


$periodo_semestre= $periodo_semestre->id_periodo;
$busqueda = DB::table('detalle_extracurriculares')
->select('detalle_extracurriculares.actividad')
->join('estudiantes', 'estudiantes.matricula', '=', 'detalle_extracurriculares.matricula')
->where([['estudiantes.matricula', '=', $data['matricula']], ['detalle_extracurriculares.actividad', '=', $data['extra']],
      ['detalle_extracurriculares.periodo', '=', $periodo_semestre], ['detalle_extracurriculares.estado', '=', 'Acreditado']])
->take(1)
->first();


if(empty($busqueda->actividad)){
$resultado = DB::table('extracurriculares')
->select('extracurriculares.creditos')
->where([['extracurriculares.id_extracurricular', $data['extra']] , ['extracurriculares.bandera', '=', '2']])
->take(1)
->first();
$suma = ($resultado->creditos)* 2;
$inscripcion = new Detalle_extracurricular;
$inscripcion->matricula= $data['matricula'];
$inscripcion->actividad= $data['extra'];
$inscripcion->creditos= $suma;
$inscripcion->estado= 'Acreditado';
$inscripcion->periodo= $periodo_semestre;
$inscripcion->save();

  return redirect()->route('busqueda_estudiante_fi')->with('success','¡El registro de horas se ha realizado correctamente!');
}
  else {return redirect()->back()->with('error','¡El estudiante ya se encuentra registrado en la actividad!');
  }
}

public function cuenta_formacion(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
		
		  $usuario_actual=auth()->user();
	$id=$usuario_actual->id_user;
	
		  $users = DB::table('administrativos')
          ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'personas.genero', 'administrativos.puesto')
          ->join('personas', 'personas.id_persona', '=', 'administrativos.id_persona')
		  ->join('users', 'personas.id_persona', '=', 'users.id_persona')
          ->where([['administrativos.puesto','!=', ''],['users.id_persona', $id]])
          ->take(1)
          ->first();
	
    return view('personal_administrativo/formacion_integral.configuracion_cuenta_formacion')->with('datos_usuario', $users);
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
            return redirect()->route('cuenta_formacion')->with('success','Contraseña Actualizada Correctamente');
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
            return redirect()->route('cuenta_formacion')->with('success','El nombre de usuario se ha actualizado correctamente');
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
            return redirect()->route('cuenta_formacion')->with('success','El correo se ha actualizado correctamente');
          }

      }
	  
	  	   public function datos_personales_formacion(Request $request){
			   	  $usuario_actual=auth()->user();
	$id=$usuario_actual->id_user;
	$data = $request;
   DB::table('personas')
      ->where('personas.id_persona', $id)
      ->update([ 'nombre' => $data['nombre'] ,'apellido_paterno' => $data['apellido_paterno'], 'apellido_materno' => $data['apellido_materno'],
                'genero' => $data['genero']]);
          
		    DB::table('administrativos')
      ->where('administrativos.id_persona', $id)
      ->update([ 'puesto' => $data['puesto']]);
		   		  
            return redirect()->route('cuenta_formacion')->with('success','Datos actualizados correctamente');
          
      }
	  
	  	  protected function restablecimiento_talle($id_user){

  $id= $id_user;
  $nueva_con= "TALLERISTAS";
    $user_password= Hash::make($nueva_con);
    DB::table('users')
      ->where('users.id_user', $id)
      ->update(
          ['password' => $user_password]);
      return redirect()->route('tallerista_activo')->with('success','¡La contraseña se ha restablecido correctamente! Contraseña asignada: TALLERISTAS');
}

public function tutorias_encu(){
  $usuario_actuales=\Auth::user();
   if($usuario_actuales->tipo_usuario!='1'){
     return redirect()->back();
    }


  $periodo_semestre = DB::table('periodos')
  ->select('periodos.id_periodo', 'periodos.inicio', 'periodos.final')
  ->orderBy('periodos.id_periodo', 'desc')
  ->get();

      return view('personal_administrativo/formacion_integral.encuestas_estudiantes')->with('fechas_p', $periodo_semestre);
}


public function busqueda_encu(Request $request){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect('perfiles');
    }

  $q = $request;
  $users = DB::table('tutorias')
       ->where('tutorias.periodo', $q['id_periodo'])
  ->count('matricula');

     $si_t = DB::table('tutorias')
          ->where([['tutorias.periodo', $q['id_periodo']], ['tutorias.acompaniamiento_tutor', '=', '1']])
     ->count('acompaniamiento_tutor');
     $no_t = DB::table('tutorias')
          ->where([['tutorias.periodo', $q['id_periodo']], ['tutorias.acompaniamiento_tutor', '=', '0']])
     ->count('acompaniamiento_tutor');

     $des= DB::table('tutorias')
          ->where([['tutorias.periodo', $q['id_periodo']], ['tutorias.desempenio_tutor', '!=', '']])
     ->count('desempenio_tutor');

     $des_sum= DB::table('tutorias')
          ->where([['tutorias.periodo', $q['id_periodo']], ['tutorias.desempenio_tutor', '!=', '']])
     ->sum('desempenio_tutor');
     if(($des == 0) or ($des_sum == 0))
     {
       $promedio= 0;
     }else {
       $promedio = $des_sum / $des;
     }

     $a_aca= DB::table('tutorias')
          ->where([['tutorias.periodo', $q['id_periodo']], ['tutorias.area_academico', '!=', '']])
     ->count('area_academico');


     $periodo_semestre = DB::table('periodos')
     ->select('periodos.id_periodo', 'periodos.inicio', 'periodos.final')
     ->orderBy('periodos.id_periodo', 'desc')
     ->get();

     $periodo_semestre_se = DB::table('periodos')
     ->select('periodos.id_periodo', 'periodos.inicio', 'periodos.final')
     ->where('periodos.id_periodo', $q['id_periodo'])
     ->take(1)
     ->first();

     $a_emo= DB::table('tutorias')
          ->where([['tutorias.periodo', $q['id_periodo']], ['tutorias.area_emocional', '!=', '']])
     ->count('area_emocional');
     $a_salud= DB::table('tutorias')
          ->where([['tutorias.periodo', $q['id_periodo']], ['tutorias.area_salud', '!=', '']])
     ->count('area_salud');
     $a_valor= DB::table('tutorias')
          ->where([['tutorias.periodo', $q['id_periodo']], ['tutorias.area_valores', '!=', '']])
     ->count('area_valores');
     $a_relac= DB::table('tutorias')
          ->where([['tutorias.periodo', $q['id_periodo']], ['tutorias.area_relaciones', '!=', '']])
     ->count('area_relaciones');

     $datos_es = DB::table('tutorias')
     ->select('tutorias.acompaniamiento_tutor', 'tutorias.desempenio_tutor', 'tutorias.area_academico', 'tutorias.area_emocional',
     'tutorias.area_salud', 'tutorias.area_valores', 'tutorias.area_relaciones')
     ->where('tutorias.periodo', $q['id_periodo'])
     ->get();


  return view ( 'personal_administrativo/formacion_integral.encuestas_estudiantes' )
  ->withDetails ($users)->with('fechas_p', $periodo_semestre)->with('si_tu', $si_t)
  ->with('no_tu', $no_t)->with('dese', $promedio)
  ->with('otro_p', $periodo_semestre_se)->with('voto_a', $a_aca)
  ->with('voto_e', $a_emo)->with('voto_s', $a_salud)->with('voto_v', $a_valor)
  ->with('voto_r', $a_relac)->with('datos_encuesta', $datos_es);
}

protected function actualizar_fechas_encuesta(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='1'){
     return redirect()->back();
    }

    
      $fecha_inicio = DB::table('periodo_actualizacion')
      ->select('periodo_actualizacion.estado')
      ->where('periodo_actualizacion.tipo', '=', 'encuesta')
      ->take(1)
      ->first();

    
    return view('personal_administrativo/formacion_integral.fecha_encuestas')->with('estatus_t', $fecha_inicio);
}

protected function fecha_encuesta(Request $request){
  $data = $request;
  $id_clave = DB::table('periodo_actualizacion')
  ->select('periodo_actualizacion.id_actualizacion')
  ->where('periodo_actualizacion.tipo', 'encuesta')
  ->take(1)
  ->first();

  if(empty($id_clave)){
    $nueva_ac = new FechaActualizacion;
    $nueva_ac->tipo='encuesta';
    $nueva_ac->save();

    if($nueva_ac->save()){
      return redirect()->route('fecha_solicitud')->with('success','¡Fechas agregadas Correctamente!');
    }
  }
  else {
    $id_clave = $id_clave->id_actualizacion;
    DB::table('periodo_actualizacion')
        //->where('periodo_actualizacion.id_actualizacion', $id_clave)
        ->where([['periodo_actualizacion.id_actualizacion', $id_clave], ['periodo_actualizacion.tipo', '=', 'encuesta']])
        ->update(['estado' => $data['estado']]);
        return redirect()->route('fecha_encuesta')->with('success','¡Periodo actualizado Correctamente!');
  }
}



}
