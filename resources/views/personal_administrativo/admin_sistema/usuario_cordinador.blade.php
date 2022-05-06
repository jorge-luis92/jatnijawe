<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_admin')
@section('title')
: Búsqueda Cordinadores
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Búsqueda de Cordinadores</h1>
 <div class="container" id="font4">
 </br>                    <form method="POST" action="{{ route('usuario_cordinador') }}">
                         @csrf

                          <div class="form-row">

                         </div>

                         <div class="form-group col-md-4">
                             <label for="nombre" >{{ __('') }}</label>
                                 <input id="nombre" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre">
                                 @error('nombre')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                               @enderror
                         </div>


                         <div class="form-group">
                             <div class="col-xs-offset-2 col-xs-9" align="center">
                                 <button type="submit" class="btn btn-primary">
                                     {{ __('Buscar') }}
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



  @endsection
