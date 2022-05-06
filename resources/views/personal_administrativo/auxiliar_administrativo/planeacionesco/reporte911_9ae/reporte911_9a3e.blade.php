<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
: 911.9A
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('reporte911_9A3E') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">


<table class="table table-bordered table-info" style="color: #8181F7;" >

<h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ALUMNOS INSCRITOS POR EDAD Y GRADO DE AVANCE</strong></h4>
  <h5 style="font-size: 1.0em; color: #000000;" align="center"><u>MODALIDAD ESCOLARIZADA</u></h5>
  <h5 style="font-size: 1.0em; color: #000000;" align="center"><u>CU</u></h5>
      <tr>
        <td colspan="10"align="center"><strong>Grado de Avance</strong></td>
     </tr>
        <tr>
          <td ><strong>Edad</strong></td>
          <td bgcolor="white">Primero</td>
          <td bgcolor="white">Segundo</td>
          <td bgcolor="white">Tercero</td>
          <td bgcolor="white">Cuarto</td>
          <td bgcolor="white">Quinto</td>
          <td bgcolor="white">Sexto</td>
          <td bgcolor="white">Séptimo</td>
          <td bgcolor="white">Octavo</td>
          <td ><strong>Total</strong></td>
        </tr>
 <tr>
    <td >Menos de 18 años</td>
    <td bgcolor="white" >{{$tot_m_18_1}}</td>
    <td bgcolor="white" >{{$tot_m_18_2}}</td>
    <td bgcolor="white" >{{$tot_m_18_3}}</td>
    <td bgcolor="white" >{{$tot_m_18_4}}</td>
    <td bgcolor="white" >{{$tot_m_18_5}}</td>
    <td bgcolor="white" >{{$tot_m_18_6}}</td>
    <td bgcolor="white" >{{$tot_m_18_7}}</td>
    <td bgcolor="white" >{{$tot_m_18_8}}</td>
    <td >{{$tot_m_18_T}}</td>
  </tr>

  <tr>
    <td >18 años</td>
    <td bgcolor="white" >{{$tot_18_1}}</td>
    <td bgcolor="white" >{{$tot_18_2}}</td>
    <td bgcolor="white" >{{$tot_18_3}}</td>
    <td bgcolor="white" >{{$tot_18_4}}</td>
    <td bgcolor="white" >{{$tot_18_5}}</td>
    <td bgcolor="white" >{{$tot_18_6}}</td>
    <td bgcolor="white" >{{$tot_18_7}}</td>
    <td bgcolor="white" >{{$tot_18_8}}</td>
    <td >{{$tot_18_T}}</td>
  </tr>
  <tr>
    <td >19 años</td>
    <td bgcolor="white" >{{$tot_19_1}}</td>
    <td bgcolor="white" >{{$tot_19_2}}</td>
    <td bgcolor="white" >{{$tot_19_3}}</td>
    <td bgcolor="white" >{{$tot_19_4}}</td>
    <td bgcolor="white" >{{$tot_19_5}}</td>
    <td bgcolor="white" >{{$tot_19_6}}</td>
    <td bgcolor="white" >{{$tot_19_7}}</td>
    <td bgcolor="white" >{{$tot_19_8}}</td>
    <td >{{$tot_19_T}}</td>
  </tr>
  <tr>
    <td >20 años</td>
    <td bgcolor="white" >{{$tot_20_1}}</td>
    <td bgcolor="white" >{{$tot_20_2}}</td>
    <td bgcolor="white" >{{$tot_20_3}}</td>
    <td bgcolor="white" >{{$tot_20_4}}</td>
    <td bgcolor="white" >{{$tot_20_5}}</td>
    <td bgcolor="white" >{{$tot_20_6}}</td>
    <td bgcolor="white" >{{$tot_20_7}}</td>
    <td bgcolor="white" >{{$tot_20_8}}</td>
    <td >{{$tot_20_T}}</td>
  </tr>
  <tr>
    <td >21 años</td>
    <td bgcolor="white" >{{$tot_21_1}}</td>
    <td bgcolor="white" >{{$tot_21_2}}</td>
    <td bgcolor="white" >{{$tot_21_3}}</td>
    <td bgcolor="white" >{{$tot_21_4}}</td>
    <td bgcolor="white" >{{$tot_21_5}}</td>
    <td bgcolor="white" >{{$tot_21_6}}</td>
    <td bgcolor="white" >{{$tot_21_7}}</td>
    <td bgcolor="white" >{{$tot_21_8}}</td>
    <td >{{$tot_21_T}}</td>
  </tr>
  <tr>
    <td >22 años</td>
    <td bgcolor="white" >{{$tot_22_1}}</td>
    <td bgcolor="white" >{{$tot_22_2}}</td>
    <td bgcolor="white" >{{$tot_22_3}}</td>
    <td bgcolor="white" >{{$tot_22_4}}</td>
    <td bgcolor="white" >{{$tot_22_5}}</td>
    <td bgcolor="white" >{{$tot_22_6}}</td>
    <td bgcolor="white" >{{$tot_22_7}}</td>
    <td bgcolor="white" >{{$tot_22_8}}</td>
    <td >{{$tot_22_T}}</td>
  </tr>
  <tr>
    <td >23 años</td>
    <td bgcolor="white" >{{$tot_23_1}}</td>
    <td bgcolor="white" >{{$tot_23_2}}</td>
    <td bgcolor="white" >{{$tot_23_3}}</td>
    <td bgcolor="white" >{{$tot_23_4}}</td>
    <td bgcolor="white" >{{$tot_23_5}}</td>
    <td bgcolor="white" >{{$tot_23_6}}</td>
    <td bgcolor="white" >{{$tot_23_7}}</td>
    <td bgcolor="white" >{{$tot_23_8}}</td>
    <td >{{$tot_23_T}}</td>
  </tr>
  <tr>
    <td >24 años</td>
    <td bgcolor="white" >{{$tot_24_1}}</td>
    <td bgcolor="white" >{{$tot_24_2}}</td>
    <td bgcolor="white" >{{$tot_24_3}}</td>
    <td bgcolor="white" >{{$tot_24_4}}</td>
    <td bgcolor="white" >{{$tot_24_5}}</td>
    <td bgcolor="white" >{{$tot_24_6}}</td>
    <td bgcolor="white" >{{$tot_24_7}}</td>
    <td bgcolor="white" >{{$tot_24_8}}</td>
    <td >{{$tot_24_T}}</td>
  </tr>
  <tr>
    <td >25 años</td>
    <td bgcolor="white" >{{$tot_25_1}}</td>
    <td bgcolor="white" >{{$tot_25_2}}</td>
    <td bgcolor="white" >{{$tot_25_3}}</td>
    <td bgcolor="white" >{{$tot_25_4}}</td>
    <td bgcolor="white" >{{$tot_25_5}}</td>
    <td bgcolor="white" >{{$tot_25_6}}</td>
    <td bgcolor="white" >{{$tot_25_7}}</td>
    <td bgcolor="white" >{{$tot_25_8}}</td>
    <td >{{$tot_25_T}}</td>
  </tr>
  <tr>
    <td >26 años</td>
    <td bgcolor="white" >{{$tot_26_1}}</td>
    <td bgcolor="white" >{{$tot_26_2}}</td>
    <td bgcolor="white" >{{$tot_26_3}}</td>
    <td bgcolor="white" >{{$tot_26_4}}</td>
    <td bgcolor="white" >{{$tot_26_5}}</td>
    <td bgcolor="white" >{{$tot_26_6}}</td>
    <td bgcolor="white" >{{$tot_26_7}}</td>
    <td bgcolor="white" >{{$tot_26_8}}</td>
    <td >{{$tot_26_T}}</td>
    </tr>
    <tr>
      <td >27 años</td>
      <td bgcolor="white" >{{$tot_27_1}}</td>
      <td bgcolor="white" >{{$tot_27_2}}</td>
      <td bgcolor="white" >{{$tot_27_3}}</td>
      <td bgcolor="white" >{{$tot_27_4}}</td>
      <td bgcolor="white" >{{$tot_27_5}}</td>
      <td bgcolor="white" >{{$tot_27_6}}</td>
      <td bgcolor="white" >{{$tot_27_7}}</td>
      <td bgcolor="white" >{{$tot_27_8}}</td>
      <td >{{$tot_27_T}}</td>
    </tr>
      <tr>
        <td >28 años</td>
        <td bgcolor="white" >{{$tot_28_1}}</td>
        <td bgcolor="white" >{{$tot_28_2}}</td>
        <td bgcolor="white" >{{$tot_28_3}}</td>
        <td bgcolor="white" >{{$tot_28_4}}</td>
        <td bgcolor="white" >{{$tot_28_5}}</td>
        <td bgcolor="white" >{{$tot_28_6}}</td>
        <td bgcolor="white" >{{$tot_28_7}}</td>
        <td bgcolor="white" >{{$tot_28_8}}</td>
        <td >{{$tot_28_T}}</td>
      </tr>
      <tr>
        <td >29 años</td>
        <td bgcolor="white" >{{$tot_29_1}}</td>
        <td bgcolor="white" >{{$tot_29_2}}</td>
        <td bgcolor="white" >{{$tot_29_3}}</td>
        <td bgcolor="white" >{{$tot_29_4}}</td>
        <td bgcolor="white" >{{$tot_29_5}}</td>
        <td bgcolor="white" >{{$tot_29_6}}</td>
        <td bgcolor="white" >{{$tot_29_7}}</td>
        <td bgcolor="white" >{{$tot_29_8}}</td>
        <td >{{$tot_29_T}}</td>
      </tr>
      <tr>
        <td >30 a 34 años</td>
        <td bgcolor="white" >{{$tot_30_1}}</td>
        <td bgcolor="white" >{{$tot_30_2}}</td>
        <td bgcolor="white" >{{$tot_30_3}}</td>
        <td bgcolor="white" >{{$tot_30_4}}</td>
        <td bgcolor="white" >{{$tot_30_5}}</td>
        <td bgcolor="white" >{{$tot_30_6}}</td>
        <td bgcolor="white" >{{$tot_30_7}}</td>
        <td bgcolor="white" >{{$tot_30_8}}</td>
        <td >{{$tot_30_T}}</td>
      </tr>
      <tr>
        <td >35 a 39 años</td>
        <td bgcolor="white" >{{$tot_35_1}}</td>
        <td bgcolor="white" >{{$tot_35_2}}</td>
        <td bgcolor="white" >{{$tot_35_3}}</td>
        <td bgcolor="white" >{{$tot_35_4}}</td>
        <td bgcolor="white" >{{$tot_35_5}}</td>
        <td bgcolor="white" >{{$tot_35_6}}</td>
        <td bgcolor="white" >{{$tot_35_7}}</td>
        <td bgcolor="white" >{{$tot_35_8}}</td>
        <td >{{$tot_35_T}}</td>
      </tr>
      <tr>
        <td >40 años o más</td>
        <td bgcolor="white" >{{$tot_40_1}}</td>
        <td bgcolor="white" >{{$tot_40_2}}</td>
        <td bgcolor="white" >{{$tot_40_3}}</td>
        <td bgcolor="white" >{{$tot_40_4}}</td>
        <td bgcolor="white" >{{$tot_40_5}}</td>
        <td bgcolor="white" >{{$tot_40_6}}</td>
        <td bgcolor="white" >{{$tot_40_7}}</td>
        <td bgcolor="white" >{{$tot_40_8}}</td>
        <td >{{$tot_40_T}}</td>
      </tr>
  <tr>
  <td ><strong>Total</strong></td>
  <td bgcolor="white" >{{$tot_G_1}}</td>
  <td bgcolor="white" >{{$tot_G_2}}</td>
  <td bgcolor="white" >{{$tot_G_3}}</td>
  <td bgcolor="white" >{{$tot_G_4}}</td>
  <td bgcolor="white" >{{$tot_G_5}}</td>
  <td bgcolor="white" >{{$tot_G_6}}</td>
  <td bgcolor="white" >{{$tot_G_7}}</td>
  <td bgcolor="white" >{{$tot_G_8}}</td>
  <td >{{$tot_G_T}}</td>
  </tr>


        </table>
<a> Páginas</a>
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A0E')}}>1</a>
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A1E')}}>2</a>
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A2E')}}>3</a>
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A3E')}}><strong>4</strong></a>

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
