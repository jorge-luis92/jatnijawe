@extends('layouts.plantillaperfil')
@section('title')
: Estudiantes
@endsection

@section('seccion')
<div class="container">
  @include('flash-message')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="opacity: 0.7;filter:alpha(opacity=5);">
                <div class="card-header" align="center">{{ __('Inicio de Sesión') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('login_studiante')}}">
                        @csrf
                        <div class="form-group row">
                            <label for="id_user" class="col-md-4 col-form-label text-md-right" >{{ __('Matrícula') }}</label>

                            <div class="col-md-6">
                                <input id="id_user" type="tel" onkeypress="return numeros (event)" class="form-control @error('id_user') is-invalid @enderror" name="id_user" value="{{ old('id_user') }}" required autocomplete="id_user" autofocus>

                                @error('id_user')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" required >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row mb-0" >
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Ingresar') }}
                                </button>
                                @if (Route::has('password.request'))
                                   <a class="btn btn-link" href="{{ route('password.request') }}">
                                       {{ __('¿Olvidaste tu Contraseña?') }}
                                   </a>
                               @endif
                                    </div>



                        </div>

                      </div>
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
