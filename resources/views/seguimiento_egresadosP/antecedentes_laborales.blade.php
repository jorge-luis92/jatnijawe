<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_estudiante')
@section('title')
: Egresados
@endsection
@section('seccion')
<h1 style="font-size: 2.0em; color: #000000;" align="center">Antecedentes Laborales</h1>
<div class="container" id="font7">
  @include('flash-message')
</br>
<form method="POST" action="{{ route('antecedentes_laborales_actu') }}">
                        @csrf
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <h6 align="left">Trabajo Actual</h6>
                              </div>
                       </div>
      <div class="form-row">
      <div class="radio col-md-12" id="labels">
      <label> ¿Actualmente Laboras?</label>

      <input type="radio" id="bandera_laboractual" name="bandera_laboractual" value="1" onclick="checar_labora(this.id)" required >
      <label for="si_labora">Si</label>

      <input type="radio" id="bandera_laboractual_no" name="bandera_laboractual" value="0" onclick="checar_nolabora(this.id)" required>
      <label for="no_labora">No</label>

      </div>
      </div>

      <div class="form-row">
      <div class="form-group col-md-6">
      <label for="lugar_labor_actual" >{{ __('Lugar donde labora') }}</label>
       <input id="lugar_labor_actual"  name="lugar_labor_actual" value="<?php if(empty($laborales->lugar_labor_actual)){ $vacio=null; echo $vacio;} else{ echo $laborales->lugar_labor_actual;} ?>" required disabled type="text" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('lugar_labor_actual') is-invalid @enderror"   autocomplete="lugar_labor_actual" >
         @error('lugar_labor_actual')
       <span class="invalid-feedback" role="alert">
       <strong>{{ $message }}</strong>
       </span>
                                   @enderror
      </div>

      <div class="form-group col-md-6">
      <label for="funcion_labor_actual" >{{ __('Función que desempeña') }}</label>
       <input id="funcion_labor_actual" name="funcion_labor_actual" value="<?php if(empty($laborales->funcion_labor_actual)){ $vacio=null; echo $vacio;} else{ echo $laborales->funcion_labor_actual;} ?>" required disabled type="text" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('funcion_labor_actual') is-invalid @enderror"  autocomplete="funcion_labor_actual" >
         @error('funcion_labor_actual')
       <span class="invalid-feedback" role="alert">
       <strong>{{ $message }}</strong>
       </span>
                                   @enderror
      </div>
      </div>

      <div class="form-row">
      <div class="radio col-md-5" id="labels">
      <label> ¿El trabajo actual coincide con  los estudios realizados?</label>
</br>
      <input type="radio" id="bandera_coincidencia" disabled name="bandera_coincidencia" value="1" onclick="checar()" required >
      <label for="coincide">Si</label>

      <input type="radio" id="bandera_coincidencia_no" disabled name="bandera_coincidencia" value="0" onclick="nochecar()" required>
      <label for="no_coincide">No</label>



      </div>


    <div class="form-group col-md-3">
    <label for="ingreso_mensual" >{{ __('¿Cuál es su ingreso mensual?') }}</label>
    <input id="ingreso_mensual" name="ingreso_mensual" value="<?php if(empty($laborales->ingreso_mensual)){ $vacio=null; echo $vacio;} else{ echo $laborales->ingreso_mensual;} ?>" required disabled type="tel" maxlength="10" onkeypress="return numeros (event)" class="form-control @error('ingreso_mensual') is-invalid @enderror"   autocomplete="ingreso_mensual" >
      @error('ingreso_mensual')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
                                @enderror
    </div>

    <div class="form-group col-md-4">
    <label for="antiguedad" >{{ __('Antigüedad(Años)') }}</label>
    <input id="antiguedad" name="antiguedad" disabled value="<?php if(empty($laborales->antiguedad)){ $vacio=null; echo $vacio;} else{ echo $laborales->antiguedad;} ?>"  required type="tel" maxlength="2" onkeypress="return numeros (event)" class="form-control @error('antiguedad') is-invalid @enderror"   autocomplete="antiguedad" >
      @error('antiguedad')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
                                @enderror
    </div>
  </div>
  <hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
  </br>
  <div class="form-row">
    <div class="form-group col-md-12">
      <h6 align="left">Trabajo Anterior</h6>
        </div>
 </div>
 <div class="form-row">
 <div class="radio col-md-12" id="labels">
 <label> ¿Algún trabajo anterior al actual?</label>

 <input type="radio" id="si_anterior" name="hola" onclick="checar_an(this.id)" required >
 <label for="si_labora">Si</label>

 <input type="radio" id="no_anterior"  name="hola" onclick="nochecar_an(this.id)" required>
 <label for="no_labora">No</label>

 </div>
 </div>

<div class="form-row">
  <div class="form-group col-md-6">
  <label for="trabajo_anterior" >{{ __('Lugar donde laboraba') }}</label>
  <input id="trabajo_anterior" name="trabajo_anterior" value="<?php if(empty($laborales->trabajo_anterior)){ $vacio=null; echo $vacio;} else{ echo $laborales->trabajo_anterior;} ?>"  disabled type="text" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('trabajo_anterior') is-invalid @enderror"   autocomplete="trabajo_anterior" >
    @error('trabajo_anterior')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
                              @enderror
  </div>

  <div class="form-group col-md-6">
  <label for="funcion_trabajo_anterior" >{{ __('Función que desempeñaba') }}</label>
  <input id="funcion_trabajo_anterior" name="funcion_trabajo_anterior" value="<?php if(empty($laborales->funcion_trabajo_anterior)){ $vacio=null; echo $vacio;} else{ echo $laborales->funcion_trabajo_anterior;} ?>"  disabled type="text" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('funcion_trabajo_anterior') is-invalid @enderror"   autocomplete="funcion_trabajo_anterior" >
    @error('funcion_trabajo_anterior')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
                              @enderror
  </div>

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

<script>
function numeros(e){
 key = e.keyCode || e.which;
 tecla = String.fromCharCode(key).toLowerCase();
 letras = " 0123456789";
 especiales = [8,37,39,46];

 tecla_especial = false
 for(var i in especiales){
if(key == especiales[i]){
  tecla_especial = true;
  break;
     }
 }

 if(letras.indexOf(tecla)==-1 && !tecla_especial)
     return false;
}
</script>

<script language="JavaScript">
    function checar_labora(id){
      // document.getElementById("nombre_lengua").removeAttr("disabled");
       //$(".inputText").removeAttr("disabled");
       if ( id == "bandera_laboractual" ) {
        document.getElementById("lugar_labor_actual").removeAttribute("disabled");
        document.getElementById("funcion_labor_actual").removeAttribute("disabled");
        document.getElementById("bandera_coincidencia").removeAttribute("disabled");
        document.getElementById("bandera_coincidencia_no").removeAttribute("disabled");
        document.getElementById("ingreso_mensual").removeAttribute("disabled");
        document.getElementById("antiguedad").removeAttribute("disabled");
      }
    }

    function checar_nolabora(id){
      if ( id == "bandera_laboractual_no" ) {
       document.getElementById("lugar_labor_actual").setAttribute("disabled","disabled");
       document.getElementById("funcion_labor_actual").setAttribute("disabled","disabled");
       document.getElementById("bandera_coincidencia").setAttribute("disabled","disabled");
       document.getElementById("bandera_coincidencia_no").setAttribute("disabled","disabled");
       document.getElementById("ingreso_mensual").setAttribute("disabled","disabled");
       document.getElementById("antiguedad").setAttribute("disabled","disabled");

      document.getElementById('lugar_labor_actual').value = '';
      document.getElementById('funcion_labor_actual').value = '';
      document.getElementById('bandera_coincidencia').checked = false;
      document.getElementById('bandera_coincidencia_no').checked = false;
      document.getElementById('ingreso_mensual').value = '';
      document.getElementById('antiguedad').value = '';

         }

    }
</script>

<script language="JavaScript">
    function checar_an(id){
      // document.getElementById("nombre_lengua").removeAttr("disabled");
       //$(".inputText").removeAttr("disabled");
       if ( id == "si_anterior" ) {
        document.getElementById("trabajo_anterior").removeAttribute("disabled");
        document.getElementById("funcion_trabajo_anterior").removeAttribute("disabled");
      }
    }

    function nochecar_an(id){
      if ( id == "no_anterior" ) {
       document.getElementById("trabajo_anterior").setAttribute("disabled","disabled");
       document.getElementById("funcion_trabajo_anterior").setAttribute("disabled","disabled");
       document.getElementById('trabajo_anterior').value = '';
      document.getElementById('funcion_trabajo_anterior').value = '';
         }

    }
</script>
