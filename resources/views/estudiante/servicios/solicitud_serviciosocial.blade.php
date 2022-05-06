<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_estudiante')
@section('title')
: Datos de Servicio
@endsection

@section('seccion')
 @include('flash-message')
<h1 style="font-size: 2.0em; color: #000000;" align="center"> Datos de Servicio Social </h1>
<div class="container" id="font7">
  <h2 style="font-size: 1.2em; color: #000000;" align="left"><strong>Datos del Estudiante</strong></h2>
                  <form method="POST" action="{{ route('enviar_solicitud_servicio') }}">

                        @csrf

<div class="form-row">

  <div class="form-group col-md-2">
      <label for="matricula" >{{ __('Matricula') }}</label>
          <input id="matricula" maxlength="12" type="tel" value="{{$u->matricula}}" class="form-control @error('matricula') is-invalid @enderror" onkeypress="return numeros (event)" name="matricula"  autocomplete="matricula" autofocus required disabled>
          @error('matricula')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
  </div>
  <div class="form-group col-md-3" id="labels">
    <label for="estatus">Estatus</label>
    <input type="text" class="form-control" id="estatus" value="{{$u->estatus}}"disabled>
  </div>
  <div class="form-group col-md-2" id="labels">
    <label for="semestre">Semestre</label>
    <input type="tel" class="form-control" id="semestre" value="{{$u->semestre}}" disabled>
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

</div>

<div class="form-row">
  <div class="form-group col-md-12">
    <label for="facultad" >{{ __('Facultad') }}</label>
    <input id="facultad" type="text" disabled onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('facultad') is-invalid @enderror" name="facultad" value="FACULTAD DE IDIOMAS" required autocomplete="facultad">
          @error('facultad')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
      </span>
        @enderror
  </div>
</div>

<div class="form-row">
  <div class="form-group col-md-6">
      <label for="nombre" >{{ __('Nombre del Estudiante') }}</label>
      <input id="nombre" type="text"disabled  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{$u->nombre}} {{$u->apellido_paterno}} {{$u->apellido_materno}}" required autocomplete="nombre">
            @error('nombre')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
        </span>
          @enderror
  </div>

  <div class="form-group col-md-3">
      <label for="curp" >{{ __('CURP') }}</label>
            <input id="curp" type="text"  minlength="18" maxlength="18" onKeyUp="this.value = this.value.toUpperCase()" disabled class="form-control @error('curp') is-invalid @enderror" name="curp" value="{{ $u->curp}}" required autocomplete="curp">
          @error('curp')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
  </div>

  <div class="form-group col-md-3">
      <label for="edad" >{{ __('Edad') }}</label>
          <input id="edad" type="tel" disabled maxlength="2"  value="{{$u->edad}}" class="form-control @error('edad') is-invalid @enderror" onkeypress="return numeros (event)" name="edad" autocomplete="edad" required autofocus>
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
  <div class="form-group col-md-3">
    <label for="tel_celular">Teléfono Celular</label>
    <input type="text"  class="form-control" value="<?php if(empty($cel->numero)){ $vacio=null; echo $vacio;} else{ echo $cel->numero;} ?>" disabled  id="tel_celular" maxlength="10">
  </div>

  <div class="form-group col-md-3">
      <label for="email" >{{ __('Correo') }}</label>
          <input id="email" disabled type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">
          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
  </div>
     

  <div class="form-group col-md-3">
      <label for="fecha_ingreso" >{{ __(' Fecha de Ingreso') }}</label>
            <input id="fecha_ingreso" type="date" class="form-control" value="{{$u->fecha_ingreso}}"  disabled name="fecha_ingreso" required autocomplete="fecha_ingreso">
          @error('fecha_ingreso')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
  </div>
   
  <div class="form-group col-md-3">
      <label for="avance" >{{ __('Porcentaje de Avance') }}</label>
          <input id="avance" type="text" onkeypress="return numeros (event)" required value="<?php if(empty($datos_practicas->procentaje_avance)){ $vacio=null; echo $vacio;} else{ echo $datos_practicas->procentaje_avance;} ?>" maxlength="3" placeholder="Ejemplo: 90" class="form-control @error('avance') is-invalid @enderror"  name="avance" autocomplete="avance" >
          @error('avance')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
  </div>
</div>
                         

<hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
<h3 style="font-size: 1.2em; color: #000000;" align="left"><strong>Datos de la Empresa</strong></h3>


<div class="form-group col-md-12">
  <label for="institucion">{{ __('Nombre del la Institución o Dependencia donde Realiza Servicio Social:') }}</label>
   <textarea id="institucion" maxlength="100" rows="1" style="resize: both;"  class="form-control" name="institucion"  onKeyUp="this.value = this.value.toUpperCase()" required > <?php if(empty($dependencia_p->nombre_dependencia)){ $vacio=null; echo $vacio;} else{ echo $dependencia_p->nombre_dependencia;} ?></textarea>
  </div>

<label for="responsable" ><strong>{{ __('Información del Titular de la Dependencia(A quien fue dirigido el oficio de Presentación)') }}</strong></label>

<div class="form-row">
<div class="form-group col-md-4">
   <label for="nombre_titular" >{{ __('* Nombre(s)') }}</label>
       <input id="nombre_titular" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre_titular') is-invalid @enderror" name="nombre_titular" value="<?php if(empty($dependencia_p->nombre)){ $vacio=null; echo $vacio;} else{ echo $dependencia_p->nombre;} ?>"required autocomplete="nombre_titular">
       @error('nombre_titular')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
     @enderror
</div>

<div class="form-group col-md-4">
   <label for="apellido_paterno" >{{ __('* Apellido Paterno') }}</label>
         <input id="apellido_paterno_titular" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('apellido_paterno_titular') is-invalid @enderror" name="apellido_paterno_titular" value="<?php if(empty($dependencia_p->apellido_paterno)){ $vacio=null; echo $vacio;} else{ echo $dependencia_p->apellido_paterno;} ?>"required autocomplete="apellido_paterno_titular">
       @error('apellido_paterno')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
       @enderror
</div>

<div class="form-group col-md-4">
   <label for="apellido_materno" >{{ __('Apellido Materno') }}</label>
         <input id="apellido_materno_titular"  onKeyUp="this.value = this.value.toUpperCase()"  type="text" class="form-control @error('apellido_materno_titular') is-invalid @enderror" name="apellido_materno_titular" value="<?php if(empty($dependencia_p->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $dependencia_p->apellido_materno;} ?>" autocomplete="apellido_materno_titular">
       @error('apellido_materno')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
       @enderror
</div>

<div class="form-group col-md-8">
      <label for="cargo_responsable" >{{ __('Cargo del Titular') }}</label>
        <input id="cargo_responsable" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('cargo_responsable') is-invalid @enderror" name="cargo_responsable" value="<?php if(empty($dependencia_p->cargo_titular)){ $vacio=null; echo $vacio;} else{ echo $dependencia_p->cargo_titular;} ?>" required autocomplete="cargo_responsable">
            @error('cargo_responsable')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
          @enderror
      </div>
      <div class="form-group col-md-4">
          <label for="fecha" >{{ __('Fecha de Realización de la carga de Datos') }}</label>
                <input id="fecha" type="date" value="<?php echo date("Y-m-d");?>" disabled class="form-control @error('fecha') is-invalid @enderror" name="fecha" required>
              @error('fecha')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
      </div>


                       <div class="form-group">
                           <div class="col-xs-offset-2 col-xs-9" align="center">
                               <button type="submit" class="btn btn-primary">
                                   {{ __('Cargar datos') }}
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
