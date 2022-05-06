<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_planeacion')
@section('title')
: 911.9A
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('reporte911_9A_3') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">
<table class="table table-bordered table-info" style="color: #8181F7;" >

    <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>MATRÍCULA TOTAL DE LA CARRERA</strong></h4>
    <h5 style="font-size: 1.0em; color: #000000;" align="center">Estudiantes inscritos en el ciclo escolar actual</h5>
    <h6 style="font-size: 1.0em; color: #000000;" align="justify"><i><strong>Total de estudiantes inscritos en la carrera,
      por grado de avance, género, discapacidades y hablantes de alguna lengua indígena</i></strong></h6>
</table>
<h6 style="font-size: 1.0em; color: #000000;" align="center"><u>MODALIDAD ESCOLARIZADA</u></h6>
<table class="table table-bordered table-info" style="color: #8181F7;" >
  <h6 style="font-size: 1.0em; color: #000000;" align="center"><u>CU</u></h6>
    <tr>
      <th scope="row">Semestre</th>
      <th scope="row">Hombres </th>
      <th scope="row">Mujeres</th>
      <th scope="row">Total</th>
      <th scope="row">Con Discapacidad</th>
      <th scope="row">Hablante de Lengua</th>
    </tr>
    <tr>
      <td bgcolor="white">Primero</td>
      <td bgcolor="white">{{$tot_1_M_CU}}</td>
      <td bgcolor="white">{{$tot_1_F_CU}}</td>
      <td bgcolor="white">{{$tot_1_M_CU + $tot_1_F_CU}}</td>
      <td bgcolor="white">{{$tot_1_D_CU}}</td>
      <td bgcolor="white">{{$tot_1_L_CU}}</td>
      </tr>
  <tr>
      <td bgcolor="white">Segundo</td>
      <td bgcolor="white">{{$tot_2_M_CU}}</td>
      <td bgcolor="white">{{$tot_2_F_CU}}</td>
      <td bgcolor="white">{{$tot_2_M_CU + $tot_2_F_CU}}</td>
      <td bgcolor="white">{{$tot_2_D_CU}}</td>
      <td bgcolor="white">{{$tot_2_L_CU}}</td>
    </tr>
  <tr>
      <td bgcolor="white">Tercero</td>
      <td bgcolor="white">{{$tot_3_M_CU}}</td>
      <td bgcolor="white">{{$tot_3_F_CU}}</td>
      <td bgcolor="white">{{$tot_3_M_CU + $tot_3_F_CU}}</td>
      <td bgcolor="white">{{$tot_3_D_CU}}</td>
      <td bgcolor="white">{{$tot_3_L_CU}}</td>
  </tr>
  <tr>
      <td bgcolor="white">Cuarto</td>
      <td bgcolor="white">{{$tot_4_M_CU}}</td>
      <td bgcolor="white">{{$tot_4_F_CU}}</td>
      <td bgcolor="white">{{$tot_4_M_CU + $tot_4_F_CU}}</td>
      <td bgcolor="white">{{$tot_4_D_CU}}</td>
      <td bgcolor="white">{{$tot_4_L_CU}}</td>
  <tr>
      <td bgcolor="white">Quinto</td>
      <td bgcolor="white">{{$tot_5_M_CU}}</td>
      <td bgcolor="white">{{$tot_5_F_CU}}</td>
      <td bgcolor="white">{{$tot_5_M_CU + $tot_5_F_CU}}</td>
      <td bgcolor="white">{{$tot_5_D_CU}}</td>
      <td bgcolor="white">{{$tot_5_L_CU}}</td>
  </tr>
  <tr>
      <td bgcolor="white">Sexto</td>
      <td bgcolor="white">{{$tot_6_M_CU}}</td>
      <td bgcolor="white">{{$tot_6_F_CU}}</td>
      <td bgcolor="white">{{$tot_6_M_CU + $tot_6_F_CU}}</td>
      <td bgcolor="white">{{$tot_6_D_CU}}</td>
      <td bgcolor="white">{{$tot_6_L_CU}}</td>
  </tr>
  <tr>
      <td bgcolor="white">Séptimo</td>
      <td bgcolor="white">{{$tot_7_M_CU}}</td>
      <td bgcolor="white">{{$tot_7_F_CU}}</td>
      <td bgcolor="white">{{$tot_7_M_CU + $tot_7_F_CU}}</td>
      <td bgcolor="white">{{$tot_7_D_CU}}</td>
      <td bgcolor="white">{{$tot_7_L_CU}}</td>
  </tr>
  <tr>
      <td bgcolor="white">Octavo</td>
      <td bgcolor="white">{{$tot_8_M_CU}}</td>
      <td bgcolor="white">{{$tot_8_F_CU}}</td>
      <td bgcolor="white">{{$tot_8_M_CU + $tot_8_F_CU}}</td>
      <td bgcolor="white">{{$tot_8_D_CU}}</td>
      <td bgcolor="white">{{$tot_8_L_CU}}</td>
  </tr>

    <tr>
      <th>Total</th>
      <td bgcolor="white">{{$tot_M_CU}}</td>
      <td bgcolor="white">{{$tot_F_CU}}</td>
      <td>{{$tot_M_CU + $tot_F_CU}}</td>
      <td bgcolor="white">{{$tot_T_D_CU}}</td>
      <td bgcolor="white">{{$tot_T_L_CU}}</td>
    </tr>

    </table>

    <table class="table table-bordered table-info" style="color: #8181F7;" >
      <h6 style="font-size: 1.0em; color: #000000;" align="center"><u>TEHUANTEPEC</u></h6>
        <tr>
          <th scope="row">Semestre</th>
          <th scope="row">Hombres </th>
          <th scope="row">Mujeres</th>
          <th scope="row">Total</th>
          <th scope="row">Con Discapacidad</th>
          <th scope="row">Hablante de Lengua</th>
        </tr>
        <tr>
          <td bgcolor="white">Primero</td>
          <td bgcolor="white">{{$tot_1_M_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_1_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_1_M_TEHUANTEPEC + $tot_1_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_1_D_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_1_L_TEHUANTEPEC}}</td>
          </tr>
      <tr>
          <td bgcolor="white">Segundo</td>
          <td bgcolor="white">{{$tot_2_M_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_2_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_2_M_TEHUANTEPEC + $tot_2_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_2_D_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_2_L_TEHUANTEPEC}}</td>
        </tr>
      <tr>
          <td bgcolor="white">Tercero</td>
          <td bgcolor="white">{{$tot_3_M_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_3_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_3_M_TEHUANTEPEC + $tot_3_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_3_D_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_3_L_TEHUANTEPEC}}</td>
      </tr>
      <tr>
          <td bgcolor="white">Cuarto</td>
          <td bgcolor="white">{{$tot_4_M_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_4_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_4_M_TEHUANTEPEC + $tot_4_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_4_D_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_4_L_TEHUANTEPEC}}</td>
      <tr>
          <td bgcolor="white">Quinto</td>
          <td bgcolor="white">{{$tot_5_M_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_5_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_5_M_TEHUANTEPEC + $tot_5_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_5_D_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_5_L_TEHUANTEPEC}}</td>
      </tr>
      <tr>
          <td bgcolor="white">Sexto</td>
          <td bgcolor="white">{{$tot_6_M_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_6_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_6_M_TEHUANTEPEC + $tot_6_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_6_D_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_6_L_TEHUANTEPEC}}</td>
      </tr>
      <tr>
          <td bgcolor="white">Séptimo</td>
          <td bgcolor="white">{{$tot_7_M_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_7_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_7_M_TEHUANTEPEC + $tot_7_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_7_D_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_7_L_TEHUANTEPEC}}</td>
      </tr>
      <tr>
          <td bgcolor="white">Octavo</td>
          <td bgcolor="white">{{$tot_8_M_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_8_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_8_M_TEHUANTEPEC + $tot_8_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_8_D_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_8_L_TEHUANTEPEC}}</td>
      </tr>

        <tr>
          <th>Total</th>
          <td bgcolor="white">{{$tot_M_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_F_TEHUANTEPEC}}</td>
          <td>{{$tot_M_TEHUANTEPEC + $tot_F_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_T_D_TEHUANTEPEC}}</td>
          <td bgcolor="white">{{$tot_T_L_TEHUANTEPEC}}</td>
        </tr>

        </table>

        <table class="table table-bordered table-info" style="color: #8181F7;" >
          <h6 style="font-size: 1.0em; color: #000000;" align="center"><u>PUERTO ESCONDIDO</u></h6>
            <tr>
              <th scope="row">Semestre</th>
              <th scope="row">Hombres </th>
              <th scope="row">Mujeres</th>
              <th scope="row">Total</th>
              <th scope="row">Con Discapacidad</th>
              <th scope="row">Hablante de Lengua</th>
            </tr>
            <tr>
              <td bgcolor="white">Primero</td>
              <td bgcolor="white">{{$tot_1_M_PTO}}</td>
              <td bgcolor="white">{{$tot_1_F_PTO}}</td>
              <td bgcolor="white">{{$tot_1_M_PTO + $tot_1_F_PTO}}</td>
              <td bgcolor="white">{{$tot_1_D_PTO}}</td>
              <td bgcolor="white">{{$tot_1_L_PTO}}</td>
              </tr>
          <tr>
              <td bgcolor="white">Segundo</td>
              <td bgcolor="white">{{$tot_2_M_PTO}}</td>
              <td bgcolor="white">{{$tot_2_F_PTO}}</td>
              <td bgcolor="white">{{$tot_2_M_PTO + $tot_2_F_PTO}}</td>
              <td bgcolor="white">{{$tot_2_D_PTO}}</td>
              <td bgcolor="white">{{$tot_2_L_PTO}}</td>
            </tr>
          <tr>
              <td bgcolor="white">Tercero</td>
              <td bgcolor="white">{{$tot_3_M_PTO}}</td>
              <td bgcolor="white">{{$tot_3_F_PTO}}</td>
              <td bgcolor="white">{{$tot_3_M_PTO + $tot_3_F_PTO}}</td>
              <td bgcolor="white">{{$tot_3_D_PTO}}</td>
              <td bgcolor="white">{{$tot_3_L_PTO}}</td>
          </tr>
          <tr>
              <td bgcolor="white">Cuarto</td>
              <td bgcolor="white">{{$tot_4_M_PTO}}</td>
              <td bgcolor="white">{{$tot_4_F_PTO}}</td>
              <td bgcolor="white">{{$tot_4_M_PTO + $tot_4_F_PTO}}</td>
              <td bgcolor="white">{{$tot_4_D_PTO}}</td>
              <td bgcolor="white">{{$tot_4_L_PTO}}</td>
          <tr>
              <td bgcolor="white">Quinto</td>
              <td bgcolor="white">{{$tot_5_M_PTO}}</td>
              <td bgcolor="white">{{$tot_5_F_PTO}}</td>
              <td bgcolor="white">{{$tot_5_M_PTO + $tot_5_F_PTO}}</td>
              <td bgcolor="white">{{$tot_5_D_PTO}}</td>
              <td bgcolor="white">{{$tot_5_L_PTO}}</td>
          </tr>
          <tr>
              <td bgcolor="white">Sexto</td>
              <td bgcolor="white">{{$tot_6_M_PTO}}</td>
              <td bgcolor="white">{{$tot_6_F_PTO}}</td>
              <td bgcolor="white">{{$tot_6_M_PTO + $tot_6_F_PTO}}</td>
              <td bgcolor="white">{{$tot_6_D_PTO}}</td>
              <td bgcolor="white">{{$tot_6_L_PTO}}</td>
          </tr>
          <tr>
              <td bgcolor="white">Séptimo</td>
              <td bgcolor="white">{{$tot_7_M_PTO}}</td>
              <td bgcolor="white">{{$tot_7_F_PTO}}</td>
              <td bgcolor="white">{{$tot_7_M_PTO + $tot_7_F_PTO}}</td>
              <td bgcolor="white">{{$tot_7_D_PTO}}</td>
              <td bgcolor="white">{{$tot_7_L_PTO}}</td>
          </tr>
          <tr>
              <td bgcolor="white">Octavo</td>
              <td bgcolor="white">{{$tot_8_M_PTO}}</td>
              <td bgcolor="white">{{$tot_8_F_PTO}}</td>
              <td bgcolor="white">{{$tot_8_M_PTO + $tot_8_F_PTO}}</td>
              <td bgcolor="white">{{$tot_8_D_PTO}}</td>
              <td bgcolor="white">{{$tot_8_L_PTO}}</td>
          </tr>

            <tr>
              <th>Total</th>
              <td bgcolor="white">{{$tot_M_PTO}}</td>
              <td bgcolor="white">{{$tot_F_PTO}}</td>
              <td>{{$tot_M_PTO + $tot_F_PTO}}</td>
              <td bgcolor="white">{{$tot_T_D_PTO}}</td>
              <td bgcolor="white">{{$tot_T_L_PTO}}</td>
            </tr>

            </table>
            <h6 style="font-size: 1.0em; color: #000000;" align="center"><u>MODALIDAD SEMIESCOLARIZADA</u></h6>
            <table class="table table-bordered table-info" style="color: #8181F7;" >
              <h6 style="font-size: 1.0em; color: #000000;" align="center"><u>CU</u></h6>
                <tr>
                  <th scope="row">Semestre</th>
                  <th scope="row">Hombres </th>
                  <th scope="row">Mujeres</th>
                  <th scope="row">Total</th>
                  <th scope="row">Con Discapacidad</th>
                  <th scope="row">Hablante de Lengua</th>
                </tr>
                <tr>
                  <td bgcolor="white">Primero</td>
                  <td bgcolor="white">{{$tot_1_M_CU_S}}</td>
                  <td bgcolor="white">{{$tot_1_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_1_M_CU_S + $tot_1_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_1_D_CU_S}}</td>
                  <td bgcolor="white">{{$tot_1_L_CU_S}}</td>
                  </tr>
              <tr>
                  <td bgcolor="white">Segundo</td>
                  <td bgcolor="white">{{$tot_2_M_CU_S}}</td>
                  <td bgcolor="white">{{$tot_2_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_2_M_CU_S + $tot_2_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_2_D_CU_S}}</td>
                  <td bgcolor="white">{{$tot_2_L_CU_S}}</td>
                </tr>
              <tr>
                  <td bgcolor="white">Tercero</td>
                  <td bgcolor="white">{{$tot_3_M_CU_S}}</td>
                  <td bgcolor="white">{{$tot_3_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_3_M_CU_S + $tot_3_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_3_D_CU_S}}</td>
                  <td bgcolor="white">{{$tot_3_L_CU_S}}</td>
              </tr>
              <tr>
                  <td bgcolor="white">Cuarto</td>
                  <td bgcolor="white">{{$tot_4_M_CU_S}}</td>
                  <td bgcolor="white">{{$tot_4_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_4_M_CU_S + $tot_4_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_4_D_CU_S}}</td>
                  <td bgcolor="white">{{$tot_4_L_CU_S}}</td>
              <tr>
                  <td bgcolor="white">Quinto</td>
                  <td bgcolor="white">{{$tot_5_M_CU_S}}</td>
                  <td bgcolor="white">{{$tot_5_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_5_M_CU_S + $tot_5_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_5_D_CU_S}}</td>
                  <td bgcolor="white">{{$tot_5_L_CU_S}}</td>
              </tr>
              <tr>
                  <td bgcolor="white">Sexto</td>
                  <td bgcolor="white">{{$tot_6_M_CU_S}}</td>
                  <td bgcolor="white">{{$tot_6_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_6_M_CU_S + $tot_6_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_6_D_CU_S}}</td>
                  <td bgcolor="white">{{$tot_6_L_CU_S}}</td>
              </tr>
              <tr>
                  <td bgcolor="white">Séptimo</td>
                  <td bgcolor="white">{{$tot_7_M_CU_S}}</td>
                  <td bgcolor="white">{{$tot_7_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_7_M_CU_S + $tot_7_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_7_D_CU_S}}</td>
                  <td bgcolor="white">{{$tot_7_L_CU_S}}</td>
              </tr>
              <tr>
                  <td bgcolor="white">Octavo</td>
                  <td bgcolor="white">{{$tot_8_M_CU_S}}</td>
                  <td bgcolor="white">{{$tot_8_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_8_M_CU_S + $tot_8_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_8_D_CU_S}}</td>
                  <td bgcolor="white">{{$tot_8_L_CU_S}}</td>
              </tr>

                <tr>
                  <th>Total</th>
                  <td bgcolor="white">{{$tot_M_CU_S}}</td>
                  <td bgcolor="white">{{$tot_F_CU_S}}</td>
                  <td>{{$tot_M_CU_S + $tot_F_CU_S}}</td>
                  <td bgcolor="white">{{$tot_T_D_CU_S}}</td>
                  <td bgcolor="white">{{$tot_T_L_CU_S}}</td>
                </tr>


                </table>

            <table class="table table-bordered table-info" style="color: #8181F7;" >
              <h6 style="font-size: 1.0em; color: #000000;" align="center"><u>TOTAL GENERAL</u></h6>
                <tr>
                  <th scope="row">Semestre</th>
                  <th scope="row">Hombres </th>
                  <th scope="row">Mujeres</th>
                  <th scope="row">Total</th>
                  <th scope="row">Con Discapacidad</th>
                  <th scope="row">Hablante de Lengua</th>
                </tr>
                <tr>
                  <td bgcolor="white">Primero</td>
                  <td bgcolor="white">{{$TOT_G_M_1}}</td>
                  <td bgcolor="white">{{$TOT_G_F_1}}</td>
                  <td bgcolor="white">{{$TOT_G_T_1}}</td>
                  <td bgcolor="white">{{$TOT_G_D_1}}</td>
                  <td bgcolor="white">{{$TOT_G_L_1}}</td>
                  </tr>
              <tr>
                  <td bgcolor="white">Segundo</td>
                  <td bgcolor="white">{{$TOT_G_M_2}}</td>
                  <td bgcolor="white">{{$TOT_G_F_2}}</td>
                  <td bgcolor="white">{{$TOT_G_T_2}}</td>
                  <td bgcolor="white">{{$TOT_G_D_2}}</td>
                  <td bgcolor="white">{{$TOT_G_L_2}}</td>
                </tr>
              <tr>
                  <td bgcolor="white">Tercero</td>
                  <td bgcolor="white">{{$TOT_G_M_3}}</td>
                  <td bgcolor="white">{{$TOT_G_F_3}}</td>
                  <td bgcolor="white">{{$TOT_G_T_3}}</td>
                  <td bgcolor="white">{{$TOT_G_D_3}}</td>
                  <td bgcolor="white">{{$TOT_G_L_3}}</td>
              </tr>
              <tr>
                  <td bgcolor="white">Cuarto</td>
                  <td bgcolor="white">{{$TOT_G_M_4}}</td>
                  <td bgcolor="white">{{$TOT_G_F_4}}</td>
                  <td bgcolor="white">{{$TOT_G_T_4}}</td>
                  <td bgcolor="white">{{$TOT_G_D_4}}</td>
                  <td bgcolor="white">{{$TOT_G_L_4}}</td>
              <tr>
                  <td bgcolor="white">Quinto</td>
                  <td bgcolor="white">{{$TOT_G_M_5}}</td>
                  <td bgcolor="white">{{$TOT_G_F_5}}</td>
                  <td bgcolor="white">{{$TOT_G_T_5}}</td>
                  <td bgcolor="white">{{$TOT_G_D_5}}</td>
                  <td bgcolor="white">{{$TOT_G_L_5}}</td>
              </tr>
              <tr>
                  <td bgcolor="white">Sexto</td>
                  <td bgcolor="white">{{$TOT_G_M_6}}</td>
                  <td bgcolor="white">{{$TOT_G_F_6}}</td>
                  <td bgcolor="white">{{$TOT_G_T_6}}</td>
                  <td bgcolor="white">{{$TOT_G_D_6}}</td>
                  <td bgcolor="white">{{$TOT_G_L_6}}</td>
              </tr>
              <tr>
                  <td bgcolor="white">Séptimo</td>
                  <td bgcolor="white">{{$TOT_G_M_7}}</td>
                  <td bgcolor="white">{{$TOT_G_F_7}}</td>
                  <td bgcolor="white">{{$TOT_G_T_7}}</td>
                  <td bgcolor="white">{{$TOT_G_D_7}}</td>
                  <td bgcolor="white">{{$TOT_G_L_7}}</td>
              </tr>
              <tr>
                  <td bgcolor="white">Octavo</td>
                  <td bgcolor="white">{{$TOT_G_M_8}}</td>
                  <td bgcolor="white">{{$TOT_G_F_8}}</td>
                  <td bgcolor="white">{{$TOT_G_T_8}}</td>
                  <td bgcolor="white">{{$TOT_G_D_8}}</td>
                  <td bgcolor="white">{{$TOT_G_L_8}}</td>
              </tr>

                <tr>
                  <th>Total</th>
                  <td bgcolor="white">{{$TOT_G_M_T}}</td>
                  <td bgcolor="white">{{$TOT_G_F_T}}</td>
                  <td>{{$TOT_G_T}}</td>
                  <td bgcolor="white">{{$TOT_G_D_T}}</td>
                  <td bgcolor="white">{{$TOT_G_L_T}}</td>
                </tr>
                </table>

<a> Páginas</a>
      <a class="siguiente" align="rigth" href={{ route('reporte911_9A_0')}}>1</a>
      <a class="siguiente" align="rigth" href={{ route('reporte911_9A_1')}}>2</a>
      <a class="siguiente" align="rigth" href={{ route('reporte911_9A_3')}}><strong>3</strong></a>
      <a class="siguiente" align="rigth" href={{ route('reporte911_9A_4')}}>4</a>
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
