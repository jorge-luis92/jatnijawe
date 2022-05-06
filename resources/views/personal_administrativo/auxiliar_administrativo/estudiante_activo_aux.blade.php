<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
: Estudiantes Activos
@endsection

@section('seccion')
 @include('flash-message')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Estudiantes Activos</h1>
<div class="container" id="font5">
  </br>
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
</form>
</div>



<div class="table-responsive">
  <table class="table table-bordered table-info" style="color: #000000;" >
    <thead>
      <tr>
        <th scope="col">MATRICULA</th>
        <th scope="col">NOMBRE</th>
        <th colspan="2" >ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      <tr>
             <th scope="row">13161458</th>
             <td>AMI MEOW</td>
             <td>  <a data-toggle="modal" href="#">DETALLES</a></td>
             <td>  <a data-toggle="modal" href="#">DESACTIVAR</a></td>
           </tr>

    </tbody>
  </table>
</div>


</div>


  @endsection
