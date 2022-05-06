<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_servicios')
@section('title')
: Egresados
@endsection
@section('seccion')
<h1 style="font-size: 2.0em; color: #000000;" align="center">Antecedentes Laborales</h1>
<div class="container" id="font7">
</br>
<form method="POST" action="{{ route('antecedentes_laborales_egresado') }}">
                        @csrf

      <div class="form-row">
      <div class="form-group col-md-3">
      <label>Labora Actualmente</label>
      <input id="labora" type="text" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('labora') is-invalid @enderror"  name="labora" autocomplete="labora" autofocus>
   </div>
      </div>

      <div class="form-row">
      <div class="form-group col-md-12">
      <label for="labor_actual" >{{ __('Lugar') }}</label>
       <input id="labor_actual" type="text" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('labor_actual') is-invalid @enderror"  name="labor_actual" autocomplete="labor_actual" autofocus>
         @error('labor_actual')
       <span class="invalid-feedback" role="alert">
       <strong>{{ $message }}</strong>
       </span>
                                   @enderror
      </div>
      </div>


      <div class="form-row">
      <label> ¿El trabajo actual coincide con  los estudios realizados?</label>
        <div class="form-group col-md-4">
      <input name="coincide" id="coincide" required class="form-control"></input>
        </div>


    <div class="form-group col-md-4">
    <label for="ingreso_mensual" >{{ __('¿Cuál es su ingreso mensual?') }}</label>
    <input id="ingreso_mensual" type="text" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('ingreso_mensual') is-invalid @enderror"  name="ingreso_mensual" autocomplete="ingreso_mensual" autofocus>
      @error('ingreso_mensual')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
                                @enderror
    </div>

    <div class="form-group col-md-4">
    <label for="antiguedad" >{{ __('Antigüedad') }}</label>
    <input id="antiguedad" type="text" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('antiguedad') is-invalid @enderror"  name="antiguedad" autocomplete="antiguedad" autofocus>
      @error('antiguedad')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
                                @enderror
    </div>
  </div>

<div class="form-row">
  <div class="form-group col-md-12">
  <label for="trabajos_anteriores" >{{ __('Trabajos Anteriores') }}</label>
  <input id="trabajos_anteriores" type="text" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('trabajos_anteriores') is-invalid @enderror"  name="trabajos_anteriores" autocomplete="trabajos_anteriores" autofocus>
    @error('trabajos_anteriores')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
                              @enderror
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
