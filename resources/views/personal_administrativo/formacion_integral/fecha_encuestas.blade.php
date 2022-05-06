<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Fechas de Solicitud de Talleres
@endsection

@section('seccion')
 @include('flash-message')
<h1 style="font-size: 2.0em; color: #000000;" align="center"> Registro de Fechas encuestas</h1>
<div class="container" id="font7">
</br>                    <form method="POST" action="{{ route('agregar_fecha_encuesta')}}">
                        @csrf

					<div class="form-row">
					 <div class="form-group col-md-3">
              <label for="estatus" >{{ __('Estatus de Encuesta') }}</label>
              <input id="estatus" type="text"   name="estatus" value="<?php if(empty($estatus_t->estado)){ $vacio=null; echo $vacio;} else{ echo $estatus_t->estado;} ?>" class="form-control"  disabled>
              </div>
					<div class="form-group col-md-3">
      <label for="tipo_lengua">Actualizar Periodo</label>
        <select name="estado" id="estado" required class="form-control">
        <option value="">Seleccione una opción</option>
        <option value="Activo">Abrir Periodo</option>
        <option value="Cerrado">Cerrar Periodo</option>
            </select>
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
document.getElementById("otro").value = anio+'-'+mes+'-'+dia + '  fecha: mes: '+hey +' : '+j;
}
}

}

function vamos(){
    var ed = document.getElementById('hora_inicio').value; //fecha de nacimiento en el formulario
    var hours = ed.split(":")[0];
   var minutes = ed.split(":")[1];
   var nueva_hora= parseInt(hours);

       document.getElementById("hora_fin").min = hours + ":" + minutes;
    document.getElementById("otro").value = nueva_hora + ":" + minutes;
}
</script>
