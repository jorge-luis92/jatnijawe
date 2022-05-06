<?php

namespace App\Http\Controllers;
use App\User;
use App\Estudiante;
use App\Persona;
use App\Lengua;
use App\Beca;
use App\Telefono;
use App\Datos_emergencia;
use App\Discapacidad;
use App\Egresado;
use App\Enfermedad_Alergia;
use App\Titulo;
use App\AntecedenteLaboral;
use App\Cuestionario;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SeguimientoEgresadosController extends Controller
{

public function home_seguimiento_egresados()
{
return view('seguimiento_egresadosP.home_seguimiento_egresados');
}

public function generales_egresado()
{
  $usuario_actuales=\Auth::user();
   if($usuario_actuales->tipo_usuario!='estudiante'){
     return redirect()->back();
    }
  $usuario_actual=auth()->user();
  $id=$usuario_actual->id_user;
  $egresado_si = DB::table('estudiantes')
  ->select('estudiantes.egresado')
  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
  ->where('estudiantes.matricula',$id)
  ->take(1)
  ->first();
   $e= $egresado_si->egresado;
  if($e == 1){
  $users = DB::table('estudiantes')
  ->select('estudiantes.matricula', 'estudiantes.bachillerato_origen', 'estudiantes.semestre', 'estudiantes.modalidad', 'estudiantes.estatus', 'estudiantes.grupo',
           'personas.nombre', 'personas.apellido_paterno', 'personas.edad',  'personas.apellido_materno', 'personas.fecha_nacimiento',
           'personas.curp', 'personas.genero')
  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
  ->where('estudiantes.matricula',$id)
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
if(empty($num_cel) || empty($num_emergencia)){
  return redirect()->route('home_estudiante')->with('error','¡Actualización de datos requerida!');
}
else {
return view('seguimiento_egresadosP.generales_egresado')
->with('u', $users)->with('l', $lenguas_r)->with('ea', $enf_ale)->with('nl',$num_local)
->with('nc',$num_cel)->with('ne',$num_emergencia)->with('pro', $datos_pro);
}
}
  return redirect()->route('home_estudiante')->with('error','¡Opción del menú no habilitada, Aún no eres un egresado!');
}

public function generales_egresado_actualizar(Request $request)
{
  $usuario_actuales=\Auth::user();
   if($usuario_actuales->tipo_usuario!='estudiante'){
     return redirect()->back();
    }
  $usuario_actual=auth()->user();
  $id=$usuario_actual->id_user;
  $data= $request;

  $egresado_si = DB::table('egresados')
  ->select('egresados.matricula')
  ->where('egresados.matricula',$id)
  ->take(1)
  ->first();

  $id_clave = DB::table('escuelas')
  ->select('escuelas.clave_institucion')
  ->take(1)
  ->first();
  $id_clave = $id_clave->clave_institucion;

  $id_p = DB::table('periodos')
  ->select('periodos.id_periodo')
  ->where('periodos.estatus', '=', 'actual')
  ->take(1)
  ->first();

  $id_p= $id_p->id_periodo;
//$id_clave= json_decode( json_encode($id_clave), true);
if(empty($egresado_si)){
  $egresado=new Egresado;
  $egresado->matricula=$id;
  $egresado->clave_institucion=$id_clave;
  $egresado->generacion=$data['generacion'];
  $egresado->promedio_final=$data['promedio_final'];
  $egresado->periodo=$id_p;
  $egresado->save();

  if($egresado->save()){
  return redirect()->route('generales_egresado')->with('success','¡Datos Actualizados Correctamente!');
  }
}
  return redirect()->route('generales_egresado')->with('error','¡Los datos ya están actualizados!');

}

public function cuestionario_egresado()
{
  $usuario_actuales=\Auth::user();
   if($usuario_actuales->tipo_usuario!='estudiante'){
     return redirect()->back();
    }

  $usuario_actual=auth()->user();
  $id=$usuario_actual->id_user;
  $egresado_si = DB::table('estudiantes')
  ->select('estudiantes.egresado')
  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
  ->where('estudiantes.matricula',$id)
  ->take(1)
  ->first();
   $e= $egresado_si->egresado;
  if($e == 1){
    $egresado_si = DB::table('egresados')
    ->select('egresados.id_egresado')
    ->where('egresados.matricula',$id)
    ->take(1)
    ->first();
    //$egresado_si = $egresado_si->id_egresado;
    if(empty($egresado_si)){
      return redirect()->route('generales_egresado')->with('error','¡Para contestar el cuestionario debes actualizar tus datos!');
    }
    else {
      $egresado_si= json_decode( json_encode($egresado_si), true);
    $datos_titulo = DB::table('titulos')
    ->select('titulos.fecha_expedicion', 'titulos.modalidad_tit', 'titulos.motivos_notitulado')
    ->where('titulos.id_egresado',$egresado_si)
    ->take(1)
    ->first();

    $datos_cuestionario = DB::table('cuestionarios')
    ->select('cuestionarios.razon_carrera', 'cuestionarios.posgrado', 'cuestionarios.otros_estudios', 'cuestionarios.la_misma')
    ->where('cuestionarios.id_egresado',$egresado_si)
    ->take(1)
    ->first();

return view('seguimiento_egresadosP.cuestionario_egresado')
->with('titulo_e', $datos_titulo)->with('cuestionario_e', $datos_cuestionario);
}
}
return redirect()->route('home_estudiante')->with('error','¡Opción del menú no habilitada, Aún no eres un egresado!');
}

protected function cuestionario_egresado_actualizar(Request $request){
  $data = $request;
  $usuario_actual=auth()->user();
  $id=$usuario_actual->id_user;

$egresado_si = DB::table('egresados')
->select('egresados.id_egresado')
->where('egresados.matricula',$id)
->take(1)
->first();
$egresado_si = $egresado_si->id_egresado;
  //$egresado_si= json_decode( json_encode($egresado_si), true);
$titulo_si = DB::table('titulos')
->select('titulos.id_titulo')
->where('titulos.id_egresado',$egresado_si)
->take(1)
->first();

$titulo_si = DB::table('cuestionarios')
->select('cuestionarios.id_cuestionario')
->where('cuestionarios.id_egresado',$egresado_si)
->take(1)
->first();

$id_p = DB::table('periodos')
->select('periodos.id_periodo')
->where('periodos.estatus', '=', 'actual')
->take(1)
->first();
$id_p= $id_p->id_periodo;
//  $id_p= json_decode( json_encode($id_p), true);
if(empty($titulo_si)){
  $titulo = new Titulo;
  $titulo->bandera_titulo=$data['bandera_titulo'];
  $titulo->fecha_expedicion=$data['fecha_expedicion'];
  $titulo->modalidad_tit=$data['modalidad_tit'];
  $titulo->motivos_notitulado=$data['motivos_notitulado'];
  $titulo->id_egresado=$egresado_si;
  $titulo->save();
  if($titulo->save()){
 $cuestionario = new Cuestionario;
 $cuestionario->razon_carrera=$data['razon_carrera'];
 $cuestionario->bandera_posgrado=$data['bandera_posgrado'];
 $cuestionario->posgrado=$data['posgrado'];
 $cuestionario->otros_estudios=$data['otros_estudios'];
 $cuestionario->grado_satisfaccion=$data['grado_satisfaccion'];
 $cuestionario->bandera_lamisma=$data['bandera_lamisma'];
 $cuestionario->la_misma=$data['la_misma'];
 $cuestionario->id_egresado=$egresado_si;
 $cuestionario->periodo=$id_p;;
 $cuestionario->save();

 if($cuestionario->save()){
   return redirect()->route('cuestionario_egresado')->with('success','¡Datos Registrados Correctamente');
 }
  }
}
else {
  $bandera_titulo = DB::table('titulos')
  ->select('titulos.bandera_titulo')
  ->where('titulos.id_egresado', $egresado_si)
  ->take(1)
  ->first();
  $bandera_titulo= $bandera_titulo->bandera_titulo;
  if($bandera_titulo == 0){
    DB::table('titulos')
        ->where('titulos.id_egresado', $egresado_si)
        ->update(['bandera_titulo' => '1', 'fecha_expedicion' => $data['fecha_expedicion'],
        'modalidad_tit' => $data['modalidad_tit'], 'motivos_notitulado' => '']);
  }
  DB::table('cuestionarios')
      ->where('cuestionarios.id_egresado', $egresado_si)
      ->update(['razon_carrera' => $data['razon_carrera'], 'bandera_posgrado' => $data['bandera_posgrado'],
                'posgrado' => $data['posgrado'], 'otros_estudios' => $data['otros_estudios'],
                'grado_satisfaccion' => $data['grado_satisfaccion'], 'bandera_lamisma' => $data['bandera_lamisma'],
                'la_misma' => $data['la_misma']]);
      return redirect()->route('cuestionario_egresado')->with('success','¡Datos Actualizados Correctamente!');
}
}


public function antecedentes_laborales()
{
  $usuario_actuales=\Auth::user();
   if($usuario_actuales->tipo_usuario!='estudiante'){
     return redirect()->back();
    }
  $usuario_actual=auth()->user();
  $id=$usuario_actual->id_user;
  $egresado_si = DB::table('estudiantes')
  ->select('estudiantes.egresado')
  ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
  ->where('estudiantes.matricula',$id)
  ->take(1)
  ->first();
   $e= $egresado_si->egresado;
  if($e == 1){
    $egresado_si = DB::table('egresados')
    ->select('egresados.id_egresado')
    ->where('egresados.matricula',$id)
    ->take(1)
    ->first();
    if(empty($egresado_si)){
      return redirect()->route('generales_egresado')->with('error','¡Para rellenar el cuestionario de datos debes actualizar tus datos!');
    }
    else {
    $egresado_si = $egresado_si->id_egresado;
  //    $egresado_si= json_decode( json_encode($egresado_si), true);
    $laboral = DB::table('antecedentes_laborales')
    ->select('antecedentes_laborales.lugar_labor_actual', 'antecedentes_laborales.funcion_labor_actual', 'antecedentes_laborales.ingreso_mensual',
    'antecedentes_laborales.antiguedad', 'antecedentes_laborales.trabajo_anterior', 'antecedentes_laborales.funcion_trabajo_anterior')
    ->where('antecedentes_laborales.id_egresado',$egresado_si)
    ->take(1)
    ->first();

  return view('seguimiento_egresadosP.antecedentes_laborales')->with('laborales', $laboral);
}
}
return redirect()->route('home_estudiante')->with('error','¡Opción del menú no habilitada, Aún no eres un egresado!');
}

protected function antecedentes_laborales_actualizar(Request $request){
  $usuario_actuales=\Auth::user();
   if($usuario_actuales->tipo_usuario!='estudiante'){
     return redirect()->back();
    }
  $usuario_actual=auth()->user();
  $id=$usuario_actual->id_user;
  $data= $request;

  $egresado_si = DB::table('egresados')
  ->select('egresados.id_egresado')
  ->where('egresados.matricula',$id)
  ->take(1)
  ->first();
  $egresado_si = $egresado_si->id_egresado;
  //$egresado_si= json_decode( json_encode($egresado_si), true);

  $laboral = DB::table('antecedentes_laborales')
  ->select('antecedentes_laborales.id_egresado')
  ->where('antecedentes_laborales.id_egresado',$egresado_si)
  ->take(1)
  ->first();

  $id_p = DB::table('periodos')
  ->select('periodos.id_periodo')
  ->where('periodos.estatus', '=', 'actual')
  ->take(1)
  ->first();

  $id_p= $id_p->id_periodo;

  if(empty($laboral)){
    $antecendente = new AntecedenteLaboral;
    $antecendente->bandera_laboractual = $data['bandera_laboractual'];
    $antecendente->lugar_labor_actual = $data['lugar_labor_actual'];
    $antecendente->funcion_labor_actual = $data['funcion_labor_actual'];
    $antecendente->bandera_coincidencia = $data['bandera_coincidencia'];
    $antecendente->ingreso_mensual = $data['ingreso_mensual'];
    $antecendente->antiguedad = $data['antiguedad'];
    $antecendente->trabajo_anterior = $data['trabajo_anterior'];
    $antecendente->funcion_trabajo_anterior = $data['funcion_trabajo_anterior'];
    $antecendente->id_egresado = $egresado_si;
    $antecendente->periodo=$id_p;
    $antecendente->save();

    if($antecendente->save()){
    return redirect()->route('antecedentes_laborales')->with('success','¡Datos Registrados Correctamente!');
    }
  }

  else {
    DB::table('antecedentes_laborales')
        ->where('antecedentes_laborales.id_egresado', $egresado_si)
        ->update(['bandera_laboractual' => $data['bandera_laboractual'], 'lugar_labor_actual' => $data['lugar_labor_actual'],
                  'funcion_labor_actual' => $data['funcion_labor_actual'], 'bandera_coincidencia' => $data['bandera_coincidencia'],
                  'ingreso_mensual' => $data['ingreso_mensual'], 'antiguedad' => $data['antiguedad'],
                  'trabajo_anterior' => $data['trabajo_anterior'], 'funcion_trabajo_anterior' => $data['funcion_trabajo_anterior']]);

        return redirect()->route('antecedentes_laborales')->with('success','¡Datos Actualizados Correctamente!');

  }

}
}
