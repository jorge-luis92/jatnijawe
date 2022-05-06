<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_planeacion')
@section('title')
: 911.9A
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('reporte911_9A_2') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">

<table class="table table-bordered table-info" style="color: #8181F7;" >

  <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ALUMNOS DE PRIMER INGRESO SEGÚN EL LUGAR DONDE ESTUDIARON EL BACHILLERATO</strong></h4>
  <h5 style="font-size: 1.0em; color: #000000;" align="rigt">En el país</h5>
  <tr>
    <th scope="row">Estado de la República</th>
    <th scope="row">Total</th>
  </tr>
  <tr>
    <td bgcolor="white"> </td>
    <td bgcolor="white"> </td>

  </tr>

  </table>

  <table class="table table-bordered table-info" style="color: #8181F7;" >
  <h5 style="font-size: 1.0em; color: #000000;" align="rigt">Fuera de México</h5>

<tr>
    <th scope="col" WIDTH="50%">Estados Unidos</th>
    <td bgcolor="white"> </td>
</tr>
  <tr>
    <th scope="col">Canadá</th>
    <td bgcolor="white"> </td>
  </tr>
  <tr>
    <th scope="col">Centro América y el Caribe</th>
    <td bgcolor="white"> </td>
  </tr>
  <tr>
    <th scope="col">Sudámerica</th>
    <td bgcolor="white"> </td>
  </tr>

  <tr>
    <th scope="col">África</th>
    <td bgcolor="white"> </td>
  </tr>

  <tr>
    <th scope="col">Asia</th>
    <td bgcolor="white"> </td>
  </tr>
  <tr>
    <th scope="col">Europa</th>
    <td bgcolor="white"> </td>
  </tr>
  <tr>
    <th scope="col">Oceanía</th>
    <td bgcolor="white"> </td>
  </tr>
  <tr>
    <th scope="col">Oceanía</th>
    <td bgcolor="white"> </td>
  </tr>
  <tr>
    <th scope="col">Total</th>
    <td bgcolor="white"> </td>
  </tr>
  </table>

  <table class="table table-bordered table-info" style="color: #8181F7;" >
    <th scope="col">Total General</th>
    <td bgcolor="white"> </td>
  </tr>
  </table>



  <table class="table table-bordered table-info" style="color: #8181F7;" >

  <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>NÚMERO DE ALUMNOS DE PRIMER INGRESO A LA CARRERA SEGÚN SU LUGAR DE NACIMIENTO</strong></h4>

    <tr>
      <th scope="row">Lugar de Nacimiento</th>
      <th scope="row">Total</th>
    </tr>
    <tr>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>

    </tr>

    </table>
<a> Páginas</a>
    <a class="siguiente" align="rigth" href={{ route('reporte911_9A_0')}}>1</a>
    <a class="siguiente" align="rigth" href={{ route('reporte911_9A_1')}}>2</a>
    <a class="siguiente" align="rigth" href={{ route('reporte911_9A_2')}}><strong>3</strong></a>
    <a class="siguiente" align="rigth" href={{ route('reporte911_9A_3')}}>4</a>
    <a class="siguiente" align="rigth" href={{ route('reporte911_9A_4')}}>5</a>
    <a class="siguiente" align="rigth" href={{ route('reporte911_9A_5')}}>6</a>
    <a class="siguiente" align="rigth" href={{ route('reporte911_9A_6')}}>7</a>

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
