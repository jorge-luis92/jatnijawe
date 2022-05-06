<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
:Grupos Asignados
@endsection
@section('seccion')
</br>
<h1 style="font-size: 2.0em; color: #000000;" align="center"> Mis Grupos Asignados</h1>
<div class="container" id="font4">
</br>     <form  method="post" action="{{ route('talleres_tallerista') }}">
                        @csrf

         <div class="form-row">

             <div class="form-group col-md-4">
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

<br>
                 <div class="form-group">
                 <div class="col-xs-offset-1 col-xs-8" align="">
                 <button type="submit" class="btn btn-primary">
                 {{ __('Buscar') }}
                 </button>
                 </div>
                 </div>

         <div class="table-responsive">
         <table class="table table-bordered table-info" style="color: #000000;" >
         <thead>
         <tr>
           <th scope="col">GRUPO</th>
           <th scope="col">SEMESTRE</th>
           <th colspan="1" >ACCIONES</th>

         </tr>
         </thead>
         <tbody>
         <tr>
           <th scope="row">D</th>
           <th scope="row">8</th>
           <td>  <a  href="{{ route ('grupo_auxadm')}}">VER GRUPO</a></td>
           </tr>

         </tbody>
         </table>
         </div>
         </form>
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
