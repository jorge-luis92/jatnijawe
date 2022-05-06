<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
:Datos Estudiante
@endsection
@section('seccion')
<h1 style="font-size: 2.0em; color: #000000;" align="center"> Datos Estudiante</h1>
<div class="container" id="font4">
</br>                    <form method="POST" action="{{ route('datos_estudiantes') }}">
                        @csrf

                         <div class="form-row">

                        <div class="form-group col-md-4">
                            <label for="nombre" >{{ __('* Nombre(s)') }}</label>
                                <input id="nombre" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre">
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                              @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="apellido_paterno" >{{ __('* Apellido Paterno') }}</label>
                                  <input id="apellido_paterno" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('apellido_paterno') is-invalid @enderror" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required autocomplete="apellido_paterno">
                                @error('apellido_paterno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="apellido_materno" >{{ __('Apellido Materno') }}</label>
                                  <input id="apellido_materno"  onKeyUp="this.value = this.value.toUpperCase()"  type="text" class="form-control @error('apellido_materno') is-invalid @enderror" name="apellido_materno" value="{{ old('apellido_materno') }}" autocomplete="apellido_materno">
                                @error('apellido_materno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
</div>
                                <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="curp" >{{ __('* CURP') }}</label>
                                  <input id="curp" type="text" minlength="18" maxlength="18"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('curp') is-invalid @enderror" name="curp" value="{{ old('curp') }}" required autocomplete="curp">
                                @error('curp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group col-md-2">
                            <label for="fecha_nacimiento" >{{ __('* Fecha de nacimiento') }}</label>
                                  <input id="fecha_nacimiento" type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" name="fecha_nacimiento" required>
                                @error('fecha_nacimiento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="lugar_nacimiento" >{{ __('* Lugar de Nacimiento') }}</label>
                                  <input id="lugar_nacimiento"  onKeyUp="this.value = this.value.toUpperCase()" type="text" class="form-control @error('lugar_nacimiento') is-invalid @enderror" name="lugar_nacimiento" value="{{ old('lugar_nacimiento') }}" required autocomplete="lugar_nacimiento">
                                @error('lugar_nacimiento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>


                      </div>

                         <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="edad" >{{ __('* Edad') }}</label>
                                <input id="edad" type="tel" maxlength="2" class="form-control @error('edad') is-invalid @enderror" onkeypress="return numeros (event)" name="edad" autocomplete="edad" required autofocus>
                                @error('edad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group col-md-1">

                        </div>

                        <div class="form-group col-md-3">
                          <label for="genero">* Género</label>
                            <select name="genero" id="genero" required class="form-control">
                          <option value="">Seleccione una opción</option>
                          <option value="MASCULINO">MASCULINO</option>
                          <option value="FEMEMINO">FEMEMINO</option>
                    </select>
                        </div>
                        <div class="form-group col-md-2">

                        </div>

                        <div class="form-group col-md-4">
                          <label for="tipo_sangre">* Tipo de Sangre</label>
                            <select name="tipo_sangre" id="tipo_sangre" required class="form-control" autocomplete="tipo_sangre" autofocus>
                          <option value="">Seleccione una opción</option>
                          <option value="O RH+">0 +(Positivo) u ORh +(Positivo) </option>
                          <option value="O RH-">0 -(Negativo) u ORh -(Negativo)</option>
                          <option value="A RH+">A +(Positivo) ó ARh +(Positivo)</option>
                          <option value="A RH-">A -(Negativo) ó ARh -(Negativo)</option>
                          <option value="B RH+">B +(Positivo) ó BRh +(Positivo)</option>
                          <option value="B RH-">B -(Negativo) u BRh -(Negativo)</option>
                          <option value="AB RH+">AB +(Positivo) ó ABRh +(Positivo)</option>
                          <option value="AB RH-">AB -(Negativo) ó ABRh -(Negativo)</option>
                    </select>
                        </div>
</div>

<hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
</br>
                      <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="matricula" >{{ __('* Matricula') }}</label>
                                <input id="matricula" maxlength="12" type="tel" class="form-control @error('matricula') is-invalid @enderror" onkeypress="return numeros (event)" name="matricula"  autocomplete="matricula" autofocus required>
                                @error('matricula')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group col-md-3">
                          <label for="modalidad">* Modalidad</label>
                            <select name="modalidad" id="modalidad" required class="form-control">
                            <option value="">Seleccione una opción</option>
                            <option value="escolarizada">ESCOLARIZADA</option>
                            <option value="semiescolarizada">SEMIESCOLARIZADA</option>
                                </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="fecha_ingreso" >{{ __('* Fecha Ingreso') }}</label>
                                  <input id="fecha_ingreso" type="date" class="form-control @error('fecha_ingreso') is-invalid @enderror" name="fecha_ingreso" required autocomplete="fecha_ingreso">
                                @error('fecha_ingreso')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group col-md-3">
                          <label for="semestre">* Semestre</label>
                            <select name="semestre" id="semestre" required class="form-control">
                            <option value="">Seleccione una opción</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>

                                </select>
                        </div>

                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-1">
                            <label for="grupo" >{{ __('* Grupo') }}</label>
                                <input id="grupo" type="text" maxlength="1" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('grupo') is-invalid @enderror"  name="grupo" autocomplete="grupo" autofocus>
                                @error('grupo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group col-md-3">
                          <label for="estatus">* Estatus</label>
                            <select name="estatus" id="estatus" required class="form-control">
                          <option value="">Seleccione una opción</option>
                          <option value="regular">REGULAR</option>
                          <option value="irregular">IRREGULAR</option>
                    </select>
                        </div>

                        <div class="form-group col-md-5">
                            <label for="bachillerato_origen" >{{ __('* Bachillerato de Origen') }}</label>
                                <input id="bachillerato_origen" type="text" onKeyUp="this.value = this.value.toUpperCase();" class="form-control @error('bachillerato_origen') is-invalid @enderror"  name="bachillerato_origen" autocomplete="bachillerato_origen" autofocus>
                                @error('bachillerato_origen')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>


                        <div class="form-group col-md-3">
                            <label for="email" >{{ __('Correo') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        </div>

                        <div class="col-xs-offset-2 col-xs-9"align="center">
                        	<button type="submit">
                            <span class="btn btn-primary"></span>
                            &nbsp;{{ __('Verificar') }}</button>
                        	<button type="submit">
                            {{ __('Cancelar') }}&nbsp;
                          <span class="btn btn-primary">
                          </span></button>
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
