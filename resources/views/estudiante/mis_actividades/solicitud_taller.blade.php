<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_estudiante')
@section('title')
: Solicitudes
@endsection
@section('seccion')
 @include('flash-message')
<h1 style="font-size: 2.0em; color: #000000;" align="center"> Solicitud de Taller <?php if(empty($hola->bandera)){ $vacio=null; echo $vacio;} else{ echo $hola->bandera;} ?></h1>
<div class="container" id="font7">
</br>                    <form method="POST" action="{{ route('solicitud_taller_enviar') }}">
                        @csrf
<div class="form-row">
  <div class="form-group col-md-4">
    <label for="nombre" >{{ __('Nombre del Solicitante') }}</label>
    <input id="nombre" type="text" value="{{$u->nombre}} {{$u->apellido_paterno}} <?php if(empty($u->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $u->apellido_materno;} ?>" disabled onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre') is-invalid @enderror" name="nombre"  required autocomplete="nombre">
          @error('nombre')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
      </span>
        @enderror
</div>

<div class="form-group col-md-2" id="labels">
  <label for="semestre">Semestre</label>
  <input type="number" name="semestre" class="form-control" disabled id="semestre" value="{{$u->semestre}}" >
</div>

<div class="form-group col-md-2" id="labels">
  <label for="modalidad">Modalidad</label>
  <input type="text" name="modalidad" class="form-control" disabled id="modalidad" value="{{$u->modalidad}}" >
</div>

<div class="form-group col-md-2">
  <input type="text"  hidden size=10  maxlength=10 name="fecha_nac"  onblur="calcular_edad();" id="fecha_nac">
    <label for="edad" >{{ __('* Edad') }}</label>
    <input id="edad" type="tel" maxlength="2"  value="{{$u->edad}}" disabled class="form-control @error('edad') is-invalid @enderror" onkeypress="return numeros (event)" name="edad" autocomplete="edad" required autofocus>
        @error('edad')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
        @enderror
</div>

<div class="form-group col-md-2">
  <label for="tel_celular">* Teléfono Celular</label>
  <input type="tel" name='tel_celular' class="form-control" disabled id="tel_celular" maxlength="10" value="<?php if(empty($num_c->numero)){ $vacio=null; echo $vacio;} else{ echo $num_c->numero;} ?>" onkeypress="return numeros (event)"  placeholder=""  pattern="([0-9]{3})([0-9]{7})" required>
</div>



</div>

<div class="form-row">

<div class="form-group col-md-4">
  <label for="nombre_taller" >{{ __('Nombre del Taller') }}</label>
    <input id="nombre_taller" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre_taller') is-invalid @enderror" name="nombre_taller" value="<?php if(empty($taller->nombre_taller)){ $vacio=null; echo $vacio;} else{ echo $taller->nombre_taller;} ?>" required autocomplete="nombre_taller">
        @error('nombre_taller')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
      @enderror
  </div>
  <div class="form-group col-md-3">
      <label for="area">* Área</label>
      <select name="area" id="area" required class="form-control">
            <option value="">Seleccione una opción</option>
            <option value="ACADEMICA">ACADÉMICA</option>
            <option value="CULTURAL">CULTURAL</option>
            <option value="DEPORTIVA">DEPORTIVA</option>
      </select>
  </div>
  <div class="form-group col-md-5">
        <label for="lugar" >{{ __('* Lugar') }}</label>
        <input id="lugar" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('lugar') is-invalid @enderror" name="lugar" value="<?php if(empty($taller->lugar)){ $vacio=null; echo $vacio;} else{ echo $taller->lugar;} ?>" >
          @error('lugar')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
  </div>
</div>

<div class="form-row">

<div class="form-group col-md-6">
  <label for="descripcion" >{{ __('Descripción') }}</label>
    <textarea id="descripcion"   onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion"  required autocomplete="descripcion"><?php if(empty($taller->descripcion)){ $vacio=null; echo $vacio;} else{ echo $taller->descripcion;} ?></textarea>
      <div>
      @error('descripcion')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
</div></div>

<div class="form-group col-md-6">
    <label for="objetivos" >{{ __('Objetivos') }}</label>
    <textarea id="objetivos"  onKeyUp="this.value = this.value.toUpperCase()"  type="text" class="form-control @error('objetivos') is-invalid @enderror" name="objetivos"  autocomplete="objetivos" required><?php if(empty($taller->objetivos)){ $vacio=null; echo $vacio;} else{ echo $taller->objetivos;} ?></textarea>
     @error('objetivos')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
</div>



<div class="form-row">
<div class="form-group col-md-12">
    <label for="justificacion" >{{ __('Justificación') }}</label>
    <textarea id="justificacion"  onKeyUp="this.value = this.value.toUpperCase()"  type="text" class="form-control @error('justificacion') is-invalid @enderror" name="justificacion"  autocomplete="justificacion" required><?php if(empty($taller->justificacion)){ $vacio=null; echo $vacio;} else{ echo $taller->justificacion;} ?></textarea>
     @error('justificacion')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
</div>

<div class="form-row">

  <div class="form-group col-md-3">
    <label for="duracion">Duración</label>
      <select name="duracion" id="duracion"  required class="form-control" oninput="validarTipo(this)" >
    <option value="">Seleccione una opción</option>
    <option value="SEMESTRAL">SEMESTRAL (35 HORAS)</option>
    <option value="4 MESES">4 MESES (30 HORAS)</option>
    <option value="3 MESES">3 MESES (25 HORAS)</option>
    <option value="2 MESES">2 MESES (20 HORAS)</option>
    <option value="1 MES">1 MES (15 HORAS)</option>
    <!--<option value="CHARLA">CHARLA (2-15 HORAS)</option>-->
  </select>
  </div>
  <div class="form-group col-md-3">
   <label for="dias_sem">* Días de la semana</label>
   <input id="dias_sem" type="text" name="dias_sem" onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('dias_sem') is-invalid @enderror"  value="<?php if(empty($taller->dias_sem)){ $vacio=null; echo $vacio;} else{ echo $taller->dias_sem;} ?>"required autocomplete="dias_sem">
     @error('dias_sem')
   <span class="invalid-feedback" role="alert">
   <strong>{{ $message }}</strong>
   </span>
     @enderror
   </div>
        <div class="form-group col-md-3">
        <label for="fecha_inicio" >{{ __('* Fecha de Inicio(tentativo)') }}</label>
        <input id="fecha_inicio" type="date"  max=""  value="<?php if(empty($taller->fecha_inicio)){ $vacio=null; echo $vacio;} else{ echo $taller->fecha_inicio;} ?>" class="form-control @error('fecha_inicio') is-invalid @enderror" name="fecha_inicio" required>
        @error('fecha_inicio')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
        </div>

  <div class="form-group col-md-3">
       <label for="fecha_fin" >{{ __('* Fecha Terminación(tentativo)') }}</label>
       <input id="fecha_fin" type="date"   min="<?php echo date("Y-m-d");?>"  max="" value="<?php if(empty($taller->fecha_fin)){ $vacio=null; echo $vacio;} else{ echo $taller->fecha_fin;} ?>" class="form-control @error('fecha_fin') is-invalid @enderror" name="fecha_fin" required>
       @error('fecha_fin')
       <span class="invalid-feedback" role="alert">
       <strong>{{ $message }}</strong>
       </span>
      @enderror
   </div>

</div>

<div class="form-row">

<div class="form-group col-md-4">
   <label for="hora_inicio">Hora de entrada(tentativo)</label>
       <input class="form-control" oninput="vamos()"  type="time" min="07:00" max="20:00" id="hora_inicio" value="<?php if(empty($taller->hora_inicio)){ $vacio=null; echo $vacio;} else{ echo $taller->hora_inicio;} ?>"  name="hora_inicio" required>
   </div>

<div class="form-group col-md-4">
   <label for="hora_fin">Hora de salida (tentativo)</label>
     <input class="form-control" type="time" onchange="vamos()" min="07:00" max="20:00" id="hora_fin" value="<?php if(empty($taller->hora_fin)){ $vacio=null; echo $vacio;} else{ echo $taller->hora_fin;} ?>" name="hora_fin" required>
</div>

  <div class="form-group col-md-2">
      <label for="creditos" >{{ __('Créditos') }}</label>
      <input id="creditos" type="tel" maxlength="2"  value="<?php if(empty($taller->creditos)){ $vacio=null; echo $vacio;} else{ echo $taller->creditos;} ?>" class="form-control @error('creditos') is-invalid @enderror" onkeypress="return numeros (event)" name="creditos" autocomplete="creditos" required autofocus>
          @error('creditos')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
          @enderror
  </div>
  <div class="form-group col-md-2">
      <label for="cupo" >{{ __('Cupo') }}</label>
      <input id="cupo" type="tel" maxlength="3" value="<?php if(empty($taller->cupo)){ $vacio=null; echo $vacio;} else{ echo $taller->cupo;} ?>"  class="form-control @error('cupo') is-invalid @enderror" onkeypress="return numeros (event)" name="cupo" autocomplete="cupo" required autofocus>
          @error('cupo')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
          @enderror
  </div>

</div>

<div class="form-row">
  <div class="form-group col-md-4">
      <label for="materiales" >{{ __('Materiales') }}</label>
      <textarea id="materiales"  onKeyUp="this.value = this.value.toUpperCase()" required type="text" class="form-control @error('materiales') is-invalid @enderror" name="materiales" autocomplete="materiales"><?php if(empty($taller->materiales)){ $vacio=null; echo $vacio;} else{ echo $taller->materiales;} ?></textarea>
      @error('materiales')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
  </div>
<div class="form-group col-md-8">
    <label for="propuesta" >{{ __('Propuesta de Proyecto Final') }}</label>
    <textarea id="propuesta"  onKeyUp="this.value = this.value.toUpperCase()" required type="text" class="form-control @error('propuesta') is-invalid @enderror" name="propuesta"  autocomplete="propuesta"><?php if(empty($taller->proyecto_final)){ $vacio=null; echo $vacio;} else{ echo $taller->proyecto_final;} ?></textarea>
    @error('propuesta')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
</div>


                       <div class="form-group">
                           <div class="col-xs-offset-2 col-xs-9" align="center">
                               <button type="submit" class="btn btn-primary">
                                   {{ __('Enviar solicitud') }}
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
function validarTipo(input) {
  var form = document.getElementById('duracion').value;
  if(form == ''){
  document.getElementById('creditos').value = 0 ;
}
  if(form == 'SEMESTRAL'){
  document.getElementById('creditos').value = 35 ;
}
if(form == '4 MESES'){
document.getElementById('creditos').value = 30 ;
}
if(form == '3 MESES'){
document.getElementById('creditos').value = 25 ;
}
if(form == '2 MESES'){
document.getElementById('creditos').value = 20 ;
}
if(form == '1 MES'){
document.getElementById('creditos').value = 15 ;
}
if(form == 'CHARLA'){
document.getElementById('creditos').value = 2;
}
}
</script>

<script type="text/javascript">
function vamo(){
    var ed = document.getElementById('fecha_inicio').value; //fecha de nacimiento en el formulario
    var fecha_inicio = ed.split("-");
    var anio = fecha_inicio[0];
    var mes = fecha_inicio[1];
    var dia = fecha_inicio[2];
  var mm = parseInt(mes);
  var anios= parseInt(anio);
var j=anio;
var hey;
if((mes >= 1) || (mes <12)){
  mm=1+mm;
if((mm > 1) || (mm < 10)){
hey =mm;
document.getElementById("fecha_fin").min = anio+'-'+'0'+hey+'-'+dia;
//document.getElementById("fecha_fin").max = j+'-'+'0'+vale+'-'+dia;
}
}

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

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
