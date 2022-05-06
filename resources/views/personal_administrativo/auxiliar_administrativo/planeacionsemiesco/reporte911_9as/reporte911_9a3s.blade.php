<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
: 911.9A
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('reporte911_9A3S') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">


<table class="table table-bordered table-info" style="color: #8181F7;" >

<h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ALUMNOS INSCRITOS POR EDAD Y GRADO DE AVANCE</strong></h4>
  <h5 style="font-size: 1.0em; color: #000000;" align="center"><u>MODALIDAD SEMIESCOLARIZADA</u></h5>
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
          <td bgcolor="white" >{{$tot_m_18_1_S}}</td>
          <td bgcolor="white" >{{$tot_m_18_2_S}}</td>
          <td bgcolor="white" >{{$tot_m_18_3_S}}</td>
          <td bgcolor="white" >{{$tot_m_18_4_S}}</td>
          <td bgcolor="white" >{{$tot_m_18_5_S}}</td>
          <td bgcolor="white" >{{$tot_m_18_6_S}}</td>
          <td bgcolor="white" >{{$tot_m_18_7_S}}</td>
          <td bgcolor="white" >{{$tot_m_18_8_S}}</td>
          <td >{{$tot_m_18_T_S}}</td>
        </tr>

        <tr>
          <td >18 años</td>
          <td bgcolor="white" >{{$tot_18_1_S}}</td>
          <td bgcolor="white" >{{$tot_18_2_S}}</td>
          <td bgcolor="white" >{{$tot_18_3_S}}</td>
          <td bgcolor="white" >{{$tot_18_4_S}}</td>
          <td bgcolor="white" >{{$tot_18_5_S}}</td>
          <td bgcolor="white" >{{$tot_18_6_S}}</td>
          <td bgcolor="white" >{{$tot_18_7_S}}</td>
          <td bgcolor="white" >{{$tot_18_8_S}}</td>
          <td >{{$tot_18_T_S}}</td>
        </tr>
        <tr>
          <tr>
            <td >19 años</td>
            <td bgcolor="white" >{{$tot_19_1_S}}</td>
            <td bgcolor="white" >{{$tot_19_2_S}}</td>
            <td bgcolor="white" >{{$tot_19_3_S}}</td>
            <td bgcolor="white" >{{$tot_19_4_S}}</td>
            <td bgcolor="white" >{{$tot_19_5_S}}</td>
            <td bgcolor="white" >{{$tot_19_6_S}}</td>
            <td bgcolor="white" >{{$tot_19_7_S}}</td>
            <td bgcolor="white" >{{$tot_19_8_S}}</td>
            <td >{{$tot_19_T_S}}</td>
          </tr>
          <tr>
            <td >20 años</td>
            <td bgcolor="white" >{{$tot_20_1_S}}</td>
            <td bgcolor="white" >{{$tot_20_2_S}}</td>
            <td bgcolor="white" >{{$tot_20_3_S}}</td>
            <td bgcolor="white" >{{$tot_20_4_S}}</td>
            <td bgcolor="white" >{{$tot_20_5_S}}</td>
            <td bgcolor="white" >{{$tot_20_6_S}}</td>
            <td bgcolor="white" >{{$tot_20_7_S}}</td>
            <td bgcolor="white" >{{$tot_20_8_S}}</td>
            <td >{{$tot_20_T_S}}</td>
          </tr>
        <tr>
          <td >21 años</td>
          <td bgcolor="white" >{{$tot_21_1_S}}</td>
          <td bgcolor="white" >{{$tot_21_2_S}}</td>
          <td bgcolor="white" >{{$tot_21_3_S}}</td>
          <td bgcolor="white" >{{$tot_21_4_S}}</td>
          <td bgcolor="white" >{{$tot_21_5_S}}</td>
          <td bgcolor="white" >{{$tot_21_6_S}}</td>
          <td bgcolor="white" >{{$tot_21_7_S}}</td>
          <td bgcolor="white" >{{$tot_21_8_S}}</td>
          <td >{{$tot_21_T_S}}</td>
        </tr>
        <tr>
          <td >22 años</td>
          <td bgcolor="white" >{{$tot_22_1_S}}</td>
          <td bgcolor="white" >{{$tot_22_2_S}}</td>
          <td bgcolor="white" >{{$tot_22_3_S}}</td>
          <td bgcolor="white" >{{$tot_22_4_S}}</td>
          <td bgcolor="white" >{{$tot_22_5_S}}</td>
          <td bgcolor="white" >{{$tot_22_6_S}}</td>
          <td bgcolor="white" >{{$tot_22_7_S}}</td>
          <td bgcolor="white" >{{$tot_22_8_S}}</td>
          <td >{{$tot_22_T_S}}</td>
        </tr>
        <tr>
          <td >23 años</td>
          <td bgcolor="white" >{{$tot_23_1_S}}</td>
          <td bgcolor="white" >{{$tot_23_2_S}}</td>
          <td bgcolor="white" >{{$tot_23_3_S}}</td>
          <td bgcolor="white" >{{$tot_23_4_S}}</td>
          <td bgcolor="white" >{{$tot_23_5_S}}</td>
          <td bgcolor="white" >{{$tot_23_6_S}}</td>
          <td bgcolor="white" >{{$tot_23_7_S}}</td>
          <td bgcolor="white" >{{$tot_23_8_S}}</td>
          <td >{{$tot_23_T_S}}</td>
        </tr>
        <tr>
          <td >24 años</td>
          <td bgcolor="white" >{{$tot_24_1_S}}</td>
          <td bgcolor="white" >{{$tot_24_2_S}}</td>
          <td bgcolor="white" >{{$tot_24_3_S}}</td>
          <td bgcolor="white" >{{$tot_24_4_S}}</td>
          <td bgcolor="white" >{{$tot_24_5_S}}</td>
          <td bgcolor="white" >{{$tot_24_6_S}}</td>
          <td bgcolor="white" >{{$tot_24_7_S}}</td>
          <td bgcolor="white" >{{$tot_24_8_S}}</td>
          <td >{{$tot_24_T_S}}</td>
        </tr>
        <tr>
          <td >25 años</td>
          <td bgcolor="white" >{{$tot_25_1_S}}</td>
          <td bgcolor="white" >{{$tot_25_2_S}}</td>
          <td bgcolor="white" >{{$tot_25_3_S}}</td>
          <td bgcolor="white" >{{$tot_25_4_S}}</td>
          <td bgcolor="white" >{{$tot_25_5_S}}</td>
          <td bgcolor="white" >{{$tot_25_6_S}}</td>
          <td bgcolor="white" >{{$tot_25_7_S}}</td>
          <td bgcolor="white" >{{$tot_25_8_S}}</td>
          <td >{{$tot_25_T_S}}</td>
        </tr>
        <tr>
          <td >26 años</td>
          <td bgcolor="white" >{{$tot_26_1_S}}</td>
          <td bgcolor="white" >{{$tot_26_2_S}}</td>
          <td bgcolor="white" >{{$tot_26_3_S}}</td>
          <td bgcolor="white" >{{$tot_26_4_S}}</td>
          <td bgcolor="white" >{{$tot_26_5_S}}</td>
          <td bgcolor="white" >{{$tot_26_6_S}}</td>
          <td bgcolor="white" >{{$tot_26_7_S}}</td>
          <td bgcolor="white" >{{$tot_26_8_S}}</td>
          <td >{{$tot_26_T_S}}</td>
          </tr>
          <tr>
            <td >27 años</td>
            <td bgcolor="white" >{{$tot_27_1_S}}</td>
            <td bgcolor="white" >{{$tot_27_2_S}}</td>
            <td bgcolor="white" >{{$tot_27_3_S}}</td>
            <td bgcolor="white" >{{$tot_27_4_S}}</td>
            <td bgcolor="white" >{{$tot_27_5_S}}</td>
            <td bgcolor="white" >{{$tot_27_6_S}}</td>
            <td bgcolor="white" >{{$tot_27_7_S}}</td>
            <td bgcolor="white" >{{$tot_27_8_S}}</td>
            <td >{{$tot_27_T_S}}</td>
          </tr>
            <tr>
              <td >28 años</td>
              <td bgcolor="white" >{{$tot_28_1_S}}</td>
              <td bgcolor="white" >{{$tot_28_2_S}}</td>
              <td bgcolor="white" >{{$tot_28_3_S}}</td>
              <td bgcolor="white" >{{$tot_28_4_S}}</td>
              <td bgcolor="white" >{{$tot_28_5_S}}</td>
              <td bgcolor="white" >{{$tot_28_6_S}}</td>
              <td bgcolor="white" >{{$tot_28_7_S}}</td>
              <td bgcolor="white" >{{$tot_28_8_S}}</td>
              <td >{{$tot_28_T_S}}</td>
            </tr>
            <tr>
              <td >29 años</td>
              <td bgcolor="white" >{{$tot_29_1_S}}</td>
              <td bgcolor="white" >{{$tot_29_2_S}}</td>
              <td bgcolor="white" >{{$tot_29_3_S}}</td>
              <td bgcolor="white" >{{$tot_29_4_S}}</td>
              <td bgcolor="white" >{{$tot_29_5_S}}</td>
              <td bgcolor="white" >{{$tot_29_6_S}}</td>
              <td bgcolor="white" >{{$tot_29_7_S}}</td>
              <td bgcolor="white" >{{$tot_29_8_S}}</td>
              <td >{{$tot_29_T_S}}</td>
            </tr>
            <tr>
              <td >30 a 34 años</td>
              <td bgcolor="white" >{{$tot_30_1_S}}</td>
              <td bgcolor="white" >{{$tot_30_2_S}}</td>
              <td bgcolor="white" >{{$tot_30_3_S}}</td>
              <td bgcolor="white" >{{$tot_30_4_S}}</td>
              <td bgcolor="white" >{{$tot_30_5_S}}</td>
              <td bgcolor="white" >{{$tot_30_6_S}}</td>
              <td bgcolor="white" >{{$tot_30_7_S}}</td>
              <td bgcolor="white" >{{$tot_30_8_S}}</td>
              <td >{{$tot_30_T_S}}</td>
            </tr>
            <tr>
              <td >35 a 39 años</td>
              <td bgcolor="white" >{{$tot_35_1_S}}</td>
              <td bgcolor="white" >{{$tot_35_2_S}}</td>
              <td bgcolor="white" >{{$tot_35_3_S}}</td>
              <td bgcolor="white" >{{$tot_35_4_S}}</td>
              <td bgcolor="white" >{{$tot_35_5_S}}</td>
              <td bgcolor="white" >{{$tot_35_6_S}}</td>
              <td bgcolor="white" >{{$tot_35_7_S}}</td>
              <td bgcolor="white" >{{$tot_35_8_S}}</td>
              <td >{{$tot_35_T_S}}</td>
            </tr>
            <tr>
              <td >40 años o más</td>
              <td bgcolor="white" >{{$tot_40_1_S}}</td>
              <td bgcolor="white" >{{$tot_40_2_S}}</td>
              <td bgcolor="white" >{{$tot_40_3_S}}</td>
              <td bgcolor="white" >{{$tot_40_4_S}}</td>
              <td bgcolor="white" >{{$tot_40_5_S}}</td>
              <td bgcolor="white" >{{$tot_40_6_S}}</td>
              <td bgcolor="white" >{{$tot_40_7_S}}</td>
              <td bgcolor="white" >{{$tot_40_8_S}}</td>
              <td >{{$tot_40_T_S}}</td>
            </tr>
        <tr>
        <td ><strong>Total</strong></td>
        <td bgcolor="white" >{{$tot_G_1_S}}</td>
        <td bgcolor="white" >{{$tot_G_2_S}}</td>
        <td bgcolor="white" >{{$tot_G_3_S}}</td>
        <td bgcolor="white" >{{$tot_G_4_S}}</td>
        <td bgcolor="white" >{{$tot_G_5_S}}</td>
        <td bgcolor="white" >{{$tot_G_6_S}}</td>
        <td bgcolor="white" >{{$tot_G_7_S}}</td>
        <td bgcolor="white" >{{$tot_G_8_S}}</td>
        <td >{{$tot_G_T_S}}</td>
        </tr>



        </table>
<a> Páginas</a>
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A0S')}}>1</a>
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A1S')}}>2</a>
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A2S')}}>3</a>
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A3S')}}><strong>4</strong></a>

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
