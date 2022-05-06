<?php
namespace App\Http\Controllers;
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
use App\Periodo;
use App\FechaActualizacion;
use App\SolicitudTaller;
use Illuminate\Support\Facades\DB;
use Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


class RegistrosController extends Controller
{
  protected function ver(){
    $dep = DB::table('departamentos')
    ->select('departamentos.id_departamento', 'departamentos.departamento')
    ->get();
            //  return view('errores.intentosfallidos');
      return view('super_admin.registros_externos')->with('de', $dep);
  }

    public function create(Request $request){
      $this->validate($request, [
        'nombre' => ['required', 'string', 'max:25'],
        'apellido_paterno' => ['required', 'string', 'max:25'],
      //  'curp' => ['required', 'string', 'min:18','max:18'],
      //  'edad' => ['required', 'string', 'max:70'],
      //  'genero' => ['required', 'string'],
       'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      ]);

      $ultima = DB::table('personas')
         ->sum('personas.id_persona');
         if(empty($ultima)){
           $ultima=1;
         }
         else {
           $ultima=$ultima+1;
         }
      $data = $request;
      $id_prueba= $ultima;
    //  $password= $data['apellido_paterno'];
      $persona=new Persona;
      $persona->id_persona=$id_prueba;
      $persona->nombre=$data['nombre'];
      $persona->apellido_paterno=$data['apellido_paterno'];
      $persona->apellido_materno=$data['apellido_materno'];
//$persona->curp=$data['curp'];
  //    $persona->fecha_nacimiento=$data['fecha_nacimiento'];
    //  $persona->edad=$data['edad'];
    //  $persona->genero=$data['genero'];
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
          $depto_admin->save();

            if($depto_admin->save()){
              $nivel = new Nivel();
              $nivel ->id_administrativo= $bus_adm;
              $nivel ->grado_estudios=$data['grado_estudios'];
              $nivel ->rfc=$data['curp'];
              $nivel ->save();

            if($nivel->save()){
          $user=new User;
          $user->id_user=$id_prueba;
          $user->username=$data['username'];
          $user->email=$data['email'];
          $user->password = Hash::make($data['password']);
          $user->tipo_usuario=$data['departamento'];
          $user->id_persona=$id_prueba;
          $user->save();
            if($user->save()){
          return redirect()->route('registro_externo')->with('success','¡Datos registrados correctamente!');
        }else{
         return redirect()->route('registro_externo')->with('error','error en la creacion');
        }
      }}}}

    }


    function prueba($id_extracurricular){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
      $data= $id_extracurricular;

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
      return view('personal_administrativo/formacion_integral/gestion_talleres.finalizar_taller_admin')->with('dato', $data)->with('datos', $result);

    }

    public function finalizar_t(Request $request){
    $data= $request;


    }

    function desactivar_actividad_estudiante($id_extracurricular){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
      $data= $id_extracurricular;

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
      return view('personal_administrativo/formacion_integral/gestion_talleres.desactivar_extra_estudiante')->with('dato', $data)->with('datos', $result);

    }

    function desactivar_actividad_tallerista($id_extracurricular){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='1'){
         return redirect()->back();
        }
      $data= $id_extracurricular;
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
      return view('personal_administrativo/formacion_integral/gestion_talleres.finalizar_taller_admin')->with('dato', $data)->with('datos', $result);

    }


}
