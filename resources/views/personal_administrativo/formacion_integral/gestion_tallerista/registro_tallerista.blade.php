<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Registro Tallerista
@endsection

@section('seccion')
 @include('flash-message')
<h1 style="font-size: 2.0em; color: #000000;" align="center"> Registro de Tallerista</h1>
<div class="container" id="font7">
</br>                    <form method="POST" action="{{ route('registrar_talleristas') }}">
                        @csrf
<div class="form-row">
  <div class="form-group col-md-3">
      <label for="id_persona">* Tutor</label>
          <select name="id_persona" id="id_persona" required class="form-control @error('id_persona') is-invalid @enderror" value="{{ old('id_persona') }}" required autocomplete="id_persona" autofocus>
      <option value="">Seleccione Tutor</option>
      @foreach ($taller as $talleres)
      <option value="{!! $talleres->id_persona!!}">{!! $talleres->nombre !!} {!! $talleres->apellido_paterno !!} {!! $talleres->apellido_materno !!}</option>
        @endforeach
      </select>
        @error('id_persona')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
  </div>
  <div class="form-group col-md-3">
    <label for="username" >{{ __('Nombre de Usuario') }}</label>
        <input id="username" type="text"  class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
        @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
</div>

<div class="form-group col-md-3">
    <label for="password" >{{ __('Contraseña') }}</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
         <i class="fas fa-eye" type="button" onclick="mostrarContrasena()"></i>
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
</div>

<div class="form-group col-md-3">
    <label for="email" >{{ __('Correo Electrónico') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
</div>
</div>


                        <div class="form-group">
                            <div class="col-xs-offset-2 col-xs-9" align="center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrar') }}
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

<script>
  function mostrarContrasena(){
      var tipo = document.getElementById("password");
      if(tipo.type == "password"){
          tipo.type = "text";
		  $('.fas').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		  
      }else{
          tipo.type = "password";
		  $('.fas').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
      }
  }
</script>