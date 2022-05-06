<?php

namespace App\Http\Controllers;
use App\User;
use App\Estudiante;
use App\Persona;
use Illuminate\Support\Facades\DB;
use Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
//use Excel;

class UserSystemController extends Controller
{
    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */
    public function index()
    {
        //$users = DB::table('users')->simplePaginate(7);
        $users = DB::table('users')
        ->where([['tipo_usuario', '=', 'tallerista'], ['bandera', '=', '1'],])
        ->simplePaginate(7 );

        return view('personal_administrativo/formacion_integral/gestion_tallerista.read', ['users' => $users]);

    }

    public function form_nuevo_usuario()
	{
		return view('personal_administrativo/formacion_integral/gestion_tallerista.create');
	}

    public function agregar_nuevo_usuario(Request $request)
	{
    $this->validate($request, [
      'id_user' => ['required', 'string', 'max:13', 'unique:users'],
      'username' => ['required', 'string', 'max:255', 'unique:users'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
      'tipo_usuario' => ['required', 'string', 'max:255'],
      'id_persona' => ['required', 'string', 'max:255'],

    ]);

    $data = $request;


    $user=new User;
    $user->id_user=$data['id'];
    $user->username=$data['name'];
    $user->email=$data['email'];
    $user->password=Hash::make($data['password']);
    $user->tipo_usuario=$data['tipo_usuario'];
    $user->id_persona='';


    if($user->save()){
      return redirect()->route('registros_talleristas')->with('success','Usuario Creado Correctamente');
    }

	}


  public function cargar_datos_usuario_estudiante(){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='4'){
       return redirect()->back();
      }
     return view('personal_administrativo/auxiliar_administrativo.carga_de_datos');

}


public function axcel(Request $request)
{
  $request->validate([
      'archivo' => 'required'
  ]);

   $archivo = $request->file('archivo');
   $nombre_original=$archivo->getClientOriginalName();
 $extension=$archivo->getClientOriginalExtension();
   $r1=Storage::disk('archivos')->put($nombre_original,  \File::get($archivo) );
   $ruta  =  storage_path('archivos') ."/". $nombre_original;

    $usuario='';
   Excel::load($ruta ,function($reader){
   $reader->get();
     // iteracción
     $reader->each(function($row) {
       if(($row->matricula)!=null){
       $usuario=User::find($row->matricula);
       $contador=0;
        // id_persona,nombre,apellido_paterno,apellido_materno,genero,modalidad,semestre,estatus,sede,email
       if(empty($usuario)){
         $periodo_semestre = DB::table('periodos')
         ->select('periodos.id_periodo')
         ->where('periodos.estatus', '=', 'actual')
         ->take(1)
         ->first();
        $periodo_semestre= $periodo_semestre->id_periodo;
       $id_for_all=$row->matricula;
       $name=$row->nombre;
       $user = new Persona;
       $user->id_persona = $id_for_all;
       $user->nombre = $name;
       $user->apellido_paterno = $row->apellido_paterno;
       $user->apellido_materno = $row->apellido_materno;
       $user->genero = $row->genero;
       $user->periodo = $periodo_semestre;
       $user->save();

       $estudiante = new Estudiante;
       $estudiante->matricula = $id_for_all;
       $estudiante->modalidad = $row->modalidad;
       $estudiante->semestre = $row->semestre;
       $estudiante->estatus = $row->estatus;
       $estudiante->id_persona = $id_for_all;
       $estudiante->sede = 'CU';
       $estudiante->periodo = $periodo_semestre;
       $estudiante->save();

       $usuario=new User;
       $usuario->id_user= $id_for_all;
       $usuario->username= $id_for_all;
       $usuario->email= $row->email;
       $usuario->password= Hash::make($id_for_all);
       $usuario->tipo_usuario= 'estudiante';
       $usuario->id_persona = $id_for_all;
       $usuario->periodo = $periodo_semestre;
       $usuario->save();
     }
     }
     });
 });
            return redirect()->route('registros_estudiantes_dia')->with('success','Carga de datos exitosa');
}


  public function creados_hoy(){
      //$usu=0;
     return view('personal_administrativo/auxiliar_administrativo.creados');

}

}
