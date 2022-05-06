<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Registro Taller
@endsection

@section('seccion')
 @include('flash-message')
<h1 style="font-size: 2.0em; color: #000000;" align="center"> Registro de Actividades Extracurriculares: Conferencias</h1>
<div class="container" id="font7">
</br>
<form method="POST" action="registrar_conferencia">
@csrf
<div class="form-row">
    <div class="form-group col-md-6">
          <label for="nombre_ec" >{{ __('*Nombre de la Conferencia') }}</label>
          <input id="nombre_ec" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre_ec') is-invalid @enderror" name="nombre_ec" value="{{ old('nombre_ec') }}" required autocomplete="nombre_ec">
            @error('nombre_ec')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
    </div>

    <div class="form-group col-md-6">
          <label for="lugar" >{{ __('* Lugar') }}</label>
          <input id="lugar" type="text" onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('lugar') is-invalid @enderror" name="lugar" value="{{ old('lugar') }}" required autocomplete="lugar">
            @error('lugar')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
    </div>

  </div>

<div class="form-row">
    <div class="form-group col-md-2">
        <label for="creditos" >{{ __('* Créditos') }}</label>
        <input id="creditos" type="creditos" maxlength="2" class="form-control @error('creditos') is-invalid @enderror" onkeypress="return numeros (event)" name="creditos" autocomplete="creditos" required autofocus>
        @error('creditos')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group col-md-4">
        <label for="area">* Área</label>
        <select name="area" id="area" required class="form-control">
              <option value="">Seleccione una opción</option>
              <option value="ACADEMICA">ACADÉMICA</option>
              <option value="CULTURAL">CULTURAL</option>
              <option value="DEPORTIVA">DEPORTIVA</option>
        </select>
    </div>

    <div class="form-group col-md-4">
        <label for="modalidad">* Modalidad</label>
        <select name="modalidad" id="modalidad" required class="form-control">
        <option value="">Seleccione una opción</option>
        <option value="ESCOLARIZADO">ESCOLARIZADO</option>
        <option value="SEMIESCOLARIZADO">SEMIESCOLARIZADO</option>
        </select>
    </div>

    <div class="form-group col-md-2">
        <label for="cupo" >{{ __('* Cupo') }}</label>
        <input id="cupo" type="cupo" maxlength="3" class="form-control @error('cupo') is-invalid @enderror" onkeypress="return numeros (event)" name="cupo" autocomplete="cupo" required autofocus>
        @error('cupo')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
  </div>

  <div class="form-row">
        <div class="form-group col-md-3">
        <label for="fecha_inicio" >{{ __('* Fecha de Inicio') }}</label>
        <input id="fecha_inicio" type="date" min= "<?php echo date("Y-m-d");?>"  class="form-control @error('fecha_inicio') is-invalid @enderror" name="fecha_inicio" required>
        @error('fecha_inicio')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
        </div>

        <div class="form-group col-md-3">
              <label for="hora_inicio">* Hora de entrada</label>
              <input id="hora_inicio" type="time" oninput="vamos()" min= "07:00" max="19:00" class="form-control"  name="hora_inicio"  required class="form-control" >
        </div>

        <div class="form-group col-md-3">
          <label for="hora_fin" >{{ __('* Hora Salida') }}</label>
          <input id="hora_fin" type="time" onchange="vamos()"  name="hora_fin"  min="" max="20:00"  value="" class="form-control"  required>
                </div>

  <div class="form-group col-md-3">
      <label for="tutor">* Tutor</label>
          <select name="tutor" id="tutor" required class="form-control">
      <option value="">Seleccione un Tutor</option>
      @foreach ($taller as $talleres)
      <option value="{!! $talleres->id_tutor !!}">{!! $talleres->nombre !!} {!! $talleres->apellido_paterno !!} {!! $talleres->apellido_materno !!}</option>
        @endforeach
      </select>
  </div>

</div>


<div class="form-group">
    <div class="col-xs-offset-2 col-xs-9" align="center">
        <button type="submit" class="btn btn-primary">
          {{ __('Registrar') }}
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


<script>
function vamo(){
    var ed = document.getElementById('fecha_inicio').value; //fecha de nacimiento en el formulario
   var fecha_inicio = ed.split("-");
    var anio = fecha_inicio[0];
    var mes = fecha_inicio[1];
    var dia = fecha_inicio[2];
  /*var mm = parseInt(mes);
  var anios= parseInt(anio);
var j=anio;
var hey;
if((mes >= 1) || (mes <12)){
  mm=1+mm;
if((mm > 1) || (mm < 10)){
hey =mm;*/
document.getElementById("fecha_fin").min = anio+'-'+'0'+hey+'-'+dia;
}

function vamos(){
    var ed = document.getElementById('hora_inicio').value; //fecha de nacimiento en el formulario
    var hours = ed.split(":")[0];
   var minutes = ed.split(":")[1];
var nueva_hora= parseInt(hours);
var primero;
if((nueva_hora >= 6) &&  (nueva_hora <= 8)){
       primero= nueva_hora + 1;
       document.getElementById("hora_fin").min = "0"+primero  + ":" + minutes;

     }

   if((nueva_hora >= 9) &&  (nueva_hora <= 19)){
          primero= nueva_hora + 1;
          document.getElementById("hora_fin").min = primero  + ":" + minutes;

        }
    if(nueva_hora == 20){
           primero= nueva_hora + 1;
           document.getElementById("hora_fin").min = primero  + ":" + minutes;

         }

}

</script>
