<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_servicios')
@section('title')
: Datos de Servicio
@endsection

@section('seccion')
 @include('flash-message')
<h1 style="font-size: 2.0em; color: #000000;" align="center"> Datos de Servicio Social </h1>
<div class="container" id="font7">
 <br />
  <h2 style="font-size: 1.2em; color: #000000;" align="center"><strong>Estudiante: <?php if(empty($u->nombre)){ $vacio=null; echo $vacio;} else{ echo $u->nombre." ".$u->apellido_paterno;} ?> <?php if(empty($u->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $u->apellido_materno;} ?></strong></h2>
  <h3 style="font-size: 1.2em; color: #000000;" align="left"><strong>Datos generales</strong></h3>   
<div class="form-row">
	  <div class="form-group col-md-3">
    <label for="tel_celular">Teléfono Celular</label>
    <input type="text"  class="form-control" value="<?php if(empty($cel->numero)){ $vacio=null; echo $vacio;} else{ echo $cel->numero;} ?>" disabled  id="tel_celular" maxlength="10">
  </div>
  <div class="form-group col-md-3">
      <label for="fecha_ingreso" >{{ __(' Fecha de Ingreso') }}</label>
            <input id="fecha_ingreso" type="date" class="form-control" value="{{$u->fecha_ingreso}}"  disabled name="fecha_ingreso" autocomplete="fecha_ingreso">
          @error('fecha_ingreso')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
  </div>
   
  <div class="form-group col-md-3">
      <label for="avance" >{{ __('Porcentaje de Avance') }}</label>
          <input id="avance" type="text" disabled value="<?php if(empty($datos_practicas->procentaje_avance)){ $vacio=null; echo $vacio;} else{ echo $datos_practicas->procentaje_avance." %";} ?>" maxlength="3" placeholder="Ejemplo: 90" class="form-control @error('avance') is-invalid @enderror"  name="avance" autocomplete="avance" >
          @error('avance')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
  </div>
</div>
                         

<hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
<h3 style="font-size: 1.2em; color: #000000;" align="left"><strong>Datos de la Empresa</strong></h3>

<div class="form-row">

<div class="form-group col-md-12">
  <label for="institucion" >{{ __('Nombre del la Institución o Dependencia donde Realiza Servicio Social:') }}</label>
     <textarea rows="1" style="resize: both;" id="institucion" disabled class="form-control" name="institucion"  onKeyUp="this.value = this.value.toUpperCase()" required > <?php if(empty($dependencia_p->nombre_dependencia)){ $vacio=null; echo $vacio;} else{ echo $dependencia_p->nombre_dependencia;} ?></textarea>
   </div>
</div>

<label for="responsable" ><strong>{{ __('Información del Titular de la Dependencia(A quien fue dirigido el oficio de Presentación)') }}</strong></label>

<div class="form-row">
<div class="form-group col-md-4">
   <label for="nombre_titular" >{{ __('Nombre(s)') }}</label>
       <input id="nombre_titular" disabled type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre_titular') is-invalid @enderror" name="nombre_titular" value="<?php if(empty($dependencia_p->nombre)){ $vacio=null; echo $vacio;} else{ echo $dependencia_p->nombre;} ?>"required autocomplete="nombre_titular">
       @error('nombre_titular')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
     @enderror
</div>

<div class="form-group col-md-4">
   <label for="apellido_paterno" >{{ __('Apellido Paterno') }}</label>
         <input id="apellido_paterno_titular" disabled type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('apellido_paterno_titular') is-invalid @enderror" name="apellido_paterno_titular" value="<?php if(empty($dependencia_p->apellido_paterno)){ $vacio=null; echo $vacio;} else{ echo $dependencia_p->apellido_paterno;} ?>"required autocomplete="apellido_paterno_titular">
       @error('apellido_paterno')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
       @enderror
</div>

<div class="form-group col-md-4">
   <label for="apellido_materno" >{{ __('Apellido Materno') }}</label>
         <input id="apellido_materno_titular"  disabled onKeyUp="this.value = this.value.toUpperCase()"  type="text" class="form-control @error('apellido_materno_titular') is-invalid @enderror" name="apellido_materno_titular" value="<?php if(empty($dependencia_p->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $dependencia_p->apellido_materno;} ?>" autocomplete="apellido_materno_titular">
       @error('apellido_materno')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
       @enderror
</div>
 </div>
 <div class="form-row">
<div class="form-group col-md-12">
      <label for="cargo_responsable" >{{ __('Cargo del Titular') }}</label>
        <input id="cargo_responsable" disabled type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('cargo_responsable') is-invalid @enderror" name="cargo_responsable" value="<?php if(empty($dependencia_p->cargo_titular)){ $vacio=null; echo $vacio;} else{ echo $dependencia_p->cargo_titular;} ?>" required autocomplete="cargo_responsable">
            @error('cargo_responsable')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
          @enderror
      </div>
     
</div>


@endsection


