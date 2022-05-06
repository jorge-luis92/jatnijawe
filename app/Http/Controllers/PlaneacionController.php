<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Carrera;
use App\Escuela;
use App\Persona;
use App\Direccion;
use App\Administrativo;
use App\CodigoPostal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class PlaneacionController extends Controller
{

  public function home_planeacion(){
    return view('personal_administrativo/planeacion.home_planeacion');
  }
  
  public function cuenta_planeacion(){
      $usuario_actual=\Auth::user();
       if($usuario_actual->tipo_usuario!='2'){
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
	
	
    return view('personal_administrativo/planeacion.configuracion_cuenta_planeacion')->with('datos_usuario', $users);
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
            return redirect()->route('cuenta_planeacion')->with('success','Contraseña Actualizada Correctamente');
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
            return redirect()->route('cuenta_planeacion')->with('success','El nombre de usuario se ha actualizado correctamente');
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
            return redirect()->route('cuenta_planeacion')->with('success','El correo se ha actualizado correctamente');
          }

      }
	  
	  	   public function datos_personales_planeacion(Request $request){
			   	  $usuario_actual=auth()->user();
	$id=$usuario_actual->id_user;
	$data = $request;
   DB::table('personas')
      ->where('personas.id_persona', $id)
      ->update([ 'nombre' => $data['nombre'] ,'apellido_paterno' => $data['apellido_paterno'], 'apellido_materno' => $data['apellido_materno'],
                'genero' => $data['genero']]);
          
            return redirect()->route('cuenta_planeacion')->with('success','Datos actualizados correctamente');
          

      }

/*INFO COORDINACION ACADEMICA*/
  public function info_coord_academica1(){

/*ESTUDIANTES INSCRITOS EN EL CICLO ESCOLAR ACTUAL*/
/*MODALIDAD ESCOLARIZADA*/
//---------------------------------------------------------------------/*CU*/
/*MASCULINO*/
$actualM=DB::select
('SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="M"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="CU"
    AND estudiantes.egresado="0"
    GROUP BY personas.genero');
    $totalactualM=$actualM[0]->total;

/*FEMENINO*/
$actualF=DB::select
('SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="F"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="CU"
    AND estudiantes.egresado="0"
    GROUP BY personas.genero');
    $totalactualF=$actualF[0]->total;

/*TOTAL*/

$actualT=DB::select
('SELECT SUM(total) as tot
  FROM (SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="CU"
    AND estudiantes.egresado="0"
    GROUP BY personas.genero) AS T');
    $totalactualT=$actualT[0]->tot;

/*CON DISCAPACIDAD*/
$discapacidadesCU=DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.modalidad="ESCOLARIZADA"
AND estudiantes.sede="CU"
AND estudiantes.egresado="0"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$discapacidadesTCU=$discapacidadesCU[0]->tot;

/*HABLANTE DE LENGUA*/
$conteo_lengua = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.lengua', '=', '1'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
         ['estudiantes.egresado', '=','0']])
->count();

//--------------------------------------------------------------/*TEHUANTEPEC*/
/*MASCULINO*/
$actualMT=DB::select
('SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="M"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="TEHUANTEPEC"
    AND estudiantes.egresado="0"
    GROUP BY personas.genero');
    $totalactualMT=$actualMT[0]->total;

/*FEMENINO*/
$actualFT=DB::select
('SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="F"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="TEHUANTEPEC"
    AND estudiantes.egresado="0"
    GROUP BY personas.genero');
    $totalactualFT=$actualFT[0]->total;

/*TOTAL*/
$actualTT=DB::select
('SELECT SUM(total) as tot
  FROM (SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="TEHUANTEPEC"
    AND estudiantes.egresado="0"
    GROUP BY personas.genero) AS T');
    $totalactualTT=$actualTT[0]->tot;

/*CON DISCAPACIDAD*/
$discapacidadesT=DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.modalidad="ESCOLARIZADA"
AND estudiantes.sede="TEHUANTEPEC"
AND estudiantes.egresado="0"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$discapacidadesT=$discapacidadesT[0]->tot;

/*HABLANTE DE LENGUA*/
$conteo_lenguaT = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.lengua', '=', '1'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'TEHUANTEPEC'],
         ['estudiantes.egresado', '=', '0']])
->count();


//--------------------------------------------------------------/*PUERTO ESCONDIDO*/
/*MASCULINO*/
$actualMP=DB::select
('SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="M"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="PUERTO ESCONDIDO"
    AND estudiantes.egresado="0"
    GROUP BY personas.genero');
    $totalactualMP=$actualMP[0]->total;

/*FEMENINO*/
$actualFP=DB::select
('SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="F"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="PUERTO ESCONDIDO"
    AND estudiantes.egresado="0"
    GROUP BY personas.genero');
    $totalactualFP=$actualFP[0]->total;

/*TOTAL*/
$actualTP=DB::select
('SELECT SUM(total) as tot
  FROM (SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="PUERTO ESCONDIDO"
    AND estudiantes.egresado="0"
    GROUP BY personas.genero) AS T');
    $totalactualTP=$actualTP[0]->tot;

/*CON DISCAPACIDAD*/
$discapacidadesP=DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.modalidad="ESCOLARIZADA"
AND estudiantes.sede="PUERTO ESCONDIDO"
AND estudiantes.egresado="0"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$discapacidadesP=$discapacidadesP[0]->tot;

/*HABLANTE DE LENGUA*/
$conteo_lenguaP = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.lengua', '=', '1'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
         ['estudiantes.egresado', '=', '0']])
->count();

/*MODALIDAD SEMIESCOLARIZADA*/
//---------------------------------------------------------------------/*CU*/
/*MASCULINO*/
$actualMS=DB::select
('SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="M"
    AND estudiantes.modalidad="SEMIESCOLARIZADA"
    AND estudiantes.sede="CU"
    AND estudiantes.egresado="0"
    GROUP BY personas.genero');
    $totalactualMS=$actualMS[0]->total;

/*FEMENINO*/
$actualFS=DB::select
('SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="F"
    AND estudiantes.modalidad="SEMIESCOLARIZADA"
    AND estudiantes.sede="CU"
    AND estudiantes.egresado="0"
    GROUP BY personas.genero');
    $totalactualFS=$actualFS[0]->total;

/*TOTAL*/
$actualTS=DB::select
('SELECT SUM(total) as tot
  FROM (SELECT personas.genero, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.modalidad="SEMIESCOLARIZADA"
    AND estudiantes.sede="CU"
    AND estudiantes.egresado="0"
    GROUP BY personas.genero) AS T');
    $totalactualTS=$actualTS[0]->tot;

/*CON DISCAPACIDAD*/
$discapacidadesCUS=DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.modalidad="SEMIESCOLARIZADA"
AND estudiantes.sede="CU"
AND estudiantes.egresado="0"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$discapacidadesTCUS=$discapacidadesCUS[0]->tot;

/*HABLANTE DE LENGUA*/
$conteo_lenguaS = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.lengua', '=', '1'],
         ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
         ['estudiantes.sede', '=', 'CU'],
         ['estudiantes.egresado','=','0']])
->count();

//-------------------------------------------------------------------/*TOTAL*/
/*MASCULINO*/
$totalactualMG= $totalactualM  +  $totalactualMT + $totalactualMP + $totalactualMS;

/*FEMENINO*/
$totalactualFG = $totalactualF + $totalactualFT + $totalactualFP + $totalactualFS;

/*TOTAL*/
$totalactualTG = $totalactualT + $totalactualTT + $totalactualTP + $totalactualTS;

/*CON DISCAPACIDAD*/
$discapacidadesG = $discapacidadesTCU + $discapacidadesT + $discapacidadesP + $discapacidadesTCUS;


/*HABLANTE DE LENGUA*/
$conteo_lenguaG = $conteo_lengua + $conteo_lenguaT + $conteo_lenguaP + $conteo_lenguaS;


    return view('personal_administrativo/planeacion/info_departamentos/info_coord_academica.info_coord_academica1')

    //------------------------------------------------------------------MODALIDAD ESCOLARIZADA
    //--------------------------------------------------------------------------------------CU

    ->with('totalactualM', $totalactualM)
    ->with('totalactualF', $totalactualF)
    ->with('totalactualT', $totalactualT)
    ->with('discapacidadesTCU', $discapacidadesTCU)
    ->with('conteo_lengua', $conteo_lengua)

    //-----------------------------------------------------------------------------------TEHUANTEPEC

    ->with('totalactualMT', $totalactualMT)
    ->with('totalactualFT', $totalactualFT)
    ->with('totalactualTT', $totalactualTT)
    ->with('discapacidadesT', $discapacidadesT)
    ->with('conteo_lenguaT', $conteo_lenguaT)

    //-----------------------------------------------------------------------------------PUERTO ESCONDIDO

    ->with('totalactualMP', $totalactualMP)
    ->with('totalactualFP', $totalactualFP)
    ->with('totalactualTP', $totalactualTP)
    ->with('discapacidadesP', $discapacidadesP)
    ->with('conteo_lenguaP', $conteo_lenguaP)

    //------------------------------------------------------------------MODALIDAD SEMIESCOLARIZADA
    //--------------------------------------------------------------------------------------CU

    ->with('totalactualMS', $totalactualMS)
    ->with('totalactualFS', $totalactualFS)
    ->with('totalactualTS', $totalactualTS)
    ->with('discapacidadesTCUS', $discapacidadesTCUS)
    ->with('conteo_lenguaS', $conteo_lenguaS)

    //------------------------------------------------------------------TOTAL GENERAL
    ->with('totalactualMG', $totalactualMG)
    ->with('totalactualFG', $totalactualFG)
    ->with('totalactualTG', $totalactualTG)
    ->with('discapacidadesG', $discapacidadesG)
    ->with('conteo_lenguaG', $conteo_lenguaG)
;
}


public function info_coord_academica2(){
  //ESTUDIANTES BECADOS DEL CICLO ESCOLAR ACTUAL CU
  //MODALIDAD ESCOLARIZADA
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



  return view('personal_administrativo/planeacion/info_departamentos/info_coord_academica.info_coord_academica2')
  /*CU*/
    ->with('sql_BECA_ESC', $sql_BECA_ESC)
    ->with('tipos_becas_ESC_M', $tipos_becas_ESC_M)
    ->with('tipos_becas_ESC_F', $tipos_becas_ESC_F)
    ->with('tipos_becas_ESC_G', $tipos_becas_ESC_G)
    ->with('tipos_becas_esco_D', $tipos_becas_esco_D)
    ->with('tipos_becas_esco_L', $tipos_becas_esco_L)
    ->with('$sql_BECA_SEMI', $sql_BECA_SEMI)
    ->with('tipos_becas_SEMI_M', $tipos_becas_SEMI_M )
    ->with('tipos_becas_SEMI_F', $tipos_becas_SEMI_F )
    ->with('tipos_becas_SEMI_G', $tipos_becas_SEMI_G )
    ->with('tipos_becas_semi_D', $tipos_becas_semi_D )
    ->with('tipos_becas_semi_L', $tipos_becas_semi_L )
  ;


  }

public function info_coord_academica3(){

    //------HABLANTE DE LENGUA DEL CICLO ESCOLAR ACTUAL
    //------ MODALIDAD ESCO
  //-------------------------------  ----------------------- CU

  //-----MASCULINO---//
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
//--------FEMIENINO----//
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

    //------HABLANTE DE LENGUA MODALIDAD ESCO TEHUANTEPEC
  $total_lenguasMT=DB:: select('SELECT lenguas.nombre_lengua,
    COUNT(estudiantes.matricula) as total_lengua
    FROM personas, estudiantes, lenguas
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.sede="TEHUANTEPEC"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND personas.genero="M"
    AND personas.id_persona=lenguas.id_persona
    AND personas.lengua="1"
    AND lenguas.nombre_lengua IS NOT NULL
    GROUP BY lenguas.nombre_lengua');

  $total_lenguasFT=DB:: select('SELECT lenguas.nombre_lengua,
    COUNT(estudiantes.matricula) as total_lengua
    FROM personas, estudiantes, lenguas
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.sede="TEHUANTEPEC"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND personas.genero="F"
    AND personas.id_persona=lenguas.id_persona
    AND personas.lengua="1"
    AND lenguas.nombre_lengua IS NOT NULL
    GROUP BY lenguas.nombre_lengua');

    $total_lenguasET=DB:: select('SELECT lenguas.nombre_lengua,
    COUNT(estudiantes.matricula) as total_lengua
    FROM personas, estudiantes, lenguas
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.sede="TEHUANTEPEC"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND personas.id_persona=lenguas.id_persona
    AND personas.lengua="1"
    AND lenguas.nombre_lengua IS NOT NULL
    GROUP BY lenguas.nombre_lengua');

  $totalG_lenguasT=DB::select ('SELECT personas.genero,
  COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, lenguas
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=lenguas.id_persona
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND estudiantes.sede="TEHUANTEPEC"
  AND personas.lengua="1"
  AND lenguas.nombre_lengua IS NOT NULL
  GROUP BY personas.genero');
  $count_totalG_lenguasT = count($totalG_lenguasT);
  $totalG_femeninoLT = 0;
  $totalG_masculinoLT = 0;
  if ($count_totalG_lenguasT > 0) {
        $totalG_femeninoLT = $totalG_lenguasT[0]->total;
         if ($count_totalG_lenguasT == 2) {
             $totalG_masculinoLT = $totalG_lenguasT[1]->total;
         }
  }

    $totalGLMFT= $totalG_femeninoLT + $totalG_masculinoLT;

    //------HABLANTE DE LENGUA MODALIDAD ESCO PUERTO ESCONDIDO
  $total_lenguasMPE=DB:: select('SELECT lenguas.nombre_lengua,
    COUNT(estudiantes.matricula) as total_lengua
    FROM personas, estudiantes, lenguas
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.sede="PUERTO ESCONDIDO"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND personas.genero="M"
    AND personas.lengua="1"
    AND lenguas.nombre_lengua IS NOT NULL
    AND personas.id_persona=lenguas.id_persona
    GROUP BY lenguas.nombre_lengua');

  $total_lenguasFPE=DB:: select('SELECT lenguas.nombre_lengua,
    COUNT(estudiantes.matricula) as total_lengua
    FROM personas, estudiantes, lenguas
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.sede="PUERTO ESCONDIDO"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND personas.genero="F"
    AND personas.id_persona=lenguas.id_persona
    AND personas.lengua="1"
    AND lenguas.nombre_lengua IS NOT NULL
    GROUP BY lenguas.nombre_lengua');

    $total_lenguasEPE=DB:: select('SELECT lenguas.nombre_lengua,
    COUNT(estudiantes.matricula) as total_lengua
    FROM personas, estudiantes, lenguas
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.sede="PUERTO ESCONDIDO"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND personas.id_persona=lenguas.id_persona
    AND personas.lengua="1"
    AND lenguas.nombre_lengua IS NOT NULL
    GROUP BY lenguas.nombre_lengua');

  $totalG_lenguasPE=DB::select ('SELECT personas.genero,
  COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, lenguas
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=lenguas.id_persona
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND estudiantes.sede="PUERTO ESCONDIDO"
  AND personas.lengua="1"
  AND lenguas.nombre_lengua IS NOT NULL
  GROUP BY personas.genero');
  $count_totalG_lenguasPE = count($totalG_lenguasPE);
  $totalG_femeninoLPE = 0;
  $totalG_masculinoLPE = 0;
  if ($count_totalG_lenguasPE > 0) {
        $totalG_femeninoLPE = $totalG_lenguasPE[0]->total;
         if ($count_totalG_lenguasPE == 2) {
             $totalG_masculinoLPE = $totalG_lenguasPE[1]->total;
         }
  }

    $totalGLMFPE= $totalG_femeninoLPE + $totalG_masculinoLPE;


    //------HABLANTE DE LENGUA MODALIDAD SEMIESCO CU

    $total_lenguasMS=DB:: select('SELECT lenguas.nombre_lengua,
    COUNT(estudiantes.matricula) as total_lengua
    FROM personas, estudiantes, lenguas
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.sede="CU"
    AND estudiantes.modalidad="SEMIESCOLARIZADA"
    AND personas.genero="M"
    AND personas.id_persona=lenguas.id_persona
    AND personas.lengua="1"
    AND lenguas.nombre_lengua IS NOT NULL
    GROUP BY lenguas.nombre_lengua');

   $total_lenguasFS=DB:: select('SELECT lenguas.nombre_lengua,
    COUNT(estudiantes.matricula) as total_lengua
    FROM personas, estudiantes, lenguas
    WHERE personas.id_persona=estudiantes.id_persona
    AND estudiantes.sede="CU"
    AND estudiantes.modalidad="SEMIESCOLARIZADA"
    AND personas.genero="F"
    AND personas.id_persona=lenguas.id_persona
    AND personas.lengua="1"
    AND lenguas.nombre_lengua IS NOT NULL
    GROUP BY lenguas.nombre_lengua');

    $total_lenguasS=DB:: select('SELECT lenguas.nombre_lengua,
     COUNT(estudiantes.matricula) as total_lengua
     FROM personas, estudiantes, lenguas
     WHERE personas.id_persona=estudiantes.id_persona
     AND estudiantes.sede="CU"
     AND estudiantes.modalidad="SEMIESCOLARIZADA"
     AND personas.id_persona=lenguas.id_persona
     AND personas.lengua="1"
     AND lenguas.nombre_lengua IS NOT NULL
     GROUP BY lenguas.nombre_lengua');


  $totalGS_lenguas=DB::select ('SELECT personas.genero,
  COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, lenguas
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=lenguas.id_persona
  AND estudiantes.modalidad="SEMIESCOLARIZADA"
  AND estudiantes.sede="CU"
  AND personas.lengua="1"
  AND lenguas.nombre_lengua IS NOT NULL
  GROUP BY personas.genero');
  $count_totalGS_lenguas = count($totalGS_lenguas);
  $totalGS_femeninoL = 0;
  $totalGS_masculinoL = 0;
  if ($count_totalGS_lenguas > 0) {
         $totalGS_femeninoL = $totalGS_lenguas[0]->total;
          if ($count_totalGS_lenguas == 2) {
              $totalGS_masculinoL = $totalGS_lenguas[1]->total;
          }
  }


  $totalGSLMF= $totalGS_femeninoL + $totalGS_masculinoL;


  //------HABLANTE DE LENGUA GENERAL
$total_lenguasG=DB:: select('SELECT lenguas.nombre_lengua,
  COUNT(estudiantes.matricula) as total_lengua
  FROM personas, estudiantes, lenguas
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=lenguas.id_persona
  AND personas.lengua="1"
  AND lenguas.nombre_lengua IS NOT NULL
  GROUP BY lenguas.nombre_lengua');

$total_lenguasT=$totalGLMF + $totalGLMFT + $totalGLMFPE + $totalGSLMF;

    return view('personal_administrativo/planeacion/info_departamentos/info_coord_academica.info_coord_academica3')
    //------HABLANTE DE LENGUA MODALIDAD ESCO CU
    ->with('total_lenguasM', $total_lenguasM)->with('total_lenguasF', $total_lenguasF)
    ->with('totalG_femeninoL', $totalG_femeninoL)->with('totalG_masculinoL', $totalG_masculinoL)
    ->with('total_lenguasE',$total_lenguasE)
    ->with('totalGLMF', $totalGLMF)
    //------HABLANTE DE LENGUA MODALIDAD ESCO TEHUANTEPEC
    ->with('total_lenguasMT', $total_lenguasMT)->with('total_lenguasFT', $total_lenguasFT)
    ->with('totalG_femeninoLT', $totalG_femeninoLT)->with('totalG_masculinoLT', $totalG_masculinoLT)
    ->with('total_lenguasET',$total_lenguasET)
    ->with('totalGLMFT', $totalGLMFT)
    //------HABLANTE DE LENGUA MODALIDAD ESCO PUERTO ESCONDIDO
    ->with('total_lenguasMPE', $total_lenguasMPE)->with('total_lenguasFPE', $total_lenguasFPE)
    ->with('totalG_femeninoLPE', $totalG_femeninoLPE)->with('totalG_masculinoLPE', $totalG_masculinoLPE)
    ->with('total_lenguasEPE',$total_lenguasEPE)
    ->with('totalGLMFPE', $totalGLMFPE)
    //------HABLANTE DE LENGUA MODALIDAD SEMIESCO
    ->with('total_lenguasMS', $total_lenguasMS)->with('total_lenguasFS', $total_lenguasFS)
    ->with('totalGS_femeninoL', $totalGS_femeninoL)->with('totalGS_masculinoL', $totalGS_masculinoL)
    ->with('total_lenguasS',$total_lenguasS)
    ->with('totalGSLMF', $totalGSLMF)
    //------HABLANTE DE LENGUA GENERAL
    ->with('total_lenguasG', $total_lenguasG)
    ->with('total_lenguasT', $total_lenguasT)
    ;

  }

public function info_coord_academica4(){
//ESTUDIANTES QUE TIENEN ALGUNA ALERGIA/ENFERMEDAD ESCOLARIZADA
$total_enf_aler= ' SELECT enfermedades_alergias.tipo_enfermedadalergia,
COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, enfermedades_alergias
WHERE personas.id_persona=estudiantes.id_persona
AND estudiantes.matricula=enfermedades_alergias.matricula
AND estudiantes.modalidad="ESCOLARIZADA"
AND estudiantes.sede="CU"
AND personas.genero="M"
AND enfermedades_alergias.bandera="1"
GROUP BY enfermedades_alergias.tipo_enfermedadalergia';
  $ea_query = DB::select($total_enf_aler);
  $array_ea = array(
   "Alergia" => 0,
   "Enfermedad" => 0,
   "TOTAL" => 0
  );

  $tipos_eaM_ESC = array(
    "Alergia" => 0,
    "Enfermedad" => 0,
    "TOTAL" => 0
   );

for($i = 0; $i < count($ea_query); $i++) {
$sub = $ea_query[$i]->total;
$tipos_eaM_ESC[$ea_query[$i]->tipo_enfermedadalergia] = $sub;
$tipos_eaM_ESC['TOTAL'] += $sub;
$array_ea[$ea_query[$i]->tipo_enfermedadalergia] += $sub;
$array_ea['TOTAL'] += $sub;
}

$total_enf_alerF= ' SELECT enfermedades_alergias.tipo_enfermedadalergia,
COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, enfermedades_alergias
WHERE personas.id_persona=estudiantes.id_persona
AND estudiantes.matricula=enfermedades_alergias.matricula
AND estudiantes.modalidad="ESCOLARIZADA"
AND estudiantes.sede="CU"
AND personas.genero="F"
AND enfermedades_alergias.bandera="1"
GROUP BY enfermedades_alergias.tipo_enfermedadalergia';
$ea_query = DB::select($total_enf_alerF);
$tipos_eaF_ESC = array(
"Alergia" => 0,
"Enfermedad" => 0,
"TOTAL" => 0
);

for($i = 0; $i < count($ea_query); $i++) {
$sub = $ea_query[$i]->total;
$tipos_eaF_ESC[$ea_query[$i]->tipo_enfermedadalergia] = $sub;
$tipos_eaF_ESC['TOTAL'] += $sub;
$array_ea[$ea_query[$i]->tipo_enfermedadalergia] += $sub;
$array_ea['TOTAL'] += $sub;
}

$total_enf_alerT= ' SELECT enfermedades_alergias.tipo_enfermedadalergia,
COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, enfermedades_alergias
WHERE personas.id_persona=estudiantes.id_persona
AND estudiantes.matricula=enfermedades_alergias.matricula
AND estudiantes.modalidad="ESCOLARIZADA"
AND estudiantes.sede="CU"
AND enfermedades_alergias.bandera="1"
GROUP BY enfermedades_alergias.tipo_enfermedadalergia';
$ea_query = DB::select($total_enf_alerT);
$tipos_ea_ESC = array(
"Alergia" => 0,
"Enfermedad" => 0,
"TOTAL" => 0
);

for($i = 0; $i < count($ea_query); $i++) {
$sub = $ea_query[$i]->total;
$tipos_ea_ESC[$ea_query[$i]->tipo_enfermedadalergia] = $sub;
$tipos_ea_ESC['TOTAL'] += $sub;
$array_ea[$ea_query[$i]->tipo_enfermedadalergia] += $sub;
$array_ea['TOTAL'] += $sub;
}

//ESTUDIANTES QUE TIENEN ALGUNA ALERGIA/ENFERMEDAD SEMIESCO
$total_enf_alerSEMI= ' SELECT enfermedades_alergias.tipo_enfermedadalergia,
COUNT(estudiantes.matricula) as totalS
FROM personas, estudiantes, enfermedades_alergias
WHERE personas.id_persona=estudiantes.id_persona
AND estudiantes.matricula=enfermedades_alergias.matricula
AND estudiantes.modalidad="SEMIESCOLARIZADA"
AND estudiantes.sede="CU"
AND personas.genero="M"
AND enfermedades_alergias.bandera="1"
GROUP BY enfermedades_alergias.tipo_enfermedadalergia';
$ea_queryS = DB::select($total_enf_alerSEMI);
$array_eaS = array(
"Alergia" => 0,
"Enfermedad" => 0,
"TOTAL" => 0
);
$tipos_eaM_SEMI = array(
"Alergia" => 0,
"Enfermedad" => 0,
"TOTAL" => 0
);

for($i = 0; $i < count($ea_queryS); $i++) {
$sub = $ea_queryS[$i]->totalS;
$tipos_eaM_SEMI[$ea_queryS[$i]->tipo_enfermedadalergia] = $sub;
$tipos_eaM_SEMI['TOTAL'] += $sub;
$array_eaS[$ea_queryS[$i]->tipo_enfermedadalergia] += $sub;
$array_eaS['TOTAL'] += $sub;
}

$total_enf_alerFSEMI= ' SELECT enfermedades_alergias.tipo_enfermedadalergia,
COUNT(estudiantes.matricula) as totalS
FROM personas, estudiantes, enfermedades_alergias
WHERE personas.id_persona=estudiantes.id_persona
AND estudiantes.matricula=enfermedades_alergias.matricula
AND estudiantes.modalidad="SEMIESCOLARIZADA"
AND estudiantes.sede="CU"
AND personas.genero="F"
AND enfermedades_alergias.bandera="1"
GROUP BY enfermedades_alergias.tipo_enfermedadalergia';
$ea_queryS = DB::select($total_enf_alerFSEMI);

$tipos_eaF_SEMI = array(
"Alergia" => 0,
"Enfermedad" => 0,
"TOTAL" => 0
);

for($i = 0; $i < count($ea_queryS); $i++) {
$sub = $ea_queryS[$i]->totalS;
$tipos_eaF_SEMI[$ea_queryS[$i]->tipo_enfermedadalergia] = $sub;
$tipos_eaF_SEMI['TOTAL'] += $sub;
$array_eaS[$ea_queryS[$i]->tipo_enfermedadalergia] += $sub;
$array_eaS['TOTAL'] += $sub;
}


$total_enf_alerGSEMI= ' SELECT enfermedades_alergias.tipo_enfermedadalergia,
COUNT(estudiantes.matricula) as totalS
FROM personas, estudiantes, enfermedades_alergias
WHERE personas.id_persona=estudiantes.id_persona
AND estudiantes.matricula=enfermedades_alergias.matricula
AND estudiantes.modalidad="SEMIESCOLARIZADA"
AND estudiantes.sede="CU"
AND enfermedades_alergias.bandera="1"
GROUP BY enfermedades_alergias.tipo_enfermedadalergia';
$ea_queryS = DB::select($total_enf_alerGSEMI);

$tipos_eaG_SEMI = array(
"Alergia" => 0,
"Enfermedad" => 0,
"TOTAL" => 0
);

for($i = 0; $i < count($ea_queryS); $i++) {
$sub = $ea_queryS[$i]->totalS;
$tipos_eaG_SEMI[$ea_queryS[$i]->tipo_enfermedadalergia] = $sub;
$tipos_eaG_SEMI['TOTAL'] += $sub;
$array_eaS[$ea_queryS[$i]->tipo_enfermedadalergia] += $sub;
$array_eaS['TOTAL'] += $sub;
}

/*----------------------------------------------------------*/
//TOTAL DE ESTUDIANTES QUE TIENEN ALGUNA ALERGIA/ENFERMEDAD
//MASCULINO
$total_enf_alerT= ' SELECT enfermedades_alergias.tipo_enfermedadalergia,
COUNT(estudiantes.matricula) as totalT
FROM personas, estudiantes, enfermedades_alergias
WHERE personas.id_persona=estudiantes.id_persona
AND estudiantes.matricula=enfermedades_alergias.matricula
AND estudiantes.sede="CU"
AND personas.genero="M"
AND enfermedades_alergias.bandera="1"
GROUP BY enfermedades_alergias.tipo_enfermedadalergia';
$ea_queryT = DB::select($total_enf_alerT);
$array_eaT = array(
"Alergia" => 0,
"Enfermedad" => 0,
"TOTAL" => 0
);
$tipos_eaM_T = array(
"Alergia" => 0,
"Enfermedad" => 0,
"TOTAL" => 0
);

for($i = 0; $i < count($ea_queryT); $i++) {
$sub = $ea_queryT[$i]->totalT;
$tipos_eaM_T[$ea_queryT[$i]->tipo_enfermedadalergia] = $sub;
$tipos_eaM_T['TOTAL'] += $sub;
$array_eaT[$ea_queryT[$i]->tipo_enfermedadalergia] += $sub;
$array_eaT['TOTAL'] += $sub;
}
/*----------------------------------------------------------*/
//FEMENINO
$total_enf_alerTF= ' SELECT enfermedades_alergias.tipo_enfermedadalergia,
COUNT(estudiantes.matricula) as totalT
FROM personas, estudiantes, enfermedades_alergias
WHERE personas.id_persona=estudiantes.id_persona
AND estudiantes.matricula=enfermedades_alergias.matricula
AND estudiantes.sede="CU"
AND personas.genero="F"
AND enfermedades_alergias.bandera="1"
GROUP BY enfermedades_alergias.tipo_enfermedadalergia';
$ea_queryT = DB::select($total_enf_alerTF);

$tipos_eaM_TF = array(
"Alergia" => 0,
"Enfermedad" => 0,
"TOTAL" => 0
);

for($i = 0; $i < count($ea_queryT); $i++) {
$sub = $ea_queryT[$i]->totalT;
$tipos_eaM_TF[$ea_queryT[$i]->tipo_enfermedadalergia] = $sub;
$tipos_eaM_TF['TOTAL'] += $sub;
$array_eaT[$ea_queryT[$i]->tipo_enfermedadalergia] += $sub;
$array_eaT['TOTAL'] += $sub;
}
/*----------------------------------------------------------*/
/*----------------------------------------------------------*/
//TOTAL
$total_enf_alerTG= ' SELECT enfermedades_alergias.tipo_enfermedadalergia,
COUNT(estudiantes.matricula) as totalT
FROM personas, estudiantes, enfermedades_alergias
WHERE personas.id_persona=estudiantes.id_persona
AND estudiantes.matricula=enfermedades_alergias.matricula
AND estudiantes.sede="CU"
AND enfermedades_alergias.bandera="1"
GROUP BY enfermedades_alergias.tipo_enfermedadalergia';
$ea_queryT = DB::select($total_enf_alerTG);

$tipos_eaM_TG = array(
"Alergia" => 0,
"Enfermedad" => 0,
"TOTAL" => 0
);

for($i = 0; $i < count($ea_queryT); $i++) {
$sub = $ea_queryT[$i]->totalT;
$tipos_eaM_TG[$ea_queryT[$i]->tipo_enfermedadalergia] = $sub;
$tipos_eaM_TG['TOTAL'] += $sub;
$array_eaT[$ea_queryT[$i]->tipo_enfermedadalergia] += $sub;
$array_eaT['TOTAL'] += $sub;
}
/*----------------------------------------------------------*/

  return view('personal_administrativo/planeacion/info_departamentos/info_coord_academica.info_coord_academica4')
  ->with('array_ea', $array_ea)
  ->with('tipos_eaM_ESC', $tipos_eaM_ESC)
  ->with('tipos_eaF_ESC', $tipos_eaF_ESC)
  ->with('tipos_ea_ESC', $tipos_ea_ESC)
  ->with('array_eaS', $array_eaS)
  ->with('tipos_eaM_SEMI', $tipos_eaM_SEMI)
  ->with('tipos_eaF_SEMI', $tipos_eaF_SEMI)
  ->with('tipos_eaG_SEMI', $tipos_eaG_SEMI)
  ->with('array_eaT', $array_eaT)
  ->with('tipos_eaM_T',$tipos_eaM_T)
  ->with('tipos_eaM_TF',$tipos_eaM_TF)
  ->with('tipos_eaM_TG',$tipos_eaM_TG);
  }
  public function info_coord_academica5(){
    //----ESTUDIANTES DE LA MODALIDAD ESCOLARIZADA QUE REALIZAN OTRAS ACTIVIDADES
    //MASCULINO
    $sql_actext= 'SELECT datos_externos.tipo_actividadexterna, COUNT(estudiantes.matricula) as total_actext
                FROM personas, estudiantes, datos_externos
                WHERE personas.id_persona=estudiantes.id_persona
                AND estudiantes.matricula=datos_externos.matricula
                AND estudiantes.modalidad="ESCOLARIZADA"
                AND estudiantes.sede="CU"
                AND personas.genero="M"
                AND datos_externos.bandera="1"
                GROUP BY datos_externos.tipo_actividadexterna';
    $act_query = DB::select($sql_actext);
    $array_act = array(
     "Laboral" => 0,
     "Escolar" => 0,
     "TOTAL" => 0
    );

    $tipos_actextM_ESC = array(
      "Laboral" => 0,
      "Escolar" => 0,
      "TOTAL" => 0
     );

    for($i = 0; $i < count($act_query); $i++) {
      $sub = $act_query[$i]->total_actext;
      $tipos_actextM_ESC[$act_query[$i]->tipo_actividadexterna] = $sub;
      $tipos_actextM_ESC['TOTAL'] += $sub;
      $array_act[$act_query[$i]->tipo_actividadexterna] += $sub;
      $array_act['TOTAL'] += $sub;
    }

    //FEMENINO
    $sql_actext= 'SELECT datos_externos.tipo_actividadexterna, COUNT(estudiantes.matricula) as total_actext
                FROM personas, estudiantes, datos_externos
                WHERE personas.id_persona=estudiantes.id_persona
                AND estudiantes.matricula=datos_externos.matricula
                AND estudiantes.modalidad="ESCOLARIZADA"
                AND estudiantes.sede="CU"
                AND personas.genero="F"
                AND datos_externos.bandera="1"
                GROUP BY datos_externos.tipo_actividadexterna';
    $act_query = DB::select($sql_actext);
    $array_act = array(
     "Laboral" => 0,
     "Escolar" => 0,
     "TOTAL" => 0
    );

    $tipos_actextF_ESC = array(
      "Laboral" => 0,
      "Escolar" => 0,
      "TOTAL" => 0
     );

    for($i = 0; $i < count($act_query); $i++) {
      $sub = $act_query[$i]->total_actext;
      $tipos_actextF_ESC[$act_query[$i]->tipo_actividadexterna] = $sub;
      $tipos_actextF_ESC['TOTAL'] += $sub;
      $array_act[$act_query[$i]->tipo_actividadexterna] += $sub;
      $array_act['TOTAL'] += $sub;
    }

    //TOTAL
    $sql_actext= 'SELECT datos_externos.tipo_actividadexterna, COUNT(estudiantes.matricula) as total_actext
                FROM personas, estudiantes, datos_externos
                WHERE personas.id_persona=estudiantes.id_persona
                AND estudiantes.matricula=datos_externos.matricula
                AND estudiantes.modalidad="ESCOLARIZADA"
                AND estudiantes.sede="CU"
                AND datos_externos.bandera="1"
                GROUP BY datos_externos.tipo_actividadexterna';
    $act_query = DB::select($sql_actext);
    $array_act = array(
     "Laboral" => 0,
     "Escolar" => 0,
     "TOTAL" => 0
    );

    $tipos_actext_ESC = array(
      "Laboral" => 0,
      "Escolar" => 0,
      "TOTAL" => 0
     );

    for($i = 0; $i < count($act_query); $i++) {
      $sub = $act_query[$i]->total_actext;
      $tipos_actext_ESC[$act_query[$i]->tipo_actividadexterna] = $sub;
      $tipos_actext_ESC['TOTAL'] += $sub;
      $array_act[$act_query[$i]->tipo_actividadexterna] += $sub;
      $array_act['TOTAL'] += $sub;
    }



  //----ESTUDIANTES DE LA MODALIDAD SEMI ESCOLARIZADA QUE REALIZAN OTRAS ACTIVIDADES
  //MASCULINO

  $sql_actextS= 'SELECT datos_externos.tipo_actividadexterna, COUNT(estudiantes.matricula) as total_actext
              FROM personas, estudiantes, datos_externos
              WHERE personas.id_persona=estudiantes.id_persona
              AND estudiantes.matricula=datos_externos.matricula
              AND estudiantes.modalidad="SEMIESCOLARIZADA"
              AND estudiantes.sede="CU"
              AND personas.genero="M"
              AND datos_externos.bandera="1"
              GROUP BY datos_externos.tipo_actividadexterna';
  $act_query = DB::select($sql_actextS);
  $array_act = array(
   "Laboral" => 0,
   "Escolar" => 0,
   "TOTAL" => 0
  );

  $tipos_actextM_SEMI = array(
    "Laboral" => 0,
    "Escolar" => 0,
    "TOTAL" => 0
   );

  for($i = 0; $i < count($act_query); $i++) {
    $sub = $act_query[$i]->total_actext;
    $tipos_actextM_SEMI[$act_query[$i]->tipo_actividadexterna] = $sub;
    $tipos_actextM_SEMI['TOTAL'] += $sub;
    $array_act[$act_query[$i]->tipo_actividadexterna] += $sub;
    $array_act['TOTAL'] += $sub;
  }

  //FEMENINO
  $sql_actextS= 'SELECT datos_externos.tipo_actividadexterna, COUNT(estudiantes.matricula) as total_actext
              FROM personas, estudiantes, datos_externos
              WHERE personas.id_persona=estudiantes.id_persona
              AND estudiantes.matricula=datos_externos.matricula
              AND estudiantes.modalidad="SEMIESCOLARIZADA"
              AND estudiantes.sede="CU"
              AND personas.genero="F"
              AND datos_externos.bandera="1"
              GROUP BY datos_externos.tipo_actividadexterna';
  $act_query = DB::select($sql_actextS);
  $array_act = array(
   "Laboral" => 0,
   "Escolar" => 0,
   "TOTAL" => 0
  );

  $tipos_actextF_SEMI = array(
    "Laboral" => 0,
    "Escolar" => 0,
    "TOTAL" => 0
   );

  for($i = 0; $i < count($act_query); $i++) {
    $sub = $act_query[$i]->total_actext;
    $tipos_actextF_SEMI[$act_query[$i]->tipo_actividadexterna] = $sub;
    $tipos_actextF_SEMI['TOTAL'] += $sub;
    $array_act[$act_query[$i]->tipo_actividadexterna] += $sub;
    $array_act['TOTAL'] += $sub;
  }

  //TOTAL
  $sql_actextS= 'SELECT datos_externos.tipo_actividadexterna, COUNT(estudiantes.matricula) as total_actext
              FROM personas, estudiantes, datos_externos
              WHERE personas.id_persona=estudiantes.id_persona
              AND estudiantes.matricula=datos_externos.matricula
              AND estudiantes.modalidad="SEMIESCOLARIZADA"
              AND estudiantes.sede="CU"
              AND datos_externos.bandera="1"
              GROUP BY datos_externos.tipo_actividadexterna';
  $act_query = DB::select($sql_actextS);
  $array_act = array(
   "Laboral" => 0,
   "Escolar" => 0,
   "TOTAL" => 0
  );

  $tipos_actext_SEMI = array(
    "Laboral" => 0,
    "Escolar" => 0,
    "TOTAL" => 0
   );

  for($i = 0; $i < count($act_query); $i++) {
    $sub = $act_query[$i]->total_actext;
    $tipos_actext_SEMI[$act_query[$i]->tipo_actividadexterna] = $sub;
    $tipos_actext_SEMI['TOTAL'] += $sub;
    $array_act[$act_query[$i]->tipo_actividadexterna] += $sub;
    $array_act['TOTAL'] += $sub;
  }

  //----ESTUDIANTES QUE REALIZAN OTRAS GENERAL
  //MASCULINO

  $sql_actext_TOT= 'SELECT datos_externos.tipo_actividadexterna, COUNT(estudiantes.matricula) as total_actext
              FROM personas, estudiantes, datos_externos
              WHERE personas.id_persona=estudiantes.id_persona
              AND estudiantes.matricula=datos_externos.matricula
              AND estudiantes.sede="CU"
              AND personas.genero="M"
              AND datos_externos.bandera="1"
              GROUP BY datos_externos.tipo_actividadexterna';
  $act_query = DB::select($sql_actext_TOT);
  $array_act = array(
   "Laboral" => 0,
   "Escolar" => 0,
   "TOTAL" => 0
  );

  $tipos_actextM = array(
    "Laboral" => 0,
    "Escolar" => 0,
    "TOTAL" => 0
   );

  for($i = 0; $i < count($act_query); $i++) {
    $sub = $act_query[$i]->total_actext;
    $tipos_actextM[$act_query[$i]->tipo_actividadexterna] = $sub;
    $tipos_actextM['TOTAL'] += $sub;
    $array_act[$act_query[$i]->tipo_actividadexterna] += $sub;
    $array_act['TOTAL'] += $sub;
  }

  //FEMENINO

  $sql_actext_TOT= 'SELECT datos_externos.tipo_actividadexterna, COUNT(estudiantes.matricula) as total_actext
              FROM personas, estudiantes, datos_externos
              WHERE personas.id_persona=estudiantes.id_persona
              AND estudiantes.matricula=datos_externos.matricula
              AND estudiantes.sede="CU"
              AND personas.genero="F"
              AND datos_externos.bandera="1"
              GROUP BY datos_externos.tipo_actividadexterna';
  $act_query = DB::select($sql_actext_TOT);
  $array_act = array(
   "Laboral" => 0,
   "Escolar" => 0,
   "TOTAL" => 0
  );

  $tipos_actextF = array(
    "Laboral" => 0,
    "Escolar" => 0,
    "TOTAL" => 0
   );

  for($i = 0; $i < count($act_query); $i++) {
    $sub = $act_query[$i]->total_actext;
    $tipos_actextF[$act_query[$i]->tipo_actividadexterna] = $sub;
    $tipos_actextF['TOTAL'] += $sub;
    $array_act[$act_query[$i]->tipo_actividadexterna] += $sub;
    $array_act['TOTAL'] += $sub;
  }

  //TOTAL

  $sql_actext_TOT= 'SELECT datos_externos.tipo_actividadexterna, COUNT(estudiantes.matricula) as total_actext
              FROM personas, estudiantes, datos_externos
              WHERE personas.id_persona=estudiantes.id_persona
              AND estudiantes.matricula=datos_externos.matricula
              AND estudiantes.sede="CU"
              AND datos_externos.bandera="1"
              GROUP BY datos_externos.tipo_actividadexterna';
  $act_query = DB::select($sql_actext_TOT);
  $array_act = array(
   "Laboral" => 0,
   "Escolar" => 0,
   "TOTAL" => 0
  );

  $tipos_actext = array(
    "Laboral" => 0,
    "Escolar" => 0,
    "TOTAL" => 0
   );

  for($i = 0; $i < count($act_query); $i++) {
    $sub = $act_query[$i]->total_actext;
    $tipos_actext[$act_query[$i]->tipo_actividadexterna] = $sub;
    $tipos_actext['TOTAL'] += $sub;
    $array_act[$act_query[$i]->tipo_actividadexterna] += $sub;
    $array_act['TOTAL'] += $sub;
  }

return view('personal_administrativo/planeacion/info_departamentos/info_coord_academica.info_coord_academica5')
->with('array_act', $array_act)
->with('tipos_actextM_ESC', $tipos_actextM_ESC)
->with('tipos_actextF_ESC', $tipos_actextF_ESC)
->with('tipos_actext_ESC', $tipos_actext_ESC)

->with('tipos_actextM_SEMI', $tipos_actextM_SEMI)
->with('tipos_actextF_SEMI', $tipos_actextF_SEMI)
->with('tipos_actext_SEMI', $tipos_actext_SEMI)

->with('tipos_actextM', $tipos_actextM)
->with('tipos_actextF', $tipos_actextF)
->with('tipos_actext', $tipos_actext);
}

/*INFO FORMACION INTEGRAL */
  public function info_formacion_integral1(){
  $total_ac_ec=DB:: select('SELECT extracurriculares.nombre_ec,
  COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, extracurriculares, detalle_extracurriculares
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.genero="M"
  AND estudiantes.matricula=detalle_extracurriculares.matricula
  AND estudiantes.modalidad="SESCOLARIZADA"
  AND estudiantes.sede="CU"
  GROUP BY extracurriculares.nombre_ec');

  $total_ac_ec_T=DB:: select('SELECT extracurriculares.tipo,
  COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, extracurriculares, detalle_extracurriculares
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.genero="M"
  AND estudiantes.matricula=detalle_extracurriculares.matricula
  AND estudiantes.modalidad="SEMI ESCOLARIZADA"
  AND estudiantes.sede="CU"
  GROUP BY extracurriculares.tipo');

  $total_ac_ec_A=DB:: select('SELECT extracurriculares.area,
  COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, extracurriculares, detalle_extracurriculares
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.genero="M"
  AND estudiantes.matricula=detalle_extracurriculares.matricula
  AND estudiantes.modalidad="SEMI ESCOLARIZADA"
  AND estudiantes.sede="CU"
  GROUP BY extracurriculares.area');

  $total_ac_ec_C=DB:: select('SELECT extracurriculares.creditos,
  COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, extracurriculares, detalle_extracurriculares
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.genero="M"
  AND estudiantes.matricula=detalle_extracurriculares.matricula
  AND estudiantes.modalidad="SEMI ESCOLARIZADA"
  AND estudiantes.sede="CU"
  GROUP BY extracurriculares.creditos');


  return view('personal_administrativo/planeacion/info_departamentos/info_form_integral.info_formacion_integral1')
  ->with('total_ac_ec', $total_ac_ec)
  ->with('total_ac_ec_T', $total_ac_ec_T)
  ->with('total_ac_ec_A', $total_ac_ec_A)
  ->with('total_ac_ec_C', $total_ac_ec_C);
  }

public function gral_escuela(){
  $usuario_actuales=\Auth::user();
   if($usuario_actuales->tipo_usuario!='2'){
     return redirect()->back();
    }
  $usuario_actual=auth()->user();
  $id=$usuario_actual->id_user;

  $id_persona = DB::table('users')
  ->select('users.id_persona')
  ->join('personas', 'personas.id_persona', '=', 'users.id_persona')
  ->where('users.id_persona',$id)
  ->take(1)
  ->first();
    $id_persona= $id_persona->id_persona;
    //$id_persona= json_decode( json_encode($id_persona), true);
  $codigo = DB::table('codigos_postales')
  ->select('codigos_postales.cp', 'codigos_postales.colonia', 'codigos_postales.municipio', 'codigos_postales.estado')
  ->where('codigos_postales.cp', '=', '68120')
  ->take(1)
  ->first();
  $id_admin = DB::table('administrativos')
  ->select('administrativos.id_administrativo')
  ->where('administrativos.id_persona', $id_persona)
  ->take(1)
  ->first();
  $id_admin= $id_admin->id_administrativo;

  $escuela_r = DB::table('escuelas')
  ->select('escuelas.clave_institucion', 'escuelas.clave_escuela', 'escuelas.nombre_escuela', 'escuelas.dependencia_normativa',
           'escuelas.institucion_pertenciente', 'escuelas.pagina_web_escuela')
  ->where('escuelas.responsable', $id_admin)
  ->take(1)
  ->first();

  $id_direccions= DB::table('escuelas')
  ->select('escuelas.id_direccion')
  ->where('escuelas.responsable', $id_admin)
  ->take(1)
  ->first();
  //$id_direccions= $id_direccions->id_direccion;
  $id_direccions= json_decode( json_encode($id_direccions), true);

  $direccion_director = DB::table('direcciones')
  ->select('direcciones.vialidad_principal', 'direcciones.vialidad_derecha', 'direcciones.vialidad_izquierda', 'direcciones.vialidad_psterior',
  'direcciones.num_exterior', 'direcciones.num_interior', 'direcciones.cp', 'direcciones.localidad','direcciones.municipio',
  'direcciones.entidad_federativa', 'direcciones.asentamiento_humano')
  ->where('direcciones.id_direccion',$id_direccions)
  ->take(1)
  ->first();

  $id_directores = DB::table('escuelas')
  ->select('escuelas.director')
  ->where('escuelas.responsable', $id_admin)
  ->take(1)
  ->first();

  //$id_directores= $id_directores->id_direccion;
  $id_directores= json_decode( json_encode($id_directores), true);

  $datos_director = DB::table('personas')
  ->select('personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
  ->where('personas.id_persona', $id_directores)
  ->take(1)
  ->first();

  return view ('personal_administrativo/planeacion.gral_escuela')
  ->with('codego', $codigo)->with('direccion_d', $direccion_director )->with('datos_director', $datos_director)->with('datos_escuela', $escuela_r);
}



protected function crear_escuela(Request $request){
  $usuario_actuales=\Auth::user();
   if($usuario_actuales->tipo_usuario!='2'){
     return redirect()->back();
    }
  $usuario_actual=auth()->user();
  $id=$usuario_actual->id_user;

  $id_persona = DB::table('users')
  ->select('users.id_persona')
  ->join('personas', 'personas.id_persona', '=', 'users.id_persona')
  ->where('users.id_persona',$id)
  ->take(1)
  ->first();
    $id_persona= $id_persona->id_persona;


  $valor_persona = DB::table('personas')->max('id_persona');
   $data = $request;
   $id_prueba= $valor_persona*4;
//   $id_persona= json_decode( json_encode($id_persona), true);
  $result = DB::table('escuelas')->count();
  $responsable_di = DB::table('escuelas')
  ->select('escuelas.director')
  ->take(1)
  ->first();

  if($result == 0){
    $valor_direccion = DB::table('direcciones')->max('id_direccion');
    $id_direc=$valor_direccion+1;

     $direccion = new Direccion;
     $direccion->id_direccion = $id_direc;
     $direccion->vialidad_principal=$data['vialidad_principal'];
     $direccion->vialidad_derecha=$data['vialidad_derecha'];
     $direccion->vialidad_izquierda=$data['vialidad_izquierda'];
     $direccion->vialidad_psterior=$data['vialidad_psterior'];
     $direccion->num_exterior=$data['num_exterior'];
     $direccion->num_interior=$data['num_interior'];
     $direccion->cp=$data['cp'];
     $direccion->localidad=$data['localidad'];
     $direccion->municipio=$data['municipio'];
     $direccion->entidad_federativa=$data['entidad_federativa'];
     $direccion->asentamiento_humano=$data['asentamiento_humano'];
     $direccion->save();

     if($direccion->save()){
     $persona=new Persona;
     $persona->id_persona=$id_prueba;
     $persona->nombre=$data['nombre'];
     $persona->apellido_paterno=$data['apellido_paterno'];
     $persona->apellido_materno=$data['apellido_materno'];
     $persona->save();

     if($persona->save()){
       $id_admin = DB::table('administrativos')
       ->select('administrativos.id_administrativo')
       ->where('administrativos.id_persona', $id_persona)
       ->take(1)
       ->first();
       $id_admin= $id_admin->id_administrativo;

    $escuela = new Escuela;
    $escuela->clave_institucion=$data['clave_institucion'];
    $escuela->clave_escuela=$data['clave_escuela'];
    $escuela->nombre_escuela=$data['nombre_escuela'];
    $escuela->id_direccion=$id_direc;
    $escuela->dependencia_normativa=$data['dependencia_normativa'];
    $escuela->institucion_pertenciente=$data['institucion_pertenciente'];
    $escuela->director=$id_prueba;
    $escuela->pagina_web_escuela=$data['pagina_web'];
    $escuela->responsable=$id_admin;
    $escuela->save();

     if($escuela->save()){
  return redirect()->route('gral_escuela')->with('success','¡Datos registrados correctamente!');
}}}}

  else {
    $id_admin = DB::table('administrativos')
    ->select('administrativos.id_administrativo')
    ->where('administrativos.id_persona', $id_persona)
    ->take(1)
    ->first();
    $id_admin= $id_admin->id_administrativo;

    $id_directores = DB::table('escuelas')
    ->select('escuelas.director')
    ->where('escuelas.responsable', $id_admin)
    ->take(1)
    ->first();
    $id_directores= json_decode( json_encode($id_directores), true);

    DB::table('personas')
        ->where('personas.id_persona',$id_directores)
        ->update(
          ['nombre' => $data['nombre'], 'apellido_paterno' => $data['apellido_paterno'], 'apellido_materno' => $data['apellido_materno']]);

     return redirect()->route('gral_escuela')->with('success','¡Datos actualizados correctamente!');
  }
}


public function gral_carrera(){
  $usuario_actuales=\Auth::user();
   if($usuario_actuales->tipo_usuario!='2'){
     return redirect()->back();
    }
  $usuario_actual=auth()->user();
  $id=$usuario_actual->id_user;

  $result = DB::table('escuelas')->count();
   if($result == 0){
     return redirect()->route('gral_escuela')->with('error', 'Para agregar una Carrera, primero debe registrar la Escuela');

   }
   $id_persona = DB::table('users')
   ->select('users.id_persona')
   ->join('personas', 'personas.id_persona', '=', 'users.id_persona')
   ->where('users.id_persona',$id)
   ->take(1)
   ->first();
     $id_persona= $id_persona->id_persona;

   $id_admin = DB::table('administrativos')
   ->select('administrativos.id_administrativo')
   ->where('administrativos.id_persona', $id_persona)
   ->take(1)
   ->first();
   $id_admin= $id_admin->id_administrativo;

   $escuela_r = DB::table('escuelas')
   ->select('escuelas.clave_institucion', 'escuelas.clave_escuela', 'escuelas.nombre_escuela', 'escuelas.dependencia_normativa',
            'escuelas.institucion_pertenciente', 'escuelas.pagina_web_escuela')
   ->where('escuelas.responsable', $id_admin)
   ->take(1)
   ->first();
  return view ('personal_administrativo/planeacion.gral_carrera')->with('re', $result)->with('datos_escuela', $escuela_r);
}

protected function crear_carrera(Request $request){

  $usuario_actuales=\Auth::user();
   if($usuario_actuales->tipo_usuario!='2'){
     return redirect()->back();
    }
  $usuario_actual=auth()->user();
  $id=$usuario_actual->id_user;
  $data = $request;
  $id_persona = DB::table('users')
  ->select('users.id_persona')
  ->join('personas', 'personas.id_persona', '=', 'users.id_persona')
  ->where('users.id_persona',$id)
  ->take(1)
  ->first();

    $id_persona= $id_persona->id_persona;
    $id_admin = DB::table('administrativos')
    ->select('administrativos.id_administrativo')
    ->where('administrativos.id_persona', $id_persona)
    ->take(1)
    ->first();
    $id_admin= $id_admin->id_administrativo;

    $escuela_r = DB::table('escuelas')
    ->select('escuelas.clave_institucion')
    ->where('escuelas.responsable', $id_admin)
    ->take(1)
    ->first();

     $escuela_r = $escuela_r->clave_institucion;
    // $escuela_r= json_decode( json_encode($escuela_r), true);

    $carrera = new Carrera;
    $carrera->clave_carrera = $data['clave_carrera'];$id_direc;
    $carrera->clave_institucion= $escuela_r;
    $carrera->facultad='FACULTAD DE IDIOMAS';
    $carrera->carrera=$data['carrera'];
    $carrera->modalidad=$data['modalidad'];
    $carrera->save();

    if($carrera->save()){
      return redirect()->route('carreras_registradas')->with('success', 'Carrera Registrada correctamente');

    }



}

protected function info_carreras(){

     $result = DB::table('carreras')
     ->select('carreras.clave_carrera', 'carreras.clave_institucion', 'carreras.facultad', 'carreras.carrera', 'carreras.modalidad')
     ->simplePaginate(10);

  return view ('personal_administrativo/planeacion.carreras')->with('info_carrera', $result);

}
/*REPORTE Semestral*/
public function reporte_semestral(){
  return view ('personal_administrativo/planeacion/reportes/reporte_semestral.reporte_semestral');
}

/*REPORTE 911.9*/
public function reporte911_9(){
//ESTUDIANTES BECADOS DEL CICLO ESCOLAR ACTUAL CU
//MODALIDAD ESCOLARIZADA
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

//---------------------------------------------------------------------------//
//ESTUDIANTES BECADOS DEL CICLO ESCOLAR ACTUAL TEHUANTEPEC
//MODALIDAD ESCOLARIZADA
//MASCULINO
  $sql_BECA_ESCT= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC
  FROM personas, estudiantes, becas
  WHERE personas.id_persona=estudiantes.id_persona
  AND estudiantes.matricula=becas.matricula
  AND personas.genero="M"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND estudiantes.sede="TEHUANTEPEC"
  AND becas.tipo_beca IS NOT NULL
  AND becas.bandera="1"
  GROUP BY becas.tipo_beca';
 $beca_queryT = DB::select($sql_BECA_ESCT);
 $array_becasT = array(
   "INSTITUCIONAL" => 0,
   "FEDERAL" => 0,
   "ESTATAL" => 0,
   "MUNICIPAL" => 0,
   "PARTICULAR" => 0,
   "INTERNACIONAL" => 0,
   "TOTAL" => 0
 );
 $tipos_becas_ESC_MT = array(
   "INSTITUCIONAL" => 0,
   "FEDERAL" => 0,
   "ESTATAL" => 0,
   "MUNICIPAL" => 0,
   "PARTICULAR" => 0,
   "INTERNACIONAL" => 0,
   "TOTAL" => 0
 );

  for($i = 0; $i < count($beca_queryT); $i++) {
    $sub = $beca_queryT[$i]->total_BECA_ESCT;
    $tipos_becas_ESC_MT[$beca_queryT[$i]->tipo_beca] = $sub;
    $tipos_becas_ESC_MT['TOTAL'] += $sub;
    $array_becasT[$beca_query[$i]->tipo_beca] += $sub;
    $array_becasT['TOTAL'] += $sub;
  }

  //FEMENINO
    $sql_BECA_ESCT= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC
  FROM personas, estudiantes, becas
  WHERE personas.id_persona=estudiantes.id_persona
  AND estudiantes.matricula=becas.matricula
  AND personas.genero="F"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND estudiantes.sede="TEHUANTEPEC"
  AND becas.tipo_beca IS NOT NULL
  AND becas.bandera="1"
  GROUP BY becas.tipo_beca';
   $beca_queryT = DB::select($sql_BECA_ESCT);

   $tipos_becas_ESC_FT = array(
     "INSTITUCIONAL" => 0,
     "FEDERAL" => 0,
     "ESTATAL" => 0,
     "MUNICIPAL" => 0,
     "PARTICULAR" => 0,
     "INTERNACIONAL" => 0,
     "TOTAL" => 0
   );

    for($i = 0; $i < count($beca_queryT); $i++) {
      $sub = $beca_queryT[$i]->total_BECA_ESCT;
      $tipos_becas_ESC_FT[$beca_queryT[$i]->tipo_beca] = $sub;
      $tipos_becas_ESC_FT['TOTAL'] += $sub;
      $array_becasT[$beca_queryT[$i]->tipo_beca] += $sub;
      $array_becasT['TOTAL'] += $sub;
    }

    //GENERAL
      $sql_BECA_ESCT= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC
      FROM personas, estudiantes, becas
      WHERE personas.id_persona=estudiantes.id_persona
      AND estudiantes.matricula=becas.matricula
      AND estudiantes.modalidad="ESCOLARIZADA"
      AND estudiantes.sede="TEHUANTEPEC"
      AND becas.tipo_beca IS NOT NULL
      AND becas.bandera="1"
      GROUP BY becas.tipo_beca';
     $beca_queryT = DB::select($sql_BECA_ESCT);

     $tipos_becas_ESC_GT = array(
       "INSTITUCIONAL" => 0,
       "FEDERAL" => 0,
       "ESTATAL" => 0,
       "MUNICIPAL" => 0,
       "PARTICULAR" => 0,
       "INTERNACIONAL" => 0,
       "TOTAL" => 0
     );

      for($i = 0; $i < count($beca_queryT); $i++) {
        $sub = $beca_queryT[$i]->total_BECA_ESCT;
        $tipos_becas_ESC_GT[$beca_queryT[$i]->tipo_beca] = $sub;
        $tipos_becas_ESC_GT['TOTAL'] += $sub;
        $array_becasT[$beca_queryT[$i]->tipo_beca] += $sub;
        $array_becasT['TOTAL'] += $sub;
      }

      //------CON DISCAPACIDAD
      $sql_BECA_ESC_DT= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC_D
                FROM personas, estudiantes, discapacidades, becas
                WHERE personas.id_persona=estudiantes.id_persona
                AND personas.id_persona=discapacidades.id_persona
                AND estudiantes.sede="TEHUANTEPEC"
                AND estudiantes.modalidad="ESCOLARIZADA"
                AND estudiantes.matricula=becas.matricula
                AND discapacidades.tipo IS NOT NULL
                AND becas.tipo_beca IS NOT NULL
                AND becas.bandera="1"
                GROUP BY becas.tipo_beca';
     $beca_queryT = DB::select($sql_BECA_ESC_DT);
     $tipos_becas_esco_DT = array(
       "INSTITUCIONAL" => 0,
       "FEDERAL" => 0,
       "ESTATAL" => 0,
       "MUNICIPAL" => 0,
       "PARTICULAR" => 0,
       "INTERNACIONAL" => 0,
       "TOTAL" => 0
     );

      for($i = 0; $i < count($beca_queryT); $i++) {
        $sub = $beca_queryT[$i]->total_BECA_ESC_DT;
        $tipos_becas_esco_DT[$beca_queryT[$i]->tipo_beca] = $sub;
        $tipos_becas_esco_DT['TOTAL'] += $sub;
        $array_becasT[$beca_queryT[$i]->tipo_beca] += $sub;
        $array_becasT['TOTAL'] += $sub;
      }

      //------HABLANTE DE LENGUA
      $sql_BECA_ESC_LT= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC_LT
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
     $beca_queryT = DB::select($sql_BECA_ESC_LT);

     $tipos_becas_esco_LT = array(
       "INSTITUCIONAL" => 0,
       "FEDERAL" => 0,
       "ESTATAL" => 0,
       "MUNICIPAL" => 0,
       "PARTICULAR" => 0,
       "INTERNACIONAL" => 0,
       "TOTAL" => 0
     );

      for($i = 0; $i < count($beca_queryT); $i++) {
        $sub = $beca_queryT[$i]->total_BECA_ESC_LT;
        $tipos_becas_esco_LT[$beca_queryT[$i]->tipo_beca] = $sub;
        $tipos_becas_esco_LT['TOTAL'] += $sub;
        $array_becasT[$beca_queryT[$i]->tipo_beca] += $sub;
        $array_becasT['TOTAL'] += $sub;
      }
//---------------------------------------------------------------------------//
//ESTUDIANTES BECADOS DEL CICLO ESCOLAR ACTUAL PUERTO ESCONDIDO
//MODALIDAD ESCOLARIZADA
//MASCULINO
  $sql_BECA_ESCPE= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC
  FROM personas, estudiantes, becas
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.genero="M" AND estudiantes.matricula=becas.matricula
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND estudiantes.sede="PUERTO ESCONDIDO"
  AND becas.tipo_beca IS NOT NULL
  AND becas.bandera="1"
  GROUP BY becas.tipo_beca';
 $beca_queryPE = DB::select($sql_BECA_ESCPE);
 $array_becasPE = array(
   "INSTITUCIONAL" => 0,
   "FEDERAL" => 0,
   "ESTATAL" => 0,
   "MUNICIPAL" => 0,
   "PARTICULAR" => 0,
   "INTERNACIONAL" => 0,
   "TOTAL" => 0
 );
 $tipos_becas_ESC_MPE = array(
   "INSTITUCIONAL" => 0,
   "FEDERAL" => 0,
   "ESTATAL" => 0,
   "MUNICIPAL" => 0,
   "PARTICULAR" => 0,
   "INTERNACIONAL" => 0,
   "TOTAL" => 0
 );

  for($i = 0; $i < count($beca_queryPE); $i++) {
    $sub = $beca_queryPE[$i]->total_BECA_ESCPE;
    $tipos_becas_ESC_MPE[$beca_queryPE[$i]->tipo_beca] = $sub;
    $tipos_becas_ESC_MPE['TOTAL'] += $sub;
    $array_becasPE[$beca_queryPE[$i]->tipo_beca] += $sub;
    $array_becasPE['TOTAL'] += $sub;
  }

  //FEMENINO
    $sql_BECA_ESCPE= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC
    FROM personas, estudiantes, becas
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="F"
    AND estudiantes.matricula=becas.matricula
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="PUERTO ESCONDIDO"
    AND becas.tipo_beca IS NOT NULL
    AND becas.bandera="1"
    GROUP BY becas.tipo_beca';
   $beca_queryPE = DB::select($sql_BECA_ESCPE);

   $tipos_becas_ESC_FPE = array(
     "INSTITUCIONAL" => 0,
     "FEDERAL" => 0,
     "ESTATAL" => 0,
     "MUNICIPAL" => 0,
     "PARTICULAR" => 0,
     "INTERNACIONAL" => 0,
     "TOTAL" => 0
   );

    for($i = 0; $i < count($beca_queryPE); $i++) {
      $sub = $beca_queryPE[$i]->total_BECA_ESCPE;
      $tipos_becas_ESC_FPE[$beca_queryPE[$i]->tipo_beca] = $sub;
      $tipos_becas_ESC_FPE['TOTAL'] += $sub;
      $array_becasPE[$beca_queryPE[$i]->tipo_beca] += $sub;
      $array_becasPE['TOTAL'] += $sub;
    }

    //GENERAL
      $sql_BECA_ESCPE= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC
      FROM personas, estudiantes, becas
      WHERE personas.id_persona=estudiantes.id_persona
      AND estudiantes.matricula=becas.matricula
      AND estudiantes.modalidad="ESCOLARIZADA"
      AND estudiantes.sede="PUERTO ESCONDIDO"
      AND becas.tipo_beca IS NOT NULL
      AND becas.bandera="1"
      GROUP BY becas.tipo_beca';
     $beca_queryPE = DB::select($sql_BECA_ESCPE);

     $tipos_becas_ESC_GPE = array(
       "INSTITUCIONAL" => 0,
       "FEDERAL" => 0,
       "ESTATAL" => 0,
       "MUNICIPAL" => 0,
       "PARTICULAR" => 0,
       "INTERNACIONAL" => 0,
       "TOTAL" => 0
     );

      for($i = 0; $i < count($beca_queryPE); $i++) {
        $sub = $beca_queryPE[$i]->total_BECA_ESCPE;
        $tipos_becas_ESC_GPE[$beca_queryPE[$i]->tipo_beca] = $sub;
        $tipos_becas_ESC_GPE['TOTAL'] += $sub;
        $array_becasPE[$beca_queryPE[$i]->tipo_beca] += $sub;
        $array_becasPE['TOTAL'] += $sub;
      }

  //------CON DISCAPACIDAD
$sql_BECA_ESC_DPE= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC_D
    FROM personas, estudiantes, discapacidades, becas
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.id_persona=discapacidades.id_persona
    AND estudiantes.sede="PUERTO ESCONDIDO"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.matricula=becas.matricula
    AND discapacidades.tipo IS NOT NULL
    AND becas.tipo_beca IS NOT NULL
    AND becas.bandera="1"
    GROUP BY becas.tipo_beca';
     $beca_queryPE = DB::select($sql_BECA_ESC_DPE);
     $tipos_becas_esco_DPE = array(
       "INSTITUCIONAL" => 0,
       "FEDERAL" => 0,
       "ESTATAL" => 0,
       "MUNICIPAL" => 0,
       "PARTICULAR" => 0,
       "INTERNACIONAL" => 0,
       "TOTAL" => 0
     );

      for($i = 0; $i < count($beca_queryPE); $i++) {
        $sub = $beca_queryPE[$i]->total_BECA_ESC_DPE;
        $tipos_becas_esco_DPE[$beca_queryPE[$i]->tipo_beca] = $sub;
        $tipos_becas_esco_DPE['TOTAL'] += $sub;
        $array_becasPE[$beca_queryPE[$i]->tipo_beca] += $sub;
        $array_becasPE['TOTAL'] += $sub;
      }

  //------HABLANTE DE LENGUA
      $sql_BECA_ESC_LPE= 'SELECT becas.tipo_beca, COUNT(estudiantes.matricula) as total_BECA_ESC_LPE
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
     $beca_queryPE = DB::select($sql_BECA_ESC_LPE);

     $tipos_becas_esco_LPE = array(
       "INSTITUCIONAL" => 0,
       "FEDERAL" => 0,
       "ESTATAL" => 0,
       "MUNICIPAL" => 0,
       "PARTICULAR" => 0,
       "INTERNACIONAL" => 0,
       "TOTAL" => 0
     );

      for($i = 0; $i < count($beca_queryPE); $i++) {
        $sub = $beca_queryPE[$i]->total_BECA_ESC_LPE;
        $tipos_becas_esco_LPE[$beca_queryPE[$i]->tipo_beca] = $sub;
        $tipos_becas_esco_LPE['TOTAL'] += $sub;
        $array_becasPE[$beca_queryPE[$i]->tipo_beca] += $sub;
        $array_becasPE['TOTAL'] += $sub;
      }

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

  return view ('personal_administrativo/planeacion/reportes/reporte911_9.reporte911_9')
/*CU*/
  ->with('sql_BECA_ESC', $sql_BECA_ESC)
  ->with('tipos_becas_ESC_M', $tipos_becas_ESC_M)
  ->with('tipos_becas_ESC_F', $tipos_becas_ESC_F)
  ->with('tipos_becas_ESC_G', $tipos_becas_ESC_G)
  ->with('tipos_becas_esco_D', $tipos_becas_esco_D)
  ->with('tipos_becas_esco_L', $tipos_becas_esco_L)
  ->with('$sql_BECA_SEMI', $sql_BECA_SEMI)
  ->with('tipos_becas_SEMI_M', $tipos_becas_SEMI_M )
  ->with('tipos_becas_SEMI_F', $tipos_becas_SEMI_F )
  ->with('tipos_becas_SEMI_G', $tipos_becas_SEMI_G )
  ->with('tipos_becas_semi_D', $tipos_becas_semi_D )
  ->with('tipos_becas_semi_L', $tipos_becas_semi_L )
/*TEHUANTEPEC*/
->with('sql_BECA_ESCT', $sql_BECA_ESCT)
->with('tipos_becas_ESC_MT', $tipos_becas_ESC_MT)
->with('tipos_becas_ESC_FT', $tipos_becas_ESC_FT)
->with('tipos_becas_ESC_GT', $tipos_becas_ESC_GT)
->with('tipos_becas_esco_DT', $tipos_becas_esco_DT)
->with('tipos_becas_esco_LT', $tipos_becas_esco_LT)
/*PUERTO ESCONDIDO*/
->with('sql_BECA_ESCPE', $sql_BECA_ESCPE)
->with('tipos_becas_ESC_MPE', $tipos_becas_ESC_MPE)
->with('tipos_becas_ESC_FPE', $tipos_becas_ESC_FPE)
->with('tipos_becas_ESC_GPE', $tipos_becas_ESC_GPE)
->with('tipos_becas_esco_DPE', $tipos_becas_esco_DPE)
->with('tipos_becas_esco_LPE', $tipos_becas_esco_LPE)
  ;
}

/*REPORTE 911.9A*/
public function reporte911_9A_0(){
/*ALUMNOS DE PRIMER INGRESO DEL CICLO ESCOLAR ANTERIOR CU ESCO*/
/*MASCULINO*/
$primeringreso_A_M=DB::select
('SELECT personas.genero,
  COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="M"
    AND estudiantes.semestre="2"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="CU"
    GROUP BY personas.genero');
    $PIA_M=$primeringreso_A_M[0]->total;
/*FEMENINO*/
$primeringreso_A_F=DB::select
('SELECT personas.genero,
  COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.genero="F"
  AND estudiantes.semestre="2"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND estudiantes.sede="CU"
  GROUP BY personas.genero');
  $PIA_F=$primeringreso_A_F[0]->total;
  /*CON DISCAPACIDAD*/
  $discapacidadesPICU=DB::select('SELECT SUM(total) as tot
  FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, discapacidades
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=discapacidades.id_persona
  AND estudiantes.semestre="2"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND estudiantes.sede="CU"
  AND discapacidades.tipo IS NOT NULL
  GROUP BY discapacidades.tipo) as total');
  $PIA_D=$discapacidadesPICU[0]->tot;

    /*HABLANTE DE LENGUA*/
    $PIA_L = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.lengua', '=', '1'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'CU'],
              ['estudiantes.semestre','=','2']])
    ->count();


/*ALUMNOS DE PRIMER INGRESO DEL CICLO ESCOLAR ANTERIOR TEHUANTEPEC ESCO*/
/*MASCULINO*/
$primeringreso_A_M_T=DB::select
('SELECT personas.genero,
  COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="M"
    AND estudiantes.semestre="2"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="TEHUANTEPEC"
    GROUP BY personas.genero');
    $PIA_M_T=$primeringreso_A_M_T[0]->total;
/*FEMENINO*/
$primeringreso_A_F_T=DB::select
  ('SELECT personas.genero,
    COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="F"
    AND estudiantes.semestre="2"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="TEHUANTEPEC"
    GROUP BY personas.genero');
    $PIA_F_T=$primeringreso_A_F_T[0]->total;

  /*CON DISCAPACIDAD*/
  $discapacidadesPIT=DB::select('SELECT SUM(total) as tot
  FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, discapacidades
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=discapacidades.id_persona
  AND estudiantes.semestre="2"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND estudiantes.sede="TEHUANTEPEC"
  AND discapacidades.tipo IS NOT NULL
  GROUP BY discapacidades.tipo) as total');
  $PIA_D_T=$discapacidadesPIT[0]->tot;

  /*HABLANTE DE LENGUA*/
  $PIA_L_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.lengua', '=', '1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'TEHUANTEPEC'],
            ['estudiantes.semestre','=','2']])
  ->count();
  /*ALUMNOS DE PRIMER INGRESO DEL CICLO ESCOLAR ANTERIOR PUERTO ESCO*/
  /*MASCULINO*/
  $primeringreso_A_M_P=DB::select
  ('SELECT personas.genero,
    COUNT(estudiantes.matricula) as total
      FROM personas, estudiantes
      WHERE personas.id_persona=estudiantes.id_persona
      AND personas.genero="M"
      AND estudiantes.semestre="2"
      AND estudiantes.modalidad="ESCOLARIZADA"
      AND estudiantes.sede="PUERTO ESCONDIDO"
      GROUP BY personas.genero');
      $PIA_M_P=$primeringreso_A_M_P[0]->total;
  /*FEMENINO*/
  $primeringreso_A_F_P=DB::select
    ('SELECT personas.genero,
  COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.genero="F"
  AND estudiantes.semestre="2"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND estudiantes.sede="PUERTO ESCONDIDO"
  GROUP BY personas.genero');
  $PIA_F_P=$primeringreso_A_F_P[0]->total;
  /*CON DISCAPACIDAD*/
  $discapacidadesPIP=DB::select('SELECT SUM(total) as tot
  FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, discapacidades
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=discapacidades.id_persona
  AND estudiantes.semestre="2"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND estudiantes.sede="PUERTO ESCONDIDO"
  AND discapacidades.tipo IS NOT NULL
  GROUP BY discapacidades.tipo) as total');
  $PIA_D_P=$discapacidadesPIP[0]->tot;
  /*HABLANTE DE LENGUA*/
  $PIA_L_P = DB::table('personas')
        ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
        ->where([['personas.lengua', '=', '1'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
              ['estudiantes.semestre','=','2']])
    ->count();

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

    /*ALUMNOS DE PRIMER INGRESO DEL CICLO ESCOLAR ANTERIOR TOTAL*/
    /*MASCULINO*/
    $primeringreso_A_MTOT=DB::select
    ('SELECT personas.genero,
      COUNT(estudiantes.matricula) as total
        FROM personas, estudiantes
        WHERE personas.id_persona=estudiantes.id_persona
        AND personas.genero="M"
        AND estudiantes.semestre="2"
        GROUP BY personas.genero');
        $PIA_MTOT=$primeringreso_A_MTOT[0]->total;
/*FEMENINO*/
$primeringreso_A_FTOT=DB::select
('SELECT personas.genero,
  COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.genero="F"
  AND estudiantes.semestre="2"
  GROUP BY personas.genero');
  $PIA_FTOT=$primeringreso_A_FTOT[0]->total;
  /*CON DISCAPACIDAD*/
  $discapacidadesPICUTOT=DB::select('SELECT SUM(total) as tot
  FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, discapacidades
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=discapacidades.id_persona
  AND estudiantes.semestre="2"
  AND discapacidades.tipo IS NOT NULL
  GROUP BY discapacidades.tipo) as total');
  $PIA_DTOT=$discapacidadesPICUTOT[0]->tot;
    /*HABLANTE DE LENGUA*/
    $PIA_LTOT = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.lengua', '=', '1'],
              ['estudiantes.semestre','=','2']])
    ->count();

  return view ('personal_administrativo/planeacion/reportes/reporte911_9A.reporte911_9A_0')
  /*CU*/
  ->with('PIA_M', $PIA_M)
  ->with('PIA_F', $PIA_F)
  ->with('PIA_D', $PIA_D)
  ->with('PIA_L', $PIA_L)

  /*TEHUANTEPEC*/
  ->with('PIA_M_T', $PIA_M_T)
  ->with('PIA_F_T', $PIA_F_T)
  ->with('PIA_D_T', $PIA_D_T)
  ->with('PIA_L_T', $PIA_L_T)

  /*PUERTO*/
  ->with('PIA_M_P', $PIA_M_P)
  ->with('PIA_F_P', $PIA_F_P)
  ->with('PIA_D_P', $PIA_D_P)
  ->with('PIA_L_P', $PIA_L_P)

  /*CU SEMI*/
  ->with('PIA_MS', $PIA_MS)
  ->with('PIA_FS', $PIA_FS)
  ->with('PIA_DS', $PIA_DS)
  ->with('PIA_LS', $PIA_LS)

  /*TOTAL*/
  ->with('PIA_MTOT', $PIA_MTOT)
  ->with('PIA_FTOT', $PIA_FTOT)
  ->with('PIA_DTOT', $PIA_DTOT)
  ->with('PIA_LTOT', $PIA_LTOT)
  ;
}

public function reporte911_9A_1(){
  /*ALUMNOS DE PRIMER INGRESO DEL CICLO ESCOLAR ANTERIOR CU ESCO*/
  /*MASCULINO*/
  $primeringreso_AC_M=DB::select
  ('SELECT personas.genero,
    COUNT(estudiantes.matricula) as total
      FROM personas, estudiantes
      WHERE personas.id_persona=estudiantes.id_persona
      AND personas.genero="M"
      AND estudiantes.semestre="1"
      AND estudiantes.modalidad="ESCOLARIZADA"
      AND estudiantes.sede="CU"
      GROUP BY personas.genero');
      $PIAC_M=$primeringreso_AC_M[0]->total;
  /*FEMENINO*/
  $primeringreso_AC_F=DB::select
  ('SELECT personas.genero,
    COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="F"
    AND estudiantes.semestre="1"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="CU"
    GROUP BY personas.genero');
    $PIAC_F=$primeringreso_AC_F[0]->total;
    /*CON DISCAPACIDAD*/
    $discapacidadesPICUAC=DB::select('SELECT SUM(total) as tot
    FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes, discapacidades
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.id_persona=discapacidades.id_persona
    AND estudiantes.semestre="1"
    AND estudiantes.modalidad="ESCOLARIZADA"
    AND estudiantes.sede="CU"
    AND discapacidades.tipo IS NOT NULL
    GROUP BY discapacidades.tipo) as total');
    $PIAC_D=$discapacidadesPICUAC[0]->tot;

      /*HABLANTE DE LENGUA*/
      $PIAC_L = DB::table('personas')
      ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
      ->where([['personas.lengua', '=', '1'],
               ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
               ['estudiantes.sede', '=', 'CU'],
                ['estudiantes.semestre','=','1']])
      ->count();


  /*ALUMNOS DE PRIMER INGRESO DEL CICLO ESCOLAR ANTERIOR TEHUANTEPEC ESCO*/
  /*MASCULINO*/
$PIAC_M_T = DB:: table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=', 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.semestre','=', '1'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'TEHUANTEPEC']])
->count();

  /*FEMENINO*/
$PIAC_F_T= DB:: table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=', 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.semestre','=', '1'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'TEHUANTEPEC']])
->count();

    /*CON DISCAPACIDAD*/

    $PIAC_D_T= DB:: table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=', 'personas.id_persona')
    ->join('discapacidades', 'personas.id_persona', '=', 'discapacidades.id_persona')
    ->where([['estudiantes.semestre','=', '1'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
             ['discapacidades.tipo', '=', 'is not NULL']])
    ->count();

    /*HABLANTE DE LENGUA*/
    $PIAC_L_T = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.lengua', '=', '1'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','1']])
    ->count();
    /*ALUMNOS DE PRIMER INGRESO DEL CICLO ESCOLAR ANTERIOR PUERTO ESCO*/
    /*MASCULINO*/
  $PIAC_M_P = DB:: table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=', 'personas.id_persona')
  ->where([['personas.genero', '=', 'M'],
           ['estudiantes.semestre','=', '1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'PUERTO ESCONDIDO']])
  ->count();

    /*FEMENINO*/
  $PIAC_F_P= DB:: table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=', 'personas.id_persona')
  ->where([['personas.genero', '=', 'F'],
           ['estudiantes.semestre','=', '1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede', '=', 'PUERTO ESCONDIDO']])
  ->count();

      /*CON DISCAPACIDAD*/

      $PIAC_D_P= DB:: table('personas')
      ->join('estudiantes', 'estudiantes.id_persona', '=', 'personas.id_persona')
      ->join('discapacidades', 'personas.id_persona', '=', 'discapacidades.id_persona')
      ->where([['estudiantes.semestre','=', '1'],
               ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
               ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
               ['discapacidades.tipo', '=', 'is not NULL']])
      ->count();

    /*HABLANTE DE LENGUA*/
    $PIAC_L_P = DB::table('personas')
          ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
          ->where([['personas.lengua', '=', '1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
               ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
                ['estudiantes.semestre','=','1']])
      ->count();

      /*ALUMNOS DE PRIMER INGRESO DEL CICLO ESCOLAR ANTERIOR CU SEMIESCO*/
      /*MASCULINO*/
      $primeringreso_AC_MS=DB::select
      ('SELECT personas.genero,
        COUNT(estudiantes.matricula) as total
          FROM personas, estudiantes
          WHERE personas.id_persona=estudiantes.id_persona
          AND personas.genero="M"
          AND estudiantes.semestre="1"
          AND estudiantes.modalidad="SEMIESCOLARIZADA"
          AND estudiantes.sede="CU"
          GROUP BY personas.genero');
          $PIAC_MS=$primeringreso_AC_MS[0]->total;
  /*FEMENINO*/
  $primeringreso_AC_FS=DB::select
  ('SELECT personas.genero,
    COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="F"
    AND estudiantes.semestre="1"
    AND estudiantes.modalidad="SEMIESCOLARIZADA"
    AND estudiantes.sede="CU"
    GROUP BY personas.genero');
    $PIAC_FS=$primeringreso_AC_FS[0]->total;
    /*CON DISCAPACIDAD*/
    $discapacidadesPICUSAC=DB::select('SELECT SUM(total) as tot
    FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes, discapacidades
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.id_persona=discapacidades.id_persona
    AND estudiantes.semestre="1"
    AND estudiantes.modalidad="SEMIESCOLARIZADA"
    AND estudiantes.sede="CU"
    AND discapacidades.tipo IS NOT NULL
    GROUP BY discapacidades.tipo) as total');
    $PIAC_DS=$discapacidadesPICUSAC[0]->tot;
      /*HABLANTE DE LENGUA*/
      $PIAC_LS = DB::table('personas')
      ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
      ->where([['personas.lengua', '=', '1'],
               ['estudiantes.modalidad', '=', 'SEMIESCOLARIZADA'],
               ['estudiantes.sede', '=', 'CU'],
                ['estudiantes.semestre','=','1']])
      ->count();

      /*ALUMNOS DE PRIMER INGRESO DEL CICLO ESCOLAR ANTERIOR TOTAL*/
      /*MASCULINO*/
      $primeringreso_AC_MTOT=DB::select
      ('SELECT personas.genero,
        COUNT(estudiantes.matricula) as total
          FROM personas, estudiantes
          WHERE personas.id_persona=estudiantes.id_persona
          AND personas.genero="M"
          AND estudiantes.semestre="1"
          GROUP BY personas.genero');
          $PIAC_MTOT=$primeringreso_AC_MTOT[0]->total;
  /*FEMENINO*/
  $primeringreso_AC_FTOT=DB::select
  ('SELECT personas.genero,
    COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.genero="F"
    AND estudiantes.semestre="1"
    GROUP BY personas.genero');
    $PIAC_FTOT=$primeringreso_AC_FTOT[0]->total;
    /*CON DISCAPACIDAD*/
    $discapacidadesPICUTOTAC=DB::select('SELECT SUM(total) as tot
    FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
    FROM personas, estudiantes, discapacidades
    WHERE personas.id_persona=estudiantes.id_persona
    AND personas.id_persona=discapacidades.id_persona
    AND estudiantes.semestre="1"
    AND discapacidades.tipo IS NOT NULL
    GROUP BY discapacidades.tipo) as total');
    $PIAC_DTOT=$discapacidadesPICUTOTAC[0]->tot;
      /*HABLANTE DE LENGUA*/
      $PIAC_LTOT = DB::table('personas')
      ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
      ->where([['personas.lengua', '=', '1'],
                ['estudiantes.semestre','=','1']])
      ->count();


return view ('personal_administrativo/planeacion/reportes/reporte911_9A.reporte911_9A_1')
/*CU*/
->with('PIAC_M', $PIAC_M)
->with('PIAC_F', $PIAC_F)
->with('PIAC_DTOT', $PIAC_DTOT)
->with('PIAC_L', $PIAC_L)

/*TEHUANTEPEC*/
->with('PIAC_M_T', $PIAC_M_T)
->with('PIAC_F_T', $PIAC_F_T)
->with('PIAC_D_T', $PIAC_D_T)
->with('PIAC_L_T', $PIAC_L_T)

/*PUERTO*/
->with('PIAC_M_P', $PIAC_M_P)
->with('PIAC_F_P', $PIAC_F_P)
->with('PIAC_D_P', $PIAC_D_P)
->with('PIAC_L_P', $PIAC_L_P)

/*CU SEMI*/
->with('PIAC_MS', $PIAC_MS)
->with('PIAC_FS', $PIAC_FS)
->with('PIAC_DS', $PIAC_DS)
->with('PIAC_LS', $PIAC_LS)

/*TOTAL*/
->with('PIAC_MTOT', $PIAC_MTOT)
->with('PIAC_FTOT', $PIAC_FTOT)
->with('PIAC_DTOT', $PIAC_DTOT)
->with('PIAC_LTOT', $PIAC_LTOT)
;
}

public function reporte911_9A_2(){
  return view ('personal_administrativo/planeacion/reportes/reporte911_9A.reporte911_9A_2');
}

public function reporte911_9A_3(){
//MATRÍCULA TOTAL DE LA CARRERA
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

  //MODALIDAD ESCOLARIZADA
  //TEHUANTEPEC
  //-----------------------------------HOMBRES

    $tot_1_M_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'M'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','1']])
    ->count();
    $tot_2_M_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'M'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','2']])
    ->count();
    $tot_3_M_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'M'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','3']])
    ->count();
    $tot_4_M_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'M'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','4']])
    ->count();
    $tot_5_M_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'M'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','5']])
    ->count();
    $tot_6_M_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'M'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','6']])
    ->count();
    $tot_7_M_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'M'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','7']])
    ->count();
    $tot_8_M_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'M'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','8'],
              ['estudiantes.egresado','=', '0']])
    ->count();
  $tot_M_TEHUANTEPEC = ($tot_1_M_TEHUANTEPEC
                      + $tot_2_M_TEHUANTEPEC
                      + $tot_3_M_TEHUANTEPEC
                      + $tot_4_M_TEHUANTEPEC
                      + $tot_5_M_TEHUANTEPEC
                      + $tot_6_M_TEHUANTEPEC
                      + $tot_7_M_TEHUANTEPEC
                      + $tot_8_M_TEHUANTEPEC);

  //-----------------------------------MUJERES
    $tot_1_F_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'F'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','1']])
    ->count();
    $tot_2_F_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'F'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','2']])
    ->count();
    $tot_3_F_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'F'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','3']])
    ->count();
    $tot_4_F_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'F'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','4']])
    ->count();
    $tot_5_F_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'F'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','5']])
    ->count();
    $tot_6_F_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'F'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','6']])
    ->count();
    $tot_7_F_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'F'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','7']])
    ->count();
    $tot_8_F_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.genero', '=', 'F'],
             ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede', '=', 'TEHUANTEPEC'],
              ['estudiantes.semestre','=','8'],
              ['estudiantes.egresado','=', '0']])
    ->count();

    $tot_F_TEHUANTEPEC = ($tot_1_F_TEHUANTEPEC
                        + $tot_2_F_TEHUANTEPEC
                        + $tot_3_F_TEHUANTEPEC
                        + $tot_4_F_TEHUANTEPEC
                        + $tot_5_F_TEHUANTEPEC
                        + $tot_6_F_TEHUANTEPEC
                        + $tot_7_F_TEHUANTEPEC
                        + $tot_8_F_TEHUANTEPEC);

  /*CON DISCAPACIDAD*/
  $tot_D_1_TEHUANTEPEC = DB::select('SELECT SUM(total) as tot
  FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, discapacidades
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=discapacidades.id_persona
  AND estudiantes.semestre="1"
  AND estudiantes.sede="TEHUANTEPEC"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND discapacidades.tipo IS NOT NULL
  GROUP BY discapacidades.tipo) as total');
  $tot_1_D_TEHUANTEPEC = $tot_D_1_TEHUANTEPEC[0]->tot;

  $tot_D_2_TEHUANTEPEC = DB::select('SELECT SUM(total) as tot
  FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, discapacidades
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=discapacidades.id_persona
  AND estudiantes.semestre="2"
  AND estudiantes.sede="TEHUANTEPEC"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND discapacidades.tipo IS NOT NULL
  GROUP BY discapacidades.tipo) as total');
  $tot_2_D_TEHUANTEPEC = $tot_D_2_TEHUANTEPEC[0]->tot;

  $tot_D_3_TEHUANTEPEC = DB::select('SELECT SUM(total) as tot
  FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, discapacidades
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=discapacidades.id_persona
  AND estudiantes.semestre="3"
  AND estudiantes.sede="TEHUANTEPEC"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND discapacidades.tipo IS NOT NULL
  GROUP BY discapacidades.tipo) as total');
  $tot_3_D_TEHUANTEPEC = $tot_D_3_TEHUANTEPEC[0]->tot;

  $tot_D_4_TEHUANTEPEC = DB::select('SELECT SUM(total) as tot
  FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, discapacidades
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=discapacidades.id_persona
  AND estudiantes.semestre="4"
  AND estudiantes.sede="TEHUANTEPEC"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND discapacidades.tipo IS NOT NULL
  GROUP BY discapacidades.tipo) as total');
  $tot_4_D_TEHUANTEPEC = $tot_D_4_TEHUANTEPEC[0]->tot;

  $tot_D_5_TEHUANTEPEC = DB::select('SELECT SUM(total) as tot
  FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, discapacidades
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=discapacidades.id_persona
  AND estudiantes.semestre="5"
  AND estudiantes.sede="TEHUANTEPEC"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND discapacidades.tipo IS NOT NULL
  GROUP BY discapacidades.tipo) as total');
  $tot_5_D_TEHUANTEPEC = $tot_D_5_TEHUANTEPEC[0]->tot;

  $tot_D_6_TEHUANTEPEC = DB::select('SELECT SUM(total) as tot
  FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, discapacidades
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=discapacidades.id_persona
  AND estudiantes.semestre="6"
  AND estudiantes.sede="TEHUANTEPEC"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND discapacidades.tipo IS NOT NULL
  GROUP BY discapacidades.tipo) as total');
  $tot_6_D_TEHUANTEPEC = $tot_D_6_TEHUANTEPEC[0]->tot;

  $tot_D_7_TEHUANTEPEC = DB::select('SELECT SUM(total) as tot
  FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, discapacidades
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=discapacidades.id_persona
  AND estudiantes.semestre="7"
  AND estudiantes.sede="TEHUANTEPEC"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND discapacidades.tipo IS NOT NULL
  GROUP BY discapacidades.tipo) as total');
  $tot_7_D_TEHUANTEPEC = $tot_D_7_TEHUANTEPEC[0]->tot;

  $tot_D_8_TEHUANTEPEC = DB::select('SELECT SUM(total) as tot
  FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
  FROM personas, estudiantes, discapacidades
  WHERE personas.id_persona=estudiantes.id_persona
  AND personas.id_persona=discapacidades.id_persona
  AND estudiantes.semestre="8"
  AND estudiantes.sede="TEHUANTEPEC"
  AND estudiantes.modalidad="ESCOLARIZADA"
  AND estudiantes.egresado="0"
  AND discapacidades.tipo IS NOT NULL
  GROUP BY discapacidades.tipo) as total');
  $tot_8_D_TEHUANTEPEC = $tot_D_8_TEHUANTEPEC[0]->tot;

  $tot_T_D_TEHUANTEPEC = $tot_1_D_TEHUANTEPEC +
                $tot_2_D_TEHUANTEPEC +
                $tot_3_D_TEHUANTEPEC +
                $tot_4_D_TEHUANTEPEC +
                $tot_5_D_TEHUANTEPEC +
                $tot_6_D_TEHUANTEPEC +
                $tot_7_D_TEHUANTEPEC +
                $tot_8_D_TEHUANTEPEC ;


  /*HABLANTE DE LENGUA*/
    $tot_1_L_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.lengua', '=', '1'],
             ['estudiantes.semestre','=','1'],
                ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede','=','TEHUANTEPEC']])
    ->count();

    $tot_2_L_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.lengua', '=', '2'],
             ['estudiantes.semestre','=','2'],
                ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede','=','TEHUANTEPEC']])
    ->count();

    $tot_3_L_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.lengua', '=', '3'],
             ['estudiantes.semestre','=','3'],
                ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede','=','TEHUANTEPEC']])
    ->count();

    $tot_4_L_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.lengua', '=', '4'],
             ['estudiantes.semestre','=','4'],
                ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede','=','TEHUANTEPEC']])
    ->count();

    $tot_5_L_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.lengua', '=', '5'],
             ['estudiantes.semestre','=','5'],
                ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede','=','TEHUANTEPEC']])
    ->count();

    $tot_6_L_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.lengua', '=', '6'],
             ['estudiantes.semestre','=','6'],
                ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede','=','TEHUANTEPEC']])
    ->count();

    $tot_7_L_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.lengua', '=', '7'],
             ['estudiantes.semestre','=','7'],
                ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede','=','TEHUANTEPEC']])
    ->count();

    $tot_8_L_TEHUANTEPEC = DB::table('personas')
    ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
    ->where([['personas.lengua', '=', '8'],
             ['estudiantes.semestre','=','8'],
                ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
             ['estudiantes.sede','=','TEHUANTEPEC'],
             ['estudiantes.egresado','=','0']])
    ->count();

    $tot_T_L_TEHUANTEPEC = $tot_1_L_TEHUANTEPEC +
                  $tot_2_L_TEHUANTEPEC +
                  $tot_3_L_TEHUANTEPEC +
                  $tot_4_L_TEHUANTEPEC +
                  $tot_5_L_TEHUANTEPEC +
                  $tot_6_L_TEHUANTEPEC +
                  $tot_7_L_TEHUANTEPEC +
                  $tot_8_L_TEHUANTEPEC ;


//MODALIDAD ESCOLARIZADA
//PUERTO ESCONDIDO
                  //-----------------------------------HOMBRES
$tot_1_M_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','1']])
->count();

$tot_2_M_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','2']])
->count();

$tot_3_M_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','3']])
->count();

$tot_4_M_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','4']])
->count();

$tot_5_M_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','5']])
->count();

$tot_6_M_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','6']])
->count();

$tot_7_M_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','7']])
->count();

$tot_8_M_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'M'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','8'],
          ['estudiantes.egresado','=', '0']])
->count();

$tot_M_PTO = ($tot_1_M_PTO
          + $tot_2_M_PTO
          + $tot_3_M_PTO
          + $tot_4_M_PTO
          + $tot_5_M_PTO
          + $tot_6_M_PTO
          + $tot_7_M_PTO
          + $tot_8_M_PTO);


//-----------------------------------MUJERES
$tot_1_F_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','1']])
->count();

$tot_2_F_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','2']])
->count();

$tot_3_F_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','3']])
->count();

$tot_4_F_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','4']])
->count();

$tot_5_F_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','5']])
->count();

$tot_6_F_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','6']])
->count();

$tot_7_F_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','7']])
->count();


$tot_8_F_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.genero', '=', 'F'],
         ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede', '=', 'PUERTO ESCONDIDO'],
          ['estudiantes.semestre','=','8'],
          ['estudiantes.egresado','=', '0']])
                    ->count();


$tot_F_PTO = ($tot_1_F_PTO
          + $tot_2_F_PTO
          + $tot_3_F_PTO
          + $tot_4_F_PTO
          + $tot_5_F_PTO
          + $tot_6_F_PTO
          + $tot_7_F_PTO
          + $tot_8_F_PTO);

                  /*CON DISCAPACIDAD*/
$tot_D_1_PTO = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="1"
AND estudiantes.sede="PUERTO ESCONDIDO"
AND estudiantes.modalidad="ESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_1_D_PTO = $tot_D_1_PTO[0]->tot;

$tot_D_2_PTO = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="2"
AND estudiantes.sede="PUERTO ESCONDIDO"
AND estudiantes.modalidad="ESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_2_D_PTO = $tot_D_2_PTO[0]->tot;

$tot_D_3_PTO = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="3"
AND estudiantes.sede="PUERTO ESCONDIDO"
AND estudiantes.modalidad="ESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_3_D_PTO = $tot_D_3_PTO[0]->tot;

$tot_D_4_PTO = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="4"
AND estudiantes.sede="PUERTO ESCONDIDO"
AND estudiantes.modalidad="ESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_4_D_PTO = $tot_D_4_PTO[0]->tot;

$tot_D_5_PTO = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="5"
AND estudiantes.sede="PUERTO ESCONDIDO"
AND estudiantes.modalidad="ESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_5_D_PTO = $tot_D_5_PTO[0]->tot;

$tot_D_6_PTO = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="6"
AND estudiantes.sede="PUERTO ESCONDIDO"
AND estudiantes.modalidad="ESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_6_D_PTO = $tot_D_6_PTO[0]->tot;

$tot_D_7_PTO = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="7"
AND estudiantes.sede="PUERTO ESCONDIDO"
AND estudiantes.modalidad="ESCOLARIZADA"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_7_D_PTO = $tot_D_7_PTO[0]->tot;

$tot_D_8_PTO = DB::select('SELECT SUM(total) as tot
FROM (SELECT discapacidades.tipo, COUNT(estudiantes.matricula) as total
FROM personas, estudiantes, discapacidades
WHERE personas.id_persona=estudiantes.id_persona
AND personas.id_persona=discapacidades.id_persona
AND estudiantes.semestre="8"
AND estudiantes.sede="PUERTO ESCONDIDO"
AND estudiantes.modalidad="ESCOLARIZADA"
AND estudiantes.egresado="0"
AND discapacidades.tipo IS NOT NULL
GROUP BY discapacidades.tipo) as total');
$tot_8_D_PTO = $tot_D_8_PTO[0]->tot;

$tot_T_D_PTO = $tot_1_D_PTO +
              $tot_2_D_PTO +
              $tot_3_D_PTO +
              $tot_4_D_PTO +
              $tot_5_D_PTO +
              $tot_6_D_PTO +
              $tot_7_D_PTO +
              $tot_8_D_PTO ;


                  /*HABLANTE DE LENGUA*/
$tot_1_L_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.lengua', '=', '1'],
         ['estudiantes.semestre','=','1'],
            ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_2_L_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.lengua', '=', '2'],
         ['estudiantes.semestre','=','2'],
            ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede','=','PUERTO ESCONDIDO']])
->count();

$tot_3_L_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.lengua', '=', '3'],
         ['estudiantes.semestre','=','3'],
            ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede','=','PUERTO ESCONDIDO']])
->count();

$tot_4_L_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.lengua', '=', '4'],
         ['estudiantes.semestre','=','4'],
            ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede','=','PUERTO ESCONDIDO']])
->count();

$tot_5_L_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.lengua', '=', '5'],
         ['estudiantes.semestre','=','5'],
            ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede','=','PUERTO ESCONDIDO']])
->count();

$tot_6_L_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.lengua', '=', '6'],
         ['estudiantes.semestre','=','6'],
            ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede','=','PUERTO ESCONDIDO']])
->count();

$tot_7_L_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.lengua', '=', '7'],
         ['estudiantes.semestre','=','7'],
            ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede','=','PUERTO ESCONDIDO']])
->count();

$tot_8_L_PTO = DB::table('personas')
->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
->where([['personas.lengua', '=', '8'],
         ['estudiantes.semestre','=','8'],
            ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
         ['estudiantes.sede','=','PUERTO ESCONDIDO'],
         ['estudiantes.egresado','=','0']])
->count();

$tot_T_L_PTO = $tot_1_L_PTO +
              $tot_2_L_PTO +
              $tot_3_L_PTO +
              $tot_4_L_PTO +
              $tot_5_L_PTO +
              $tot_6_L_PTO +
              $tot_7_L_PTO +
              $tot_8_L_PTO ;




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

//-------------------TOTAL GENRAL
//------------------------------------MASCULINO
$TOT_G_M_1 = $tot_1_M_CU + $tot_1_M_TEHUANTEPEC + $tot_1_M_PTO + $tot_1_M_CU_S;
$TOT_G_M_2 = $tot_2_M_CU + $tot_2_M_TEHUANTEPEC + $tot_2_M_PTO + $tot_2_M_CU_S;
$TOT_G_M_3 = $tot_3_M_CU + $tot_3_M_TEHUANTEPEC + $tot_3_M_PTO + $tot_3_M_CU_S;
$TOT_G_M_4 = $tot_4_M_CU + $tot_4_M_TEHUANTEPEC + $tot_4_M_PTO + $tot_4_M_CU_S;
$TOT_G_M_5 = $tot_5_M_CU + $tot_5_M_TEHUANTEPEC + $tot_5_M_PTO + $tot_5_M_CU_S;
$TOT_G_M_6 = $tot_6_M_CU + $tot_6_M_TEHUANTEPEC + $tot_6_M_PTO + $tot_6_M_CU_S;
$TOT_G_M_7 = $tot_7_M_CU + $tot_7_M_TEHUANTEPEC + $tot_7_M_PTO + $tot_7_M_CU_S;
$TOT_G_M_8 = $tot_8_M_CU + $tot_8_M_TEHUANTEPEC + $tot_8_M_PTO + $tot_8_M_CU_S;

$TOT_G_M_T = $TOT_G_M_1 +
             $TOT_G_M_2 +
             $TOT_G_M_3 +
             $TOT_G_M_4 +
             $TOT_G_M_5 +
             $TOT_G_M_6 +
             $TOT_G_M_7 +
             $TOT_G_M_8 ;

//------------------------------------FEMENINO
$TOT_G_F_1 = $tot_1_F_CU + $tot_1_F_TEHUANTEPEC + $tot_1_F_PTO + $tot_1_F_CU_S;
$TOT_G_F_2 = $tot_2_F_CU + $tot_2_F_TEHUANTEPEC + $tot_2_F_PTO + $tot_2_F_CU_S;
$TOT_G_F_3 = $tot_3_F_CU + $tot_3_F_TEHUANTEPEC + $tot_3_F_PTO + $tot_3_F_CU_S;
$TOT_G_F_4 = $tot_4_F_CU + $tot_4_F_TEHUANTEPEC + $tot_4_F_PTO + $tot_4_F_CU_S;
$TOT_G_F_5 = $tot_5_F_CU + $tot_5_F_TEHUANTEPEC + $tot_5_F_PTO + $tot_5_F_CU_S;
$TOT_G_F_6 = $tot_6_F_CU + $tot_6_F_TEHUANTEPEC + $tot_6_F_PTO + $tot_6_F_CU_S;
$TOT_G_F_7 = $tot_7_F_CU + $tot_7_F_TEHUANTEPEC + $tot_7_F_PTO + $tot_7_F_CU_S;
$TOT_G_F_8 = $tot_8_F_CU + $tot_8_F_TEHUANTEPEC + $tot_8_F_PTO + $tot_8_F_CU_S;

$TOT_G_F_T = $TOT_G_F_1 +
             $TOT_G_F_2 +
             $TOT_G_F_3 +
             $TOT_G_F_4 +
             $TOT_G_F_5 +
             $TOT_G_F_6 +
             $TOT_G_F_7 +
             $TOT_G_F_8 ;

//------------------------------------TOTAL
$TOT_G_T_1 = $TOT_G_M_1 + $TOT_G_F_1 ;
$TOT_G_T_2 = $TOT_G_M_2 + $TOT_G_F_2 ;
$TOT_G_T_3 = $TOT_G_M_3 + $TOT_G_F_3 ;
$TOT_G_T_4 = $TOT_G_M_4 + $TOT_G_F_4 ;
$TOT_G_T_5 = $TOT_G_M_5 + $TOT_G_F_5 ;
$TOT_G_T_6 = $TOT_G_M_6 + $TOT_G_F_6 ;
$TOT_G_T_7 = $TOT_G_M_7 + $TOT_G_F_7 ;
$TOT_G_T_8 = $TOT_G_M_8 + $TOT_G_F_8 ;
$TOT_G_T = $TOT_G_M_T + $TOT_G_F_T ;


//-----------------------------------CON DISCAPACIDAD
$TOT_G_D_1 = $tot_1_D_CU + $tot_1_D_TEHUANTEPEC + $tot_1_D_PTO + $tot_1_D_CU_S ;
$TOT_G_D_2 = $tot_2_D_CU + $tot_2_D_TEHUANTEPEC + $tot_2_D_PTO + $tot_2_D_CU_S ;
$TOT_G_D_3 = $tot_3_D_CU + $tot_3_D_TEHUANTEPEC + $tot_3_D_PTO + $tot_3_D_CU_S ;
$TOT_G_D_4 = $tot_4_D_CU + $tot_4_D_TEHUANTEPEC + $tot_4_D_PTO + $tot_4_D_CU_S ;
$TOT_G_D_5 = $tot_5_D_CU + $tot_5_D_TEHUANTEPEC + $tot_5_D_PTO + $tot_5_D_CU_S ;
$TOT_G_D_6 = $tot_6_D_CU + $tot_6_D_TEHUANTEPEC + $tot_6_D_PTO + $tot_6_D_CU_S ;
$TOT_G_D_7 = $tot_7_D_CU + $tot_7_D_TEHUANTEPEC + $tot_7_D_PTO + $tot_7_D_CU_S ;
$TOT_G_D_8 = $tot_8_D_CU + $tot_8_D_TEHUANTEPEC + $tot_8_D_PTO + $tot_8_D_CU_S ;

$TOT_G_D_T = $TOT_G_D_1 +
             $TOT_G_D_2 +
             $TOT_G_D_3 +
             $TOT_G_D_4 +
             $TOT_G_D_5 +
             $TOT_G_D_6 +
             $TOT_G_D_7 +
             $TOT_G_D_8 ;

//------------------------------HABLANTE DE LENGUA
$TOT_G_L_1 = $tot_1_L_CU + $tot_1_L_TEHUANTEPEC + $tot_1_L_PTO + $tot_1_L_CU_S ;
$TOT_G_L_2 = $tot_2_L_CU + $tot_2_L_TEHUANTEPEC + $tot_2_L_PTO + $tot_2_L_CU_S ;
$TOT_G_L_3 = $tot_3_L_CU + $tot_3_L_TEHUANTEPEC + $tot_3_L_PTO + $tot_3_L_CU_S ;
$TOT_G_L_4 = $tot_4_L_CU + $tot_4_L_TEHUANTEPEC + $tot_4_L_PTO + $tot_4_L_CU_S ;
$TOT_G_L_5 = $tot_5_L_CU + $tot_5_L_TEHUANTEPEC + $tot_5_L_PTO + $tot_5_L_CU_S ;
$TOT_G_L_6 = $tot_6_L_CU + $tot_6_L_TEHUANTEPEC + $tot_6_L_PTO + $tot_6_L_CU_S ;
$TOT_G_L_7 = $tot_7_L_CU + $tot_7_L_TEHUANTEPEC + $tot_7_L_PTO + $tot_7_L_CU_S ;
$TOT_G_L_8 = $tot_8_L_CU + $tot_8_L_TEHUANTEPEC + $tot_8_L_PTO + $tot_8_L_CU_S ;

$TOT_G_L_T = $TOT_G_L_1 +
             $TOT_G_L_2 +
             $TOT_G_L_3 +
             $TOT_G_L_4 +
             $TOT_G_L_5 +
             $TOT_G_L_6 +
             $TOT_G_L_7 +
             $TOT_G_L_8 ;

return view ('personal_administrativo/planeacion/reportes/reporte911_9A.reporte911_9A_3')
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


//TEHUANTEPEC
//MASCULINO
->with('tot_1_M_TEHUANTEPEC',$tot_1_M_TEHUANTEPEC)
->with('tot_2_M_TEHUANTEPEC',$tot_2_M_TEHUANTEPEC)
->with('tot_3_M_TEHUANTEPEC',$tot_3_M_TEHUANTEPEC)
->with('tot_4_M_TEHUANTEPEC',$tot_4_M_TEHUANTEPEC)
->with('tot_5_M_TEHUANTEPEC',$tot_5_M_TEHUANTEPEC)
->with('tot_6_M_TEHUANTEPEC',$tot_6_M_TEHUANTEPEC)
->with('tot_7_M_TEHUANTEPEC',$tot_7_M_TEHUANTEPEC)
->with('tot_8_M_TEHUANTEPEC',$tot_8_M_TEHUANTEPEC)
->with('tot_M_TEHUANTEPEC',$tot_M_TEHUANTEPEC)

//FEMENINO
->with('tot_1_F_TEHUANTEPEC',$tot_1_F_TEHUANTEPEC)
->with('tot_2_F_TEHUANTEPEC',$tot_2_F_TEHUANTEPEC)
->with('tot_3_F_TEHUANTEPEC',$tot_3_F_TEHUANTEPEC)
->with('tot_4_F_TEHUANTEPEC',$tot_4_F_TEHUANTEPEC)
->with('tot_5_F_TEHUANTEPEC',$tot_5_F_TEHUANTEPEC)
->with('tot_6_F_TEHUANTEPEC',$tot_6_F_TEHUANTEPEC)
->with('tot_7_F_TEHUANTEPEC',$tot_7_F_TEHUANTEPEC)
->with('tot_8_F_TEHUANTEPEC',$tot_8_F_TEHUANTEPEC)
->with('tot_F_TEHUANTEPEC',$tot_F_TEHUANTEPEC)

//CON DISCAPACIDAD
->with('tot_1_D_TEHUANTEPEC',$tot_1_D_TEHUANTEPEC)
->with('tot_2_D_TEHUANTEPEC',$tot_2_D_TEHUANTEPEC)
->with('tot_3_D_TEHUANTEPEC',$tot_3_D_TEHUANTEPEC)
->with('tot_4_D_TEHUANTEPEC',$tot_4_D_TEHUANTEPEC)
->with('tot_5_D_TEHUANTEPEC',$tot_5_D_TEHUANTEPEC)
->with('tot_6_D_TEHUANTEPEC',$tot_6_D_TEHUANTEPEC)
->with('tot_7_D_TEHUANTEPEC',$tot_7_D_TEHUANTEPEC)
->with('tot_8_D_TEHUANTEPEC',$tot_8_D_TEHUANTEPEC)
->with('tot_T_D_TEHUANTEPEC',$tot_T_D_TEHUANTEPEC)

//HABLANTE DE LENGUA
->with('tot_1_L_TEHUANTEPEC',$tot_1_L_TEHUANTEPEC)
->with('tot_2_L_TEHUANTEPEC',$tot_2_L_TEHUANTEPEC)
->with('tot_3_L_TEHUANTEPEC',$tot_3_L_TEHUANTEPEC)
->with('tot_4_L_TEHUANTEPEC',$tot_4_L_TEHUANTEPEC)
->with('tot_5_L_TEHUANTEPEC',$tot_5_L_TEHUANTEPEC)
->with('tot_6_L_TEHUANTEPEC',$tot_6_L_TEHUANTEPEC)
->with('tot_7_L_TEHUANTEPEC',$tot_7_L_TEHUANTEPEC)
->with('tot_8_L_TEHUANTEPEC',$tot_8_L_TEHUANTEPEC)
->with('tot_T_L_TEHUANTEPEC',$tot_T_L_TEHUANTEPEC)

//PUERTO ESCONDIDO
//MASCULINO
->with('tot_1_M_PTO',$tot_1_M_PTO)
->with('tot_2_M_PTO',$tot_2_M_PTO)
->with('tot_3_M_PTO',$tot_3_M_PTO)
->with('tot_4_M_PTO',$tot_4_M_PTO)
->with('tot_5_M_PTO',$tot_5_M_PTO)
->with('tot_6_M_PTO',$tot_6_M_PTO)
->with('tot_7_M_PTO',$tot_7_M_PTO)
->with('tot_8_M_PTO',$tot_8_M_PTO)
->with('tot_M_PTO',$tot_M_PTO)

//FEMENINO
->with('tot_1_F_PTO',$tot_1_F_PTO)
->with('tot_2_F_PTO',$tot_2_F_PTO)
->with('tot_3_F_PTO',$tot_3_F_PTO)
->with('tot_4_F_PTO',$tot_4_F_PTO)
->with('tot_5_F_PTO',$tot_5_F_PTO)
->with('tot_6_F_PTO',$tot_6_F_PTO)
->with('tot_7_F_PTO',$tot_7_F_PTO)
->with('tot_8_F_PTO',$tot_8_F_PTO)
->with('tot_F_PTO',$tot_F_PTO)

//CON DISCAPACIDAD
->with('tot_1_D_PTO',$tot_1_D_PTO)
->with('tot_2_D_PTO',$tot_2_D_PTO)
->with('tot_3_D_PTO',$tot_3_D_PTO)
->with('tot_4_D_PTO',$tot_4_D_PTO)
->with('tot_5_D_PTO',$tot_5_D_PTO)
->with('tot_6_D_PTO',$tot_6_D_PTO)
->with('tot_7_D_PTO',$tot_7_D_PTO)
->with('tot_8_D_PTO',$tot_8_D_PTO)
->with('tot_T_D_PTO',$tot_T_D_PTO)

//HABLANTE DE LENGUA
->with('tot_1_L_PTO',$tot_1_L_PTO)
->with('tot_2_L_PTO',$tot_2_L_PTO)
->with('tot_3_L_PTO',$tot_3_L_PTO)
->with('tot_4_L_PTO',$tot_4_L_PTO)
->with('tot_5_L_PTO',$tot_5_L_PTO)
->with('tot_6_L_PTO',$tot_6_L_PTO)
->with('tot_7_L_PTO',$tot_7_L_PTO)
->with('tot_8_L_PTO',$tot_8_L_PTO)
->with('tot_T_L_PTO',$tot_T_L_PTO)

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

// TOTAL GENERAL
//---------------MASCULINO
->with('TOT_G_M_1', $TOT_G_M_1)
->with('TOT_G_M_2', $TOT_G_M_2)
->with('TOT_G_M_3', $TOT_G_M_3)
->with('TOT_G_M_4', $TOT_G_M_4)
->with('TOT_G_M_5', $TOT_G_M_5)
->with('TOT_G_M_6', $TOT_G_M_6)
->with('TOT_G_M_7', $TOT_G_M_7)
->with('TOT_G_M_8', $TOT_G_M_8)
->with('TOT_G_M_T', $TOT_G_M_T)

//---------------FEMENINO
->with('TOT_G_F_1', $TOT_G_F_1)
->with('TOT_G_F_2', $TOT_G_F_2)
->with('TOT_G_F_3', $TOT_G_F_3)
->with('TOT_G_F_4', $TOT_G_F_4)
->with('TOT_G_F_5', $TOT_G_F_5)
->with('TOT_G_F_6', $TOT_G_F_6)
->with('TOT_G_F_7', $TOT_G_F_7)
->with('TOT_G_F_8', $TOT_G_F_8)
->with('TOT_G_F_T', $TOT_G_F_T)

//-------------TOTAL
->with('TOT_G_T_1', $TOT_G_T_1)
->with('TOT_G_T_2', $TOT_G_T_2)
->with('TOT_G_T_3', $TOT_G_T_3)
->with('TOT_G_T_4', $TOT_G_T_4)
->with('TOT_G_T_5', $TOT_G_T_5)
->with('TOT_G_T_6', $TOT_G_T_6)
->with('TOT_G_T_7', $TOT_G_T_7)
->with('TOT_G_T_8', $TOT_G_T_8)
->with('TOT_G_T', $TOT_G_T)

//-----------CON DISCAPACIDAD
->with('TOT_G_D_1', $TOT_G_D_1)
->with('TOT_G_D_2', $TOT_G_D_2)
->with('TOT_G_D_3', $TOT_G_D_3)
->with('TOT_G_D_4', $TOT_G_D_4)
->with('TOT_G_D_5', $TOT_G_D_5)
->with('TOT_G_D_6', $TOT_G_D_6)
->with('TOT_G_D_7', $TOT_G_D_7)
->with('TOT_G_D_8', $TOT_G_D_8)
->with('TOT_G_D_T', $TOT_G_D_T)

//--------------HABLANTE DE LENGUA
->with('TOT_G_L_1', $TOT_G_L_1)
->with('TOT_G_L_2', $TOT_G_L_2)
->with('TOT_G_L_3', $TOT_G_L_3)
->with('TOT_G_L_4', $TOT_G_L_4)
->with('TOT_G_L_5', $TOT_G_L_5)
->with('TOT_G_L_6', $TOT_G_L_6)
->with('TOT_G_L_7', $TOT_G_L_7)
->with('TOT_G_L_8', $TOT_G_L_8)
->with('TOT_G_L_T', $TOT_G_L_T)
;



}

public function reporte911_9A_4(){
  //----------------ALUMNOS INSCRITOS POR EDAD Y GRADO DE AVANCE-----------//
  //MODALIDAD ESCOLARIZADA------------------------//
  //CU
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

//----------------ALUMNOS INSCRITOS POR EDAD Y GRADO DE AVANCE-----------//
//-----------------------------------------------------------------------------------------------------------TEHUANTEPEC
  //---------------------------------- <18---------------------------------//
$tot_m_18_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_m_18_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_m_18_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_m_18_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_m_18_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_m_18_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_m_18_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_m_18_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_m_18_T_T = $tot_m_18_1_T +
                $tot_m_18_2_T +
                $tot_m_18_3_T +
                $tot_m_18_4_T +
                $tot_m_18_5_T +
                $tot_m_18_6_T +
                $tot_m_18_7_T +
                $tot_m_18_8_T ;

//---------------------------------- 18---------------------------------//
$tot_18_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_18_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_18_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_18_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_18_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_18_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_18_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_18_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_18_T_T = $tot_18_1_T +
              $tot_18_2_T +
              $tot_18_3_T +
              $tot_18_4_T +
              $tot_18_5_T +
              $tot_18_6_T +
              $tot_18_7_T +
              $tot_18_8_T ;

//---------------------------------- 19---------------------------------//
$tot_19_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_19_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_19_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_19_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_19_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_19_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_19_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_19_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_19_T_T = $tot_19_1_T +
              $tot_19_2_T +
              $tot_19_3_T +
              $tot_19_4_T +
              $tot_19_5_T +
              $tot_19_6_T +
              $tot_19_7_T +
              $tot_19_8_T ;

//---------------------------------- 20---------------------------------//
$tot_20_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_20_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_20_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_20_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_20_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_20_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_20_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_20_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_20_T_T = $tot_20_1_T +
              $tot_20_2_T +
              $tot_20_3_T +
              $tot_20_4_T +
              $tot_20_5_T +
              $tot_20_6_T +
              $tot_20_7_T +
              $tot_20_8_T ;

//---------------------------------- 21---------------------------------//
$tot_21_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_21_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_21_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_21_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_21_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_21_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_21_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_21_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_21_T_T = $tot_21_1_T +
              $tot_21_2_T +
              $tot_21_3_T +
              $tot_21_4_T +
              $tot_21_5_T +
              $tot_21_6_T +
              $tot_21_7_T +
              $tot_21_8_T ;

//---------------------------------- 22---------------------------------//
$tot_22_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_22_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_22_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_22_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_22_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_22_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_22_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_22_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_22_T_T = $tot_22_1_T +
              $tot_22_2_T +
              $tot_22_3_T +
              $tot_22_4_T +
              $tot_22_5_T +
              $tot_22_6_T +
              $tot_22_7_T +
              $tot_22_8_T ;

//---------------------------------- 23---------------------------------//
$tot_23_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_23_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_23_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_23_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_23_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_23_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_23_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_23_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_23_T_T = $tot_23_1_T +
              $tot_23_2_T +
              $tot_23_3_T +
              $tot_23_4_T +
              $tot_23_5_T +
              $tot_23_6_T +
              $tot_23_7_T +
              $tot_23_8_T ;

//---------------------------------- 24---------------------------------//
$tot_24_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_24_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_24_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_24_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_24_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_24_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_24_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_24_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_24_T_T = $tot_24_1_T +
              $tot_24_2_T +
              $tot_24_3_T +
              $tot_24_4_T +
              $tot_24_5_T +
              $tot_24_6_T +
              $tot_24_7_T +
              $tot_24_8_T ;


//----------------------------------25---------------------------------//
$tot_25_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_25_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_25_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_25_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_25_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_25_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_25_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_25_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_25_T_T = $tot_25_1_T +
              $tot_25_2_T +
              $tot_25_3_T +
              $tot_25_4_T +
              $tot_25_5_T +
              $tot_25_6_T +
              $tot_25_7_T +
              $tot_25_8_T ;


//---------------------------------- 26---------------------------------//
$tot_26_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_26_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_26_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_26_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_26_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_26_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_26_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_26_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_26_T_T = $tot_26_1_T +
              $tot_26_2_T +
              $tot_26_3_T +
              $tot_26_4_T +
              $tot_26_5_T +
              $tot_26_6_T +
              $tot_26_7_T +
              $tot_26_8_T ;


//----------------------------------27---------------------------------//
$tot_27_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_27_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_27_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_27_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_27_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_27_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_27_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_27_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_27_T_T = $tot_27_1_T +
              $tot_27_2_T +
              $tot_27_3_T +
              $tot_27_4_T +
              $tot_27_5_T +
              $tot_27_6_T +
              $tot_27_7_T +
              $tot_27_8_T ;


//---------------------------------- 28---------------------------------//
$tot_28_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_28_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_28_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_28_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_28_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_28_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_28_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_28_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_28_T_T = $tot_28_1_T +
              $tot_28_2_T +
              $tot_28_3_T +
              $tot_28_4_T +
              $tot_28_5_T +
              $tot_28_6_T +
              $tot_28_7_T +
              $tot_28_8_T ;


//---------------------------------- 29---------------------------------//
$tot_29_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_29_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_29_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_29_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_29_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_29_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_29_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_29_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_29_T_T = $tot_29_1_T +
              $tot_29_2_T +
              $tot_29_3_T +
              $tot_29_4_T +
              $tot_29_5_T +
              $tot_29_6_T +
              $tot_29_7_T +
              $tot_29_8_T ;


//----------------------------------30-34--------------------------------//
$tot_30_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_30_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_30_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_30_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_30_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_30_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_30_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_30_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_30_T_T = $tot_30_1_T +
              $tot_30_2_T +
              $tot_30_3_T +
              $tot_30_4_T +
              $tot_30_5_T +
              $tot_30_6_T +
              $tot_30_7_T +
              $tot_30_8_T ;


//----------------------------------35-40--------------------------------//
$tot_35_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_35_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_35_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_35_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_35_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_35_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_35_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_35_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_35_T_T = $tot_35_1_T +
              $tot_35_2_T +
              $tot_35_3_T +
              $tot_35_4_T +
              $tot_35_5_T +
              $tot_35_6_T +
              $tot_35_7_T +
              $tot_35_8_T ;

//---------------------------------->=40--------------------------------//
$tot_40_1_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_40_2_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_40_3_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_40_4_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_40_5_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_40_6_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_40_7_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC']])
  ->count();

$tot_40_8_T = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','TEHUANTEPEC'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_40_T_T = $tot_40_1_T +
              $tot_40_2_T +
              $tot_40_3_T +
              $tot_40_4_T +
              $tot_40_5_T +
              $tot_40_6_T +
              $tot_40_7_T +
              $tot_40_8_T ;


//---------------------------TOTALES
$tot_G_1_T = $tot_m_18_1_T + $tot_18_1_T + $tot_19_1_T + $tot_20_1_T + $tot_21_1_T + $tot_22_1_T
           + $tot_23_1_T + $tot_24_1_T + $tot_25_1_T + $tot_26_1_T + $tot_27_1_T + $tot_28_1_T
           + $tot_29_1_T + $tot_30_1_T + $tot_35_1_T + $tot_40_1_T ;

$tot_G_2_T = $tot_m_18_2_T + $tot_18_2_T + $tot_19_2_T + $tot_20_2_T + $tot_21_2_T + $tot_22_2_T
           + $tot_23_2_T + $tot_24_2_T + $tot_25_2_T + $tot_26_2_T + $tot_27_2_T + $tot_28_2_T
           + $tot_29_2_T + $tot_30_2_T + $tot_35_2_T + $tot_40_2_T ;

$tot_G_3_T = $tot_m_18_3_T + $tot_18_3_T + $tot_19_3_T + $tot_20_3_T + $tot_21_3_T + $tot_22_3_T
           + $tot_23_3_T + $tot_24_3_T + $tot_25_3_T + $tot_26_3_T + $tot_27_3_T + $tot_28_3_T
           + $tot_29_3 + $tot_30_3 + $tot_35_3 + $tot_40_3 ;

$tot_G_4_T = $tot_m_18_4_T + $tot_18_4_T + $tot_19_4_T + $tot_20_4_T + $tot_21_4_T + $tot_22_4_T
           + $tot_23_4_T + $tot_24_4_T + $tot_25_4_T + $tot_26_4_T + $tot_27_4_T + $tot_28_4_T
           + $tot_29_4_T + $tot_30_4_T + $tot_35_4_T + $tot_40_4_T ;

$tot_G_5_T = $tot_m_18_5_T + $tot_18_5_T + $tot_19_5_T + $tot_20_5_T + $tot_21_5_T + $tot_22_5_T
           + $tot_23_5_T + $tot_24_5_T + $tot_25_5_T + $tot_26_5_T + $tot_27_5_T + $tot_28_5_T
           + $tot_29_5_T + $tot_30_5_T + $tot_35_5_T + $tot_40_5_T ;

$tot_G_6_T = $tot_m_18_6_T + $tot_18_6_T + $tot_19_6_T + $tot_20_6_T + $tot_21_6_T + $tot_22_6_T
           + $tot_23_6_T + $tot_24_6_T + $tot_25_6_T + $tot_26_6_T + $tot_27_6_T + $tot_28_6_T
           + $tot_29_6_T + $tot_30_6_T + $tot_35_6_T + $tot_40_6_T ;

$tot_G_7_T = $tot_m_18_7_T + $tot_18_7_T + $tot_19_7_T + $tot_20_7_T + $tot_21_7_T + $tot_22_7_T
           + $tot_23_7_T + $tot_24_7_T + $tot_25_7_T + $tot_26_7_T + $tot_27_7_T + $tot_28_7_T
           + $tot_29_7_T + $tot_30_7_T + $tot_35_7_T + $tot_40_7_T ;

$tot_G_8_T = $tot_m_18_8_T + $tot_18_8_T + $tot_19_8_T + $tot_20_8_T + $tot_21_8_T + $tot_22_8_T
           + $tot_23_8_T + $tot_24_8_T + $tot_25_8_T + $tot_26_8_T + $tot_27_8_T + $tot_28_8_T
           + $tot_29_8_T + $tot_30_8_T + $tot_35_8_T + $tot_40_8_T ;

$tot_G_T_T = $tot_G_1_T + $tot_G_2_T + $tot_G_3_T + $tot_G_4_T + $tot_G_5_T + $tot_G_6_T + $tot_G_7_T + $tot_G_8_T;
//-----------------------------------------------------------------------------------------------------------------------//
//----------------ALUMNOS INSCRITOS POR EDAD Y GRADO DE AVANCE-----------//
//-----------------------------------------------------------------------------------------------------------PUERTO ESCONDIDO
  //---------------------------------- <18---------------------------------//
$tot_m_18_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_m_18_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_m_18_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_m_18_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_m_18_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_m_18_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_m_18_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_m_18_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '<', '18'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_m_18_T_P = $tot_m_18_1_P +
                $tot_m_18_2_P +
                $tot_m_18_3_P +
                $tot_m_18_4_P +
                $tot_m_18_5_P +
                $tot_m_18_6_P +
                $tot_m_18_7_P +
                $tot_m_18_8_P ;

//---------------------------------- 18---------------------------------//
$tot_18_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_18_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_18_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_18_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_18_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_18_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_18_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_18_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '18'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_18_T_P = $tot_18_1_P +
              $tot_18_2_P +
              $tot_18_3_P +
              $tot_18_4_P +
              $tot_18_5_P +
              $tot_18_6_P +
              $tot_18_7_P +
              $tot_18_8_P ;

//---------------------------------- 19---------------------------------//
$tot_19_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_19_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_19_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_19_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_19_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_19_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_19_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_19_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '19'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_19_T_P = $tot_19_1_P +
              $tot_19_2_P +
              $tot_19_3_P +
              $tot_19_4_P +
              $tot_19_5_P +
              $tot_19_6_P +
              $tot_19_7_P +
              $tot_19_8_P ;

//---------------------------------- 20---------------------------------//
$tot_20_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_20_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_20_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_20_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_20_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_20_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_20_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_20_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_20_T_P = $tot_20_1_P +
              $tot_20_2_P +
              $tot_20_3_P +
              $tot_20_4_P +
              $tot_20_5_P +
              $tot_20_6_P +
              $tot_20_7_P +
              $tot_20_8_P ;

//---------------------------------- 21---------------------------------//
$tot_21_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_21_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_21_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '20'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_21_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_21_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_21_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_21_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_21_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '21'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_21_T_P = $tot_21_1_P +
              $tot_21_2_P +
              $tot_21_3_P +
              $tot_21_4_P +
              $tot_21_5_P +
              $tot_21_6_P +
              $tot_21_7_P +
              $tot_21_8_P ;

//---------------------------------- 22---------------------------------//
$tot_22_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_22_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_22_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_22_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_22_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_22_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_22_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_22_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '22'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_22_T_P = $tot_22_1_P +
              $tot_22_2_P +
              $tot_22_3_P +
              $tot_22_4_P +
              $tot_22_5_P +
              $tot_22_6_P +
              $tot_22_7_P +
              $tot_22_8_P ;

//---------------------------------- 23---------------------------------//
$tot_23_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_23_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_23_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_23_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_23_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_23_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_23_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_23_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '23'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_23_T_P = $tot_23_1_P +
              $tot_23_2_P +
              $tot_23_3_P +
              $tot_23_4_P +
              $tot_23_5_P +
              $tot_23_6_P +
              $tot_23_7_P +
              $tot_23_8_P ;

//---------------------------------- 24---------------------------------//
$tot_24_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_24_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_24_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_24_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_24_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_24_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_24_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_24_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '24'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_24_T_P = $tot_24_1_P +
              $tot_24_2_P +
              $tot_24_3_P +
              $tot_24_4_P +
              $tot_24_5_P +
              $tot_24_6_P +
              $tot_24_7_P +
              $tot_24_8_P ;


//----------------------------------25---------------------------------//
$tot_25_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_25_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_25_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_25_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_25_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_25_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_25_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_25_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '25'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_25_T_P = $tot_25_1_P +
              $tot_25_2_P +
              $tot_25_3_P +
              $tot_25_4_P +
              $tot_25_5_P +
              $tot_25_6_P +
              $tot_25_7_P +
              $tot_25_8_P ;


//---------------------------------- 26---------------------------------//
$tot_26_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_26_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_26_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_26_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_26_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_26_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_26_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_26_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '26'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_26_T_P = $tot_26_1_P +
              $tot_26_2_P +
              $tot_26_3_P +
              $tot_26_4_P +
              $tot_26_5_P +
              $tot_26_6_P +
              $tot_26_7_P +
              $tot_26_8_P ;


//----------------------------------27---------------------------------//
$tot_27_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_27_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_27_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_27_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_27_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_27_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_27_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_27_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '27'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_27_T_P = $tot_27_1_P +
              $tot_27_2_P +
              $tot_27_3_P +
              $tot_27_4_P +
              $tot_27_5_P +
              $tot_27_6_P +
              $tot_27_7_P +
              $tot_27_8_P ;


//---------------------------------- 28---------------------------------//
$tot_28_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_28_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_28_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_28_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_28_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_28_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_28_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_28_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '28'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_28_T_P = $tot_28_1_P +
              $tot_28_2_P +
              $tot_28_3_P +
              $tot_28_4_P +
              $tot_28_5_P +
              $tot_28_6_P +
              $tot_28_7_P +
              $tot_28_8_P ;


//---------------------------------- 29---------------------------------//
$tot_29_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_29_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_29_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_29_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_29_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_29_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_29_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_29_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '=', '29'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_29_T_P = $tot_29_1_P +
              $tot_29_2_P +
              $tot_29_3_P +
              $tot_29_4_P +
              $tot_29_5_P +
              $tot_29_6_P +
              $tot_29_7_P +
              $tot_29_8_P ;


//----------------------------------30-34--------------------------------//
$tot_30_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_30_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_30_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_30_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_30_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_30_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_30_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_30_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '30', 'AND', '34'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_30_T_P = $tot_30_1_P +
              $tot_30_2_P +
              $tot_30_3_P +
              $tot_30_4_P +
              $tot_30_5_P +
              $tot_30_6_P +
              $tot_30_7_P +
              $tot_30_8_P ;


//----------------------------------35-40--------------------------------//
$tot_35_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_35_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_35_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_35_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_35_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_35_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_35_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_35_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', 'BETWEEN', '35', 'AND', '39'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_35_T_P = $tot_35_1_P +
              $tot_35_2_P +
              $tot_35_3_P +
              $tot_35_4_P +
              $tot_35_5_P +
              $tot_35_6_P +
              $tot_35_7_P +
              $tot_35_8_P ;

//---------------------------------->=40--------------------------------//
$tot_40_1_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','1'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_40_2_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','2'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_40_3_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','3'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_40_4_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','4'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_40_5_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','5'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_40_6_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','6'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_40_7_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','7'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO']])
  ->count();

$tot_40_8_P = DB::table('personas')
  ->join('estudiantes', 'estudiantes.id_persona', '=' , 'personas.id_persona')
  ->where([['personas.edad', '>=', '40'],
           ['estudiantes.semestre','=','8'],
           ['estudiantes.modalidad', '=', 'ESCOLARIZADA'],
           ['estudiantes.sede','=','PUERTO ESCONDIDO'],
           ['estudiantes.egresado','=','0']])
  ->count();

$tot_40_T_P = $tot_40_1_P +
              $tot_40_2_P +
              $tot_40_3_P +
              $tot_40_4_P +
              $tot_40_5_P +
              $tot_40_6_P +
              $tot_40_7_P +
              $tot_40_8_P ;


//---------------------------TOTALES
$tot_G_1_P = $tot_m_18_1_P + $tot_18_1_P + $tot_19_1_P + $tot_20_1_P + $tot_21_1_P + $tot_22_1_P
           + $tot_23_1_P + $tot_24_1_P + $tot_25_1_P + $tot_26_1_P + $tot_27_1_P + $tot_28_1_P
           + $tot_29_1_P + $tot_30_1_P + $tot_35_1_P + $tot_40_1_P ;

$tot_G_2_P = $tot_m_18_2_P + $tot_18_2_P + $tot_19_2_P + $tot_20_2_P + $tot_21_2_P + $tot_22_2_P
           + $tot_23_2_P + $tot_24_2_P + $tot_25_2_P + $tot_26_2_P + $tot_27_2_P + $tot_28_2_P
           + $tot_29_2_P + $tot_30_2_P + $tot_35_2_P + $tot_40_2_P ;

$tot_G_3_P = $tot_m_18_3_P + $tot_18_3_P + $tot_19_3_P + $tot_20_3_P + $tot_21_3_P + $tot_22_3_P
           + $tot_23_3_P + $tot_24_3_P + $tot_25_3_P + $tot_26_3_P + $tot_27_3_P + $tot_28_3_P
           + $tot_29_3 + $tot_30_3 + $tot_35_3 + $tot_40_3 ;

$tot_G_4_P = $tot_m_18_4_P + $tot_18_4_P + $tot_19_4_P + $tot_20_4_P + $tot_21_4_P + $tot_22_4_P
           + $tot_23_4_P + $tot_24_4_P + $tot_25_4_P + $tot_26_4_P + $tot_27_4_P + $tot_28_4_P
           + $tot_29_4_P + $tot_30_4_P + $tot_35_4_P + $tot_40_4_P ;

$tot_G_5_P = $tot_m_18_5_P + $tot_18_5_P + $tot_19_5_P + $tot_20_5_P + $tot_21_5_P + $tot_22_5_P
           + $tot_23_5_P + $tot_24_5_P + $tot_25_5_P + $tot_26_5_P + $tot_27_5_P + $tot_28_5_P
           + $tot_29_5_P + $tot_30_5_P + $tot_35_5_P + $tot_40_5_P ;

$tot_G_6_P = $tot_m_18_6_P + $tot_18_6_P + $tot_19_6_P + $tot_20_6_P + $tot_21_6_P + $tot_22_6_P
           + $tot_23_6_P + $tot_24_6_P + $tot_25_6_P + $tot_26_6_P + $tot_27_6_P + $tot_28_6_P
           + $tot_29_6_P + $tot_30_6_P + $tot_35_6_P + $tot_40_6_P ;

$tot_G_7_P = $tot_m_18_7_P + $tot_18_7_P + $tot_19_7_P + $tot_20_7_P + $tot_21_7_P + $tot_22_7_P
           + $tot_23_7_P + $tot_24_7_P + $tot_25_7_P + $tot_26_7_P + $tot_27_7_P + $tot_28_7_P
           + $tot_29_7_P + $tot_30_7_P + $tot_35_7_P + $tot_40_7_P ;

$tot_G_8_P = $tot_m_18_8_P + $tot_18_8_P + $tot_19_8_P + $tot_20_8_P + $tot_21_8_P + $tot_22_8_P
           + $tot_23_8_P + $tot_24_8_P + $tot_25_8_P + $tot_26_8_P + $tot_27_8_P + $tot_28_8_P
           + $tot_29_8_P + $tot_30_8_P + $tot_35_8_P + $tot_40_8_P ;

$tot_G_T_P = $tot_G_1_P + $tot_G_2_P + $tot_G_3_P + $tot_G_4_P + $tot_G_5_P + $tot_G_6_P + $tot_G_7_P + $tot_G_8_P;
//-----------------------------------------------------------------------------------------------------------------------//
 //----------------ALUMNOS INSCRITOS POR EDAD Y GRADO DE AVANCE-----------//
  //CU SEMI
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
//-----------------------------------------------------------------------------------------------------------------------//

return view ('personal_administrativo/planeacion/reportes/reporte911_9A.reporte911_9A_4')
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

//----------------------------------------------------------------------------TEHUANTEPEC
//-------------------------------------CU
//------------------<18
->with('tot_m_18_1_T', $tot_m_18_1_T)
->with('tot_m_18_2_T', $tot_m_18_2_T)
->with('tot_m_18_3_T', $tot_m_18_3_T)
->with('tot_m_18_4_T', $tot_m_18_4_T)
->with('tot_m_18_5_T', $tot_m_18_5_T)
->with('tot_m_18_6_T', $tot_m_18_6_T)
->with('tot_m_18_7_T', $tot_m_18_7_T)
->with('tot_m_18_8_T', $tot_m_18_8_T)
->with('tot_m_18_T_T', $tot_m_18_T_T)
//------------------18
->with('tot_18_1_T', $tot_18_1_T)
->with('tot_18_2_T', $tot_18_2_T)
->with('tot_18_3_T', $tot_18_3_T)
->with('tot_18_4_T', $tot_18_4_T)
->with('tot_18_5_T', $tot_18_5_T)
->with('tot_18_6_T', $tot_18_6_T)
->with('tot_18_7_T', $tot_18_7_T)
->with('tot_18_8_T', $tot_18_8_T)
->with('tot_18_T_T', $tot_18_T_T)

//------------------19
->with('tot_19_1_T', $tot_19_1_T)
->with('tot_19_2_T', $tot_19_2_T)
->with('tot_19_3_T', $tot_19_3_T)
->with('tot_19_4_T', $tot_19_4_T)
->with('tot_19_5_T', $tot_19_5_T)
->with('tot_19_6_T', $tot_19_6_T)
->with('tot_19_7_T', $tot_19_7_T)
->with('tot_19_8_T', $tot_19_8_T)
->with('tot_19_T_T', $tot_19_T_T)

//------------------20
->with('tot_20_1_T', $tot_20_1_T)
->with('tot_20_2_T', $tot_20_2_T)
->with('tot_20_3_T', $tot_20_3_T)
->with('tot_20_4_T', $tot_20_4_T)
->with('tot_20_5_T', $tot_20_5_T)
->with('tot_20_6_T', $tot_20_6_T)
->with('tot_20_7_T', $tot_20_7_T)
->with('tot_20_8_T', $tot_20_8_T)
->with('tot_20_T_T', $tot_20_T_T)

//------------------21
->with('tot_21_1_T', $tot_21_1_T)
->with('tot_21_2_T', $tot_21_2_T)
->with('tot_21_3_T', $tot_21_3_T)
->with('tot_21_4_T', $tot_21_4_T)
->with('tot_21_5_T', $tot_21_5_T)
->with('tot_21_6_T', $tot_21_6_T)
->with('tot_21_7_T', $tot_21_7_T)
->with('tot_21_8_T', $tot_21_8_T)
->with('tot_21_T_T', $tot_21_T_T)

//------------------22
->with('tot_22_1_T', $tot_22_1_T)
->with('tot_22_2_T', $tot_22_2_T)
->with('tot_22_3_T', $tot_22_3_T)
->with('tot_22_4_T', $tot_22_4_T)
->with('tot_22_5_T', $tot_22_5_T)
->with('tot_22_6_T', $tot_22_6_T)
->with('tot_22_7_T', $tot_22_7_T)
->with('tot_22_8_T', $tot_22_8_T)
->with('tot_22_T_T', $tot_22_T_T)

//------------------23
->with('tot_23_1_T', $tot_23_1_T)
->with('tot_23_2_T', $tot_23_2_T)
->with('tot_23_3_T', $tot_23_3_T)
->with('tot_23_4_T', $tot_23_4_T)
->with('tot_23_5_T', $tot_23_5_T)
->with('tot_23_6_T', $tot_23_6_T)
->with('tot_23_7_T', $tot_23_7_T)
->with('tot_23_8_T', $tot_23_8_T)
->with('tot_23_T_T', $tot_23_T_T)

//------------------24
->with('tot_24_1_T', $tot_24_1_T)
->with('tot_24_2_T', $tot_24_2_T)
->with('tot_24_3_T', $tot_24_3_T)
->with('tot_24_4_T', $tot_24_4_T)
->with('tot_24_5_T', $tot_24_5_T)
->with('tot_24_6_T', $tot_24_6_T)
->with('tot_24_7_T', $tot_24_7_T)
->with('tot_24_8_T', $tot_24_8_T)
->with('tot_24_T_T', $tot_24_T_T)

//------------------25
->with('tot_25_1_T', $tot_25_1_T)
->with('tot_25_2_T', $tot_25_2_T)
->with('tot_25_3_T', $tot_25_3_T)
->with('tot_25_4_T', $tot_25_4_T)
->with('tot_25_5_T', $tot_25_5_T)
->with('tot_25_6_T', $tot_25_6_T)
->with('tot_25_7_T', $tot_25_7_T)
->with('tot_25_8_T', $tot_25_8_T)
->with('tot_25_T_T', $tot_25_T_T)

//------------------26
->with('tot_26_1_T', $tot_26_1_T)
->with('tot_26_2_T', $tot_26_2_T)
->with('tot_26_3_T', $tot_26_3_T)
->with('tot_26_4_T', $tot_26_4_T)
->with('tot_26_5_T', $tot_26_5_T)
->with('tot_26_6_T', $tot_26_6_T)
->with('tot_26_7_T', $tot_26_7_T)
->with('tot_26_8_T', $tot_26_8_T)
->with('tot_26_T_T', $tot_26_T_T)

//------------------27
->with('tot_27_1_T', $tot_27_1_T)
->with('tot_27_2_T', $tot_27_2_T)
->with('tot_27_3_T', $tot_27_3_T)
->with('tot_27_4_T', $tot_27_4_T)
->with('tot_27_5_T', $tot_27_5_T)
->with('tot_27_6_T', $tot_27_6_T)
->with('tot_27_7_T', $tot_27_7_T)
->with('tot_27_8_T', $tot_27_8_T)
->with('tot_27_T_T', $tot_27_T_T)

//------------------28
->with('tot_28_1_T', $tot_28_1_T)
->with('tot_28_2_T', $tot_28_2_T)
->with('tot_28_3_T', $tot_28_3_T)
->with('tot_28_4_T', $tot_28_4_T)
->with('tot_28_5_T', $tot_28_5_T)
->with('tot_28_6_T', $tot_28_6_T)
->with('tot_28_7_T', $tot_28_7_T)
->with('tot_28_8_T', $tot_28_8_T)
->with('tot_28_T_T', $tot_28_T_T)

//------------------29
->with('tot_29_1_T', $tot_29_1_T)
->with('tot_29_2_T', $tot_29_2_T)
->with('tot_29_3_T', $tot_29_3_T)
->with('tot_29_4_T', $tot_29_4_T)
->with('tot_29_5_T', $tot_29_5_T)
->with('tot_29_6_T', $tot_29_6_T)
->with('tot_29_7_T', $tot_29_7_T)
->with('tot_29_8_T', $tot_29_8_T)
->with('tot_29_T_T', $tot_29_T_T)

//------------------30 - 34
->with('tot_30_1_T', $tot_30_1_T)
->with('tot_30_2_T', $tot_30_2_T)
->with('tot_30_3_T', $tot_30_3_T)
->with('tot_30_4_T', $tot_30_4_T)
->with('tot_30_5_T', $tot_30_5_T)
->with('tot_30_6_T', $tot_30_6_T)
->with('tot_30_7_T', $tot_30_7_T)
->with('tot_30_8_T', $tot_30_8_T)
->with('tot_30_T_T', $tot_30_T_T)

//------------------35 - 39
->with('tot_35_1_T', $tot_35_1_T)
->with('tot_35_2_T', $tot_35_2_T)
->with('tot_35_3_T', $tot_35_3_T)
->with('tot_35_4_T', $tot_35_4_T)
->with('tot_35_5_T', $tot_35_5_T)
->with('tot_35_6_T', $tot_35_6_T)
->with('tot_35_7_T', $tot_35_7_T)
->with('tot_35_8_T', $tot_35_8_T)
->with('tot_35_T_T', $tot_35_T_T)

//---------------->=40
->with('tot_40_1_T', $tot_40_1_T)
->with('tot_40_2_T', $tot_40_2_T)
->with('tot_40_3_T', $tot_40_3_T)
->with('tot_40_4_T', $tot_40_4_T)
->with('tot_40_5_T', $tot_40_5_T)
->with('tot_40_6_T', $tot_40_6_T)
->with('tot_40_7_T', $tot_40_7_T)
->with('tot_40_8_T', $tot_40_8_T)
->with('tot_40_T_T', $tot_40_T_T)

//-----------------------------------TOTALES
->with('tot_G_1_T', $tot_G_1_T)
->with('tot_G_2_T', $tot_G_2_T)
->with('tot_G_3_T', $tot_G_3_T)
->with('tot_G_4_T', $tot_G_4_T)
->with('tot_G_5_T', $tot_G_5_T)
->with('tot_G_6_T', $tot_G_6_T)
->with('tot_G_7_T', $tot_G_7_T)
->with('tot_G_8_T', $tot_G_8_T)
->with('tot_G_T_T', $tot_G_T_T)

//----------------------------------------------------------------------------PUERTO ESCONDIDO
//------------------<18
->with('tot_m_18_1_P', $tot_m_18_1_P)
->with('tot_m_18_2_P', $tot_m_18_2_P)
->with('tot_m_18_3_P', $tot_m_18_3_P)
->with('tot_m_18_4_P', $tot_m_18_4_P)
->with('tot_m_18_5_P', $tot_m_18_5_P)
->with('tot_m_18_6_P', $tot_m_18_6_P)
->with('tot_m_18_7_P', $tot_m_18_7_P)
->with('tot_m_18_8_P', $tot_m_18_8_P)
->with('tot_m_18_T_P', $tot_m_18_T_P)
//------------------18
->with('tot_18_1_P', $tot_18_1_P)
->with('tot_18_2_P', $tot_18_2_P)
->with('tot_18_3_P', $tot_18_3_P)
->with('tot_18_4_P', $tot_18_4_P)
->with('tot_18_5_P', $tot_18_5_P)
->with('tot_18_6_P', $tot_18_6_P)
->with('tot_18_7_P', $tot_18_7_P)
->with('tot_18_8_P', $tot_18_8_P)
->with('tot_18_T_P', $tot_18_T_P)

//------------------19
->with('tot_19_1_P', $tot_19_1_P)
->with('tot_19_2_P', $tot_19_2_P)
->with('tot_19_3_P', $tot_19_3_P)
->with('tot_19_4_P', $tot_19_4_P)
->with('tot_19_5_P', $tot_19_5_P)
->with('tot_19_6_P', $tot_19_6_P)
->with('tot_19_7_P', $tot_19_7_P)
->with('tot_19_8_P', $tot_19_8_P)
->with('tot_19_T_P', $tot_19_T_P)

//------------------20
->with('tot_20_1_P', $tot_20_1_P)
->with('tot_20_2_P', $tot_20_2_P)
->with('tot_20_3_P', $tot_20_3_P)
->with('tot_20_4_P', $tot_20_4_P)
->with('tot_20_5_P', $tot_20_5_P)
->with('tot_20_6_P', $tot_20_6_P)
->with('tot_20_7_P', $tot_20_7_P)
->with('tot_20_8_P', $tot_20_8_P)
->with('tot_20_T_P', $tot_20_T_P)

//------------------21
->with('tot_21_1_P', $tot_21_1_P)
->with('tot_21_2_P', $tot_21_2_P)
->with('tot_21_3_P', $tot_21_3_P)
->with('tot_21_4_P', $tot_21_4_P)
->with('tot_21_5_P', $tot_21_5_P)
->with('tot_21_6_P', $tot_21_6_P)
->with('tot_21_7_P', $tot_21_7_P)
->with('tot_21_8_P', $tot_21_8_P)
->with('tot_21_T_P', $tot_21_T_P)

//------------------22
->with('tot_22_1_P', $tot_22_1_P)
->with('tot_22_2_P', $tot_22_2_P)
->with('tot_22_3_P', $tot_22_3_P)
->with('tot_22_4_P', $tot_22_4_P)
->with('tot_22_5_P', $tot_22_5_P)
->with('tot_22_6_P', $tot_22_6_P)
->with('tot_22_7_P', $tot_22_7_P)
->with('tot_22_8_P', $tot_22_8_P)
->with('tot_22_T_P', $tot_22_T_P)

//------------------23
->with('tot_23_1_P', $tot_23_1_P)
->with('tot_23_2_P', $tot_23_2_P)
->with('tot_23_3_P', $tot_23_3_P)
->with('tot_23_4_P', $tot_23_4_P)
->with('tot_23_5_P', $tot_23_5_P)
->with('tot_23_6_P', $tot_23_6_P)
->with('tot_23_7_P', $tot_23_7_P)
->with('tot_23_8_P', $tot_23_8_P)
->with('tot_23_T_P', $tot_23_T_P)

//------------------24
->with('tot_24_1_P', $tot_24_1_P)
->with('tot_24_2_P', $tot_24_2_P)
->with('tot_24_3_P', $tot_24_3_P)
->with('tot_24_4_P', $tot_24_4_P)
->with('tot_24_5_P', $tot_24_5_P)
->with('tot_24_6_P', $tot_24_6_P)
->with('tot_24_7_P', $tot_24_7_P)
->with('tot_24_8_P', $tot_24_8_P)
->with('tot_24_T_P', $tot_24_T_P)

//------------------25
->with('tot_25_1_P', $tot_25_1_P)
->with('tot_25_2_P', $tot_25_2_P)
->with('tot_25_3_P', $tot_25_3_P)
->with('tot_25_4_P', $tot_25_4_P)
->with('tot_25_5_P', $tot_25_5_P)
->with('tot_25_6_P', $tot_25_6_P)
->with('tot_25_7_P', $tot_25_7_P)
->with('tot_25_8_P', $tot_25_8_P)
->with('tot_25_T_P', $tot_25_T_P)

//------------------26
->with('tot_26_1_P', $tot_26_1_P)
->with('tot_26_2_P', $tot_26_2_P)
->with('tot_26_3_P', $tot_26_3_P)
->with('tot_26_4_P', $tot_26_4_P)
->with('tot_26_5_P', $tot_26_5_P)
->with('tot_26_6_P', $tot_26_6_P)
->with('tot_26_7_P', $tot_26_7_P)
->with('tot_26_8_P', $tot_26_8_P)
->with('tot_26_T_P', $tot_26_T_P)

//------------------27
->with('tot_27_1_P', $tot_27_1_P)
->with('tot_27_2_P', $tot_27_2_P)
->with('tot_27_3_P', $tot_27_3_P)
->with('tot_27_4_P', $tot_27_4_P)
->with('tot_27_5_P', $tot_27_5_P)
->with('tot_27_6_P', $tot_27_6_P)
->with('tot_27_7_P', $tot_27_7_P)
->with('tot_27_8_P', $tot_27_8_P)
->with('tot_27_T_P', $tot_27_T_P)

//------------------28
->with('tot_28_1_P', $tot_28_1_P)
->with('tot_28_2_P', $tot_28_2_P)
->with('tot_28_3_P', $tot_28_3_P)
->with('tot_28_4_P', $tot_28_4_P)
->with('tot_28_5_P', $tot_28_5_P)
->with('tot_28_6_P', $tot_28_6_P)
->with('tot_28_7_P', $tot_28_7_P)
->with('tot_28_8_P', $tot_28_8_P)
->with('tot_28_T_P', $tot_28_T_P)

//------------------29
->with('tot_29_1_P', $tot_29_1_P)
->with('tot_29_2_P', $tot_29_2_P)
->with('tot_29_3_P', $tot_29_3_P)
->with('tot_29_4_P', $tot_29_4_P)
->with('tot_29_5_P', $tot_29_5_P)
->with('tot_29_6_P', $tot_29_6_P)
->with('tot_29_7_P', $tot_29_7_P)
->with('tot_29_8_P', $tot_29_8_P)
->with('tot_29_T_P', $tot_29_T_P)

//------------------30 - 34
->with('tot_30_1_P', $tot_30_1_P)
->with('tot_30_2_P', $tot_30_2_P)
->with('tot_30_3_P', $tot_30_3_P)
->with('tot_30_4_P', $tot_30_4_P)
->with('tot_30_5_P', $tot_30_5_P)
->with('tot_30_6_P', $tot_30_6_P)
->with('tot_30_7_P', $tot_30_7_P)
->with('tot_30_8_P', $tot_30_8_P)
->with('tot_30_T_P', $tot_30_T_P)

//------------------35 - 39
->with('tot_35_1_P', $tot_35_1_P)
->with('tot_35_2_P', $tot_35_2_P)
->with('tot_35_3_P', $tot_35_3_P)
->with('tot_35_4_P', $tot_35_4_P)
->with('tot_35_5_P', $tot_35_5_P)
->with('tot_35_6_P', $tot_35_6_P)
->with('tot_35_7_P', $tot_35_7_P)
->with('tot_35_8_P', $tot_35_8_P)
->with('tot_35_T_P', $tot_35_T_P)

//---------------->=40
->with('tot_40_1_P', $tot_40_1_P)
->with('tot_40_2_P', $tot_40_2_P)
->with('tot_40_3_P', $tot_40_3_P)
->with('tot_40_4_P', $tot_40_4_P)
->with('tot_40_5_P', $tot_40_5_P)
->with('tot_40_6_P', $tot_40_6_P)
->with('tot_40_7_P', $tot_40_7_P)
->with('tot_40_8_P', $tot_40_8_P)
->with('tot_40_T_P', $tot_40_T_P)

//-----------------------------------TOTALES
->with('tot_G_1_P', $tot_G_1_P)
->with('tot_G_2_P', $tot_G_2_P)
->with('tot_G_3_P', $tot_G_3_P)
->with('tot_G_4_P', $tot_G_4_P)
->with('tot_G_5_P', $tot_G_5_P)
->with('tot_G_6_P', $tot_G_6_P)
->with('tot_G_7_P', $tot_G_7_P)
->with('tot_G_8_P', $tot_G_8_P)
->with('tot_G_T_P', $tot_G_T_P)
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
public function reporte911_9A_5(){

  return view ('personal_administrativo/planeacion/reportes/reporte911_9A.reporte911_9A_5');
}

public function reporte911_9A_6(){
  return view ('personal_administrativo/planeacion/reportes/reporte911_9A.reporte911_9A_6');
}
/*Servicio Social y Practicas Profesionales*/
public function info_practicasp(){

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
//--------------SERVICIO SOCIAL

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



return view ('personal_administrativo/planeacion/info_departamentos.info_practicasp')
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
public function info_serviciosocial(){
//----ESTUDIANTES QUE REALIZAN PRACTICAS PROFESIONALES
//---MODALIDAD ESCOLARIZADA
//MASCULINO


  return view ('personal_administrativo/planeacion/info_departamentos.info_serviciosocial')



  ;
}



}
