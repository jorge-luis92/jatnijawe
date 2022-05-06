@extends('layouts.plantilla_planeacion')
@section('title')
:Carrera
@endsection
@section('seccion')
<h1 style="font-size: 2.0em; color: #000000;" align="center">Identificación de la Carrera</h1>
<div class="container" id="font7">
</br>                    <form method="POST" action="{{ route('agregar_carrera') }}">
                        @csrf
                        <p style="font-size: 1.0em; color: #000000;"> Los Campos con un * son Obligatorios</p>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <h6 align="left">Datos de la Escuela</h6>
                              </div>
                     </div>
   <div class="form-row">
     <div class="form-group col-md-3">
        <label for="clave_institucion" >{{ __('Clave de la Institución') }}</label>
        <input id="clave_institucion" disabled type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('clave_institucion') is-invalid @enderror" name="clave_institucion" value="<?php if(empty($datos_escuela->clave_institucion)){ $vacio=null; echo $vacio;} else{ echo $datos_escuela->clave_institucion;} ?>"  required autocomplete="clave_institucion">
                                @error('clave_institucion')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
                              @enderror
      </div>

      <div class="form-group col-md-3">
        <label for="clave_escuela" >{{ __('Clave de la escuela ') }}</label>
        <input id="clave_escuela" disabled type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('clave_escuela') is-invalid @enderror" name="clave_escuela" value="<?php if(empty($datos_escuela->clave_escuela)){ $vacio=null; echo $vacio;} else{ echo $datos_escuela->clave_escuela;} ?>" required autocomplete="clave_escuela">
                                    @error('clave_escuela')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
                                    @enderror
      </div>

      <div class="form-group col-md-6">
         <label for="nombre_institucion" >{{ __('Nombre de la Escuela a la que pertenece') }}</label>
         <input id="nombre_institucion" disabled type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre_institucion') is-invalid @enderror" name="nombre_institucion" value="<?php if(empty($datos_escuela->institucion_pertenciente)){ $vacio=null; echo $vacio;} else{ echo $datos_escuela->institucion_pertenciente;} ?>" required autocomplete="nombre_institucion">
                                 @error('nombre_institucion')
         <span class="invalid-feedback" role="alert">
                 <strong>{{ $message }}</strong>
         </span>
                               @enderror
       </div>

</div>

  <div class="form-row">
    <div class="form-group col-md-12">
      <h6 align="left">Datos de la Carrera</h6>
        </div>
</div>
<div class="form-row">
  <div class="form-group col-md-5">
    <label for="clave_carrera" >{{ __('*Clave de la Carrera ') }}</label>
    <input id="clave_carrera" autofocus type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('clave_carrera') is-invalid @enderror" name="clave_carrera" value="" required autocomplete="clave_carrera">
                                @error('clave_carrera')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
                                @enderror
  </div>
    <div class="form-group col-md-7">
       <label for="facultad" >{{ __('Nombre de la Facultad') }}</label>
       <input id="facultad" type="text" value="FACULTAD DE IDIOMAS" disabled onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('facultad') is-invalid @enderror" name="facultad" value="" required autocomplete="facultad">
                               @error('facultad')
       <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
       </span>
                             @enderror
     </div>
</div>
<div class="form-row">
    <div class="form-group col-md-8">
       <label for="carrera" >{{ __('*Nombre de la Carrera') }}</label>
       <input id="carrera"  type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('carrera') is-invalid @enderror" name="carrera" value=""   required autocomplete="carrera">
                               @error('carrera')
       <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
       </span>
                             @enderror
     </div>
     <div class="form-group col-md-4">
         <label for="modalidad">* Modalidad</label>
         <select name="modalidad" id="modalidad" required class="form-control">
         <option value="">Seleccione una opción</option>
         <option value="ESCOLARIZADA">ESCOLARIZADO</option>
         <option value="SEMI ESCOLARIZADA">SEMIESCOLARIZADO</option>
         <option value="MIXTA">MIXTA</option>
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
