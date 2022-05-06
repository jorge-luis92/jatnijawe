<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
: Mis Grupos
@endsection
@section('seccion')
<h1 style="font-size: 2.0em; color: #000000;" align="center"> Estudiantes Asignados </h1>
<div class="container" id="font4">
</br>  <form  method="post" action="{{ route('grupo_auxadm') }}">
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
    <th scope="col">MATRICULA</th>
    <th scope="col">NOMBRE</th>
    <th scope="col">SEMESTRE</th>
    <th scope="col">GRUPO</th>
    <th scope="col">ESTATUS</th>
    <th colspan="2" >ACCIONES</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <th scope="row">238957</th>
    <th scope="row">KAREN CRUZ NUÑEZ</th>
    <th scope="row">8</th>
    <th scope="row">D</th>
    <th scope="row">REGULAR</th>
    <td>  <a  href="{{ route ('datos_estudiantes')}}">VER DATOS</a></td>
    </tr>

    </tbody>
    </table>
    </div>
    </form>
    </div>

</div>

  @endsection






<script language="JavaScript">
    function checar(){
        $(".inputText").removeAttr("disabled");
    }

    function nochecar(){
        $(".inputText").attr("disabled","disabled");
    }
</script>

<script language="JavaScript">
    function checar_beca(){
        $(".inputBeca").removeAttr("disabled");
    }

    function nochecar_beca(){
        $(".inputBeca").attr("disabled","disabled");
    }
</script>
