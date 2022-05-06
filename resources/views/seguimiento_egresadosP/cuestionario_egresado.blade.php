<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_estudiante')
@section('title')
: Egresados
@endsection
@section('seccion')
<h1 style="font-size: 2.0em; color: #000000;" align="center">Cuestionario al Egresado</h1>
<div class="container" id="font7">
    @include('flash-message')
</br>
<form method="POST" action="{{ route('cuestionario_egresado_actu') }}">
                        @csrf

 <div class="form-row">
<div class="radio col-md-4" id="labels">
  <label>¿Títulado?</label>

 <input type="radio" id="si_titulo" name="titulo" value="1" onclick="sititulado(this.id)" required >
 <label for="si_titulo">Si</label>

 <input type="radio" id="no_titulo" name="titulo" value="0" onclick="notitulado(this.id)" required>
 <label for="no_titulo">No</label>

</div>

<div class="form-group col-md-4" id="labels">
  <label for="fecha_expedicion">Fecha de Expedición del título</label>
  <input type="date" name="fecha_expedicion" onchange="validarFechaMenorActual();" max="<?php echo date("Y-m-d");?>" value="<?php if(empty($titulo_e->fecha_expedicion)){ $vacio=null; echo $vacio;} else{ echo $titulo_e->fecha_expedicion;} ?>" class="form-control" id="fecha_expedicion" required disabled >
  <pre id="resultado"></pre>
</div>


  <div class="form-group col-md-4">
    <label for="modalidad_tit">Modalidad de Titulación: <?php if(empty($titulo_e->modalidad_tit)){ $vacio=null; echo $vacio;} else{ echo $titulo_e->modalidad_tit;}?></label>
      <select name="modalidad_tit" id="modalidad_tit"  required class="form-control" required disabled>
      <option value="">Seleccione una opción</option>
      <option value="TESIS">TESIS</option>
      <option value="PROMEDIO">PROMEDIO</option>
      <option value="CENEVAL">CENEVAL</option>
      <option value="EXPERIENCIA PROFESIONAL">EXPERIENCIA PROFESIONAL</option>
          </select>
</div>
</div>
</br>
<div class="form-row">
  <div class="form-group col-md-12">
  <label for="motivos_notitulado" >{{ __('En caso de no haberse titulado, ¿Cuales son los motivos de haber postergado la Titulación?') }}</label>
  <textarea id="motivos_notitulado" name="motivos_notitulado" type="text" disabled onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('motivos_notitulado') is-invalid @enderror"   autocomplete="motivos_notitulado" required><?php if(empty($titulo_e->motivos_notitulado)){$vacio=null; echo $vacio;}else{echo $titulo_e->motivos_notitulado;}?></textarea>
</div>
</div>

<div class="form-row">
  <div class="form-group col-md-12">
  <label for="razon_carrera" >{{ __('¿Cual es la razón de haber estudiado la Licenciatura?') }}</label>
  <textarea id="razon_carrera" type="text" onKeyUp="this.value = this.value.toUpperCase();" required class="form-control @error('razon_carrera') is-invalid @enderror"  name="razon_carrera" autocomplete="razon_carrera" ><?php if(empty($cuestionario_e->razon_carrera)){$vacio=null; echo $vacio;}else{echo $cuestionario_e->razon_carrera;}?></textarea>
    @error('razon_carrera')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
                              @enderror
</div>
</div>

<div class="form-row">
<div class="radio col-md-8" id="labels">
 <label>¿Has realizado o actualmente realizas estudios de Posgrado?</label>

<input type="radio" id="si_pos" name="bandera_posgrado" value="1" onclick="posgrado_si(this.id)" required >
<label for="si_titulo">Si</label>

<input type="radio" id="no_pos" name="bandera_posgrado" value="0" onclick="posgrado_no(this.id)" required>
<label for="no_titulo">No</label>
</div>
</div>

<div class="form-group col-md-4">
  <label for="posgrado">Específique</label>
    <select name="posgrado" id="posgrado" required class="form-control" disabled>
    <option value="">Seleccione una opción</option>
    <option value="DIPLOMADO">DIPLOMADO</option>
    <option value="MAESTRÍA">MAESTRÍA</option>
    <option value="DOCTORADO">DOCTORADO</option>

        </select>
</div>


<div class="form-row">
<div class="radio col-md-12" id="labels">
 <label>¿Has realizado o actualmente realizas otros estudios en un ámbito diferente al perfil?</label>

<input type="radio" id="si_estudio" name="otros_e"  onclick="si_otros(this.id)" required >
<label for="si_estudio">Si</label>

<input type="radio" id="no_estudio" name="otros_e"  onclick="no_otros(this.id)" required>
<label for="no_estudio">No</label>
</div>
</div>

<div class="form-row">
  <div class="form-group col-md-12">
  <label for="otros_estudios" >{{ __('Específique') }}</label>
  <input id="otros_estudios" disabled type="text"  name="otros_estudios" <?php if(empty($cuestionario_e->otros_estudios)){$vacio=null; echo $vacio;}else{echo $cuestionario_e->otros_estudios;}?> onKeyUp="this.value = this.value.toUpperCase();" class="form-control">
  </div>
</div>

<div class="form-row">
  <div class="form-group col-md-8">
    <label for="grado_satisfaccion">¿Cuál es el	Grado de satisfacción en cuanto a la formación recibida por la Licenciatura?</label>
      <select name="grado_satisfaccion" id="grado_satisfaccion" required class="form-control">
      <option value="">Seleccione una opción</option>
      <option value="EXCELENTE">EXCELENTE</option>
      <option value="BUENO">BUENO</option>
      <option value="REGULAR">REGULAR</option>
      <option value="MALO">MALO</option>
          </select>
</div>
</div>

<div class="form-row">
<div class="radio col-md-4" id="labels">
 <label>¿Elegirías la misma institución, para realizar algún estudio de Posgrado?</label>

<input type="radio" id="si_elegir" name="bandera_lamisma" value="1" onclick="elegir_si(this.id)" required >
<label for="si_elegir">Si</label>

<input type="radio" id="no_elegir" name="bandera_lamisma" value="0" onclick="elegir_no(this.id)" required>
<label for="no_elegir">No</label>

</div>

</div>

<div class="form-group col-md-12">
<label for="la_misma" >{{ __('¿Por qué?') }}</label>
<input id="la_misma" type="text" disabled onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('la_misma') is-invalid @enderror"  name="la_misma" value="<?php if(empty($cuestionario_e->la_misma)){$vacio=null; echo $vacio;}else{echo $cuestionario_e->la_misma;}?>" autocomplete="la_misma" >
  @error('la_misma')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
                            @enderror
</div>


                        <div class="form-group">
                            <div class="col-xs-offset-2 col-xs-9" align="center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                        </div>

                    </form>

                </div>

@endsection

<script language="JavaScript">
    function sititulado(id){
      // document.getElementById("nombre_lengua").removeAttr("disabled");
       //$(".inputText").removeAttr("disabled");
       if ( id == "si_titulo" ) {
        document.getElementById("fecha_expedicion").removeAttribute("disabled");
        document.getElementById("modalidad_tit").removeAttribute("disabled");
         document.getElementById("motivos_notitulado").setAttribute("disabled","disabled");
        document.getElementById('motivos_notitulado').value = '';
      }
    }

    function notitulado(id){
      if ( id == "no_titulo" ) {
        document.getElementById("motivos_notitulado").removeAttribute("disabled");
       document.getElementById("fecha_expedicion").setAttribute("disabled","disabled");
       document.getElementById("modalidad_tit").setAttribute("disabled","disabled");
       document.getElementById('fecha_expedicion').value = '';
       document.getElementById('modalidad_tit').value = '';
         }

    }
</script>

<script language="JavaScript">
    function posgrado_si(id){
      // document.getElementById("nombre_lengua").removeAttr("disabled");
       //$(".inputText").removeAttr("disabled");
       if ( id == "si_pos" ) {
        document.getElementById("posgrado").removeAttribute("disabled");
      }
    }

    function posgrado_no(id){
      if ( id == "no_pos" ) {
        document.getElementById("posgrado").setAttribute("disabled","disabled");
       document.getElementById('posgrado').value = '';
         }

    }
</script>

<script language="JavaScript">
    function si_otros(id){
      // document.getElementById("nombre_lengua").removeAttr("disabled");
       //$(".inputText").removeAttr("disabled");
       if ( id == "si_estudio" ) {
        document.getElementById("otros_estudios").removeAttribute("disabled");
      }
    }

    function no_otros(id){
      if ( id == "no_estudio" ) {
        document.getElementById("otros_estudios").setAttribute("disabled","disabled");
       document.getElementById('otros_estudios').value = '';
         }

    }
</script>

<script language="JavaScript">
    function elegir_si(id){
      // document.getElementById("nombre_lengua").removeAttr("disabled");
       //$(".inputText").removeAttr("disabled");
       if ( id == "si_elegir" ) {
        document.getElementById("la_misma").removeAttribute("disabled");
      }
    }

    function elegir_no(id){
      if ( id == "no_elegir" ) {
       document.getElementById("la_misma").removeAttribute("disabled");
       //document.getElementById('la_misma').value = '';
         }
    }
</script>

<script language="JavaScript">
function validarFechaMenorActual(){
  var today = new Date();
  var ingreso = document.getElementById('fecha_expedicion').value;
  var hoy = today.split("-");
  var fecha_ingreso_form = ingreso.split("-");

  if (fecha_ingreso_form > hoy){
    document.getElementById('resultado').value = 'No puedes ingresar una fecha mayor al día de hoy' ;
  }
}

</script>
