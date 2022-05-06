<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_estudiante')
@section('title')
: Solicitudes
@endsection

@section('seccion')
 @include('flash-message')
<h1 style="font-size: 2.0em; color: #000000;" align="center"> Solicitud de Prácticas Profesionales </h1>
<div class="container" id="font7">
<h2 style="font-size: 1.2em; color: #000000;" align="left"><strong>Datos del Estudiante</strong></h2>
                  <form method="POST" action="{{ route('enviar_solicitud_practicas') }}">

                        @csrf

<div class="form-row">
  <div class="form-group col-md-2">
      <label for="matricula" >{{ __('* Matricula') }}</label>
          <input id="matricula" maxlength="12" type="tel" value="{{$u->matricula}}" class="form-control @error('matricula') is-invalid @enderror" onkeypress="return numeros (event)" name="matricula"  autocomplete="matricula" autofocus required disabled>
          @error('matricula')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
  </div>

  <div class="form-group col-md-1" id="labels">
    <label for="semestre">Semestre</label>
    <input type="tel" name="semestre" value="{{$u->semestre}}" class="form-control" id="semestre" value="" disabled>
  </div>

  <div class="form-group col-md-1">
      <label for="grupo" >{{ __('Grupo') }}</label>
      <input id="grupo" type="tel" value="<?php if(empty($u->grupo)){ $vacio=null; echo $vacio;} else{ echo $u->grupo;} ?>" maxlength="2" class="form-control @error('grupo') is-invalid @enderror" onkeypress="return numeros (event)" name="grupo" autocomplete="grupo" required autofocus disabled>
          @error('grupo')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
          @enderror
  </div>

  <div class="form-group col-md-5">
    <label for="carrera" >{{ __('Carrera') }}</label>
    <input id="carrera" type="text" disabled value="<?php if(empty($carreras->carrera)){ $vacio=null; echo $vacio;} else{ echo $carreras->carrera;} ?>"  onKeyUp="this.value = this.value.toUpperCase()"  class="form-control @error('carrera') is-invalid @enderror" name="carrera"  required autocomplete="carrera">
          @error('carrera')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
      </span>
        @enderror
  </div>

  <div class="form-group col-md-3" id="labels">
    <label for="modalidad">Modalidad</label>
    <input type="text" name="modalidad" value="{{$u->modalidad}}" class="form-control" id="modalidad" value="" disabled>
  </div>
</div>

<div class="form-row">
<div class="form-group col-md-5">
    <label for="nombre" >{{ __('Nombre del Estudiante') }}</label>
    <input id="nombre" type="text"disabled  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{$u->nombre}} {{$u->apellido_paterno}} {{$u->apellido_materno}}" required autocomplete="nombre">
          @error('nombre')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
      </span>
        @enderror
</div>

<div class="form-group col-md-4">
    <label for="curp" >{{ __('CURP') }}</label>
          <input id="curp" type="text"  minlength="18" maxlength="18" onKeyUp="this.value = this.value.toUpperCase()" disabled class="form-control @error('curp') is-invalid @enderror" name="curp" value="<?php if(empty($u->curp)){ $vacio=null; echo $vacio;} else{ echo $u->curp;} ?>" required autocomplete="curp">
        @error('curp')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
</div>

<div class="form-group col-md-3">
    <label for="edad" >{{ __('* Edad') }}</label>
        <input id="edad" type="tel"  value="<?php if(empty($u->edad)){ $vacio=null; echo $vacio;} else{ echo $u->edad;} ?>" disabled maxlength="2"  value="{{$u->edad}}" class="form-control @error('edad') is-invalid @enderror" onkeypress="return numeros (event)" name="edad" autocomplete="edad" required autofocus>
        @error('edad')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
</div>
</div>

<div class="form-row">

<div class="form-group col-md-12">
      <label for="direccion_actual" >{{ __('Dirección Actual') }}</label>
      <textarea id="direccion_actual" disabled  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('direccion_actual') is-invalid @enderror" name="direccion_actual"  required autocomplete="nombre"><?php if(empty($d->vialidad_principal)){ $vacio=null; echo $vacio;} else {echo "CALLE: ".$d->vialidad_principal." #".$d->num_exterior.", C.P: ".$d->cp.", COLONIA: ".$d->localidad." MUNICIPIO: ".$d->municipio." CIUDAD: ".$d->entidad_federativa;}?> </textarea>
            @error('direccion_actual')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
        </span>
          @enderror
</div>
</div>


<div class="form-row">
  <div class="form-group col-md-2">
    <label for="tel_celular">* Teléfono Celular</label>
    <input type="text"  class="form-control" disabled value="<?php if(empty($cel->numero)){ $vacio=null; echo $vacio;} else{ echo $cel->numero;} ?>"  id="tel_celular"  >
  </div>

  <div class="form-group col-md-4">
      <label for="email" >{{ __('Correo') }}</label>
          <input id="email" disabled type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">
          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
  </div>

  <div class="form-group col-md-2">
    <label for="egresado">Egresado</label>
      <select name="egresado" id="egresado" required class="form-control">
    <option value="">Seleccione una opción</option>
    <option value="1">SI</option>
    <option value="0">NO</option>

  </select>
  </div>
  <div class="form-group col-md-4">
      <label for="fecha_ingreso" >{{ __(' Fecha de Ingreso a la Facultad de Idiomas') }}</label>
            <input id="fecha_ingreso"  type="date"  value="<?php if(empty($u->fecha_ingreso)){ $vacio=null; echo $vacio;} else{ echo $u->fecha_ingreso;} ?>"  class="form-control" name="fecha_ingreso" required >
          @error('fecha_ingreso')
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
  <label for="institucion" >{{ __('Nombre del la Institución o Dependencia donde Realizará Prácticas Profesionales:') }}</label>
    <input id="institucion" type="text" value="<?php if(empty($dependencia_p->nombre_dependencia)){ $vacio=null; echo $vacio;} else{ echo $dependencia_p->nombre_dependencia;} ?>"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('institucion') is-invalid @enderror" name="institucion" required autocomplete="institucion">
        @error('institucion')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
      @enderror
  </div>
</div>
<label for="responsable" ><strong>{{ __('Información del Titular de la Dependencia(A quien va dirigido el oficio de Presentación)') }}</strong></label>

<div class="form-row">
<div class="form-group col-md-3">
   <label for="nombre_titular" >{{ __('* Nombre(s)') }}</label>
       <input id="nombre_titular" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre_titular') is-invalid @enderror" name="nombre_titular" value="<?php if(empty($dependencia_p->nombre)){ $vacio=null; echo $vacio;} else{ echo $dependencia_p->nombre;} ?>"required autocomplete="nombre_titular">
       @error('nombre_titular')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
     @enderror
</div>

<div class="form-group col-md-3">
   <label for="apellido_paterno" >{{ __('* Apellido Paterno') }}</label>
         <input id="apellido_paterno_titular" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('apellido_paterno_titular') is-invalid @enderror" name="apellido_paterno_titular" value="<?php if(empty($dependencia_p->apellido_paterno)){ $vacio=null; echo $vacio;} else{ echo $dependencia_p->apellido_paterno;} ?>"required autocomplete="apellido_paterno_titular">
       @error('apellido_paterno')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
       @enderror
</div>

<div class="form-group col-md-3">
   <label for="apellido_materno" >{{ __('Apellido Materno') }}</label>
         <input id="apellido_materno_titular"  onKeyUp="this.value = this.value.toUpperCase()"  type="text" class="form-control @error('apellido_materno_titular') is-invalid @enderror" name="apellido_materno_titular" value="<?php if(empty($dependencia_p->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $dependencia_p->apellido_materno;} ?>" autocomplete="apellido_materno_titular">
       @error('apellido_materno')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
       @enderror
</div>

<div class="form-group col-md-3">
      <label for="cargo_responsable" >{{ __('Cargo del Titular') }}</label>
        <input id="cargo_responsable" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('cargo_responsable') is-invalid @enderror" name="cargo_responsable" value="<?php if(empty($dependencia_p->cargo_titular)){ $vacio=null; echo $vacio;} else{ echo $dependencia_p->cargo_titular;} ?>" required autocomplete="cargo_responsable">
            @error('cargo_responsable')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
          @enderror
      </div>
</div>

<label for="responsable" ><strong>{{ __('Dirección de la Institución o dependencia') }}</strong> </label>
<div class="form-row">
  <div class="form-group col-md-5">
    <label for="calle_p"  align="left">* Calle</label>
    <input type="text" class="form-control"  value="<?php if(empty($datos_practicas->vialidad_principal)){ $vacio=null; echo $vacio;} else{ echo $datos_practicas->vialidad_principal;} ?>" id="calle_p" name="calle_p" placeholder="Calle" onKeyUp="this.value = this.value.toUpperCase();" required>
  </div>
  <div class="form-group col-md-2">
    <label for="numero_p"  >* Número</label>
    <input type="text" maxlength="10" class="form-control" value="<?php if(empty($datos_practicas->num_exterior)){ $vacio=null; echo $vacio;} else{ echo $datos_practicas->num_exterior;} ?>"  id="numero_p" name="numero_p" placeholder="Número" onKeyUp="this.value = this.value.toUpperCase();" required>
  </div>
  <div class="form-group col-md-5">
    <label for="colonia_p" >*Colonia</label>
    <input type="text" class="form-control" id="colonia" value="<?php if(empty($datos_practicas->localidad)){ $vacio=null; echo $vacio;} else{ echo $datos_practicas->localidad;} ?>" name="colonia_p" placeholder="Colonia" onKeyUp="this.value = this.value.toUpperCase();" required >
  </div>
  <div class="form-group col-md-3">
    <label for="codigo_postal">* Código Postal</label>
    <input type="text" onkeypress="return numeros (event)" class="form-control" maxlength="5" id="codigo_postal" value="<?php if(empty($datos_practicas->cp)){ $vacio=null; echo $vacio;} else{ echo $datos_practicas->cp;} ?>"name="codigo_postal" placeholder="Código Postal" onKeyUp="this.value = this.value.toUpperCase();" required>
  </div>
  <div class="form-group col-md-5">
    <label for="ciudad">* Municipio</label>
    <input type="text" class="form-control" id="ciudad" value="<?php if(empty($datos_practicas->municipio)){ $vacio=null; echo $vacio;} else{ echo $datos_practicas->municipio;} ?>"disabled name="ciudad" placeholder="Ciudad" onKeyUp="this.value = this.value.toUpperCase();" required>
  </div>
</div>

<div class="form-row">

  <div class="form-group col-md-4">
    <label for="telefono">* Teléfono de la Institución o Dependencia</label>
  <input type="tel"  class="form-control" name="telefono" id="tel_celular" maxlength="10"  value="<?php if(empty($cel_dep->numero)){ $vacio=null; echo $vacio;} else{ echo $cel_dep->numero;} ?>" onkeypress="return numeros (event)"  placeholder="Formato a 10 digitos"  pattern="([0-9]{3})([0-9]{7})" required>
  </div>

</div>

  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="duracion">Periodo</label>
        <select name="duracion" id="duracion" required class="form-control">
      <option value="">Seleccione una opción</option>
      <option value="3 meses">3 MESES</option>
      <option value="6 meses">6 MESES</option>

    </select>
    </div>
    <div class="form-group col-md-3">
      <label for="periodo_va">Periodo agregado</label>
      <input type="text" disabled class="form-control"  value="<?php if(empty($datos_practicas->periodo_practicas)){ $vacio=null; echo $vacio;} else{ echo $datos_practicas->periodo_practicas;} ?>">
    </div>

    <div class="form-group col-md-4">
        <label for="fecha" >{{ __('Fecha de Realización de la Solicitud') }}</label>
              <input id="fecha" type="date" value="<?php if(empty($dependencia_p->fecha)){ echo date("Y-m-d");} else{ echo $dependencia_p->fecha;}?>" disabled class="form-control @error('fecha') is-invalid @enderror" name="fecha" required>
            @error('fecha')
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
