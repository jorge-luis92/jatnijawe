<?php

namespace App\Http\Controllers\Administrativo_Con;
use App\User;
use App\Estudiante;
use App\Persona;
use App\Administrativo;
use App\Nivel;
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

class AdministrativoController extends Controller
{

  /**
   *
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
   public function __construct()
   {
       $this->middleware('guest')->except('logout');

   }

   public function username()
   {
       return 'username';
   }
   public function logout(Request $request)
   {
     $this->guard()->logout();

     $request->session()->invalidate();

     return $this->loggedOut($request) ?: redirect('perfiles');
   }

   public function admin_inicio(){
     $usuario_actual=auth()->user();
      if($usuario_actual->tipo_usuario!='5'){
       return redirect()->back();
     }
        return view('personal_administrativo/admin_sistema.home_admin');
   }
    public function login_admin(){
        return view('personal_administrativo.login_personal');
    }

    public function auxiliar(){
      $usuario_actuales=\Auth::user();
       if($usuario_actuales->tipo_usuario!='4'){
         return redirect()->back();
        }
      return view('personal_administrativo/auxiliar_administrativo.gestion_estudiante');
    }

    public function auxiliar_carga(){
      $usuario_actuales=\Auth::user();
       if($usuario_actuales->tipo_usuario!='4'){
         return redirect()->back();
        }
      return view('personal_administrativo/auxiliar_administrativo.carga_de_datos');
    }

    public function formacion_busqueda(){
      $usuario_actuales=\Auth::user();
       if($usuario_actuales->tipo_usuario!='1'){
         return redirect()->back();
        }
      return view('personal_administrativo/formacion_integral.home_formacion');
    }

    public function home_auxiliar_adm(){
      $usuario_actual=auth()->user();
       if($usuario_actual->tipo_usuario!='4'){
        return redirect()->back();
      }
    return view('personal_administrativo/auxiliar_administrativo.home_auxiliar_adm');
  }

  public function home_formacion(){
    $usuario_actuales=\Auth::user();
     if($usuario_actuales->tipo_usuario!='1'){
       return redirect()->back();
      }
  return view('personal_administrativo/formacion_integral.home_formacion');
}

  public function carga_de_datos(){
    $usuario_actuales=\Auth::user();
     if($usuario_actuales->tipo_usuario!='4'){
       return redirect()->back();
      }
    return view('personal_administrativo/auxiliar_administrativo.carga_de_datos');
  }

  public function gestion_estudiante(){
    $usuario_actuales=\Auth::user();
     if($usuario_actuales->tipo_usuario!='4'){
       return redirect()->back();
      }
    return view('personal_administrativo/auxiliar_administrativo.gestion_estudiante');
    }

  public function grupo_auxadm(){
    $usuario_actuales=\Auth::user();
     if($usuario_actuales->tipo_usuario!='4'){
       return redirect()->back();
      }
  return view('personal_administrativo/auxiliar_administrativo.grupo_auxadm');
      }

  public function datos_estudiantes(){
    $usuario_actuales=\Auth::user();
     if($usuario_actuales->tipo_usuario!='4'){
       return redirect()->back();
      }
  return view('personal_administrativo/auxiliar_administrativo.datos_estudiantes');
        }

        public function registro_estudiante_aux(){
          $usuario_actuales=\Auth::user();
           if($usuario_actuales->tipo_usuario!='4'){
             return redirect()->back();
            }
  return view('personal_administrativo/auxiliar_administrativo.registro_estudiante_aux');
    }

  public function busqueda_estudiante_aux(){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='4'){
       return redirect()->back();
      }
  return view('personal_administrativo/auxiliar_administrativo.busqueda_estudiante_aux');
    }

  public function estudiante_activo_aux(){
    $usuario_actuales=\Auth::user();
     if($usuario_actuales->tipo_usuario!='4'){
       return redirect()->back();
      }
  return view('personal_administrativo/auxiliar_administrativo.estudiante_activo_aux');
    }
    public function carga_hoy(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='4'){
         return redirect()->back();
        }
        $now = new \DateTime();
        $est = DB::table('estudiantes')
        ->select('estudiantes.matricula', 'estudiantes.semestre', 'estudiantes.modalidad', 'personas.nombre', 'personas.apellido_paterno', 
		'personas.apellido_materno', 'users.id_user', 'users.bandera', 'personas.genero', 'users.created_at', 'estudiantes.sede')
        ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
        ->join('users', 'users.id_persona', '=', 'personas.id_persona')
        ->where('users.bandera', '=', '1')
        ->whereDate('users.created_at', $now)
         ->orderBy('users.created_at', 'desc')
        ->simplePaginate(20);
    return view('personal_administrativo/auxiliar_administrativo.creados')->with('estudiante', $est);
      }

  public function estudiante_inactivo_aux(){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='4'){
       return redirect()->back();
      }
    $est = DB::table('estudiantes')
    ->select('estudiantes.matricula', 'estudiantes.semestre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'users.id_user', 'users.bandera')
    ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
    ->join('users', 'users.id_persona', '=', 'personas.id_persona')
    ->where('users.bandera', '=', '0')
     ->orderBy('estudiantes.semestre', 'asc')
    ->simplePaginate(10);

  return view('personal_administrativo/auxiliar_administrativo.estudiante_inactivo_aux')->with('estudiante', $est);
    }
	
	
	  public function carga_hoy_admin(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='5'){
         return redirect()->back();
        }
        $now = new \DateTime();
        $est = DB::table('estudiantes')
        ->select('estudiantes.matricula', 'estudiantes.semestre', 'estudiantes.modalidad', 'personas.nombre', 'personas.apellido_paterno', 
		'personas.apellido_materno', 'users.id_user', 'users.bandera', 'personas.genero', 'users.created_at', 'estudiantes.sede')
        ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
        ->join('users', 'users.id_persona', '=', 'personas.id_persona')
        ->where('users.bandera', '=', '1')
        ->whereDate('users.created_at', $now)
         ->orderBy('users.created_at', 'desc')
        ->simplePaginate(20);
    return view('personal_administrativo/admin_sistema.creados')->with('estudiante', $est);
      }
}
