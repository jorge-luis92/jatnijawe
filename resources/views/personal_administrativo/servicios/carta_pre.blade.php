<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_servicios')
@section('title')
:Folio Carta Presentación
@endsection
@section('seccion')
<div class="container">
@include('flash-message')
  <div class="row justify-content-center">
      <div class="col-md-8">
          <div class="card">
              <div class="card-header" align="center">{{ __('Datos Carta de Presentación') }}</div>
            </br>

              <div class="card-body">
                <form method="POST" action="{{ route('ingreso_folio') }}" target="_blank">
                @csrf


    <div class="form-group row">
        <label for="matricula" class="col-md-4 col-form-label text-md-right" >{{ __('Matricula:') }}</label>
        <div class="col-md-6">
            <input id="matricula" value="{{$estudiante_matricula}}" name="matriculas" type="text" class="form-control" disabled>
    </div>
  </div>
<input id="matricula" hidden value="{{$estudiante_matricula}}" name="matricula" type="text" class="form-control" >
<input id="id_practicas" hidden value="{{$estudiante_actividad}}" name="id_practicas" type="text" class="form-control" >
    <div class="form-group row">
        <label for="num_folio" class="col-md-4 col-form-label text-md-right" >{{ __('Número de OFICIO:') }}</label>
        <div class="col-md-6">
            <input id="num_folio" required type="tel" maxlength="5"  name="num_folio" class="form-control" onkeypress="return numeros (event)">
    </div>
    </div>



<div class="form-group">
    <div class="col-xs-offset-2 col-xs-9" align="center">
        <button class="btn btn-primary" type="submit" >
          {{ __('Generar Carta de Presentación') }}
        </button>
    </div>
</div>
<a class="dropdown-item" >

</form>
</div>
</div>
</div>
</div>
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
