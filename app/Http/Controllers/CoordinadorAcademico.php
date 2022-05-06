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
use PDF;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Extracurricular;
use App\Detalle_extracurricular;
use App\Telefono;
use App\Tutor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CoordinadorAcademico extends Controller
{
	
    protected function ver_futuros_egresados(){

      $usuario_actuales=\Auth::user();
       if($usuario_actuales->tipo_usuario!='4'){
         return redirect()->back();
        }
      $usuario_actual=auth()->user();
      $id=$usuario_actual->id_user;

      $est = DB::table('estudiantes')
      ->select('estudiantes.matricula', 'estudiantes.semestre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno', 'personas.genero', 'users.id_user', 'users.bandera')
      ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
      ->join('users', 'users.id_persona', '=', 'personas.id_persona')
      ->where([['estudiantes.egresado', '=', '0'], ['estudiantes.semestre', '=', '8'], ['estudiantes.sede', '=', 'CU']])
       ->orderBy('personas.nombre', 'asc')
      ->simplePaginate(10);

      return view('personal_administrativo/auxiliar_administrativo.futuros_egresados')->with('estudiante', $est);
    }

    protected function egresados_estudiantes(){

      $usuario_actuales=\Auth::user();
       if($usuario_actuales->tipo_usuario!='4'){
         return redirect()->back();
        }
      $usuario_actual=auth()->user();
      $id=$usuario_actual->id_user;

      $est = DB::table('estudiantes')
      ->select('estudiantes.matricula', 'estudiantes.semestre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno',  'personas.genero', 'users.id_user', 'users.bandera')
      ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
      ->join('users', 'users.id_persona', '=', 'personas.id_persona')
      ->where([['estudiantes.egresado', '=', '1'], ['users.bandera', '=', '1']])
      ->orderBy('personas.nombre', 'asc')
      ->simplePaginate(10);

      return view('personal_administrativo/auxiliar_administrativo.egresados_estudiantes_idiomas')->with('estudiante', $est);
    }


    public function cambiar_estudiante($matricula){
      $usuario_actuales=\Auth::user();
       if($usuario_actuales->tipo_usuario!='4'){
         return redirect()->back();
        }
      $usuario_actual=auth()->user();
      $id=$usuario_actual->id_user;

      $estudiante= $matricula;

      DB::table('estudiantes')
          ->where('estudiantes.matricula', $estudiante)
          ->update(['egresado' => '1']);
          return redirect()->route('estudiantes_egresados')->with('success','¡El Estudiante ha sido activado como Egresado!');

  }
  
    public function editar_estudiante_aca($matricula){
		$usuario_actuales=\Auth::user();
       if($usuario_actuales->tipo_usuario!='4'){
         return redirect()->back();
        }
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
   return view('personal_administrativo/auxiliar_administrativo.editar_estudiante')->with('users', $datos)->with('emails', $ema);
    }

  public function editar_estudiante(Request $request){
    $data = $request;

    $matricula = DB::table('estudiantes')
    ->select('estudiantes.id_persona')
    ->where('estudiantes.matricula',$data['matricula'])
    ->take(1)
    ->first();
  $matricula= json_decode( json_encode($matricula), true);
    DB::table('personas')
        ->where('personas.id_persona', '=', $matricula)
        ->update([ 'nombre' => $data['nombre'] ,'apellido_paterno' => $data['apellido_paterno'], 'apellido_materno' => $data['apellido_materno'],
                  'curp' => $data['curp'] , 'fecha_nacimiento' => $data['fecha_nacimiento'], 'lugar_nacimiento' => $data['lugar_nacimiento'],
                  'tipo_sangre' => $data['tipo_sangre'], 'edad' => $data['edad'],'genero' => $data['genero']]);

      DB::table('estudiantes')
          ->where('estudiantes.matricula', '=' , $data['matricula'])
          ->update(['modalidad' => $data['modalidad'], 'fecha_ingreso' => $data['fecha_ingreso'], 'semestre' => $data['semestre'], 'grupo' => $data['grupo'],
                    'estatus' => $data['estatus'], 'bachillerato_origen' => $data['bachillerato_origen']]);

        DB::table('users')
          ->where('users.id_user',  $data['matricula'])
          ->update(['email' => $data['email']]);


        return redirect()->route('busqueda_estudiante_aux')->with('success','¡Datos actualizados correctamente!');

  }

  public function generar($matricula)
  {
	  
    $usuario_actual=auth()->user();
     if($usuario_actual->tipo_usuario!='4'){
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
           'users.facebook', 'personas.tipo_sangre', 'users.email', 'users.imagenurl' )
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

  public function busqueda_egresado(Request $request){
    $usuario_actual=\Auth::user();
     if($usuario_actual->tipo_usuario!='4'){
       return redirect()->back();
      }
    $q = $request->get('q');
    if($q != null){
    $user = Estudiante::select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno',
     'personas.genero', 'estudiantes.matricula', 'estudiantes.semestre')
    ->where( 'estudiantes.matricula', 'LIKE', '%' . $q . '%' )
                        ->where([['estudiantes.semestre', '=', '8'], ['estudiantes.egresado', '=', '0']])
                        ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
                        ->simplePaginate(10);
                        $est = DB::table('users')
                        ->where('users.bandera', '=', '1')
                        ->get();


  if ((count ($user) > 0 ) && ($est != null )){
	   $est = DB::table('estudiantes')
      ->select('estudiantes.matricula', 'estudiantes.semestre', 'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno',  'personas.genero', 'users.id_user', 'users.bandera')
      ->join('personas', 'estudiantes.id_persona', '=', 'personas.id_persona')
      ->join('users', 'users.id_persona', '=', 'personas.id_persona')
      ->where([['estudiantes.egresado', '=', '0'], ['users.bandera', '=', '1']])
      ->orderBy('personas.nombre', 'asc')
      ->simplePaginate(10);

        return view ( 'personal_administrativo/auxiliar_administrativo.futuros_egresados' )->withDetails ($user )->withQuery ($q)->with('estudiante', $est);
}
else{
return redirect()->route('futuros_egresados')->with('error','¡Sin resultados!');
}}  else{
    return redirect()->route('futuros_egresados')->with('error','¡Sin resultados!');
}

}

public function cuenta_academica(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='4'){
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
	
	
    return view('personal_administrativo/auxiliar_administrativo.configuracion_cuenta_academica')->with('datos_usuario', $users);
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
            return redirect()->route('cuenta_academica')->with('success','Contraseña Actualizada Correctamente');
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
            return redirect()->route('cuenta_academica')->with('success','El nombre de usuario se ha actualizado correctamente');
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
            return redirect()->route('cuenta_academica')->with('success','El correo se ha actualizado correctamente');
          }

      }
	  
	  	   public function datos_personales_academica(Request $request){
			   	  $usuario_actual=auth()->user();
	$id=$usuario_actual->id_user;
	$data = $request;
   DB::table('personas')
      ->where('personas.id_persona', $id)
      ->update([ 'nombre' => $data['nombre'] ,'apellido_paterno' => $data['apellido_paterno'], 'apellido_materno' => $data['apellido_materno'],
                'genero' => $data['genero']]);
          
            return redirect()->route('cuenta_academica')->with('success','Datos actualizados correctamente');
          

      }

//------------INFO COORD ACADEMICA ESCO --------------------------------------//
public function info_coord_academica_1E(){
/*ESTUDIANTES INSCRITOS EN EL CICLO ESCOLAR ACTUAL*/
/*MODALIDAD ESCOLARIZADA*/
//---------------------------------------------------------------------/*CU*/
/*MASCULINO*/
$actualM_E=DB::select
('SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="M"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="CU"
    GROUP BY personas.genero');
    $totalactualM_E=$actualM_E[0]->total;

/*FEMENINO*/
$actualF_E=DB::select
('SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="F"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="CU"
    GROUP BY personas.genero');
    $totalactualF_E=$actualF_E[0]->total;

/*TOTAL*/
$actualT_E=DB::select
('SELECT SUM(total) as tot
  FROM (SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="CU"
    GROUP BY personas.genero) AS T');
    $totalactualT_E=$actualT_E[0]->tot;

/*CON DISCAPACIDAD*/
$discapacidadesCU_E=DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.modalidad="ESCOLARIZADA"
AND estudiantes.sede="CU"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$discapacidadesTCU_E=$discapacidadesCU_E[0]->tot;

/*HABLANTE DE LENGUA*/
$conteo_lengua_E = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.lengua', '=', '1'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU']])
->count();

return view('personal_administrativo/auxiliar_administrativo/planeacionesco/info_coord_academica1e.info_coord_academica_1e')
//------------------------------------------------------------------MODALIDAD ESCOLARIZADA
  //--------------------------------------------------------------------------------------CU
  ->with('totalactualM_E', $totalactualM_E)
  ->with('totalactualF_E', $totalactualF_E)
  ->with('totalactualT_E', $totalactualT_E)
  ->with('discapacidadesTCU_E', $discapacidadesTCU_E)
  ->with('conteo_lengua_E', $conteo_lengua_E)
   ;
  }

  public function info_coord_academica_2E(){
/*---------------------------------------------------------------------------------------*/
//--------------------ESTUDIANTES BECADOS DEL CICLO ESCOLAR ACTUAL CU
//----------MODALIDAD ESCOLARIZADA

  //MASCULINO
    $sql_BECA_ESC= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC
    FROM personas, estudiantes, becas
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="M"
    AND estudiantes.matricula=becas.matricula
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="CU"
    AND becas.tipo_beca IS NOT NULL
    AND becas.bandera="1"
    GROUP BY becas.tipo_beca';
   $beca_query = DB::select($sql_BECA_ESC);
   $array_becas = array(
     "INSTITUCIONAL" => 0,
     "FEDERAL" => 0,
     "ESTATAL" => 0,
     "MUNICIPAL" => 0,
     "PARTICULAR" => 0,
     "INTERNACIONAL" => 0,
     "TOTAL" => 0
   );
   $tipos_becas_ESC_M = array(
     "INSTITUCIONAL" => 0,
     "FEDERAL" => 0,
     "ESTATAL" => 0,
     "MUNICIPAL" => 0,
     "PARTICULAR" => 0,
     "INTERNACIONAL" => 0,
     "TOTAL" => 0
   );

    for($i = 0; $i < count($beca_query); $i++) {
      $sub = $beca_query[$i]->total_BECA_ESC;
      $tipos_becas_ESC_M[$beca_query[$i]->tipo_beca] = $sub;
      $tipos_becas_ESC_M['TOTAL'] += $sub;
      $array_becas[$beca_query[$i]->tipo_beca] += $sub;
      $array_becas['TOTAL'] += $sub;
    }

    //FEMENINO
      $sql_BECA_ESC= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC
      FROM personas, estudiantes, becas
      WHERE personas.id_persona=estudiantes.id_persona
      AND personas.genero="F"
      AND estudiantes.matricula=becas.matricula
      AND estudiantes.modalidad="ESCOLARIZADA"
      AND estudiantes.sede="CU"
      AND becas.tipo_beca IS NOT NULL
      AND becas.bandera="1"
      GROUP BY becas.tipo_beca';
     $beca_query = DB::select($sql_BECA_ESC);

     $tipos_becas_ESC_F = array(
       "INSTITUCIONAL" => 0,
       "FEDERAL" => 0,
       "ESTATAL" => 0,
       "MUNICIPAL" => 0,
       "PARTICULAR" => 0,
       "INTERNACIONAL" => 0,
       "TOTAL" => 0
     );

      for($i = 0; $i < count($beca_query); $i++) {
        $sub = $beca_query[$i]->total_BECA_ESC;
        $tipos_becas_ESC_F[$beca_query[$i]->tipo_beca] = $sub;
        $tipos_becas_ESC_F['TOTAL'] += $sub;
        $array_becas[$beca_query[$i]->tipo_beca] += $sub;
        $array_becas['TOTAL'] += $sub;
      }

      //GENERAL
        $sql_BECA_ESC= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC
        FROM personas, estudiantes, becas
        WHERE personas.id_persona=estudiantes.id_persona
        AND estudiantes.matricula=becas.matricula
        AND estudiantes.modalidad="ESCOLARIZADA"
        AND estudiantes.sede="CU"
        AND becas.tipo_beca IS NOT NULL
        AND becas.bandera="1"
        GROUP BY becas.tipo_beca';
       $beca_query = DB::select($sql_BECA_ESC);

       $tipos_becas_ESC_G = array(
         "INSTITUCIONAL" => 0,
         "FEDERAL" => 0,
         "ESTATAL" => 0,
         "MUNICIPAL" => 0,
         "PARTICULAR" => 0,
         "INTERNACIONAL" => 0,
         "TOTAL" => 0
       );

        for($i = 0; $i < count($beca_query); $i++) {
          $sub = $beca_query[$i]->total_BECA_ESC;
          $tipos_becas_ESC_G[$beca_query[$i]->tipo_beca] = $sub;
          $tipos_becas_ESC_G['TOTAL'] += $sub;
          $array_becas[$beca_query[$i]->tipo_beca] += $sub;
          $array_becas['TOTAL'] += $sub;
        }

    //------CON DISCAPACIDAD
        $sql_BECA_ESC_D= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC_D
                  FROM personas, estudiantes, discapacidades, becas
                  WHERE personas.id_persona=estudiantes.id_persona
                  AND personas.id_persona=discapacidades.id_persona
                  AND estudiantes.sede="CU"
                  AND estudiantes.modalidad="ESCOLARIZADA"
                  AND estudiantes.matricula=becas.matricula
                  AND discapacidades.tipo IS NOT NULL
                  AND becas.tipo_beca IS NOT NULL
                  AND becas.bandera="1"
                  GROUP BY becas.tipo_beca';
       $beca_query = DB::select($sql_BECA_ESC_D);
       $tipos_becas_esco_D = array(
         "INSTITUCIONAL" => 0,
         "FEDERAL" => 0,
         "ESTATAL" => 0,
         "MUNICIPAL" => 0,
         "PARTICULAR" => 0,
         "INTERNACIONAL" => 0,
         "TOTAL" => 0
       );

        for($i = 0; $i < count($beca_query); $i++) {
          $sub = $beca_query[$i]->total_BECA_ESC_D;
          $tipos_becas_esco_D[$beca_query[$i]->tipo_beca] = $sub;
          $tipos_becas_esco_D['TOTAL'] += $sub;
          $array_becas[$beca_query[$i]->tipo_beca] += $sub;
          $array_becas['TOTAL'] += $sub;
        }

        //------HABLANTE DE LENGUA
        $sql_BECA_ESC_L= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC_L
        FROM personas
        INNER JOIN estudiantes
        on estudiantes.id_persona=personas.id_persona
        INNER JOIN becas
        ON becas.matricula=estudiantes.matricula
        WHERE personas.lengua=1
        AND estudiantes.modalidad="ESCOLARIZADA"
        AND estudiantes.sede="CU"
        AND becas.tipo_beca IS NOT NULL
        AND becas.bandera="1"
        GROUP BY becas.tipo_beca';
       $beca_query = DB::select($sql_BECA_ESC_L);

       $tipos_becas_esco_L = array(
         "INSTITUCIONAL" => 0,
         "FEDERAL" => 0,
         "ESTATAL" => 0,
         "MUNICIPAL" => 0,
         "PARTICULAR" => 0,
         "INTERNACIONAL" => 0,
         "TOTAL" => 0
       );

        for($i = 0; $i < count($beca_query); $i++) {
          $sub = $beca_query[$i]->total_BECA_ESC_L;
          $tipos_becas_esco_L[$beca_query[$i]->tipo_beca] = $sub;
          $tipos_becas_esco_L['TOTAL'] += $sub;
          $array_becas[$beca_query[$i]->tipo_beca] += $sub;
          $array_becas['TOTAL'] += $sub;
        }

/*---------------------------------------------------------------------------------------*/
    return view('personal_administrativo/auxiliar_administrativo/planeacionesco/info_coord_academica1e.info_coord_academica_2e')
//cu
->with('sql_BECA_ESC', $sql_BECA_ESC)
->with('tipos_becas_ESC_M', $tipos_becas_ESC_M)
->with('tipos_becas_ESC_F', $tipos_becas_ESC_F)
->with('tipos_becas_ESC_G', $tipos_becas_ESC_G)
->with('tipos_becas_esco_D', $tipos_becas_esco_D)
->with('tipos_becas_esco_L', $tipos_becas_esco_L);

    }

public function info_coord_academica_3E(){

//------HABLANTE DE LENGUA MODALIDAD ESCO CU
$total_lenguasM=DB:: select('SELECT lenguas.nombre_lengua,
COUNT(estudiantes.matricula) as total_lengua
    FROM personas, estudiantes, lenguas
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.sede="CU"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND personas.genero="M"
    AND personas.lengua="1"
    AND lenguas.nombre_lengua IS NOT NULL
    AND personas.id_persona=lenguas.id_persona
    GROUP BY lenguas.nombre_lengua');

$total_lenguasF=DB:: select('SELECT lenguas.nombre_lengua,
COUNT(estudiantes.matricula) as total_lengua
    FROM personas, estudiantes, lenguas
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.sede="CU"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND personas.genero="F"
    AND personas.lengua="1"
    AND lenguas.nombre_lengua IS NOT NULL
    AND personas.id_persona=lenguas.id_persona
    GROUP BY lenguas.nombre_lengua');

$total_lenguasE=DB:: select('SELECT lenguas.nombre_lengua,
COUNT(estudiantes.matricula) as total_lengua
  FROM personas, estudiantes, lenguas
  WHERE personas.id_persona=estudiantes.id_persona
  AND estudiantes.sede="CU"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND personas.id_persona=lenguas.id_persona
  AND personas.lengua="1"
  AND lenguas.nombre_lengua IS NOT NULL
  GROUP BY lenguas.nombre_lengua');

$totalG_lenguas=DB::select ('SELECT personas.genero,
COUNT(estudiantes.matricula) as total
 FROM personas, estudiantes, lenguas
 WHERE personas.id_persona=estudiantes.id_persona
 AND personas.id_persona=lenguas.id_persona
 AND personas.lengua="1"
 AND lenguas.nombre_lengua IS NOT NULL
 AND estudiantes.modalidad="ESCOLARIZADA"
 AND estudiantes.sede="CU"
 GROUP BY personas.genero');
     $count_totalG_lenguas = count($totalG_lenguas);
     $totalG_femeninoL = 0;
     $totalG_masculinoL = 0;
     if ($count_totalG_lenguas > 0) {
         $totalG_femeninoL = $totalG_lenguas[0]->total;
     if ($count_totalG_lenguas == 2) {
         $totalG_masculinoL = $totalG_lenguas[1]->total;
             }
     }

  $totalGLMF= $totalG_femeninoL + $totalG_masculinoL;

return view('personal_administrativo/auxiliar_administrativo/planeacionesco/info_coord_academica1e.info_coord_academica_3e')
    //------HABLANTE DE LENGUA MODALIDAD ESCO CU
    ->with('total_lenguasM', $total_lenguasM)->with('total_lenguasF', $total_lenguasF)
    ->with('totalG_femeninoL', $totalG_femeninoL)->with('totalG_masculinoL', $totalG_masculinoL)
    ->with('total_lenguasE',$total_lenguasE)
    ->with('totalGLMF', $totalGLMF);

}

/*REPORTE 911.9*/
public function reporte9119E(){
      //ESTUDIANTES BECADOS DEL CICLO ESCOLAR ACTUAL CU
      //MODALIDAD ESCOLARIZADA
      //MASCULINO
  $sql_BECA_ESC= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC
  FROM personas, estudiantes, becas
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.genero="M" AND estudiantes.matricula=becas.matricula
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND estudiantes.sede="CU"
  GROUP BY becas.tipo_beca';
 $beca_query = DB::select($sql_BECA_ESC);
 $array_becas = array(
   "INSTITUCIONAL" => 0,
   "FEDERAL" => 0,
   "ESTATAL" => 0,
   "MUNICIPAL" => 0,
   "PARTICULAR" => 0,
   "INTERNACIONAL" => 0,
   "TOTAL" => 0
 );
 $tipos_becas_ESC_M = array(
   "INSTITUCIONAL" => 0,
   "FEDERAL" => 0,
   "ESTATAL" => 0,
   "MUNICIPAL" => 0,
   "PARTICULAR" => 0,
   "INTERNACIONAL" => 0,
   "TOTAL" => 0
 );

for($i = 0; $i < count($beca_query); $i++) {
  $sub = $beca_query[$i]->total_BECA_ESC;
  $tipos_becas_ESC_M[$beca_query[$i]->tipo_beca] = $sub;
  $tipos_becas_ESC_M['TOTAL'] += $sub;
  $array_becas[$beca_query[$i]->tipo_beca] += $sub;
  $array_becas['TOTAL'] += $sub;
}
//FEMENINO
  $sql_BECA_ESC= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC
  FROM personas, estudiantes, becas
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.genero="F" AND estudiantes.matricula=becas.matricula
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND estudiantes.sede="CU"
  GROUP BY becas.tipo_beca';
 $beca_query = DB::select($sql_BECA_ESC);
 $tipos_becas_ESC_F = array(
   "INSTITUCIONAL" => 0,
   "FEDERAL" => 0,
   "ESTATAL" => 0,
   "MUNICIPAL" => 0,
   "PARTICULAR" => 0,
   "INTERNACIONAL" => 0,
   "TOTAL" => 0
 );

for($i = 0; $i < count($beca_query); $i++) {
  $sub = $beca_query[$i]->total_BECA_ESC;
  $tipos_becas_ESC_F[$beca_query[$i]->tipo_beca] = $sub;
  $tipos_becas_ESC_F['TOTAL'] += $sub;
  $array_becas[$beca_query[$i]->tipo_beca] += $sub;
  $array_becas['TOTAL'] += $sub;
}
//GENERAL
  $sql_BECA_ESC= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC
  FROM personas, estudiantes, becas
  WHERE personas.id_persona=estudiantes.id_persona
  AND estudiantes.matricula=becas.matricula
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND estudiantes.sede="CU"
  GROUP BY becas.tipo_beca';
 $beca_query = DB::select($sql_BECA_ESC);
 $tipos_becas_ESC_G = array(
   "INSTITUCIONAL" => 0,
   "FEDERAL" => 0,
   "ESTATAL" => 0,
   "MUNICIPAL" => 0,
   "PARTICULAR" => 0,
   "INTERNACIONAL" => 0,
   "TOTAL" => 0
 );

    for($i = 0; $i < count($beca_query); $i++) {
      $sub = $beca_query[$i]->total_BECA_ESC;
      $tipos_becas_ESC_G[$beca_query[$i]->tipo_beca] = $sub;
      $tipos_becas_ESC_G['TOTAL'] += $sub;
      $array_becas[$beca_query[$i]->tipo_beca] += $sub;
      $array_becas['TOTAL'] += $sub;
    }
//------CON DISCAPACIDAD
    $sql_BECA_ESC_D= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC_D
              FROM personas, estudiantes, discapacidades, becas
              WHERE personas.id_persona=estudiantes.id_persona
              AND personas.id_persona=discapacidades.id_persona
              AND estudiantes.sede="CU"
              AND estudiantes.modalidad="ESCOLARIZADA"
              AND estudiantes.matricula=becas.matricula
              AND discapacidades.tipo IS NOT NULL
              GROUP BY becas.tipo_beca';
   $beca_query = DB::select($sql_BECA_ESC_D);
   $tipos_becas_esco_D = array(
     "INSTITUCIONAL" => 0,
     "FEDERAL" => 0,
     "ESTATAL" => 0,
     "MUNICIPAL" => 0,
     "PARTICULAR" => 0,
     "INTERNACIONAL" => 0,
     "TOTAL" => 0
   );
for($i = 0; $i < count($beca_query); $i++) {
  $sub = $beca_query[$i]->total_BECA_ESC_D;
  $tipos_becas_esco_D[$beca_query[$i]->tipo_beca] = $sub;
  $tipos_becas_esco_D['TOTAL'] += $sub;
  $array_becas[$beca_query[$i]->tipo_beca] += $sub;
  $array_becas['TOTAL'] += $sub;
}
//------HABLANTE DE LENGUA
$sql_BECA_ESC_L= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC_L
          FROM personas, estudiantes, lenguas, becas
          WHERE personas.id_persona=estudiantes.id_persona
          AND personas.id_persona=lenguas.id_persona
          AND lenguas.nombre_lengua IS NOT NULL
          AND estudiantes.sede="CU"
          AND estudiantes.modalidad="ESCOLARIZADA"
          AND estudiantes.matricula=becas.matricula
          GROUP BY becas.tipo_beca';
$beca_query = DB::select($sql_BECA_ESC_L);
 $tipos_becas_esco_L = array(
         "INSTITUCIONAL" => 0,
         "FEDERAL" => 0,
         "ESTATAL" => 0,
          "MUNICIPAL" => 0,
          "PARTICULAR" => 0,
          "INTERNACIONAL" => 0,
          "TOTAL" => 0
           );

            for($i = 0; $i < count($beca_query); $i++) {
              $sub = $beca_query[$i]->total_BECA_ESC_L;
              $tipos_becas_esco_L[$beca_query[$i]->tipo_beca] = $sub;
              $tipos_becas_esco_L['TOTAL'] += $sub;
              $array_becas[$beca_query[$i]->tipo_beca] += $sub;
              $array_becas['TOTAL'] += $sub;
            }

  return view('personal_administrativo/auxiliar_administrativo/planeacionesco/reporte911_9e.reporte9119e')
      /*CU*/
        ->with('sql_BECA_ESC', $sql_BECA_ESC)
        ->with('tipos_becas_ESC_M', $tipos_becas_ESC_M)
        ->with('tipos_becas_ESC_F', $tipos_becas_ESC_F)
        ->with('tipos_becas_ESC_G', $tipos_becas_ESC_G)
        ->with('tipos_becas_esco_D', $tipos_becas_esco_D)
        ->with('tipos_becas_esco_L', $tipos_becas_esco_L)

        ;
      }

/*REPORTE 911.9A*/
public function reporte911_9A0E(){
/*ALUMNOS DE PRIMER INGRESO DEL CICLO ESCOLAR ANTERIOR CU ESCO*/

  $total_genero_primerE=DB::select ('SELECT personas.genero, COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes
  WHERE personas.id_persona=estudiantes.id_persona
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND estudiantes.semestre="2"
  AND estudiantes.sede="CU"
  GROUP BY personas.genero');
  $total_femenino_primerE=$total_genero_primerE[0]->total;
  $total_masculino_primerE=$total_genero_primerE[1]->total;
  $total_primerE= $total_femenino_primerE + $total_masculino_primerE;
/*CON DISCAPACIDAD*/
$estudiantes_discapacidadESC2=DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.modalidad="ESCOLARIZADA"
AND estudiantes.sede="CU"
AND estudiantes.semestre="2"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$total_estudiantes_discapacidadESC2=$estudiantes_discapacidadESC2[0]->tot;
/*HABLANTE DE LENGUA*/
$estudiantes_lenguaESC2=DB::select('SELECT SUM(total) as tot
FROM (SELECT lenguas.nombre_lengua, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, lenguas
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=lenguas.id_persona
AND estudiantes.modalidad="ESCOLARIZADA"
AND estudiantes.sede="CU"
AND estudiantes.semestre="2"
AND lenguas.nombre_lengua IS NOT NULL
GROUP BY lenguas.nombre_lengua) as total');
$total_estudiantes_lenguaESC2=$estudiantes_lenguaESC2[0]->tot;

return view('personal_administrativo/auxiliar_administrativo/planeacionesco/reporte911_9ae.reporte911_9a0e')
  /*CU*/
  ->with('total_femenino_primerE', $total_femenino_primerE)
  ->with('total_masculino_primerE', $total_masculino_primerE)
  ->with('total_primerE', $total_primerE)

/*CON DISCAPACIDAD*/
  ->with('total_estudiantes_discapacidadESC2',$total_estudiantes_discapacidadESC2)
  /*HABLANTE DE LENGUA*/
  ->with('total_estudiantes_lenguaESC2',$total_estudiantes_lenguaESC2)
  ;
}

public function reporte911_9A1E(){
  /*ALUMNOS DE PRIMER INGRESO DEL CICLO ESCOLAR ACTUAL CU ESCO*/
$total_inscritos_m=DB::select('SELECT SUM(total) as totm
FROM(SELECT personas.genero, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes
WHERE personas.id_persona=estudiantes.id_persona
AND estudiantes.sede="CU"
AND estudiantes.modalidad="ESCOLARIZADA"
AND estudiantes.semestre="1"
AND personas.genero="M"
GROUP BY personas.genero) as total');
$total_estudiantes_inscritos_m=$total_inscritos_m[0]->totm;

$total_inscritos_f=DB::select('SELECT SUM(total) as totf
FROM(SELECT personas.genero, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes
WHERE personas.id_persona=estudiantes.id_persona
AND estudiantes.sede="CU"
AND estudiantes.modalidad="ESCOLARIZADA"
AND estudiantes.semestre="1"
AND personas.genero="F"
GROUP BY personas.genero) as total');
$total_estudiantes_inscritos_f=$total_inscritos_f[0]->totf;
$total_inscritos=$total_estudiantes_inscritos_m + $total_estudiantes_inscritos_f;

$estudiantes_discapacidad=DB::select('SELECT SUM(total) as totD
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND discapacidades.tipo IS NOT NULL
AND estudiantes.sede="CU"
AND estudiantes.modalidad="ESCOLARIZADA"
AND estudiantes.semestre="1"
GROUP BY discapacidades.tipo) as total');
$total_estudiantes_discapacidad=$estudiantes_discapacidad[0]->totD;

$estudiantes_lengua=DB::select('SELECT SUM(total) as totL FROM
(SELECT lenguas.nombre_lengua, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, lenguas
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=lenguas.id_persona
AND lenguas.nombre_lengua IS NOT NULL
AND estudiantes.sede="CU"
AND estudiantes.modalidad="ESCOLARIZADA"
AND estudiantes.semestre="1"
GROUP BY lenguas.nombre_lengua) as total');
$total_estudiantes_lengua=$estudiantes_lengua[0]->totL;

return view('personal_administrativo/auxiliar_administrativo/planeacionesco/reporte911_9ae.reporte911_9a1e')
->with('total_inscritos_m', $total_inscritos_m)
->with('total_estudiantes_inscritos_m', $total_estudiantes_inscritos_m)
->with('total_inscritos_f', $total_inscritos_f)
->with('total_estudiantes_inscritos_f', $total_estudiantes_inscritos_f)
->with('total_inscritos', $total_inscritos)
->with('estudiantes_discapacidad', $estudiantes_discapacidad)
->with('total_estudiantes_discapacidad', $total_estudiantes_discapacidad)
->with('estudiantes_lengua', $estudiantes_lengua)
->with('total_estudiantes_lengua', $total_estudiantes_lengua);

}

public function reporte911_9A2E(){
///MATRÍCULA TOTAL DE LA CARRERA
//ESTUDIANTES INSCRITOS EN LA CARRERA POR GRADO DE AVANCE


//MODALIDAD ESCOLARIZADA
//CU
//-----------------------------------HOMBRES
  $tot_1_M_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'M'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','1']])
  ->count();

  $tot_2_M_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'M'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','2']])
  ->count();

  $tot_3_M_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'M'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','3']])
  ->count();
  $tot_4_M_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'M'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','4']])
  ->count();

  $tot_5_M_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'M'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','5']])
  ->count();

  $tot_6_M_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'M'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','6']])
  ->count();

  $tot_7_M_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'M'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','7']])
  ->count();

  $tot_8_M_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'M'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','8'],
            ['estudiantes.egresado','=', '0']])
  ->count();

$tot_M_CU = ($tot_1_M_CU
          + $tot_2_M_CU
          + $tot_3_M_CU
          + $tot_4_M_CU
          + $tot_5_M_CU
          + $tot_6_M_CU
          + $tot_7_M_CU
          + $tot_8_M_CU);

//-----------------------------------MUJERES
  $tot_1_F_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'F'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','1']])
  ->count();

  $tot_2_F_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'F'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','2']])
  ->count();

  $tot_3_F_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'F'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','3']])
  ->count();

  $tot_4_F_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'F'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','4']])
  ->count();

  $tot_5_F_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'F'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','5']])
  ->count();

  $tot_6_F_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'F'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','6']])
  ->count();

  $tot_7_F_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'F'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','7']])
  ->count();


  $tot_8_F_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.genero', '=', 'F'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'CU'],
            ['estudiantes.semestre','=','8'],
            ['estudiantes.egresado','=', '0']])
  ->count();


  $tot_F_CU = ($tot_1_F_CU
            + $tot_2_F_CU
            + $tot_3_F_CU
            + $tot_4_F_CU
            + $tot_5_F_CU
            + $tot_6_F_CU
            + $tot_7_F_CU
            + $tot_8_F_CU);

/*CON DISCAPACIDAD*/
$tot_D_1_CU = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="1"
AND estudiantes.sede="CU"
AND estudiantes.modalidad="ESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_1_D_CU = $tot_D_1_CU[0]->tot;

$tot_D_2_CU = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="2"
AND estudiantes.sede="CU"
AND estudiantes.modalidad="ESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_2_D_CU = $tot_D_2_CU[0]->tot;

$tot_D_3_CU = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="3"
AND estudiantes.sede="CU"
AND estudiantes.modalidad="ESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_3_D_CU = $tot_D_3_CU[0]->tot;

$tot_D_4_CU = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="4"
AND estudiantes.sede="CU"
AND estudiantes.modalidad="ESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_4_D_CU = $tot_D_4_CU[0]->tot;

$tot_D_5_CU = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="5"
AND estudiantes.sede="CU"
AND estudiantes.modalidad="ESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_5_D_CU = $tot_D_5_CU[0]->tot;

$tot_D_6_CU = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="6"
AND estudiantes.sede="CU"
AND estudiantes.modalidad="ESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_6_D_CU = $tot_D_6_CU[0]->tot;

$tot_D_7_CU = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="7"
AND estudiantes.sede="CU"
AND estudiantes.modalidad="ESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_7_D_CU = $tot_D_7_CU[0]->tot;

$tot_D_8_CU = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="8"
AND estudiantes.sede="CU"
AND estudiantes.modalidad="ESCOLARIZADA"
AND estudiantes.egresado="0"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_8_D_CU = $tot_D_8_CU[0]->tot;

$tot_T_D_CU = $tot_1_D_CU +
              $tot_2_D_CU +
              $tot_3_D_CU +
              $tot_4_D_CU +
              $tot_5_D_CU +
              $tot_6_D_CU +
              $tot_7_D_CU +
              $tot_8_D_CU ;


/*HABLANTE DE LENGUA*/
  $tot_1_L_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.lengua', '=', '1'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

  $tot_2_L_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.lengua', '=', '2'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

  $tot_3_L_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.lengua', '=', '3'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

  $tot_4_L_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.lengua', '=', '4'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

  $tot_5_L_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.lengua', '=', '5'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

  $tot_6_L_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.lengua', '=', '6'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

  $tot_7_L_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.lengua', '=', '7'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

  $tot_8_L_CU = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.lengua', '=', '8'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

  $tot_T_L_CU = $tot_1_L_CU +
                $tot_2_L_CU +
                $tot_3_L_CU +
                $tot_4_L_CU +
                $tot_5_L_CU +
                $tot_6_L_CU +
                $tot_7_L_CU +
                $tot_8_L_CU ;

return view('personal_administrativo/auxiliar_administrativo/planeacionesco/reporte911_9ae.reporte911_9a2e')
//CU
//MASCULINO
->with('tot_1_M_CU',$tot_1_M_CU)
->with('tot_2_M_CU',$tot_2_M_CU)
->with('tot_3_M_CU',$tot_3_M_CU)
->with('tot_4_M_CU',$tot_4_M_CU)
->with('tot_5_M_CU',$tot_5_M_CU)
->with('tot_6_M_CU',$tot_6_M_CU)
->with('tot_7_M_CU',$tot_7_M_CU)
->with('tot_8_M_CU',$tot_8_M_CU)
->with('tot_M_CU',$tot_M_CU)

//FEMENINO
->with('tot_1_F_CU',$tot_1_F_CU)
->with('tot_2_F_CU',$tot_2_F_CU)
->with('tot_3_F_CU',$tot_3_F_CU)
->with('tot_4_F_CU',$tot_4_F_CU)
->with('tot_5_F_CU',$tot_5_F_CU)
->with('tot_6_F_CU',$tot_6_F_CU)
->with('tot_7_F_CU',$tot_7_F_CU)
->with('tot_8_F_CU',$tot_8_F_CU)
->with('tot_F_CU',$tot_F_CU)

//CON DISCAPACIDAD
->with('tot_1_D_CU',$tot_1_D_CU)
->with('tot_2_D_CU',$tot_2_D_CU)
->with('tot_3_D_CU',$tot_3_D_CU)
->with('tot_4_D_CU',$tot_4_D_CU)
->with('tot_5_D_CU',$tot_5_D_CU)
->with('tot_6_D_CU',$tot_6_D_CU)
->with('tot_7_D_CU',$tot_7_D_CU)
->with('tot_8_D_CU',$tot_8_D_CU)
->with('tot_T_D_CU',$tot_T_D_CU)

//HABLANTE DE LENGUA
->with('tot_1_L_CU',$tot_1_L_CU)
->with('tot_2_L_CU',$tot_2_L_CU)
->with('tot_3_L_CU',$tot_3_L_CU)
->with('tot_4_L_CU',$tot_4_L_CU)
->with('tot_5_L_CU',$tot_5_L_CU)
->with('tot_6_L_CU',$tot_6_L_CU)
->with('tot_7_L_CU',$tot_7_L_CU)
->with('tot_8_L_CU',$tot_8_L_CU)
->with('tot_T_L_CU',$tot_T_L_CU)
;
}


public function reporte911_9A3E(){

  //----------------ALUMNOS INSCRITOS POR EDAD Y GRADO DE AVANCE-----------//
  //---------------------------------- <18---------------------------------//
$tot_m_18_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_m_18_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_m_18_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_m_18_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_m_18_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_m_18_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_m_18_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_m_18_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_m_18_T = $tot_m_18_1 +
              $tot_m_18_2 +
              $tot_m_18_3 +
              $tot_m_18_4 +
              $tot_m_18_5 +
              $tot_m_18_6 +
              $tot_m_18_7 +
              $tot_m_18_8 ;

//---------------------------------- 18---------------------------------//
$tot_18_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_18_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_18_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_18_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_18_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_18_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_18_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_18_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_18_T = $tot_18_1 +
            $tot_18_2 +
            $tot_18_3 +
            $tot_18_4 +
            $tot_18_5 +
            $tot_18_6 +
            $tot_18_7 +
            $tot_18_8 ;

//---------------------------------- 19---------------------------------//
$tot_19_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_19_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_19_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_19_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_19_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_19_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_19_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_19_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_19_T = $tot_19_1 +
            $tot_19_2 +
            $tot_19_3 +
            $tot_19_4 +
            $tot_19_5 +
            $tot_19_6 +
            $tot_19_7 +
            $tot_19_8 ;

//---------------------------------- 20---------------------------------//
$tot_20_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_20_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_20_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_20_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_20_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_20_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_20_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_20_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_20_T = $tot_20_1 +
            $tot_20_2 +
            $tot_20_3 +
            $tot_20_4 +
            $tot_20_5 +
            $tot_20_6 +
            $tot_20_7 +
            $tot_20_8 ;

//---------------------------------- 21---------------------------------//
$tot_21_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_21_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_21_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_21_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_21_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_21_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_21_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_21_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_21_T = $tot_21_1 +
            $tot_21_2 +
            $tot_21_3 +
            $tot_21_4 +
            $tot_21_5 +
            $tot_21_6 +
            $tot_21_7 +
            $tot_21_8 ;

//---------------------------------- 22---------------------------------//
$tot_22_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_22_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_22_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_22_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_22_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_22_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_22_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_22_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_22_T = $tot_22_1 +
            $tot_22_2 +
            $tot_22_3 +
            $tot_22_4 +
            $tot_22_5 +
            $tot_22_6 +
            $tot_22_7 +
            $tot_22_8 ;

//---------------------------------- 23---------------------------------//
$tot_23_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_23_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_23_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_23_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_23_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_23_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_23_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_23_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_23_T = $tot_23_1 +
            $tot_23_2 +
            $tot_23_3 +
            $tot_23_4 +
            $tot_23_5 +
            $tot_23_6 +
            $tot_23_7 +
            $tot_23_8 ;

//---------------------------------- 24---------------------------------//
$tot_24_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_24_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_24_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_24_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_24_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_24_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_24_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_24_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_24_T = $tot_24_1 +
            $tot_24_2 +
            $tot_24_3 +
            $tot_24_4 +
            $tot_24_5 +
            $tot_24_6 +
            $tot_24_7 +
            $tot_24_8 ;


//----------------------------------25---------------------------------//
$tot_25_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_25_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_25_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_25_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_25_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_25_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_25_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_25_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_25_T = $tot_25_1 +
            $tot_25_2 +
            $tot_25_3 +
            $tot_25_4 +
            $tot_25_5 +
            $tot_25_6 +
            $tot_25_7 +
            $tot_25_8 ;


//---------------------------------- 26---------------------------------//
$tot_26_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_26_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_26_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_26_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_26_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_26_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_26_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_26_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_26_T = $tot_26_1 +
            $tot_26_2 +
            $tot_26_3 +
            $tot_26_4 +
            $tot_26_5 +
            $tot_26_6 +
            $tot_26_7 +
            $tot_26_8 ;


//----------------------------------27---------------------------------//
$tot_27_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_27_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_27_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_27_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_27_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_27_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_27_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_27_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_27_T = $tot_27_1 +
            $tot_27_2 +
            $tot_27_3 +
            $tot_27_4 +
            $tot_27_5 +
            $tot_27_6 +
            $tot_27_7 +
            $tot_27_8 ;


//---------------------------------- 28---------------------------------//
$tot_28_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_28_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_28_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_28_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_28_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_28_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_28_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_28_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_28_T = $tot_28_1 +
            $tot_28_2 +
            $tot_28_3 +
            $tot_28_4 +
            $tot_28_5 +
            $tot_28_6 +
            $tot_28_7 +
            $tot_28_8 ;


//---------------------------------- 29---------------------------------//
$tot_29_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_29_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_29_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_29_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_29_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_29_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_29_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_29_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_29_T = $tot_29_1 +
            $tot_29_2 +
            $tot_29_3 +
            $tot_29_4 +
            $tot_29_5 +
            $tot_29_6 +
            $tot_29_7 +
            $tot_29_8 ;


//----------------------------------30-34--------------------------------//
$tot_30_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_30_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_30_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_30_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_30_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_30_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_30_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_30_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_30_T = $tot_30_1 +
            $tot_30_2 +
            $tot_30_3 +
            $tot_30_4 +
            $tot_30_5 +
            $tot_30_6 +
            $tot_30_7 +
            $tot_30_8 ;


//----------------------------------35-40--------------------------------//
$tot_35_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_35_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_35_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_35_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_35_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_35_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_35_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_35_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_35_T = $tot_35_1 +
            $tot_35_2 +
            $tot_35_3 +
            $tot_35_4 +
            $tot_35_5 +
            $tot_35_6 +
            $tot_35_7 +
            $tot_35_8 ;

//---------------------------------->=40--------------------------------//
$tot_40_1 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_40_2 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_40_3 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_40_4 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_40_5 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_40_6 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_40_7 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU']])
  ->count();

$tot_40_8 = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','CU'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_40_T = $tot_40_1 +
            $tot_40_2 +
            $tot_40_3 +
            $tot_40_4 +
            $tot_40_5 +
            $tot_40_6 +
            $tot_40_7 +
            $tot_40_8 ;


//---------------------------TOTALES
$tot_G_1 = $tot_m_18_1 + $tot_18_1 + $tot_19_1 + $tot_20_1 + $tot_21_1 + $tot_22_1
           + $tot_23_1 + $tot_24_1 + $tot_25_1 + $tot_26_1 + $tot_27_1 + $tot_28_1
           + $tot_29_1 + $tot_30_1 + $tot_35_1 + $tot_40_1 ;

$tot_G_2 = $tot_m_18_2 + $tot_18_2 + $tot_19_2 + $tot_20_2 + $tot_21_2 + $tot_22_2
           + $tot_23_2 + $tot_24_2 + $tot_25_2 + $tot_26_2 + $tot_27_2 + $tot_28_2
           + $tot_29_2 + $tot_30_2 + $tot_35_2 + $tot_40_2 ;

$tot_G_3 = $tot_m_18_3 + $tot_18_3 + $tot_19_3 + $tot_20_3 + $tot_21_3 + $tot_22_3
           + $tot_23_3 + $tot_24_3 + $tot_25_3 + $tot_26_3 + $tot_27_3 + $tot_28_3
           + $tot_29_3 + $tot_30_3 + $tot_35_3 + $tot_40_3 ;

$tot_G_4 = $tot_m_18_4 + $tot_18_4 + $tot_19_4 + $tot_20_4 + $tot_21_4 + $tot_22_4
           + $tot_23_4 + $tot_24_4 + $tot_25_4 + $tot_26_4 + $tot_27_4 + $tot_28_4
           + $tot_29_4 + $tot_30_4 + $tot_35_4 + $tot_40_4 ;

$tot_G_5 = $tot_m_18_5 + $tot_18_5 + $tot_19_5 + $tot_20_5 + $tot_21_5 + $tot_22_5
           + $tot_23_5 + $tot_24_5 + $tot_25_5 + $tot_26_5 + $tot_27_5 + $tot_28_5
           + $tot_29_5 + $tot_30_5 + $tot_35_5 + $tot_40_5 ;

$tot_G_6 = $tot_m_18_6 + $tot_18_6 + $tot_19_6 + $tot_20_6 + $tot_21_6 + $tot_22_6
           + $tot_23_6 + $tot_24_6 + $tot_25_6 + $tot_26_6 + $tot_27_6 + $tot_28_6
           + $tot_29_6 + $tot_30_6 + $tot_35_6 + $tot_40_6 ;

$tot_G_7 = $tot_m_18_7 + $tot_18_7 + $tot_19_7 + $tot_20_7 + $tot_21_7 + $tot_22_7
           + $tot_23_7 + $tot_24_7 + $tot_25_7 + $tot_26_7 + $tot_27_7 + $tot_28_7
           + $tot_29_7 + $tot_30_7 + $tot_35_7 + $tot_40_7 ;

$tot_G_8 = $tot_m_18_8 + $tot_18_8 + $tot_19_8 + $tot_20_8 + $tot_21_8 + $tot_22_8
           + $tot_23_8 + $tot_24_8 + $tot_25_8 + $tot_26_8 + $tot_27_8 + $tot_28_8
           + $tot_29_8 + $tot_30_8 + $tot_35_8 + $tot_40_8 ;

$tot_G_T = $tot_G_1 + $tot_G_2 + $tot_G_3 + $tot_G_4 + $tot_G_5 + $tot_G_6 + $tot_G_7 + $tot_G_8;

return view('personal_administrativo/auxiliar_administrativo/planeacionesco/reporte911_9ae.reporte911_9a3e')
//-------------------------------------CU
//------------------<18
->with('tot_m_18_1', $tot_m_18_1)
->with('tot_m_18_2', $tot_m_18_2)
->with('tot_m_18_3', $tot_m_18_3)
->with('tot_m_18_4', $tot_m_18_4)
->with('tot_m_18_5', $tot_m_18_5)
->with('tot_m_18_6', $tot_m_18_6)
->with('tot_m_18_7', $tot_m_18_7)
->with('tot_m_18_8', $tot_m_18_8)
->with('tot_m_18_T', $tot_m_18_T)

//------------------18
->with('tot_18_1', $tot_18_1)
->with('tot_18_2', $tot_18_2)
->with('tot_18_3', $tot_18_3)
->with('tot_18_4', $tot_18_4)
->with('tot_18_5', $tot_18_5)
->with('tot_18_6', $tot_18_6)
->with('tot_18_7', $tot_18_7)
->with('tot_18_8', $tot_18_8)
->with('tot_18_T', $tot_18_T)

//------------------19
->with('tot_19_1', $tot_19_1)
->with('tot_19_2', $tot_19_2)
->with('tot_19_3', $tot_19_3)
->with('tot_19_4', $tot_19_4)
->with('tot_19_5', $tot_19_5)
->with('tot_19_6', $tot_19_6)
->with('tot_19_7', $tot_19_7)
->with('tot_19_8', $tot_19_8)
->with('tot_19_T', $tot_19_T)

//------------------20
->with('tot_20_1', $tot_20_1)
->with('tot_20_2', $tot_20_2)
->with('tot_20_3', $tot_20_3)
->with('tot_20_4', $tot_20_4)
->with('tot_20_5', $tot_20_5)
->with('tot_20_6', $tot_20_6)
->with('tot_20_7', $tot_20_7)
->with('tot_20_8', $tot_20_8)
->with('tot_20_T', $tot_20_T)

//------------------21
->with('tot_21_1', $tot_21_1)
->with('tot_21_2', $tot_21_2)
->with('tot_21_3', $tot_21_3)
->with('tot_21_4', $tot_21_4)
->with('tot_21_5', $tot_21_5)
->with('tot_21_6', $tot_21_6)
->with('tot_21_7', $tot_21_7)
->with('tot_21_8', $tot_21_8)
->with('tot_21_T', $tot_21_T)

//------------------22
->with('tot_22_1', $tot_22_1)
->with('tot_22_2', $tot_22_2)
->with('tot_22_3', $tot_22_3)
->with('tot_22_4', $tot_22_4)
->with('tot_22_5', $tot_22_5)
->with('tot_22_6', $tot_22_6)
->with('tot_22_7', $tot_22_7)
->with('tot_22_8', $tot_22_8)
->with('tot_22_T', $tot_22_T)

//------------------23
->with('tot_23_1', $tot_23_1)
->with('tot_23_2', $tot_23_2)
->with('tot_23_3', $tot_23_3)
->with('tot_23_4', $tot_23_4)
->with('tot_23_5', $tot_23_5)
->with('tot_23_6', $tot_23_6)
->with('tot_23_7', $tot_23_7)
->with('tot_23_8', $tot_23_8)
->with('tot_23_T', $tot_23_T)

//------------------24
->with('tot_24_1', $tot_24_1)
->with('tot_24_2', $tot_24_2)
->with('tot_24_3', $tot_24_3)
->with('tot_24_4', $tot_24_4)
->with('tot_24_5', $tot_24_5)
->with('tot_24_6', $tot_24_6)
->with('tot_24_7', $tot_24_7)
->with('tot_24_8', $tot_24_8)
->with('tot_24_T', $tot_24_T)

//------------------25
->with('tot_25_1', $tot_25_1)
->with('tot_25_2', $tot_25_2)
->with('tot_25_3', $tot_25_3)
->with('tot_25_4', $tot_25_4)
->with('tot_25_5', $tot_25_5)
->with('tot_25_6', $tot_25_6)
->with('tot_25_7', $tot_25_7)
->with('tot_25_8', $tot_25_8)
->with('tot_25_T', $tot_25_T)

//------------------26
->with('tot_26_1', $tot_26_1)
->with('tot_26_2', $tot_26_2)
->with('tot_26_3', $tot_26_3)
->with('tot_26_4', $tot_26_4)
->with('tot_26_5', $tot_26_5)
->with('tot_26_6', $tot_26_6)
->with('tot_26_7', $tot_26_7)
->with('tot_26_8', $tot_26_8)
->with('tot_26_T', $tot_26_T)

//------------------27
->with('tot_27_1', $tot_27_1)
->with('tot_27_2', $tot_27_2)
->with('tot_27_3', $tot_27_3)
->with('tot_27_4', $tot_27_4)
->with('tot_27_5', $tot_27_5)
->with('tot_27_6', $tot_27_6)
->with('tot_27_7', $tot_27_7)
->with('tot_27_8', $tot_27_8)
->with('tot_27_T', $tot_27_T)

//------------------28
->with('tot_28_1', $tot_28_1)
->with('tot_28_2', $tot_28_2)
->with('tot_28_3', $tot_28_3)
->with('tot_28_4', $tot_28_4)
->with('tot_28_5', $tot_28_5)
->with('tot_28_6', $tot_28_6)
->with('tot_28_7', $tot_28_7)
->with('tot_28_8', $tot_28_8)
->with('tot_28_T', $tot_28_T)

//------------------29
->with('tot_29_1', $tot_29_1)
->with('tot_29_2', $tot_29_2)
->with('tot_29_3', $tot_29_3)
->with('tot_29_4', $tot_29_4)
->with('tot_29_5', $tot_29_5)
->with('tot_29_6', $tot_29_6)
->with('tot_29_7', $tot_29_7)
->with('tot_29_8', $tot_29_8)
->with('tot_29_T', $tot_29_T)

//------------------30 - 34
->with('tot_30_1', $tot_30_1)
->with('tot_30_2', $tot_30_2)
->with('tot_30_3', $tot_30_3)
->with('tot_30_4', $tot_30_4)
->with('tot_30_5', $tot_30_5)
->with('tot_30_6', $tot_30_6)
->with('tot_30_7', $tot_30_7)
->with('tot_30_8', $tot_30_8)
->with('tot_30_T', $tot_30_T)

//------------------35 - 39
->with('tot_35_1', $tot_35_1)
->with('tot_35_2', $tot_35_2)
->with('tot_35_3', $tot_35_3)
->with('tot_35_4', $tot_35_4)
->with('tot_35_5', $tot_35_5)
->with('tot_35_6', $tot_35_6)
->with('tot_35_7', $tot_35_7)
->with('tot_35_8', $tot_35_8)
->with('tot_35_T', $tot_35_T)


//------------------ >=40
->with('tot_40_1', $tot_40_1)
->with('tot_40_2', $tot_40_2)
->with('tot_40_3', $tot_40_3)
->with('tot_40_4', $tot_40_4)
->with('tot_40_5', $tot_40_5)
->with('tot_40_6', $tot_40_6)
->with('tot_40_7', $tot_40_7)
->with('tot_40_8', $tot_40_8)
->with('tot_40_T', $tot_40_T)


//-----------------------------------TOTALES
->with('tot_G_1', $tot_G_1)
->with('tot_G_2', $tot_G_2)
->with('tot_G_3', $tot_G_3)
->with('tot_G_4', $tot_G_4)
->with('tot_G_5', $tot_G_5)
->with('tot_G_6', $tot_G_6)
->with('tot_G_7', $tot_G_7)
->with('tot_G_8', $tot_G_8)
->with('tot_G_T', $tot_G_T)
  ;

}


//-------------------------------------------------------------------------------------------------------------------------------------------------------------------//
//semiesco//
public function info_coord_academica_1S(){
/*MODALIDAD SEMIESCOLARIZADA*/
//---------------------------------------------------------------------/*CU*/
/*MASCULINO*/
$actualM_S=DB::select
('SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="M"
    AND estudiantes.modalidad="SEMIESCOLARIZADA"
    AND estudiantes.sede="CU"
    GROUP BY personas.genero');
    $totalactualM_S=$actualM_S[0]->total;

/*FEMENINO*/
$actualF_S=DB::select
('SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="F"
    AND estudiantes.modalidad="SEMIESCOLARIZADA"
    AND estudiantes.sede="CU"
    GROUP BY personas.genero');
    $totalactualF_S=$actualF_S[0]->total;

/*TOTAL*/
$actualT_S=DB::select
('SELECT SUM(total) as tot
  FROM (SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.modalidad="SEMIESCOLARIZADA"
    AND estudiantes.sede="CU"
    GROUP BY personas.genero) AS T');
    $totalactualT_S=$actualT_S[0]->tot;

/*CON DISCAPACIDAD*/
$discapacidadesCU_S=DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.modalidad="SEMIESCOLARIZADA"
AND estudiantes.sede="CU"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$discapacidadesTCU_S=$discapacidadesCU_S[0]->tot;

/*HABLANTE DE LENGUA*/
$conteo_lengua_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.lengua', '=', '1'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU']])
->count();


return view('personal_administrativo/auxiliar_administrativo/planeacionsemiesco/info_coord_academica1s.info_coord_academica_1s')
//------------------------------------------------------------------MODALIDAD SEMIESCOLARIZADA
    //--------------------------------------------------------------------------------------CU

    ->with('totalactualM_S', $totalactualM_S)
    ->with('totalactualF_S', $totalactualF_S)
    ->with('totalactualT_S', $totalactualT_S)
    ->with('discapacidadesTCU_S', $discapacidadesTCU_S)
    ->with('conteo_lengua_S', $conteo_lengua_S) ;
}

public function info_coord_academica_2S(){
  /*---------------------------------------------------------------------------------------*/
  //--------------------ESTUDIANTES BECADOS DEL CICLO ESCOLAR ACTUAL CU
  //--------------------------------------------------------------------------//
  //MODALIDAD SEMI ESCOLARIZADA
  //MASCULINO

    $sql_BECA_SEMI= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_SEMI
    FROM personas, estudiantes, becas
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="M" AND estudiantes.matricula=becas.matricula
    AND estudiantes.modalidad="SEMIESCOLARIZADA"
    AND estudiantes.sede="CU"
    AND becas.tipo_beca IS NOT NULL
    AND becas.bandera="1"
    GROUP BY becas.tipo_beca';
   $beca_query = DB::select($sql_BECA_SEMI);
   $array_becas = array(
     "INSTITUCIONAL" => 0,
     "FEDERAL" => 0,
     "ESTATAL" => 0,
     "MUNICIPAL" => 0,
     "PARTICULAR" => 0,
     "INTERNACIONAL" => 0,
     "TOTAL" => 0
   );

   $tipos_becas_SEMI_M = array(
     "INSTITUCIONAL" => 0,
     "FEDERAL" => 0,
     "ESTATAL" => 0,
     "MUNICIPAL" => 0,
     "PARTICULAR" => 0,
     "INTERNACIONAL" => 0,
     "TOTAL" => 0
   );

    for($i = 0; $i < count($beca_query); $i++) {
      $sub = $beca_query[$i]->total_BECA_SEMI;
      $tipos_becas_SEMI_M[$beca_query[$i]->tipo_beca] = $sub;
      $tipos_becas_SEMI_M['TOTAL'] += $sub;
      $array_becas[$beca_query[$i]->tipo_beca] += $sub;
      $array_becas['TOTAL'] += $sub;
    }

    //FEMENINO
      $sql_BECA_SEMI= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_SEMI
      FROM personas, estudiantes, becas
      WHERE personas.id_persona=estudiantes.id_persona
      AND personas.genero="F" AND estudiantes.matricula=becas.matricula
      AND estudiantes.modalidad="SEMIESCOLARIZADA"
      AND estudiantes.sede="CU"
      AND becas.tipo_beca IS NOT NULL
      AND becas.bandera="1"
      GROUP BY becas.tipo_beca';
     $beca_query = DB::select($sql_BECA_SEMI);

     $tipos_becas_SEMI_F = array(
       "INSTITUCIONAL" => 0,
       "FEDERAL" => 0,
       "ESTATAL" => 0,
       "MUNICIPAL" => 0,
       "PARTICULAR" => 0,
       "INTERNACIONAL" => 0,
       "TOTAL" => 0
     );

      for($i = 0; $i < count($beca_query); $i++) {
        $sub = $beca_query[$i]->total_BECA_SEMI;
        $tipos_becas_SEMI_F[$beca_query[$i]->tipo_beca] = $sub;
        $tipos_becas_SEMI_F['TOTAL'] += $sub;
        $array_becas[$beca_query[$i]->tipo_beca] += $sub;
        $array_becas['TOTAL'] += $sub;
      }

      //GENERAL
        $sql_BECA_SEMI= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_SEMI
        FROM personas, estudiantes, becas
        WHERE personas.id_persona=estudiantes.id_persona
        AND estudiantes.matricula=becas.matricula
        AND estudiantes.modalidad="SEMIESCOLARIZADA"
        AND estudiantes.sede="CU"
        AND becas.tipo_beca IS NOT NULL
        AND becas.bandera="1"
        GROUP BY becas.tipo_beca';
       $beca_query = DB::select($sql_BECA_SEMI);

       $tipos_becas_SEMI_G = array(
         "INSTITUCIONAL" => 0,
         "FEDERAL" => 0,
         "ESTATAL" => 0,
         "MUNICIPAL" => 0,
         "PARTICULAR" => 0,
         "INTERNACIONAL" => 0,
         "TOTAL" => 0
       );

        for($i = 0; $i < count($beca_query); $i++) {
          $sub = $beca_query[$i]->total_BECA_SEMI;
          $tipos_becas_SEMI_G[$beca_query[$i]->tipo_beca] = $sub;
          $tipos_becas_SEMI_G['TOTAL'] += $sub;
          $array_becas[$beca_query[$i]->tipo_beca] += $sub;
          $array_becas['TOTAL'] += $sub;
        }

        //------CON DISCAPACIDAD
        $sql_BECA_SEMI_D= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_SEMI_D
                  FROM personas, estudiantes, discapacidades, becas
                  WHERE personas.id_persona=estudiantes.id_persona
                  AND personas.id_persona=discapacidades.id_persona
                  AND estudiantes.sede="CU"
                  AND estudiantes.modalidad="SEMIESCOLARIZADA"
                  AND discapacidades.tipo IS NOT NULL
                  AND estudiantes.matricula=becas.matricula
                  AND becas.tipo_beca IS NOT NULL
                  AND becas.bandera="1"
                  GROUP BY becas.tipo_beca';
       $beca_query = DB::select($sql_BECA_SEMI_D);
       $tipos_becas_semi_D = array(
         "INSTITUCIONAL" => 0,
         "FEDERAL" => 0,
         "ESTATAL" => 0,
         "MUNICIPAL" => 0,
         "PARTICULAR" => 0,
         "INTERNACIONAL" => 0,
         "TOTAL" => 0
       );

        for($i = 0; $i < count($beca_query); $i++) {
          $sub = $beca_query[$i]->total_BECA_SEMI_D;
          $tipos_becas_semi_D[$beca_query[$i]->tipo_beca] = $sub;
          $tipos_becas_semi_D['TOTAL'] += $sub;
          $array_becas[$beca_query[$i]->tipo_beca] += $sub;
          $array_becas['TOTAL'] += $sub;
        }

        //------HABLANTE DE LENGUA
        $sql_BECA_SEMI_L= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_SEMI_L
        FROM personas
        INNER JOIN estudiantes
        on estudiantes.id_persona=personas.id_persona
        INNER JOIN becas
        ON becas.matricula=estudiantes.matricula
        WHERE personas.lengua=1
        AND estudiantes.modalidad="SEMIESCOLARIZADA"
        AND estudiantes.sede="CU"
        AND becas.tipo_beca IS NOT NULL
        AND becas.bandera="1"
        GROUP BY becas.tipo_beca';
       $beca_query = DB::select($sql_BECA_SEMI_L);

       $tipos_becas_semi_L = array(
         "INSTITUCIONAL" => 0,
         "FEDERAL" => 0,
         "ESTATAL" => 0,
         "MUNICIPAL" => 0,
         "PARTICULAR" => 0,
         "INTERNACIONAL" => 0,
         "TOTAL" => 0
       );

        for($i = 0; $i < count($beca_query); $i++) {
          $sub = $beca_query[$i]->total_BECA_SEMI_L;
          $tipos_becas_semi_L[$beca_query[$i]->tipo_beca] = $sub;
          $tipos_becas_semi_L['TOTAL'] += $sub;
          $array_becas[$beca_query[$i]->tipo_beca] += $sub;
          $array_becas['TOTAL'] += $sub;
        }


/*---------------------------------------------------------------------------------------*/
return view('personal_administrativo/auxiliar_administrativo/planeacionsemiesco/info_coord_academica1s.info_coord_academica_2s')

//CU
->with('$sql_BECA_SEMI', $sql_BECA_SEMI)
->with('tipos_becas_SEMI_M', $tipos_becas_SEMI_M )
->with('tipos_becas_SEMI_F', $tipos_becas_SEMI_F )
->with('tipos_becas_SEMI_G', $tipos_becas_SEMI_G )
->with('tipos_becas_semi_D', $tipos_becas_semi_D )
->with('tipos_becas_semi_L', $tipos_becas_semi_L );


  }

  public function info_coord_academica_3S(){

//------HABLANTE DE LENGUA MODALIDAD ESCO CU
  $total_lenguasM=DB:: select('SELECT lenguas.nombre_lengua,
      COUNT(estudiantes.matricula) as total_lengua
      FROM personas, estudiantes, lenguas
      WHERE personas.id_persona=estudiantes.id_persona
      AND estudiantes.sede="CU"
      AND estudiantes.modalidad="SEMIESCOLARIZADA"
      AND personas.genero="M"
      AND personas.lengua="1"
     AND lenguas.nombre_lengua IS NOT NULL
      AND personas.id_persona=lenguas.id_persona
      GROUP BY lenguas.nombre_lengua');

  $total_lenguasF=DB:: select('SELECT lenguas.nombre_lengua,
      COUNT(estudiantes.matricula) as total_lengua
      FROM personas, estudiantes, lenguas
      WHERE personas.id_persona=estudiantes.id_persona
      AND estudiantes.sede="CU"
      AND estudiantes.modalidad="SEMIESCOLARIZADA"
      AND personas.genero="F"
      AND personas.lengua="1"
     AND lenguas.nombre_lengua IS NOT NULL
      AND personas.id_persona=lenguas.id_persona
      GROUP BY lenguas.nombre_lengua');

      $total_lenguasE=DB:: select('SELECT lenguas.nombre_lengua,
      COUNT(estudiantes.matricula) as total_lengua
      FROM personas, estudiantes, lenguas
      WHERE personas.id_persona=estudiantes.id_persona
      AND estudiantes.sede="CU"
      AND estudiantes.modalidad="SEMIESCOLARIZADA"
      AND personas.id_persona=lenguas.id_persona
      AND personas.lengua="1"
      AND lenguas.nombre_lengua IS NOT NULL
      GROUP BY lenguas.nombre_lengua');

  $totalG_lenguas=DB::select ('SELECT personas.genero,
  COUNT(estudiantes.matricula) as total
   FROM personas, estudiantes, lenguas
   WHERE personas.id_persona=estudiantes.id_persona
   AND personas.id_persona=lenguas.id_persona
   AND personas.lengua="1"
   AND lenguas.nombre_lengua IS NOT NULL
   AND estudiantes.modalidad="SEMIESCOLARIZADA"
   AND estudiantes.sede="CU"
   GROUP BY personas.genero');
   $count_totalG_lenguas = count($totalG_lenguas);
   $totalG_femeninoL = 0;
   $totalG_masculinoL = 0;
   if ($count_totalG_lenguas > 0) {
          $totalG_femeninoL = $totalG_lenguas[0]->total;
           if ($count_totalG_lenguas == 2) {
               $totalG_masculinoL = $totalG_lenguas[1]->total;
           }
   }

$totalGLMF= $totalG_femeninoL + $totalG_masculinoL;

return view('personal_administrativo/auxiliar_administrativo/planeacionsemiesco/info_coord_academica1s.info_coord_academica_3s')
  //------HABLANTE DE LENGUA MODALIDAD ESCO CU
  ->with('total_lenguasM', $total_lenguasM)->with('total_lenguasF', $total_lenguasF)
  ->with('totalG_femeninoL', $totalG_femeninoL)->with('totalG_masculinoL', $totalG_masculinoL)
  ->with('total_lenguasE',$total_lenguasE)
  ->with('totalGLMF', $totalGLMF)

      ;

    }
    /*REPORTE 911.9*/
    public function reporte9119S(){
    //ESTUDIANTES BECADOS DEL CICLO ESCOLAR ACTUAL CU
    //MODALIDAD ESCOLARIZADA
    //MASCULINO
      $sql_BECA_ESC= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC
      FROM personas, estudiantes, becas
      WHERE personas.id_persona=estudiantes.id_persona
      AND personas.genero="M" AND estudiantes.matricula=becas.matricula
      AND estudiantes.modalidad="SEMI ESCOLARIZADA"
      AND estudiantes.sede="CU"
      GROUP BY becas.tipo_beca';
     $beca_query = DB::select($sql_BECA_ESC);
     $array_becas = array(
       "INSTITUCIONAL" => 0,
       "FEDERAL" => 0,
       "ESTATAL" => 0,
       "MUNICIPAL" => 0,
       "PARTICULAR" => 0,
       "INTERNACIONAL" => 0,
       "TOTAL" => 0
     );
     $tipos_becas_ESC_M = array(
       "INSTITUCIONAL" => 0,
       "FEDERAL" => 0,
       "ESTATAL" => 0,
       "MUNICIPAL" => 0,
       "PARTICULAR" => 0,
       "INTERNACIONAL" => 0,
       "TOTAL" => 0
     );

      for($i = 0; $i < count($beca_query); $i++) {
        $sub = $beca_query[$i]->total_BECA_ESC;
        $tipos_becas_ESC_M[$beca_query[$i]->tipo_beca] = $sub;
        $tipos_becas_ESC_M['TOTAL'] += $sub;
        $array_becas[$beca_query[$i]->tipo_beca] += $sub;
        $array_becas['TOTAL'] += $sub;
      }

      //FEMENINO
        $sql_BECA_ESC= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC
        FROM personas, estudiantes, becas
        WHERE personas.id_persona=estudiantes.id_persona
        AND personas.genero="F" AND estudiantes.matricula=becas.matricula
        AND estudiantes.modalidad="SEMI ESCOLARIZADA"
        AND estudiantes.sede="CU"
        GROUP BY becas.tipo_beca';
       $beca_query = DB::select($sql_BECA_ESC);

       $tipos_becas_ESC_F = array(
         "INSTITUCIONAL" => 0,
         "FEDERAL" => 0,
         "ESTATAL" => 0,
         "MUNICIPAL" => 0,
         "PARTICULAR" => 0,
         "INTERNACIONAL" => 0,
         "TOTAL" => 0
       );

        for($i = 0; $i < count($beca_query); $i++) {
          $sub = $beca_query[$i]->total_BECA_ESC;
          $tipos_becas_ESC_F[$beca_query[$i]->tipo_beca] = $sub;
          $tipos_becas_ESC_F['TOTAL'] += $sub;
          $array_becas[$beca_query[$i]->tipo_beca] += $sub;
          $array_becas['TOTAL'] += $sub;
        }

        //GENERAL
          $sql_BECA_ESC= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC
          FROM personas, estudiantes, becas
          WHERE personas.id_persona=estudiantes.id_persona
          AND estudiantes.matricula=becas.matricula
          AND estudiantes.modalidad="SEMI ESCOLARIZADA"
          AND estudiantes.sede="CU"
          GROUP BY becas.tipo_beca';
         $beca_query = DB::select($sql_BECA_ESC);

         $tipos_becas_ESC_G = array(
           "INSTITUCIONAL" => 0,
           "FEDERAL" => 0,
           "ESTATAL" => 0,
           "MUNICIPAL" => 0,
           "PARTICULAR" => 0,
           "INTERNACIONAL" => 0,
           "TOTAL" => 0
         );

          for($i = 0; $i < count($beca_query); $i++) {
            $sub = $beca_query[$i]->total_BECA_ESC;
            $tipos_becas_ESC_G[$beca_query[$i]->tipo_beca] = $sub;
            $tipos_becas_ESC_G['TOTAL'] += $sub;
            $array_becas[$beca_query[$i]->tipo_beca] += $sub;
            $array_becas['TOTAL'] += $sub;
          }

      //------CON DISCAPACIDAD
          $sql_BECA_ESC_D= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC_D
                    FROM personas, estudiantes, discapacidades, becas
                    WHERE personas.id_persona=estudiantes.id_persona
                    AND personas.id_persona=discapacidades.id_persona
                    AND estudiantes.sede="CU"
                    AND estudiantes.modalidad="SEMI ESCOLARIZADA"
                    AND estudiantes.matricula=becas.matricula
                    AND discapacidades.tipo IS NOT NULL
                    GROUP BY becas.tipo_beca';
         $beca_query = DB::select($sql_BECA_ESC_D);
         $tipos_becas_esco_D = array(
           "INSTITUCIONAL" => 0,
           "FEDERAL" => 0,
           "ESTATAL" => 0,
           "MUNICIPAL" => 0,
           "PARTICULAR" => 0,
           "INTERNACIONAL" => 0,
           "TOTAL" => 0
         );

          for($i = 0; $i < count($beca_query); $i++) {
            $sub = $beca_query[$i]->total_BECA_ESC_D;
            $tipos_becas_esco_D[$beca_query[$i]->tipo_beca] = $sub;
            $tipos_becas_esco_D['TOTAL'] += $sub;
            $array_becas[$beca_query[$i]->tipo_beca] += $sub;
            $array_becas['TOTAL'] += $sub;
          }

          //------HABLANTE DE LENGUA
          $sql_BECA_ESC_L= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC_L
                    FROM personas, estudiantes, lenguas, becas
                    WHERE personas.id_persona=estudiantes.id_persona
                    AND personas.id_persona=lenguas.id_persona
                    AND lenguas.nombre_lengua IS NOT NULL
                    AND estudiantes.sede="CU"
                    AND estudiantes.modalidad="SEMI ESCOLARIZADA"
                    AND estudiantes.matricula=becas.matricula
                    GROUP BY becas.tipo_beca';
         $beca_query = DB::select($sql_BECA_ESC_L);

         $tipos_becas_esco_L = array(
           "INSTITUCIONAL" => 0,
           "FEDERAL" => 0,
           "ESTATAL" => 0,
           "MUNICIPAL" => 0,
           "PARTICULAR" => 0,
           "INTERNACIONAL" => 0,
           "TOTAL" => 0
         );

          for($i = 0; $i < count($beca_query); $i++) {
            $sub = $beca_query[$i]->total_BECA_ESC_L;
            $tipos_becas_esco_L[$beca_query[$i]->tipo_beca] = $sub;
            $tipos_becas_esco_L['TOTAL'] += $sub;
            $array_becas[$beca_query[$i]->tipo_beca] += $sub;
            $array_becas['TOTAL'] += $sub;
          }

return view('personal_administrativo/auxiliar_administrativo/planeacionsemiesco/reporte911_9s.reporte9119s')
    /*CU*/
      ->with('sql_BECA_ESC', $sql_BECA_ESC)
      ->with('tipos_becas_ESC_M', $tipos_becas_ESC_M)
      ->with('tipos_becas_ESC_F', $tipos_becas_ESC_F)
      ->with('tipos_becas_ESC_G', $tipos_becas_ESC_G)
      ->with('tipos_becas_esco_D', $tipos_becas_esco_D)
      ->with('tipos_becas_esco_L', $tipos_becas_esco_L)

      ;
    }

/*REPORTE 911.9A*/
public function reporte911_9A0S(){
/*ALUMNOS DE PRIMER INGRESO DEL CICLO ESCOLAR ANTERIOR CU SEMIESCO*/

/*MASCULINO*/
$primeringreso_A_MS=DB::select
('SELECT personas.genero,
  COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="M"
    AND estudiantes.semestre="2"
    AND estudiantes.modalidad="SEMIESCOLARIZADA"
    AND estudiantes.sede="CU"
    GROUP BY personas.genero');
    $PIA_MS=$primeringreso_A_MS[0]->total;
/*FEMENINO*/
$primeringreso_A_FS=DB::select
('SELECT personas.genero,
COUNT(estudiantes.matricula) as total
FROM personas, estudiantes
WHERE personas.id_persona=estudiantes.id_persona
AND personas.genero="F"
AND estudiantes.semestre="2"
AND estudiantes.modalidad="SEMIESCOLARIZADA"
AND estudiantes.sede="CU"
GROUP BY personas.genero');
$PIA_FS=$primeringreso_A_FS[0]->total;
/*CON DISCAPACIDAD*/
$discapacidadesPICUS=DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="2"
AND estudiantes.modalidad="SEMIESCOLARIZADA"
AND estudiantes.sede="CU"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$PIA_DS=$discapacidadesPICUS[0]->tot;
/*HABLANTE DE LENGUA*/
$PIA_LS = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.lengua', '=', '1'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','2']])
->count();

return view('personal_administrativo/auxiliar_administrativo/planeacionsemiesco/reporte911_9as.reporte911_9a0s')
/*CU*/
->with('PIA_MS', $PIA_MS)
->with('PIA_FS', $PIA_FS)
->with('PIA_DS', $PIA_DS)
->with('PIA_LS', $PIA_LS)

;
}

public function reporte911_9A1S(){
/*ALUMNOS DE PRIMER INGRESO DEL CICLO ESCOLAR ACTUAL CU ESCO*/
$total_inscritos_m=DB::select('SELECT SUM(total) as totm
FROM(SELECT personas.genero, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes
WHERE personas.id_persona=estudiantes.id_persona
AND estudiantes.sede="CU"
AND estudiantes.modalidad="SEMIESCOLARIZADA"
AND estudiantes.semestre="1"
AND personas.genero="M"
GROUP BY personas.genero) as total');
$total_estudiantes_inscritos_m=$total_inscritos_m[0]->totm;

$total_inscritos_f=DB::select('SELECT SUM(total) as totf
FROM(SELECT personas.genero, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes
WHERE personas.id_persona=estudiantes.id_persona
AND estudiantes.sede="CU"
AND estudiantes.modalidad="SEMIESCOLARIZADA"
AND estudiantes.semestre="1"
AND personas.genero="F"
GROUP BY personas.genero) as total');
$total_estudiantes_inscritos_f=$total_inscritos_f[0]->totf;
$total_inscritos=$total_estudiantes_inscritos_m + $total_estudiantes_inscritos_f;

$estudiantes_discapacidad=DB::select('SELECT SUM(total) as totD
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND discapacidades.tipo IS NOT NULL
AND estudiantes.sede="CU"
AND estudiantes.modalidad="SEMIESCOLARIZADA"
AND estudiantes.semestre="1"
GROUP BY discapacidades.tipo) as total');
$total_estudiantes_discapacidad=$estudiantes_discapacidad[0]->totD;

$estudiantes_lengua=DB::select('SELECT SUM(total) as totL FROM
(SELECT lenguas.nombre_lengua, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, lenguas
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=lenguas.id_persona
AND lenguas.nombre_lengua IS NOT NULL
AND estudiantes.sede="CU"
AND estudiantes.modalidad="SEMIESCOLARIZADA"
AND estudiantes.semestre="1"
GROUP BY lenguas.nombre_lengua) as total');
$total_estudiantes_lengua=$estudiantes_lengua[0]->totL;

return view('personal_administrativo/auxiliar_administrativo/planeacionsemiesco/reporte911_9as.reporte911_9a1s')
->with('total_inscritos_m', $total_inscritos_m)
->with('total_estudiantes_inscritos_m', $total_estudiantes_inscritos_m)
->with('total_inscritos_f', $total_inscritos_f)
->with('total_estudiantes_inscritos_f', $total_estudiantes_inscritos_f)
->with('total_inscritos', $total_inscritos)
->with('estudiantes_discapacidad', $estudiantes_discapacidad)
->with('total_estudiantes_discapacidad', $total_estudiantes_discapacidad)
->with('estudiantes_lengua', $estudiantes_lengua)
->with('total_estudiantes_lengua', $total_estudiantes_lengua);

}

public function reporte911_9A2S(){
//ESTUDIANTES INSCRITOS DEL CICLO ESCOLAR ACTUAL CU
//MODALIDAD SEMIESCOLARIZADA
    //CU
//-----------------------------------HOMBRES
$tot_1_M_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','1']])
->count();

$tot_2_M_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','2']])
->count();

$tot_3_M_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','3']])
->count();
$tot_4_M_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','4']])
->count();

$tot_5_M_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','5']])
->count();

$tot_6_M_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','6']])
->count();

$tot_7_M_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','7']])
->count();

$tot_8_M_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','8'],
          ['estudiantes.egresado','=', '0']])
                ->count();

              $tot_M_CU_S = ($tot_1_M_CU_S
                        + $tot_2_M_CU_S
                        + $tot_3_M_CU_S
                        + $tot_4_M_CU_S
                        + $tot_5_M_CU_S
                        + $tot_6_M_CU_S
                        + $tot_7_M_CU_S
                        + $tot_8_M_CU_S);

              //-----------------------------------MUJERES
$tot_1_F_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','1']])
->count();

$tot_2_F_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','2']])
->count();

$tot_3_F_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','3']])
->count();

$tot_4_F_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','4']])
->count();

$tot_5_F_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','5']])
->count();

$tot_6_F_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','6']])
->count();

$tot_7_F_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','7']])
->count();


$tot_8_F_CU_S = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
          ['estudiantes.semestre','=','8'],
          ['estudiantes.egresado','=', '0']])
->count();


                $tot_F_CU_S = ($tot_1_F_CU_S
                          + $tot_2_F_CU_S
                          + $tot_3_F_CU_S
                          + $tot_4_F_CU_S
                          + $tot_5_F_CU_S
                          + $tot_6_F_CU_S
                          + $tot_7_F_CU_S
                          + $tot_8_F_CU_S);

/*CON DISCAPACIDAD*/
$tot_D_1_CU_S = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="1"
AND estudiantes.sede="CU"
AND estudiantes.modalidad="SEMIESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_1_D_CU_S = $tot_D_1_CU_S[0]->tot;

$tot_D_2_CU_S = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="2"
AND estudiantes.sede="CU"
AND estudiantes.modalidad="SEMIESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_2_D_CU_S = $tot_D_2_CU_S[0]->tot;


  $tot_D_3_CU_S = DB::select('SELECT SUM(total) as tot
              FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
              FROM personas, estudiantes, discapacidades
              WHERE personas.id_persona=estudiantes.id_persona
              AND personas.id_persona=discapacidades.id_persona
              AND estudiantes.semestre="3"
              AND estudiantes.sede="CU"
              AND estudiantes.modalidad="SEMIESCOLARIZADA"
              AND discapacidades.tipo IS NOT NULL
              GROUP BY discapacidades.tipo) as total');
              $tot_3_D_CU_S = $tot_D_3_CU_S[0]->tot;

              $tot_D_4_CU_S = DB::select('SELECT SUM(total) as tot
              FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
              FROM personas, estudiantes, discapacidades
              WHERE personas.id_persona=estudiantes.id_persona
              AND personas.id_persona=discapacidades.id_persona
              AND estudiantes.semestre="4"
              AND estudiantes.sede="CU"
              AND estudiantes.modalidad="SEMIESCOLARIZADA"
              AND discapacidades.tipo IS NOT NULL
              GROUP BY discapacidades.tipo) as total');
              $tot_4_D_CU_S = $tot_D_4_CU_S[0]->tot;

              $tot_D_5_CU_S = DB::select('SELECT SUM(total) as tot
              FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
              FROM personas, estudiantes, discapacidades
              WHERE personas.id_persona=estudiantes.id_persona
              AND personas.id_persona=discapacidades.id_persona
              AND estudiantes.semestre="5"
              AND estudiantes.sede="CU"
              AND estudiantes.modalidad="SEMIESCOLARIZADA"
              AND discapacidades.tipo IS NOT NULL
              GROUP BY discapacidades.tipo) as total');
              $tot_5_D_CU_S = $tot_D_5_CU_S[0]->tot;

              $tot_D_6_CU_S = DB::select('SELECT SUM(total) as tot
              FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
              FROM personas, estudiantes, discapacidades
              WHERE personas.id_persona=estudiantes.id_persona
              AND personas.id_persona=discapacidades.id_persona
              AND estudiantes.semestre="6"
              AND estudiantes.sede="CU"
              AND estudiantes.modalidad="SEMIESCOLARIZADA"
              AND discapacidades.tipo IS NOT NULL
              GROUP BY discapacidades.tipo) as total');
              $tot_6_D_CU_S = $tot_D_6_CU_S[0]->tot;

              $tot_D_7_CU_S = DB::select('SELECT SUM(total) as tot
              FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
              FROM personas, estudiantes, discapacidades
              WHERE personas.id_persona=estudiantes.id_persona
              AND personas.id_persona=discapacidades.id_persona
              AND estudiantes.semestre="7"
              AND estudiantes.sede="CU"
              AND estudiantes.modalidad="SEMIESCOLARIZADA"
              AND discapacidades.tipo IS NOT NULL
              GROUP BY discapacidades.tipo) as total');
              $tot_7_D_CU_S = $tot_D_7_CU_S[0]->tot;

              $tot_D_8_CU_S = DB::select('SELECT SUM(total) as tot
              FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
              FROM personas, estudiantes, discapacidades
              WHERE personas.id_persona=estudiantes.id_persona
              AND personas.id_persona=discapacidades.id_persona
              AND estudiantes.semestre="8"
              AND estudiantes.sede="CU"
              AND estudiantes.modalidad="SEMIESCOLARIZADA"
              AND estudiantes.egresado="0"
              AND discapacidades.tipo IS NOT NULL
              GROUP BY discapacidades.tipo) as total');
              $tot_8_D_CU_S = $tot_D_8_CU_S[0]->tot;

              $tot_T_D_CU_S = $tot_1_D_CU_S +
                            $tot_2_D_CU_S +
                            $tot_3_D_CU_S +
                            $tot_4_D_CU_S +
                            $tot_5_D_CU_S +
                            $tot_6_D_CU_S +
                            $tot_7_D_CU_S +
                            $tot_8_D_CU_S ;


              /*HABLANTE DE LENGUA*/
                $tot_1_L_CU_S = DB::table('personas')
                ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
                ->where([['personas.lengua', '=', '1'],
                         ['estudiantes.semestre','=','1'],
                         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
                         ['estudiantes.sede','=','CU']])
                ->count();

                $tot_2_L_CU_S = DB::table('personas')
                ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
                ->where([['personas.lengua', '=', '2'],
                         ['estudiantes.semestre','=','2'],
                         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
                         ['estudiantes.sede','=','CU']])
                ->count();

                $tot_3_L_CU_S = DB::table('personas')
                ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
                ->where([['personas.lengua', '=', '3'],
                         ['estudiantes.semestre','=','3'],
                         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
                         ['estudiantes.sede','=','CU']])
                ->count();

                $tot_4_L_CU_S = DB::table('personas')
                ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
                ->where([['personas.lengua', '=', '4'],
                         ['estudiantes.semestre','=','4'],
                         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
                         ['estudiantes.sede','=','CU']])
                ->count();

                $tot_5_L_CU_S = DB::table('personas')
                ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
                ->where([['personas.lengua', '=', '5'],
                         ['estudiantes.semestre','=','5'],
                         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
                         ['estudiantes.sede','=','CU']])
                ->count();

                $tot_6_L_CU_S = DB::table('personas')
                ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
                ->where([['personas.lengua', '=', '6'],
                         ['estudiantes.semestre','=','6'],
                         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
                         ['estudiantes.sede','=','CU']])
                ->count();

                $tot_7_L_CU_S = DB::table('personas')
                ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
                ->where([['personas.lengua', '=', '7'],
                         ['estudiantes.semestre','=','7'],
                         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
                         ['estudiantes.sede','=','CU']])
                ->count();

                $tot_8_L_CU_S = DB::table('personas')
                ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
                ->where([['personas.lengua', '=', '8'],
                         ['estudiantes.semestre','=','8'],
                         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
                         ['estudiantes.sede','=','CU'],
                         ['estudiantes.egresado','=','0']])
                ->count();

              $tot_T_L_CU_S = $tot_1_L_CU_S +
                              $tot_2_L_CU_S +
                              $tot_3_L_CU_S +
                              $tot_4_L_CU_S +
                              $tot_5_L_CU_S +
                              $tot_6_L_CU_S +
                              $tot_7_L_CU_S +
                            $tot_8_L_CU_S ;

return view('personal_administrativo/auxiliar_administrativo/planeacionsemiesco/reporte911_9as.reporte911_9a2s')
//CU SEMIESCOLARIZADO
//MASCULINO
->with('tot_1_M_CU_S',$tot_1_M_CU_S)
->with('tot_2_M_CU_S',$tot_2_M_CU_S)
->with('tot_3_M_CU_S',$tot_3_M_CU_S)
->with('tot_4_M_CU_S',$tot_4_M_CU_S)
->with('tot_5_M_CU_S',$tot_5_M_CU_S)
->with('tot_6_M_CU_S',$tot_6_M_CU_S)
->with('tot_7_M_CU_S',$tot_7_M_CU_S)
->with('tot_8_M_CU_S',$tot_8_M_CU_S)
->with('tot_M_CU_S',$tot_M_CU_S)

//FEMENINO
->with('tot_1_F_CU_S',$tot_1_F_CU_S)
->with('tot_2_F_CU_S',$tot_2_F_CU_S)
->with('tot_3_F_CU_S',$tot_3_F_CU_S)
->with('tot_4_F_CU_S',$tot_4_F_CU_S)
->with('tot_5_F_CU_S',$tot_5_F_CU_S)
->with('tot_6_F_CU_S',$tot_6_F_CU_S)
->with('tot_7_F_CU_S',$tot_7_F_CU_S)
->with('tot_8_F_CU_S',$tot_8_F_CU_S)
->with('tot_F_CU_S',$tot_F_CU_S)

//CON DISCAPACIDAD
->with('tot_1_D_CU_S',$tot_1_D_CU_S)
->with('tot_2_D_CU_S',$tot_2_D_CU_S)
->with('tot_3_D_CU_S',$tot_3_D_CU_S)
->with('tot_4_D_CU_S',$tot_4_D_CU_S)
->with('tot_5_D_CU_S',$tot_5_D_CU_S)
->with('tot_6_D_CU_S',$tot_6_D_CU_S)
->with('tot_7_D_CU_S',$tot_7_D_CU_S)
->with('tot_8_D_CU_S',$tot_8_D_CU_S)
->with('tot_T_D_CU_S',$tot_T_D_CU_S)

//HABLANTE DE LENGUA
->with('tot_1_L_CU_S',$tot_1_L_CU_S)
->with('tot_2_L_CU_S',$tot_2_L_CU_S)
->with('tot_3_L_CU_S',$tot_3_L_CU_S)
->with('tot_4_L_CU_S',$tot_4_L_CU_S)
->with('tot_5_L_CU_S',$tot_5_L_CU_S)
->with('tot_6_L_CU_S',$tot_6_L_CU_S)
->with('tot_7_L_CU_S',$tot_7_L_CU_S)
->with('tot_8_L_CU_S',$tot_8_L_CU_S)
->with('tot_T_L_CU_S',$tot_T_L_CU_S)
;
}


public function reporte911_9A3S(){

//-----------------------------------------------------------------------------------------------------------------------//
   //----------------ALUMNOS INSCRITOS POR EDAD Y GRADO DE AVANCE-----------//
    //CU, SEMI
    //---------------------------------- <18---------------------------------//
  $tot_m_18_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '<', '18'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_m_18_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '<', '18'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_m_18_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '<', '18'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_m_18_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '<', '18'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_m_18_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '<', '18'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_m_18_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '<', '18'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_m_18_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '<', '18'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_m_18_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '<', '18'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU'],
             ['estudiantes.egresado','=','0']])
    ->count();

  $tot_m_18_T_S = $tot_m_18_1_S +
                  $tot_m_18_2_S +
                  $tot_m_18_3_S +
                  $tot_m_18_4_S +
                  $tot_m_18_5_S +
                  $tot_m_18_6_S +
                  $tot_m_18_7_S +
                  $tot_m_18_8_S ;

  //---------------------------------- 18---------------------------------//
  $tot_18_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '18'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_18_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '18'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_18_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '18'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_18_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '18'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_18_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '18'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_18_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '18'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_18_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '18'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_18_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '18'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU'],
             ['estudiantes.egresado','=','0']])
    ->count();

  $tot_18_T_S = $tot_18_1_S +
                $tot_18_2_S +
                $tot_18_3_S +
                $tot_18_4_S +
                $tot_18_5_S +
                $tot_18_6_S +
                $tot_18_7_S +
                $tot_18_8_S ;
  //---------------------------------- 19---------------------------------//
  $tot_19_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '19'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_19_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '19'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_19_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '19'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_19_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '19'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_19_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '19'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_19_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '19'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_19_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '19'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_19_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '19'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU'],
             ['estudiantes.egresado','=','0']])
    ->count();

  $tot_19_T_S = $tot_19_1_S +
                $tot_19_2_S +
                $tot_19_3_S +
                $tot_19_4_S +
                $tot_19_5_S +
                $tot_19_6_S +
                $tot_19_7_S +
                $tot_19_8_S ;

  //---------------------------------- 20---------------------------------//
  $tot_20_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '20'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_20_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '20'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_20_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '20'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_20_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '20'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_20_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '20'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_20_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '20'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_20_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '20'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_20_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '20'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU'],
             ['estudiantes.egresado','=','0']])
    ->count();

  $tot_20_T_S = $tot_20_1_S +
                $tot_20_2_S +
                $tot_20_3_S +
                $tot_20_4_S +
                $tot_20_5_S +
                $tot_20_6_S +
                $tot_20_7_S +
                $tot_20_8_S ;

  //---------------------------------- 21---------------------------------//
  $tot_21_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '21'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_21_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '21'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_21_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '20'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_21_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '21'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_21_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '21'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_21_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '21'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_21_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '21'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_21_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '21'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU'],
             ['estudiantes.egresado','=','0']])
    ->count();

  $tot_21_T_S = $tot_21_1_S +
                $tot_21_2_S +
                $tot_21_3_S +
                $tot_21_4_S +
                $tot_21_5_S +
                $tot_21_6_S +
                $tot_21_7_S +
                $tot_21_8_S ;

  //---------------------------------- 22---------------------------------//
  $tot_22_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '22'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_22_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '22'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_22_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '22'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_22_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '22'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_22_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '22'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_22_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '22'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_22_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '22'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_22_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '22'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU'],
             ['estudiantes.egresado','=','0']])
    ->count();

  $tot_22_T_S = $tot_22_1_S +
                $tot_22_2_S +
                $tot_22_3_S +
                $tot_22_4_S +
                $tot_22_5_S +
                $tot_22_6_S +
                $tot_22_7_S +
                $tot_22_8_S ;

  //---------------------------------- 23---------------------------------//
  $tot_23_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '23'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_23_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '23'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_23_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '23'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_23_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '23'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_23_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '23'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_23_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '23'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_23_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '23'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_23_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '23'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU'],
             ['estudiantes.egresado','=','0']])
    ->count();

  $tot_23_T_S = $tot_23_1_S +
                $tot_23_2_S +
                $tot_23_3_S +
                $tot_23_4_S +
                $tot_23_5_S +
                $tot_23_6_S +
                $tot_23_7_S +
                $tot_23_8_S ;

  //---------------------------------- 24---------------------------------//
  $tot_24_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '24'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_24_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '24'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_24_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '24'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_24_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '24'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_24_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '24'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_24_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '24'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_24_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '24'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_24_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '24'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU'],
             ['estudiantes.egresado','=','0']])
    ->count();

  $tot_24_T_S = $tot_24_1_S +
                $tot_24_2_S +
                $tot_24_3_S +
                $tot_24_4_S +
                $tot_24_5_S +
                $tot_24_6_S +
                $tot_24_7_S +
                $tot_24_8_S ;


  //----------------------------------25---------------------------------//
  $tot_25_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '25'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_25_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '25'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_25_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '25'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_25_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '25'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_25_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '25'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_25_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '25'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_25_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '25'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_25_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '25'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU'],
             ['estudiantes.egresado','=','0']])
    ->count();

  $tot_25_T_S = $tot_25_1_S +
                $tot_25_2_S +
                $tot_25_3_S +
                $tot_25_4_S +
                $tot_25_5_S +
                $tot_25_6_S +
                $tot_25_7_S +
                $tot_25_8_S ;
  //---------------------------------- 26---------------------------------//
  $tot_26_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '26'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_26_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '26'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_26_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '26'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_26_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '26'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_26_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '26'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_26_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '26'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_26_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '26'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_26_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '26'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU'],
             ['estudiantes.egresado','=','0']])
    ->count();

  $tot_26_T_S = $tot_26_1_S +
                $tot_26_2_S +
                $tot_26_3_S +
                $tot_26_4_S +
                $tot_26_5_S +
                $tot_26_6_S +
                $tot_26_7_S +
                $tot_26_8_S ;


  //----------------------------------27---------------------------------//
  $tot_27_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '27'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_27_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '27'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_27_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '27'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_27_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '27'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_27_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '27'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_27_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '27'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_27_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '27'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_27_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '27'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU'],
             ['estudiantes.egresado','=','0']])
    ->count();

  $tot_27_T_S = $tot_27_1_S +
                $tot_27_2_S +
                $tot_27_3_S +
                $tot_27_4_S +
                $tot_27_5_S +
                $tot_27_6_S +
                $tot_27_7_S +
                $tot_27_8_S ;


  //---------------------------------- 28---------------------------------//
  $tot_28_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '28'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_28_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '28'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_28_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '28'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_28_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '28'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_28_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '28'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_28_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '28'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_28_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '28'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_28_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '28'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU'],
             ['estudiantes.egresado','=','0']])
    ->count();

  $tot_28_T_S = $tot_28_1_S +
                $tot_28_2_S +
                $tot_28_3_S +
                $tot_28_4_S +
                $tot_28_5_S +
                $tot_28_6_S +
                $tot_28_7_S +
                $tot_28_8_S ;


  //---------------------------------- 29---------------------------------//
  $tot_29_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '29'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_29_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '29'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_29_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '29'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_29_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '29'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_29_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '29'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_29_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '29'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_29_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '29'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_29_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '=', '29'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU'],
             ['estudiantes.egresado','=','0']])
    ->count();

  $tot_29_T_S = $tot_29_1_S +
                $tot_29_2_S +
                $tot_29_3_S +
                $tot_29_4_S +
                $tot_29_5_S +
                $tot_29_6_S +
                $tot_29_7_S +
                $tot_29_8_S ;

  //----------------------------------30-34--------------------------------//
  $tot_30_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_30_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_30_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_30_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_30_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_30_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_30_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_30_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU'],
             ['estudiantes.egresado','=','0']])
    ->count();

  $tot_30_T_S = $tot_30_1_S +
                $tot_30_2_S +
                $tot_30_3_S +
                $tot_30_4_S +
                $tot_30_5_S +
                $tot_30_6_S +
                $tot_30_7_S +
                $tot_30_8_S ;

  //----------------------------------35-40--------------------------------//
  $tot_35_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_35_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_35_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_35_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_35_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_35_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_35_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_35_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU'],
             ['estudiantes.egresado','=','0']])
    ->count();

  $tot_35_T_S = $tot_35_1_S +
                $tot_35_2_S +
                $tot_35_3_S +
                $tot_35_4_S +
                $tot_35_5_S +
                $tot_35_6_S +
                $tot_35_7_S +
                $tot_35_8_S ;

  //---------------------------------->=40--------------------------------//
  $tot_40_1_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '>=', '40'],
             ['estudiantes.semestre','=','1'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_40_2_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '>=', '40'],
             ['estudiantes.semestre','=','2'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_40_3_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '>=', '40'],
             ['estudiantes.semestre','=','3'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_40_4_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '>=', '40'],
             ['estudiantes.semestre','=','4'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_40_5_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '>=', '40'],
             ['estudiantes.semestre','=','5'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_40_6_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '>=', '40'],
             ['estudiantes.semestre','=','6'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_40_7_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '>=', '40'],
             ['estudiantes.semestre','=','7'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

  $tot_40_8_S = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.edad', '>=', '40'],
             ['estudiantes.semestre','=','8'],
             ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
             ['estudiantes.sede','=','CU']])
    ->count();

    $tot_40_T_S = $tot_40_1_S +
                  $tot_40_2_S +
                  $tot_40_3_S +
                  $tot_40_4_S +
                  $tot_40_5_S +
                  $tot_40_6_S +
                  $tot_40_7_S +
                  $tot_40_8_S ;

  //-----------------------------------------------------------------------------------------------------------------------//
  $tot_G_1_S = $tot_m_18_1_S + $tot_18_1_S + $tot_19_1_S + $tot_20_1_S + $tot_21_1_S + $tot_22_1_S
             + $tot_23_1_S + $tot_24_1_S + $tot_25_1_S + $tot_26_1_S + $tot_27_1_S + $tot_28_1_S
             + $tot_29_1_S + $tot_30_1_S + $tot_35_1_S + $tot_40_1_S ;

  $tot_G_2_S = $tot_m_18_2_S + $tot_18_2_S + $tot_19_2_S + $tot_20_2_S + $tot_21_2_S + $tot_22_2_S
             + $tot_23_2_S + $tot_24_2_S + $tot_25_2_S + $tot_26_2_S + $tot_27_2_S + $tot_28_2_S
             + $tot_29_2_S + $tot_30_2_S + $tot_35_2_S + $tot_40_2_S ;

  $tot_G_3_S = $tot_m_18_3_S + $tot_18_3_S + $tot_19_3_S + $tot_20_3_S + $tot_21_3_S + $tot_22_3_S
             + $tot_23_3_S + $tot_24_3_S + $tot_25_3_S + $tot_26_3_S + $tot_27_3_S + $tot_28_3_S
             + $tot_29_3_S + $tot_30_3_S + $tot_35_3_S + $tot_40_3_S ;

  $tot_G_4_S = $tot_m_18_4_S + $tot_18_4_S + $tot_19_4_S + $tot_20_4_S + $tot_21_4_S + $tot_22_4_S
             + $tot_23_4_S + $tot_24_4_S + $tot_25_4_S + $tot_26_4_S + $tot_27_4_S + $tot_28_4_S
             + $tot_29_4_S + $tot_30_4_S + $tot_35_4_S + $tot_40_4_S ;

  $tot_G_5_S = $tot_m_18_5_S + $tot_18_5_S + $tot_19_5_S + $tot_20_5_S + $tot_21_5_S + $tot_22_5_S
             + $tot_23_5_S + $tot_24_5_S + $tot_25_5_S + $tot_26_5_S + $tot_27_5_S + $tot_28_5_S
             + $tot_29_5_S + $tot_30_5_S + $tot_35_5_S + $tot_40_5_S ;

  $tot_G_6_S = $tot_m_18_6_S + $tot_18_6_S + $tot_19_6_S + $tot_20_6_S + $tot_21_6_S + $tot_22_6_S
             + $tot_23_6_S + $tot_24_6_S + $tot_25_6_S + $tot_26_6_S + $tot_27_6_S + $tot_28_6_S
             + $tot_29_6_S + $tot_30_6_S + $tot_35_6_S + $tot_40_6_S ;

  $tot_G_7_S = $tot_m_18_7_S + $tot_18_7_S + $tot_19_7_S + $tot_20_7_S + $tot_21_7_S + $tot_22_7_S
             + $tot_23_7_S + $tot_24_7_S + $tot_25_7_S + $tot_26_7_S + $tot_27_7_S + $tot_28_7_S
             + $tot_29_7_S + $tot_30_7_S + $tot_35_7_S + $tot_40_7_S ;

  $tot_G_8_S = $tot_m_18_8_S + $tot_18_8_S + $tot_19_8_S + $tot_20_8_S + $tot_21_8_S + $tot_22_8_S
             + $tot_23_8_S + $tot_24_8_S + $tot_25_8_S + $tot_26_8_S + $tot_27_8_S + $tot_28_8_S
             + $tot_29_8_S + $tot_30_8_S + $tot_35_8_S + $tot_40_8_S ;

  $tot_G_T_S = $tot_G_1_S + $tot_G_2_S + $tot_G_3_S + $tot_G_4_S + $tot_G_5_S + $tot_G_6_S + $tot_G_7_S + $tot_G_8_S;
return view('personal_administrativo/auxiliar_administrativo/planeacionsemiesco/reporte911_9as.reporte911_9a3s')
//----------------------------------------------------------------------------SEMIESCO
//-------------------------------------CU
//------------------<18
->with('tot_m_18_1_S', $tot_m_18_1_S)
->with('tot_m_18_2_S', $tot_m_18_2_S)
->with('tot_m_18_3_S', $tot_m_18_3_S)
->with('tot_m_18_4_S', $tot_m_18_4_S)
->with('tot_m_18_5_S', $tot_m_18_5_S)
->with('tot_m_18_6_S', $tot_m_18_6_S)
->with('tot_m_18_7_S', $tot_m_18_7_S)
->with('tot_m_18_8_S', $tot_m_18_8_S)
->with('tot_m_18_T_S', $tot_m_18_T_S)
//------------------18
->with('tot_18_1_S', $tot_18_1_S)
->with('tot_18_2_S', $tot_18_2_S)
->with('tot_18_3_S', $tot_18_3_S)
->with('tot_18_4_S', $tot_18_4_S)
->with('tot_18_5_S', $tot_18_5_S)
->with('tot_18_6_S', $tot_18_6_S)
->with('tot_18_7_S', $tot_18_7_S)
->with('tot_18_8_S', $tot_18_8_S)
->with('tot_18_T_S', $tot_18_T_S)

//------------------19
->with('tot_19_1_S', $tot_19_1_S)
->with('tot_19_2_S', $tot_19_2_S)
->with('tot_19_3_S', $tot_19_3_S)
->with('tot_19_4_S', $tot_19_4_S)
->with('tot_19_5_S', $tot_19_5_S)
->with('tot_19_6_S', $tot_19_6_S)
->with('tot_19_7_S', $tot_19_7_S)
->with('tot_19_8_S', $tot_19_8_S)
->with('tot_19_T_S', $tot_19_T_S)

//------------------20
->with('tot_20_1_S', $tot_20_1_S)
->with('tot_20_2_S', $tot_20_2_S)
->with('tot_20_3_S', $tot_20_3_S)
->with('tot_20_4_S', $tot_20_4_S)
->with('tot_20_5_S', $tot_20_5_S)
->with('tot_20_6_S', $tot_20_6_S)
->with('tot_20_7_S', $tot_20_7_S)
->with('tot_20_8_S', $tot_20_8_S)
->with('tot_20_T_S', $tot_20_T_S)

//------------------21
->with('tot_21_1_S', $tot_21_1_S)
->with('tot_21_2_S', $tot_21_2_S)
->with('tot_21_3_S', $tot_21_3_S)
->with('tot_21_4_S', $tot_21_4_S)
->with('tot_21_5_S', $tot_21_5_S)
->with('tot_21_6_S', $tot_21_6_S)
->with('tot_21_7_S', $tot_21_7_S)
->with('tot_21_8_S', $tot_21_8_S)
->with('tot_21_T_S', $tot_21_T_S)

//------------------22
->with('tot_22_1_S', $tot_22_1_S)
->with('tot_22_2_S', $tot_22_2_S)
->with('tot_22_3_S', $tot_22_3_S)
->with('tot_22_4_S', $tot_22_4_S)
->with('tot_22_5_S', $tot_22_5_S)
->with('tot_22_6_S', $tot_22_6_S)
->with('tot_22_7_S', $tot_22_7_S)
->with('tot_22_8_S', $tot_22_8_S)
->with('tot_22_T_S', $tot_22_T_S)

//------------------23
->with('tot_23_1_S', $tot_23_1_S)
->with('tot_23_2_S', $tot_23_2_S)
->with('tot_23_3_S', $tot_23_3_S)
->with('tot_23_4_S', $tot_23_4_S)
->with('tot_23_5_S', $tot_23_5_S)
->with('tot_23_6_S', $tot_23_6_S)
->with('tot_23_7_S', $tot_23_7_S)
->with('tot_23_8_S', $tot_23_8_S)
->with('tot_23_T_S', $tot_23_T_S)

//------------------24
->with('tot_24_1_S', $tot_24_1_S)
->with('tot_24_2_S', $tot_24_2_S)
->with('tot_24_3_S', $tot_24_3_S)
->with('tot_24_4_S', $tot_24_4_S)
->with('tot_24_5_S', $tot_24_5_S)
->with('tot_24_6_S', $tot_24_6_S)
->with('tot_24_7_S', $tot_24_7_S)
->with('tot_24_8_S', $tot_24_8_S)
->with('tot_24_T_S', $tot_24_T_S)

//------------------25
->with('tot_25_1_S', $tot_25_1_S)
->with('tot_25_2_S', $tot_25_2_S)
->with('tot_25_3_S', $tot_25_3_S)
->with('tot_25_4_S', $tot_25_4_S)
->with('tot_25_5_S', $tot_25_5_S)
->with('tot_25_6_S', $tot_25_6_S)
->with('tot_25_7_S', $tot_25_7_S)
->with('tot_25_8_S', $tot_25_8_S)
->with('tot_25_T_S', $tot_25_T_S)

//------------------26
->with('tot_26_1_S', $tot_26_1_S)
->with('tot_26_2_S', $tot_26_2_S)
->with('tot_26_3_S', $tot_26_3_S)
->with('tot_26_4_S', $tot_26_4_S)
->with('tot_26_5_S', $tot_26_5_S)
->with('tot_26_6_S', $tot_26_6_S)
->with('tot_26_7_S', $tot_26_7_S)
->with('tot_26_8_S', $tot_26_8_S)
->with('tot_26_T_S', $tot_26_T_S)

//------------------27
->with('tot_27_1_S', $tot_27_1_S)
->with('tot_27_2_S', $tot_27_2_S)
->with('tot_27_3_S', $tot_27_3_S)
->with('tot_27_4_S', $tot_27_4_S)
->with('tot_27_5_S', $tot_27_5_S)
->with('tot_27_6_S', $tot_27_6_S)
->with('tot_27_7_S', $tot_27_7_S)
->with('tot_27_8_S', $tot_27_8_S)
->with('tot_27_T_S', $tot_27_T_S)

//------------------28
->with('tot_28_1_S', $tot_28_1_S)
->with('tot_28_2_S', $tot_28_2_S)
->with('tot_28_3_S', $tot_28_3_S)
->with('tot_28_4_S', $tot_28_4_S)
->with('tot_28_5_S', $tot_28_5_S)
->with('tot_28_6_S', $tot_28_6_S)
->with('tot_28_7_S', $tot_28_7_S)
->with('tot_28_8_S', $tot_28_8_S)
->with('tot_28_T_S', $tot_28_T_S)

//------------------29
->with('tot_29_1_S', $tot_29_1_S)
->with('tot_29_2_S', $tot_29_2_S)
->with('tot_29_3_S', $tot_29_3_S)
->with('tot_29_4_S', $tot_29_4_S)
->with('tot_29_5_S', $tot_29_5_S)
->with('tot_29_6_S', $tot_29_6_S)
->with('tot_29_7_S', $tot_29_7_S)
->with('tot_29_8_S', $tot_29_8_S)
->with('tot_29_T_S', $tot_29_T_S)

//------------------30 - 34
->with('tot_30_1_S', $tot_30_1_S)
->with('tot_30_2_S', $tot_30_2_S)
->with('tot_30_3_S', $tot_30_3_S)
->with('tot_30_4_S', $tot_30_4_S)
->with('tot_30_5_S', $tot_30_5_S)
->with('tot_30_6_S', $tot_30_6_S)
->with('tot_30_7_S', $tot_30_7_S)
->with('tot_30_8_S', $tot_30_8_S)
->with('tot_30_T_S', $tot_30_T_S)

//------------------35 - 39
->with('tot_35_1_S', $tot_35_1_S)
->with('tot_35_2_S', $tot_35_2_S)
->with('tot_35_3_S', $tot_35_3_S)
->with('tot_35_4_S', $tot_35_4_S)
->with('tot_35_5_S', $tot_35_5_S)
->with('tot_35_6_S', $tot_35_6_S)
->with('tot_35_7_S', $tot_35_7_S)
->with('tot_35_8_S', $tot_35_8_S)
->with('tot_35_T_S', $tot_35_T_S)

//---------------->=40
->with('tot_40_1_S', $tot_40_1_S)
->with('tot_40_2_S', $tot_40_2_S)
->with('tot_40_3_S', $tot_40_3_S)
->with('tot_40_4_S', $tot_40_4_S)
->with('tot_40_5_S', $tot_40_5_S)
->with('tot_40_6_S', $tot_40_6_S)
->with('tot_40_7_S', $tot_40_7_S)
->with('tot_40_8_S', $tot_40_8_S)
->with('tot_40_T_S', $tot_40_T_S)

//-----------------------------------TOTALES
->with('tot_G_1_S', $tot_G_1_S)
->with('tot_G_2_S', $tot_G_2_S)
->with('tot_G_3_S', $tot_G_3_S)
->with('tot_G_4_S', $tot_G_4_S)
->with('tot_G_5_S', $tot_G_5_S)
->with('tot_G_6_S', $tot_G_6_S)
->with('tot_G_7_S', $tot_G_7_S)
->with('tot_G_8_S', $tot_G_8_S)
->with('tot_G_T_S', $tot_G_T_S)
;

}

 public function download($file_name) 
 { 
 $file_path =  public_path('/lineamientos_es/'.$file_name); 
 return response()->download($file_path); 
 }


}
