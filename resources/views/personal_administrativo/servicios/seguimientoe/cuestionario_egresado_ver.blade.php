<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_servicios')
@section('title')
: Egresados
@endsection
@section('seccion')
<h1 style="font-size: 2.0em; color: #000000;" align="center">Cuestionario al Egresado</h1>
<div class="container" id="font7">
</br>
<form method="POST" action="{{ route('cuestionario_egresado_ver') }}">
                        @csrf

  <div class="form-row">
   <div class="form-group col-md-2">
   <label for="titulo">Títulado</label>
   <input name="estado" id="estado" required class="form-control"></input>
                       </div>


<div class="form-group col-md-5" id="labels">
  <label for="fecha_expedicion">Fecha de Expedición del título</label>
  <input type="date" class="form-control" id="fecha_expedicion" >
</div>


  <div class="form-group col-md-5">
    <label for="modalidad_tit">Modalidad de Titulación</label>
    <input name="modalidad_tit" id="modalidad_tit" required class="form-control"></input>
</div>

</div>

</br>
<div class="form-row">
  <div class="form-group col-md-12">
  <label for="motivos_post" >{{ __('En caso de no haberse titulado, ¿Cuales son los motivos de haber postergado la Titulación?') }}</label>
  <input id="motivos_post" type="text" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('motivos_post') is-invalid @enderror"  name="motivos_post" autocomplete="motivos_post" autofocus>
    @error('motivos_post')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
                              @enderror
</div>
</div>

<div class="form-row">
  <div class="form-group col-md-12">
  <label for="bachillerato_origen" >{{ __('¿Cual es la razón de haber estudiado la Licenciatura?') }}</label>
  <input id="bachillerato_origen" type="text" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('bachillerato_origen') is-invalid @enderror"  name="bachillerato_origen" autocomplete="bachillerato_origen" autofocus>
    @error('bachillerato_origen')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
                              @enderror
</div>
</div>

<div class="form-row">
<div class="form-group col-md-2">
<label>Estudios de Posgrado</label>
<input name="posgrado" id="posgrado" required class="form-control"></input>
</div>



  <div class="form-group col-md-10">
  <label for="posgrado" >{{ __('Especificaciones') }}</label>
  <input id="posgrado" type="text" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('posgrado') is-invalid @enderror"  name="posgrado" autocomplete="posgrado" autofocus>
    @error('posgrado')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
                              @enderror
</div>
</div>

<div class="form-row">
<div class="form-group col-md-2">
<label>Realiza otros estudios</label>
<input name="estudios_despues" id="estudios_despues" required class="form-control"></input>
</div>



  <div class="form-group col-md-10">
  <label for="posgrado" >{{ __('Especificaciones') }}</label>
  <input id="posgrado" type="text" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('posgrado') is-invalid @enderror"  name="posgrado" autocomplete="posgrado" autofocus>
    @error('posgrado')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
  </span>
                              @enderror
</div>
</div>



<div class="form-row">
  <div class="form-group col-md-8">
    <label for="grado_satisfaccion">¿Cuál es el	Grado de satisfacción en cuanto a la formación recibida por la Licenciatura?</label>
    <input name="grado_satisfaccion" id="grado_satisfaccion" required class="form-control"></input>

</div>
</div>

<div class="form-row">
 <div class="form-row">
  <label>¿Eligiria la misma institución nuevamente?</label>
   <div class="form-group col-md-2">
 <input name="estudios_despues" id="estudios_despues" required class="form-control"></input>
 </div>
</div>



<div class="form-group col-md-10">
<label for="la_misma" >{{ __('¿Por qué?') }}</label>
<input id="la_misma" type="text" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('la_misma') is-invalid @enderror"  name="la_misma" autocomplete="la_misma" autofocus>
  @error('la_misma')
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
