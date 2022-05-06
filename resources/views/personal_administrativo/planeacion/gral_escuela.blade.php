@extends('layouts.plantilla_planeacion')
@section('title')
:Escuela
@endsection
@section('seccion')
<h1 style="font-size: 2.0em; color: #000000;" align="center">Identificación de la Escuela</h1>
<div class="container" id="font7">
    @include('flash-message')
</br>                    <form method="POST" action="{{ route('agregar_escuela') }}">
                        @csrf
       <label align="left" ><strong>{{ __('Información de la Escuela ') }}</strong> </label>
   <div class="form-row">

     <div class="form-group col-md-6">
        <label for="clave_institucion" >{{ __('Clave de la Institución') }}</label>
        <input id="clave_institucion" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('clave_institucion') is-invalid @enderror" name="clave_institucion" value="<?php if(empty($datos_escuela->clave_institucion)){ $vacio=null; echo $vacio;} else{ echo $datos_escuela->clave_institucion;} ?>" autofocus required autocomplete="clave_institucion">
                                @error('clave_institucion')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
                              @enderror
      </div>

  <div class="form-group col-md-6">
    <label for="clave_escuela" >{{ __('Clave de la escuela ') }}</label>
    <input id="clave_escuela" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('clave_escuela') is-invalid @enderror" name="clave_escuela" value="<?php if(empty($datos_escuela->clave_escuela)){ $vacio=null; echo $vacio;} else{ echo $datos_escuela->clave_escuela;} ?>" required autocomplete="clave_escuela">
                                @error('clave_escuela')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
                                @enderror
  </div>
</div>

  <div class="form-row">

    <div class="form-group col-md-6">
       <label for="nombre_escuela" >{{ __('Nombre de la escuela') }}</label>
       <input id="nombre_escuela" type="text"  required onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre_escuela') is-invalid @enderror" name="nombre_escuela" value="<?php if(empty($datos_escuela->nombre_escuela)){ $vacio=null; echo $vacio;} else{ echo $datos_escuela->nombre_escuela;} ?>" required autocomplete="nombre_escuela">
                               @error('nombre_escuela')
       <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
       </span>
                             @enderror
     </div>

     <div class="form-group col-md-6">
     <label for="institucion_pertenciente" >Nombre de la Institución a la que pertenece</label>
     <input id="institucion_pertenciente" onKeyUp="this.value = this.value.toUpperCase()" type="text" class="form-control @error('institucion_pertenciente') is-invalid @enderror" value="<?php if(empty($datos_escuela->institucion_pertenciente)){ $vacio=null; echo $vacio;} else{ echo $datos_escuela->institucion_pertenciente;} ?>" name="institucion_pertenciente"  required >
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
    <label for="dependencia_normativa" >{{ __('Dependencia Normativa') }}</label>
    <input id="dependencia_normativa"   onKeyUp="this.value = this.value.toUpperCase()" type="text" class="form-control @error('dependencia_normativa') is-invalid @enderror" value="<?php if(empty($datos_escuela->dependencia_normativa)){ $vacio=null; echo $vacio;} else{ echo $datos_escuela->dependencia_normativa;} ?>" name="dependencia_normativa"  required >
                  @error('dependencia_normativa')
   <span class="invalid-feedback" role="alert">
   <strong>{{ $message }}</strong>
  </span>
                                @enderror
  </div>

  <div class="form-group col-md-6">
      <label for="pagina_web" >{{ __('Página Web de la Escuela') }}</label>
          <input id="pagina_web"  value="<?php if(empty($datos_escuela->pagina_web_escuela)){ $vacio=null; echo $vacio;} else{ echo $datos_escuela->pagina_web_escuela;} ?>" type="url" class="form-control @error('pagina_web') is-invalid @enderror" name="pagina_web"  >
          @error('pagina_web')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
  </div>
  </div>
  <label align="left" ><strong>{{ __('Dirección de la escuela ') }}</strong> </label>
    <div class="form-row">
    <div class="form-group col-md-8">
    <label for="vialidad_principal" >{{ __('Vialidad Principal') }}</label>
    <input id="vialidad_principal"  onKeyUp="this.value = this.value.toUpperCase()" type="text" class="form-control @error('vialidad_principal') is-invalid @enderror" name="vialidad_principal" value="<?php if(empty($direccion_d->vialidad_principal)){ $vacio=null; echo $vacio;} else{ echo $direccion_d->vialidad_principal;} ?>" >
                  @error('vialidad_principal')
   <span class="invalid-feedback" role="alert">
   <strong>{{ $message }}</strong>
  </span>
                                @enderror
  </div>
  <div class="form-group col-md-2">
  <label for="num_exterior" >{{ __('Número Exterior') }}</label>
  <input id="num_exterior"  onKeyUp="this.value = this.value.toUpperCase()" type="text" maxlength="6" class="form-control @error('num_exterior') is-invalid @enderror"   value="<?php if(empty($direccion_d->num_exterior)){ $vacio=null; echo $vacio;} else{ echo $direccion_d->num_exterior;} ?>"  name="num_exterior"  required>
                            @error('num_exterior')
  <span class="invalid-feedback" role="alert">
  <strong>{{ $message }}</strong>
</span>
                            @enderror
  </div>

  <div class="form-group col-md-2">
  <label for="num_interior" >{{ __('Número Interior ') }}</label>
  <input id="num_interior"  onKeyUp="this.value = this.value.toUpperCase()" type="text" maxlength="6" class="form-control @error('num_interior') is-invalid @enderror"  value="<?php if(empty($direccion_d->num_interior)){ $vacio=null; echo $vacio;} else{ echo $direccion_d->num_interior;} ?>" name="num_interior"  autocomplete="num_interior">
                @error('num_interior')
 <span class="invalid-feedback" role="alert">
 <strong>{{ $message }}</strong>
</span>
                              @enderror
</div>
                      </div>


     <div class="form-row">
       <div class="form-group col-md-4">
       <label for="vialidad_derecha" >{{ __('Vialidad Derecha') }}</label>
       <input id="vialidad_derecha" onKeyUp="this.value = this.value.toUpperCase()" type="text" class="form-control @error('vialidad_derecha') is-invalid @enderror" name="vialidad_derecha"  value="<?php if(empty($direccion_d->vialidad_derecha)){ $vacio=null; echo $vacio;} else{ echo $direccion_d->vialidad_derecha;} ?>" required autocomplete="vialidad_derecha">
                     @error('vialidad_derecha')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
     </span>
                                   @enderror
     </div>

     <div class="form-group col-md-4">
     <label for="vialidad_izquierda" >{{ __('Vialidad Izquierda') }}</label>
     <input id="vialidad_izquierda"   onKeyUp="this.value = this.value.toUpperCase()" type="text" class="form-control @error('vialidad_izquierda') is-invalid @enderror" name="vialidad_izquierda"  value="<?php if(empty($direccion_d->vialidad_izquierda)){ $vacio=null; echo $vacio;} else{ echo $direccion_d->vialidad_izquierda;} ?>" required autocomplete="vialidad_posterior">
                   @error('vialidad_izquierda')
     <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
     </span>
                               @enderror
     </div>

   <div class="form-group col-md-4">
   <label for="vialidad_psterior" >{{ __('Vialidad Posterior') }}</label>
   <input id="vialidad_psterior"   onKeyUp="this.value = this.value.toUpperCase()" type="text" class="form-control @error('vialidad_psterior') is-invalid @enderror" name="vialidad_psterior"  value="<?php if(empty($direccion_d->vialidad_psterior)){ $vacio=null; echo $vacio;} else{ echo $direccion_d->vialidad_psterior;} ?>" required autocomplete="vialidad_posterior">
                 @error('vialidad_psterior')
   <span class="invalid-feedback" role="alert">
   <strong>{{ $message }}</strong>
   </span>
                             @enderror
   </div>
</div>

<div class="form-row">
  <div class="form-group col-md-4">
  <label for="asentamiento_humano" >{{ __('Asentamiento Humano') }}</label>
  <input id="asentamiento_humano"  onKeyUp="this.value = this.value.toUpperCase()" type="text" class="form-control @error('asentamiento_humano') is-invalid @enderror" name="asentamiento_humano"  value="<?php if(empty($direccion_d->asentamiento_humano)){ $vacio=null; echo $vacio;} else{ echo $direccion_d->asentamiento_humano;} ?>"  required >
                @error('asentamiento_humano')
 <span class="invalid-feedback" role="alert">
 <strong>{{ $message }}</strong>
</span>
                              @enderror
</div>

<!--<div class="form-group col-md-4">
    <label for="cp" >{{ __('*Código Postal') }}</label>
        <input id="cp" maxlength="5" type="tel"  value="" class="form-control @error('cp') is-invalid @enderror" onkeypress="return numeros (event)" name="cp"  autocomplete="cp" autofocus required>
        @error('cp')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
</div>-->

<div class="form-group col-md-4">
    <label for="cp">Código Postal</label>
    <input type="tel" class="form-control" name="cp" id="cp"  value="<?php if(empty($direccion_d->cp)){ $vacio='68120'; echo $vacio;} else{ echo $direccion_d->cp;} ?>"  maxlength="5"  onkeypress="return numeros (event)"  placeholder="Código Postal" onKeyUp="this.value = this.value.toUpperCase();" required>
  </div>

<div class="form-group col-md-4">
<label for="localidad" >{{ __('Localidad') }}</label>
<input id="localidad"   onKeyUp="this.value = this.value.toUpperCase()"  value="<?php if(empty($direccion_d->localidad)){ $vacio=null; echo $vacio;} else{ echo $direccion_d->localidad;} ?>" type="text" class="form-control @error('localidad') is-invalid @enderror" name="localidad" >
              @error('localidad')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
                            @enderror
</div>
</div>

<div class="form-row">
  <div class="form-group col-md-4">
  <label for="municipio" >{{ __('Municipio o Delegación') }}</label>
  <input id="municipio" disabled onKeyUp="this.value = this.value.toUpperCase()"  value="<?php if(empty($codego->municipio)){ $vacio=null; echo $vacio;} else{ echo $codego->municipio;} ?>" type="text" class="form-control @error('municipio') is-invalid @enderror" name="municipio"  required autocomplete="municipio">
                @error('municipio')
 <span class="invalid-feedback" role="alert">
 <strong>{{ $message }}</strong>
</span>
                              @enderror
</div>

  <div class="form-group col-md-4">
  <label for="entidad_federativa" >{{ __('Entidad Federativa') }}</label>
  <input id="entidad_federativa" disabled onKeyUp="this.value = this.value.toUpperCase()"  value="<?php if(empty($codego->estado)){ $vacio=null; echo $vacio;} else{ echo $codego->estado;} ?>" type="text" class="form-control @error('entidad_federativa') is-invalid @enderror" name="entidad_federativa" required autocomplete="entidad_federativa">
                @error('entidad_federativa')
 <span class="invalid-feedback" role="alert">
 <strong>{{ $message }}</strong>
</span>
                              @enderror
</div>
</div>


<!--<div class="form-row">
  <div class="form-group col-md-4">
      <label for="telefono" >{{ __('Teléfono') }}</label>
          <input id="telefono" maxlength="10" type="tel" class="form-control @error('telefono') is-invalid @enderror" onkeypress="return numeros (event)" name="telefono"  autocomplete="telefono" autofocus required>
          @error('telefono')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
  </div>
  <div class="form-group col-md-2">
      <label for="extension" >{{ __('Extensión') }}</label>
          <input id="extension" maxlength="5" type="tel" class="form-control @error('extension') is-invalid @enderror" onkeypress="return numeros (event)" name="extension"  autocomplete="extension" autofocus required>
          @error('extension')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
  </div>
</div>-->

<label align="left" ><strong>{{ __('Información del Director de la Escuela ') }}</strong> </label>
<div class="form-row">
<div class="form-group col-md-4">
   <label for="nombre" >{{ __('* Nombre(s)') }}</label>
       <input id="nombre" type="text"  name='nombre' onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre_titular') is-invalid @enderror"   value="<?php if(empty($datos_director->nombre)){ $vacio=null; echo $vacio;} else{ echo $datos_director->nombre;} ?>"  required autocomplete="nombre_titular">
       @error('nombre_titular')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
     @enderror
</div>

<div class="form-group col-md-4">
   <label for="apellido_paterno" >{{ __('* Apellido Paterno') }}</label>
         <input id="apellido_paterno" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('apellido_paterno') is-invalid @enderror" name="apellido_paterno" value="<?php if(empty($datos_director->apellido_paterno)){ $vacio=null; echo $vacio;} else{ echo $datos_director->apellido_paterno;} ?>" required autocomplete="apellido_paterno">
       @error('apellido_paterno')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
       @enderror
</div>

<div class="form-group col-md-4">
   <label for="apellido_materno" >{{ __('Apellido Materno') }}</label>
         <input id="apellido_materno"  onKeyUp="this.value = this.value.toUpperCase()"  type="text" class="form-control @error('apellido_materno') is-invalid @enderror" name="apellido_materno" value="<?php if(empty($datos_director->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $datos_director->apellido_materno;} ?>" autocomplete="apellido_materno">
       @error('apellido_materno')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
       @enderror
</div>
</div>
<!--
<div class="form-row">


                        <div class="form-group col-md-6">
                            <label for="email" >{{ __('*Correo eléctronico del responsable ') }}</label>
                                <input id="email" type="email" value="{{ Auth::user()->email }}" disabled class="form-control" name="email">

                        </div>
  </div>
-->
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
