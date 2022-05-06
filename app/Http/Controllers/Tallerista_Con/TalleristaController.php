<?php

namespace App\Http\Controllers\Tallerista_Con;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
use Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class TalleristaController extends Controller
{
  public function logintallerista(){

      return view('tallerista.login_tallerista');
  }

  public function home_tallerista(){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='tallerista'){
       return redirect()->back();
      }
return view('tallerista.home_tallerista');
}

public function talleres_tallerista(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='tallerista'){
     return redirect()->back();
    }
    $id=$usuario_actual->id_user;
    $periodo_semestre = DB::table('periodos')
    ->select('periodos.id_periodo')
    ->where('periodos.estatus', '=', 'actual')
    ->take(1)
    ->first();

  $id_tutores = DB::table('tutores')
  ->select('tutores.id_tutor')
  ->join('personas', 'personas.id_persona', '=' ,'tutores.id_persona')
  ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
  ->where('users.id_user', $id)
  ->take(1)
  ->first();

  $result = DB::table('extracurriculares')
  ->select('extracurriculares.id_extracurricular', 'extracurriculares.bandera', 'extracurriculares.dias_sem',
  'extracurriculares.nombre_ec', 'extracurriculares.tipo', 'extracurriculares.creditos', 'extracurriculares.area',
  'extracurriculares.control_cupo', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio','extracurriculares.fecha_fin',
   'extracurriculares.hora_inicio', 'extracurriculares.hora_fin', 'tutores.id_tutor', 'personas.nombre',
   'personas.apellido_paterno', 'personas.apellido_materno', 'extracurriculares.cupo', 'extracurriculares.lugar')
  ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
  ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
  ->where([['extracurriculares.tipo', '=', 'Taller'], ['extracurriculares.bandera', '=', '1'], ['tutores.id_tutor', $id_tutores->id_tutor], ['extracurriculares.periodo', $periodo_semestre->id_periodo]])
  ->orderBy('extracurriculares.created_at', 'asc')
  ->simplePaginate(10);

return view('tallerista.talleres_tallerista')->with('dato', $result);
}

public function talleres_finalizados(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='tallerista'){
     return redirect()->back();
    }
   $id=$usuario_actual->id_user;
    $id_tutores = DB::table('tutores')
    ->select('tutores.id_tutor')
    ->join('personas', 'personas.id_persona', '=' ,'tutores.id_persona')
    ->join('users', 'users.id_persona', '=' ,'personas.id_persona')
    ->where('users.id_user', $id)
    ->take(1)
    ->first();
    $result = DB::table('extracurriculares')
    ->select('extracurriculares.id_extracurricular',  'extracurriculares.dias_sem', 'extracurriculares.nombre_ec', 'extracurriculares.tipo',
    'extracurriculares.creditos', 'extracurriculares.area', 'extracurriculares.control_cupo', 'extracurriculares.modalidad', 'extracurriculares.fecha_inicio',
    'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio', 'extracurriculares.observaciones', 'extracurriculares.hora_fin', 'tutores.id_tutor')
    ->join('tutores', 'extracurriculares.tutor', '=', 'tutores.id_tutor')
    ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
    ->where([['extracurriculares.bandera', '=', '2'], ['tutores.id_tutor', $id_tutores->id_tutor]])
     ->simplePaginate(10);
return view('tallerista.talleres_finalizados')->with('dato', $result);
}


public function grupo_tallerista(){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='tallerista'){
     return redirect()->back();
    }
return view('tallerista.grupo_tallerista');
}


function prueba_grupo($id_extracurricular){
  $usuario_actual=\Auth::user();
   if($usuario_actual->tipo_usuario!='tallerista'){
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
  return view('tallerista.finaliza_taller_tallerista')->with('dato', $data)->with('datos', $result);

}

public function finalizar_taller_t(Request $request){
$data= $request;

}

public function ver_estudiante(){
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
    ->select('periodos.id_periodo')
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
    ->where([['extracurriculares.bandera', '=' , '1'], ['extracurriculares.tutor', $id_tutores->id_tutor], ['detalle_extracurriculares.actividad', $id_extra], ['detalle_extracurriculares.estado', '=', 'Cursando'], ['detalle_extracurriculares.periodo', $periodo_semestre->id_periodo], ['telefonos.tipo', '=', 'celular']])
    ->get();

    $datos_extra = DB::table('extracurriculares')
    ->select('extracurriculares.nombre_ec', 'extracurriculares.fecha_inicio', 'extracurriculares.fecha_fin', 'extracurriculares.hora_inicio',
              'extracurriculares.hora_fin', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
    ->join('tutores', 'tutores.id_tutor', '=', 'extracurriculares.tutor')
    ->join('personas', 'personas.id_persona', '=', 'tutores.id_persona')
    ->where([['extracurriculares.bandera', '=' , '1'], ['extracurriculares.tutor', $id_tutores->id_tutor], ['extracurriculares.id_extracurricular', $id_extra], ['extracurriculares.periodo', $periodo_semestre->id_periodo]])
    ->take(1)
    ->first();
}

public function cuenta_tallerista(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='tallerista'){
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
	
	
    return view('tallerista.configuracion_cuenta_tallerista')->with('datos_usuario', $users);
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
            return redirect()->route('cuenta_tallerista')->with('success','Contraseña Actualizada Correctamente');
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
            return redirect()->route('cuenta_tallerista')->with('success','El nombre de usuario se ha actualizado correctamente');
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
            return redirect()->route('cuenta_tallerista')->with('success','El correo se ha actualizado correctamente');
          }

      }
	  
	  	   public function datos_personales_tallerista(Request $request){
			   	  $usuario_actual=auth()->user();
	$id=$usuario_actual->id_user;
	$data = $request;
   DB::table('personas')
      ->where('personas.id_persona', $id)
      ->update([ 'nombre' => $data['nombre'] ,'apellido_paterno' => $data['apellido_paterno'], 'apellido_materno' => $data['apellido_materno'],
                'genero' => $data['genero']]);
          
            return redirect()->route('cuenta_tallerista')->with('success','Datos actualizados correctamente');
          
      }
	  

}
