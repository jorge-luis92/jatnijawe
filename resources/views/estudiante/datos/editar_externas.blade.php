<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_estudiante')
@section('title')
: Editar Actividad
@endsection

@section('seccion')
  <h1 style="font-size: 2.0em; color: #000000;" align="center"> Otras Actividades</h1>
<div class="container" id="font4">
  @include('flash-message')
</br>

<form method="POST" action="{{ route('otras_actividades_actualizar') }}">
    @csrf
  <p style="font-size: 1.0em; color: #000000;"> Los Campos con un * son Obligatorios</p>

  <div class="radio col-md-12">
    <label >* ¿Realizas alguna actividad durante la semana?</label>

   <input type="radio" id="si_actividad" name="actividad" value="si_actividad" onclick="sitrabaja()" required  >
   <label for="si_actividad" >Si</label>

   <input type="radio" id="no_actividad" name="actividad" value="no_actividad" onclick="notrabaja()" required >
   <label for="no_actividad" >No</label>
   </div>
   <div class="form-group col-md-12">
     <h6 style="color: #000000;">Horario</h6>
       </div>
         <div class="form-row">
      <div class="form-group col-md-4">
         <label for="dias_sem">Días de la semana: </label>
            <input type="text"class="form-control" name="dias_sem" onKeyUp="this.value = this.value.toUpperCase()" placeholder="Ejemplo: Lunes a Viernes" id="dias_sem" disabled  required>
 </div>
</div>
<div class="form-row">
    <div class="form-group col-md-2">
      <label for="hora_entrada">Entrada</label>
      <input type="time"class="form-control" name="hora_entrada" id="hora_entrada" disabled  required>
    </div>
    <div class="form-group col-md-2">
      <label for="hora_salida">Salida</label>
      <input type="time" class="form-control" name="hora_salida" id="hora_salida" disabled  required >
    </div>
</div>

 <div class="form-group">
  <br>
  <div class="col-xs-offset-2 col-xs-9" align="center">
      <input type="submit" class="btn btn-primary" name="agregar" value="Actualizar">
  </div>
</div>
</form>
</div>
</br>
  @endsection
<script language="JavaScript">
    function sitrabaja(){
        $(".form-control").removeAttr("disabled");
    }

    function notrabaja(){
        $(".form-control").attr("disabled","disabled");
    }
</script>


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
