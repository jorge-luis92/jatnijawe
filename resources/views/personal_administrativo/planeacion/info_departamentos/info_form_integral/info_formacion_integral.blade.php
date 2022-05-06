<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_planeacion')
@section('title')
: Información Formación Integral
  @endsection
 @section('seccion')



 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de estudiantes que se encuentran cursando Talleres</h1>
 <div class="container" id="font4">
 </br>                    <form  method="post" action="{{ route('info_formacion_integral') }}">
                         @csrf


  <div class="table-responsive">
  <table class="table table-bordered table-info" style="color: #000000;" >
<thead>
  <tr>
    <th scope="col">MATRICULA</th>
    <th scope="col">NOMBRE</th>
    <th scope="col">SEMESTRE</th>
    <th scope="col">TALLER</th>
    <th scope="col">MODALIDAD</th>
  </tr>
</thead>
<tbody>
    <tr>
 <th scope="row">13161458</th>
 <th scope="row">CITLALI AMAIRANI MARTINEZ CAYETANO</th>
 <th scope="row">3</th>
 <th scope="row">LENGUAS INDIGENAS II</th>
 <th scope="row">SEMIESCOLARIZADO</th>
    </tr>

</tbody>
  </table>
    </div>
  </form>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

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
