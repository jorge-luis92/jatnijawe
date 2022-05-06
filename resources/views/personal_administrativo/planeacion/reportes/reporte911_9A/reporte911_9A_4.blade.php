<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_planeacion')
@section('title')
: 911.9A
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('reporte911_9A_4') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">


<table class="table table-bordered table-info" style="color: #8181F7;" >

<h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ALUMNOS INSCRITOS POR EDAD Y GRADO DE AVANCE</strong></h4>

<h6 style="font-size: 1.0em; color: #000000;" align="center"><u>MODALIDAD ESCOLARIZADA</u></h6>
<h6 style="font-size: 1.0em; color: #000000;" align="center"><u>CU</u></h6>
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

<table class="table table-bordered table-info" style="color: #8181F7;" >
<h6 style="font-size: 1.0em; color: #000000;" align="center"><u>TEHUANTEPEC</u></h6>
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
          <td bgcolor="white" >{{$tot_m_18_1_T}}</td>
          <td bgcolor="white" >{{$tot_m_18_2_T}}</td>
          <td bgcolor="white" >{{$tot_m_18_3_T}}</td>
          <td bgcolor="white" >{{$tot_m_18_4_T}}</td>
          <td bgcolor="white" >{{$tot_m_18_5_T}}</td>
          <td bgcolor="white" >{{$tot_m_18_6_T}}</td>
          <td bgcolor="white" >{{$tot_m_18_7_T}}</td>
          <td bgcolor="white" >{{$tot_m_18_8_T}}</td>
          <td >{{$tot_m_18_T_T}}</td>
        </tr>

        <tr>
          <td >18 años</td>
          <td bgcolor="white" >{{$tot_18_1_T}}</td>
          <td bgcolor="white" >{{$tot_18_2_T}}</td>
          <td bgcolor="white" >{{$tot_18_3_T}}</td>
          <td bgcolor="white" >{{$tot_18_4_T}}</td>
          <td bgcolor="white" >{{$tot_18_5_T}}</td>
          <td bgcolor="white" >{{$tot_18_6_T}}</td>
          <td bgcolor="white" >{{$tot_18_7_T}}</td>
          <td bgcolor="white" >{{$tot_18_8_T}}</td>
          <td >{{$tot_18_T_T}}</td>
        </tr>
        <tr>
          <tr>
            <td >19 años</td>
            <td bgcolor="white" >{{$tot_19_1_T}}</td>
            <td bgcolor="white" >{{$tot_19_2_T}}</td>
            <td bgcolor="white" >{{$tot_19_3_T}}</td>
            <td bgcolor="white" >{{$tot_19_4_T}}</td>
            <td bgcolor="white" >{{$tot_19_5_T}}</td>
            <td bgcolor="white" >{{$tot_19_6_T}}</td>
            <td bgcolor="white" >{{$tot_19_7_T}}</td>
            <td bgcolor="white" >{{$tot_19_8_T}}</td>
            <td >{{$tot_19_T_T}}</td>
          </tr>
          <tr>
            <td >20 años</td>
            <td bgcolor="white" >{{$tot_20_1_T}}</td>
            <td bgcolor="white" >{{$tot_20_2_T}}</td>
            <td bgcolor="white" >{{$tot_20_3_T}}</td>
            <td bgcolor="white" >{{$tot_20_4_T}}</td>
            <td bgcolor="white" >{{$tot_20_5_T}}</td>
            <td bgcolor="white" >{{$tot_20_6_T}}</td>
            <td bgcolor="white" >{{$tot_20_7_T}}</td>
            <td bgcolor="white" >{{$tot_20_8_T}}</td>
            <td >{{$tot_20_T_T}}</td>
          </tr>
        <tr>
          <td >21 años</td>
          <td bgcolor="white" >{{$tot_21_1_T}}</td>
          <td bgcolor="white" >{{$tot_21_2_T}}</td>
          <td bgcolor="white" >{{$tot_21_3_T}}</td>
          <td bgcolor="white" >{{$tot_21_4_T}}</td>
          <td bgcolor="white" >{{$tot_21_5_T}}</td>
          <td bgcolor="white" >{{$tot_21_6_T}}</td>
          <td bgcolor="white" >{{$tot_21_7_T}}</td>
          <td bgcolor="white" >{{$tot_21_8_T}}</td>
          <td >{{$tot_21_T_T}}</td>
        </tr>
        <tr>
          <td >22 años</td>
          <td bgcolor="white" >{{$tot_22_1_T}}</td>
          <td bgcolor="white" >{{$tot_22_2_T}}</td>
          <td bgcolor="white" >{{$tot_22_3_T}}</td>
          <td bgcolor="white" >{{$tot_22_4_T}}</td>
          <td bgcolor="white" >{{$tot_22_5_T}}</td>
          <td bgcolor="white" >{{$tot_22_6_T}}</td>
          <td bgcolor="white" >{{$tot_22_7_T}}</td>
          <td bgcolor="white" >{{$tot_22_8_T}}</td>
          <td >{{$tot_22_T_T}}</td>
        </tr>
        <tr>
          <td >23 años</td>
          <td bgcolor="white" >{{$tot_23_1_T}}</td>
          <td bgcolor="white" >{{$tot_23_2_T}}</td>
          <td bgcolor="white" >{{$tot_23_3_T}}</td>
          <td bgcolor="white" >{{$tot_23_4_T}}</td>
          <td bgcolor="white" >{{$tot_23_5_T}}</td>
          <td bgcolor="white" >{{$tot_23_6_T}}</td>
          <td bgcolor="white" >{{$tot_23_7_T}}</td>
          <td bgcolor="white" >{{$tot_23_8_T}}</td>
          <td >{{$tot_23_T_T}}</td>
        </tr>
        <tr>
          <td >24 años</td>
          <td bgcolor="white" >{{$tot_24_1_T}}</td>
          <td bgcolor="white" >{{$tot_24_2_T}}</td>
          <td bgcolor="white" >{{$tot_24_3_T}}</td>
          <td bgcolor="white" >{{$tot_24_4_T}}</td>
          <td bgcolor="white" >{{$tot_24_5_T}}</td>
          <td bgcolor="white" >{{$tot_24_6_T}}</td>
          <td bgcolor="white" >{{$tot_24_7_T}}</td>
          <td bgcolor="white" >{{$tot_24_8_T}}</td>
          <td >{{$tot_24_T_T}}</td>
        </tr>
        <tr>
          <td >25 años</td>
          <td bgcolor="white" >{{$tot_25_1_T}}</td>
          <td bgcolor="white" >{{$tot_25_2_T}}</td>
          <td bgcolor="white" >{{$tot_25_3_T}}</td>
          <td bgcolor="white" >{{$tot_25_4_T}}</td>
          <td bgcolor="white" >{{$tot_25_5_T}}</td>
          <td bgcolor="white" >{{$tot_25_6_T}}</td>
          <td bgcolor="white" >{{$tot_25_7_T}}</td>
          <td bgcolor="white" >{{$tot_25_8_T}}</td>
          <td >{{$tot_25_T_T}}</td>
        </tr>
        <tr>
          <td >26 años</td>
          <td bgcolor="white" >{{$tot_26_1_T}}</td>
          <td bgcolor="white" >{{$tot_26_2_T}}</td>
          <td bgcolor="white" >{{$tot_26_3_T}}</td>
          <td bgcolor="white" >{{$tot_26_4_T}}</td>
          <td bgcolor="white" >{{$tot_26_5_T}}</td>
          <td bgcolor="white" >{{$tot_26_6_T}}</td>
          <td bgcolor="white" >{{$tot_26_7_T}}</td>
          <td bgcolor="white" >{{$tot_26_8_T}}</td>
          <td >{{$tot_26_T_T}}</td>
          </tr>
          <tr>
            <td >27 años</td>
            <td bgcolor="white" >{{$tot_27_1_T}}</td>
            <td bgcolor="white" >{{$tot_27_2_T}}</td>
            <td bgcolor="white" >{{$tot_27_3_T}}</td>
            <td bgcolor="white" >{{$tot_27_4_T}}</td>
            <td bgcolor="white" >{{$tot_27_5_T}}</td>
            <td bgcolor="white" >{{$tot_27_6_T}}</td>
            <td bgcolor="white" >{{$tot_27_7_T}}</td>
            <td bgcolor="white" >{{$tot_27_8_T}}</td>
            <td >{{$tot_27_T_T}}</td>
          </tr>
            <tr>
              <td >28 años</td>
              <td bgcolor="white" >{{$tot_28_1_T}}</td>
              <td bgcolor="white" >{{$tot_28_2_T}}</td>
              <td bgcolor="white" >{{$tot_28_3_T}}</td>
              <td bgcolor="white" >{{$tot_28_4_T}}</td>
              <td bgcolor="white" >{{$tot_28_5_T}}</td>
              <td bgcolor="white" >{{$tot_28_6_T}}</td>
              <td bgcolor="white" >{{$tot_28_7_T}}</td>
              <td bgcolor="white" >{{$tot_28_8_T}}</td>
              <td >{{$tot_28_T_T}}</td>
            </tr>
            <tr>
              <td >29 años</td>
              <td bgcolor="white" >{{$tot_29_1_T}}</td>
              <td bgcolor="white" >{{$tot_29_2_T}}</td>
              <td bgcolor="white" >{{$tot_29_3_T}}</td>
              <td bgcolor="white" >{{$tot_29_4_T}}</td>
              <td bgcolor="white" >{{$tot_29_5_T}}</td>
              <td bgcolor="white" >{{$tot_29_6_T}}</td>
              <td bgcolor="white" >{{$tot_29_7_T}}</td>
              <td bgcolor="white" >{{$tot_29_8_T}}</td>
              <td >{{$tot_29_T_T}}</td>
            </tr>
            <tr>
              <td >30 a 34 años</td>
              <td bgcolor="white" >{{$tot_30_1_T}}</td>
              <td bgcolor="white" >{{$tot_30_2_T}}</td>
              <td bgcolor="white" >{{$tot_30_3_T}}</td>
              <td bgcolor="white" >{{$tot_30_4_T}}</td>
              <td bgcolor="white" >{{$tot_30_5_T}}</td>
              <td bgcolor="white" >{{$tot_30_6_T}}</td>
              <td bgcolor="white" >{{$tot_30_7_T}}</td>
              <td bgcolor="white" >{{$tot_30_8_T}}</td>
              <td >{{$tot_30_T_T}}</td>
            </tr>
            <tr>
              <td >35 a 39 años</td>
              <td bgcolor="white" >{{$tot_35_1_T}}</td>
              <td bgcolor="white" >{{$tot_35_2_T}}</td>
              <td bgcolor="white" >{{$tot_35_3_T}}</td>
              <td bgcolor="white" >{{$tot_35_4_T}}</td>
              <td bgcolor="white" >{{$tot_35_5_T}}</td>
              <td bgcolor="white" >{{$tot_35_6_T}}</td>
              <td bgcolor="white" >{{$tot_35_7_T}}</td>
              <td bgcolor="white" >{{$tot_35_8_T}}</td>
              <td >{{$tot_35_T_T}}</td>
            </tr>
            <tr>
              <td >40 años o más</td>
              <td bgcolor="white" >{{$tot_40_1_T}}</td>
              <td bgcolor="white" >{{$tot_40_2_T}}</td>
              <td bgcolor="white" >{{$tot_40_3_T}}</td>
              <td bgcolor="white" >{{$tot_40_4_T}}</td>
              <td bgcolor="white" >{{$tot_40_5_T}}</td>
              <td bgcolor="white" >{{$tot_40_6_T}}</td>
              <td bgcolor="white" >{{$tot_40_7_T}}</td>
              <td bgcolor="white" >{{$tot_40_8_T}}</td>
              <td >{{$tot_40_T_T}}</td>
            </tr>
        <tr>
        <td ><strong>Total</strong></td>
        <td bgcolor="white" >{{$tot_G_1_T}}</td>
        <td bgcolor="white" >{{$tot_G_2_T}}</td>
        <td bgcolor="white" >{{$tot_G_3_T}}</td>
        <td bgcolor="white" >{{$tot_G_4_T}}</td>
        <td bgcolor="white" >{{$tot_G_5_T}}</td>
        <td bgcolor="white" >{{$tot_G_6_T}}</td>
        <td bgcolor="white" >{{$tot_G_7_T}}</td>
        <td bgcolor="white" >{{$tot_G_8_T}}</td>
        <td >{{$tot_G_T_T}}</td>
        </tr>

        </table>

<table class="table table-bordered table-info" style="color: #8181F7;" >
<h6 style="font-size: 1.0em; color: #000000;" align="center"><u>PUERTO ESCONDIDO</u></h6>
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
          <td bgcolor="white" >{{$tot_m_18_1_P}}</td>
          <td bgcolor="white" >{{$tot_m_18_2_P}}</td>
          <td bgcolor="white" >{{$tot_m_18_3_P}}</td>
          <td bgcolor="white" >{{$tot_m_18_4_P}}</td>
          <td bgcolor="white" >{{$tot_m_18_5_P}}</td>
          <td bgcolor="white" >{{$tot_m_18_6_P}}</td>
          <td bgcolor="white" >{{$tot_m_18_7_P}}</td>
          <td bgcolor="white" >{{$tot_m_18_8_P}}</td>
          <td >{{$tot_m_18_T_P}}</td>
        </tr>

        <tr>
          <td >18 años</td>
          <td bgcolor="white" >{{$tot_18_1_P}}</td>
          <td bgcolor="white" >{{$tot_18_2_P}}</td>
          <td bgcolor="white" >{{$tot_18_3_P}}</td>
          <td bgcolor="white" >{{$tot_18_4_P}}</td>
          <td bgcolor="white" >{{$tot_18_5_P}}</td>
          <td bgcolor="white" >{{$tot_18_6_P}}</td>
          <td bgcolor="white" >{{$tot_18_7_P}}</td>
          <td bgcolor="white" >{{$tot_18_8_P}}</td>
          <td >{{$tot_18_T_P}}</td>
        </tr>
        <tr>
          <tr>
            <td >19 años</td>
            <td bgcolor="white" >{{$tot_19_1_P}}</td>
            <td bgcolor="white" >{{$tot_19_2_P}}</td>
            <td bgcolor="white" >{{$tot_19_3_P}}</td>
            <td bgcolor="white" >{{$tot_19_4_P}}</td>
            <td bgcolor="white" >{{$tot_19_5_P}}</td>
            <td bgcolor="white" >{{$tot_19_6_P}}</td>
            <td bgcolor="white" >{{$tot_19_7_P}}</td>
            <td bgcolor="white" >{{$tot_19_8_P}}</td>
            <td >{{$tot_19_T_P}}</td>
          </tr>
          <tr>
            <td >20 años</td>
            <td bgcolor="white" >{{$tot_20_1_P}}</td>
            <td bgcolor="white" >{{$tot_20_2_P}}</td>
            <td bgcolor="white" >{{$tot_20_3_P}}</td>
            <td bgcolor="white" >{{$tot_20_4_P}}</td>
            <td bgcolor="white" >{{$tot_20_5_P}}</td>
            <td bgcolor="white" >{{$tot_20_6_P}}</td>
            <td bgcolor="white" >{{$tot_20_7_P}}</td>
            <td bgcolor="white" >{{$tot_20_8_P}}</td>
            <td >{{$tot_20_T_P}}</td>
          </tr>
        <tr>
          <td >21 años</td>
          <td bgcolor="white" >{{$tot_21_1_P}}</td>
          <td bgcolor="white" >{{$tot_21_2_P}}</td>
          <td bgcolor="white" >{{$tot_21_3_P}}</td>
          <td bgcolor="white" >{{$tot_21_4_P}}</td>
          <td bgcolor="white" >{{$tot_21_5_P}}</td>
          <td bgcolor="white" >{{$tot_21_6_P}}</td>
          <td bgcolor="white" >{{$tot_21_7_P}}</td>
          <td bgcolor="white" >{{$tot_21_8_P}}</td>
          <td >{{$tot_21_T_P}}</td>
        </tr>
        <tr>
          <td >22 años</td>
          <td bgcolor="white" >{{$tot_22_1_P}}</td>
          <td bgcolor="white" >{{$tot_22_2_P}}</td>
          <td bgcolor="white" >{{$tot_22_3_P}}</td>
          <td bgcolor="white" >{{$tot_22_4_P}}</td>
          <td bgcolor="white" >{{$tot_22_5_P}}</td>
          <td bgcolor="white" >{{$tot_22_6_P}}</td>
          <td bgcolor="white" >{{$tot_22_7_P}}</td>
          <td bgcolor="white" >{{$tot_22_8_P}}</td>
          <td >{{$tot_22_T_P}}</td>
        </tr>
        <tr>
          <td >23 años</td>
          <td bgcolor="white" >{{$tot_23_1_P}}</td>
          <td bgcolor="white" >{{$tot_23_2_P}}</td>
          <td bgcolor="white" >{{$tot_23_3_P}}</td>
          <td bgcolor="white" >{{$tot_23_4_P}}</td>
          <td bgcolor="white" >{{$tot_23_5_P}}</td>
          <td bgcolor="white" >{{$tot_23_6_P}}</td>
          <td bgcolor="white" >{{$tot_23_7_P}}</td>
          <td bgcolor="white" >{{$tot_23_8_P}}</td>
          <td >{{$tot_23_T_P}}</td>
        </tr>
        <tr>
          <td >24 años</td>
          <td bgcolor="white" >{{$tot_24_1_P}}</td>
          <td bgcolor="white" >{{$tot_24_2_P}}</td>
          <td bgcolor="white" >{{$tot_24_3_P}}</td>
          <td bgcolor="white" >{{$tot_24_4_P}}</td>
          <td bgcolor="white" >{{$tot_24_5_P}}</td>
          <td bgcolor="white" >{{$tot_24_6_P}}</td>
          <td bgcolor="white" >{{$tot_24_7_P}}</td>
          <td bgcolor="white" >{{$tot_24_8_P}}</td>
          <td >{{$tot_24_T_P}}</td>
        </tr>
        <tr>
          <td >25 años</td>
          <td bgcolor="white" >{{$tot_25_1_P}}</td>
          <td bgcolor="white" >{{$tot_25_2_P}}</td>
          <td bgcolor="white" >{{$tot_25_3_P}}</td>
          <td bgcolor="white" >{{$tot_25_4_P}}</td>
          <td bgcolor="white" >{{$tot_25_5_P}}</td>
          <td bgcolor="white" >{{$tot_25_6_P}}</td>
          <td bgcolor="white" >{{$tot_25_7_P}}</td>
          <td bgcolor="white" >{{$tot_25_8_P}}</td>
          <td >{{$tot_25_T_P}}</td>
        </tr>
        <tr>
          <td >26 años</td>
          <td bgcolor="white" >{{$tot_26_1_P}}</td>
          <td bgcolor="white" >{{$tot_26_2_P}}</td>
          <td bgcolor="white" >{{$tot_26_3_P}}</td>
          <td bgcolor="white" >{{$tot_26_4_P}}</td>
          <td bgcolor="white" >{{$tot_26_5_P}}</td>
          <td bgcolor="white" >{{$tot_26_6_P}}</td>
          <td bgcolor="white" >{{$tot_26_7_P}}</td>
          <td bgcolor="white" >{{$tot_26_8_P}}</td>
          <td >{{$tot_26_T_P}}</td>
          </tr>
          <tr>
            <td >27 años</td>
            <td bgcolor="white" >{{$tot_27_1_P}}</td>
            <td bgcolor="white" >{{$tot_27_2_P}}</td>
            <td bgcolor="white" >{{$tot_27_3_P}}</td>
            <td bgcolor="white" >{{$tot_27_4_P}}</td>
            <td bgcolor="white" >{{$tot_27_5_P}}</td>
            <td bgcolor="white" >{{$tot_27_6_P}}</td>
            <td bgcolor="white" >{{$tot_27_7_P}}</td>
            <td bgcolor="white" >{{$tot_27_8_P}}</td>
            <td >{{$tot_27_T_P}}</td>
          </tr>
            <tr>
              <td >28 años</td>
              <td bgcolor="white" >{{$tot_28_1_P}}</td>
              <td bgcolor="white" >{{$tot_28_2_P}}</td>
              <td bgcolor="white" >{{$tot_28_3_P}}</td>
              <td bgcolor="white" >{{$tot_28_4_P}}</td>
              <td bgcolor="white" >{{$tot_28_5_P}}</td>
              <td bgcolor="white" >{{$tot_28_6_P}}</td>
              <td bgcolor="white" >{{$tot_28_7_P}}</td>
              <td bgcolor="white" >{{$tot_28_8_P}}</td>
              <td >{{$tot_28_T_P}}</td>
            </tr>
            <tr>
              <td >29 años</td>
              <td bgcolor="white" >{{$tot_29_1_P}}</td>
              <td bgcolor="white" >{{$tot_29_2_P}}</td>
              <td bgcolor="white" >{{$tot_29_3_P}}</td>
              <td bgcolor="white" >{{$tot_29_4_P}}</td>
              <td bgcolor="white" >{{$tot_29_5_P}}</td>
              <td bgcolor="white" >{{$tot_29_6_P}}</td>
              <td bgcolor="white" >{{$tot_29_7_P}}</td>
              <td bgcolor="white" >{{$tot_29_8_P}}</td>
              <td >{{$tot_29_T_P}}</td>
            </tr>
            <tr>
              <td >30 a 34 años</td>
              <td bgcolor="white" >{{$tot_30_1_P}}</td>
              <td bgcolor="white" >{{$tot_30_2_P}}</td>
              <td bgcolor="white" >{{$tot_30_3_P}}</td>
              <td bgcolor="white" >{{$tot_30_4_P}}</td>
              <td bgcolor="white" >{{$tot_30_5_P}}</td>
              <td bgcolor="white" >{{$tot_30_6_P}}</td>
              <td bgcolor="white" >{{$tot_30_7_P}}</td>
              <td bgcolor="white" >{{$tot_30_8_P}}</td>
              <td >{{$tot_30_T_P}}</td>
            </tr>
            <tr>
              <td >35 a 39 años</td>
              <td bgcolor="white" >{{$tot_35_1_P}}</td>
              <td bgcolor="white" >{{$tot_35_2_P}}</td>
              <td bgcolor="white" >{{$tot_35_3_P}}</td>
              <td bgcolor="white" >{{$tot_35_4_P}}</td>
              <td bgcolor="white" >{{$tot_35_5_P}}</td>
              <td bgcolor="white" >{{$tot_35_6_P}}</td>
              <td bgcolor="white" >{{$tot_35_7_P}}</td>
              <td bgcolor="white" >{{$tot_35_8_P}}</td>
              <td >{{$tot_35_T_P}}</td>
            </tr>
            <tr>
              <td >40 años o más</td>
              <td bgcolor="white" >{{$tot_40_1_P}}</td>
              <td bgcolor="white" >{{$tot_40_2_P}}</td>
              <td bgcolor="white" >{{$tot_40_3_P}}</td>
              <td bgcolor="white" >{{$tot_40_4_P}}</td>
              <td bgcolor="white" >{{$tot_40_5_P}}</td>
              <td bgcolor="white" >{{$tot_40_6_P}}</td>
              <td bgcolor="white" >{{$tot_40_7_P}}</td>
              <td bgcolor="white" >{{$tot_40_8_P}}</td>
              <td >{{$tot_40_T_P}}</td>
            </tr>
        <tr>
        <td ><strong>Total</strong></td>
        <td bgcolor="white" >{{$tot_G_1_P}}</td>
        <td bgcolor="white" >{{$tot_G_2_P}}</td>
        <td bgcolor="white" >{{$tot_G_3_P}}</td>
        <td bgcolor="white" >{{$tot_G_4_P}}</td>
        <td bgcolor="white" >{{$tot_G_5_P}}</td>
        <td bgcolor="white" >{{$tot_G_6_P}}</td>
        <td bgcolor="white" >{{$tot_G_7_P}}</td>
        <td bgcolor="white" >{{$tot_G_8_P}}</td>
        <td >{{$tot_G_T_P}}</td>
        </tr>

        </table>


<table class="table table-bordered table-info" style="color: #8181F7;" >
<h6 style="font-size: 1.0em; color: #000000;" align="center"><u>MODALIDAD SEMIESCOLARIZADA</u></h6>
<h6 style="font-size: 1.0em; color: #000000;" align="center"><u>CU</u></h6>
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
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A_0')}}>1</a>
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A_1')}}>2</a>
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A_3')}}>3</a>
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A_4')}}><strong>4</strong></a>

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
