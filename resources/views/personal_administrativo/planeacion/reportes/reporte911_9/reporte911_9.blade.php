<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_planeacion')
@section('title')
: 911.9
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('reporte911_9') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">

  <table class="table table-bordered table-info" style="color: #8181F7;" >

  <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ESTUDIANTES BECADOS</strong></h4>
  <h5 style="font-size: 1.0em; color: #000000;" align="center"><u>Número de Estudiantes Becados del ciclo escolar actual</u></h5>
  <h6 style="font-size: 1.0em; color: #000000;" align="justify"><i><strong>Número de estudiantes becados del ciclo escolar actual,
    según el origen de la beca, por género, discapacidad y hablantes de alguna lengua índigena</i></strong></h6>
<tr>
<td colspan="6"align="center"><strong>Modalidad Escolarizada</strong></td>
</tr>
<tr>
<td colspan="6"align="center" bgcolor="white"><strong>CU</strong></td>
</tr>
<tr>
  <td ><strong>Origen de la Beca</strong></td>
  <td bgcolor="white">Hombres</td>
  <td bgcolor="white">Mujeres</td>
    <td ><strong>Total</strong></td>
  <td bgcolor="white">Con discapacidad</td>
  <td bgcolor="white">Hablante de Lengua Índigena</td>
</tr>

<tr>
  <td bgcolor="white" >Propia Institución</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_M['INSTITUCIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_F['INSTITUCIONAL']}}</td>
  <td >{{$tipos_becas_ESC_G['INSTITUCIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_D['INSTITUCIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_L['INSTITUCIONAL']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Federal</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_M['FEDERAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_F['FEDERAL']}}</td>
  <td >{{$tipos_becas_ESC_G['FEDERAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_D['FEDERAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_L['FEDERAL']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Estatal</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_M['ESTATAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_F['ESTATAL']}}</td>
  <td >{{$tipos_becas_ESC_G['ESTATAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_D['ESTATAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_L['ESTATAL']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Municipal</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_M['MUNICIPAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_F['MUNICIPAL']}}</td>
  <td >{{$tipos_becas_ESC_G['MUNICIPAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_D['MUNICIPAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_L['MUNICIPAL']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Particular</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_M['PARTICULAR']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_F['PARTICULAR']}}</td>
  <td >{{$tipos_becas_ESC_G['PARTICULAR']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_D['PARTICULAR']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_L['PARTICULAR']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Internacional</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_M['INTERNACIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_F['INTERNACIONAL']}}</td>
  <td >{{$tipos_becas_ESC_G['INTERNACIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_D['INTERNACIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_L['INTERNACIONAL']}}</td>
</tr>
<tr>
  <td ><strong>Total</strong></td>
  <td bgcolor="white" >{{$tipos_becas_ESC_M['TOTAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_F['TOTAL']}}</td>
  <td >{{$tipos_becas_ESC_G['TOTAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_D['TOTAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_L['TOTAL']}}</td>
</tr>
<tr>
  <td colspan="6"align="center" bgcolor="white"><strong>TEHUANTEPEC</strong></td>
</tr>
<tr>
  <td bgcolor="white">Hombres</td>
  <td ><strong>Origen de la Beca</strong></td>
  <td bgcolor="white">Mujeres</td>
  <td ><strong>Total</strong></td>
  <td bgcolor="white">Con discapacidad</td>
  <td bgcolor="white">Hablante de Lengua Índigena</td>
  </tr>

<tr>
  <td bgcolor="white" >Propia Institución</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_MT['INSTITUCIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_FT['INSTITUCIONAL']}}</td>
  <td >{{$tipos_becas_ESC_GT['INSTITUCIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_DT['INSTITUCIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_LT['INSTITUCIONAL']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Federal</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_MT['FEDERAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_FT['FEDERAL']}}</td>
  <td >{{$tipos_becas_ESC_GT['FEDERAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_DT['FEDERAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_LT['FEDERAL']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Estatal</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_MT['ESTATAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_FT['ESTATAL']}}</td>
  <td >{{$tipos_becas_ESC_GT['ESTATAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_DT['ESTATAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_LT['ESTATAL']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Municipal</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_MT['MUNICIPAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_FT['MUNICIPAL']}}</td>
  <td >{{$tipos_becas_ESC_GT['MUNICIPAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_DT['MUNICIPAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_LT['MUNICIPAL']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Particular</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_MT['PARTICULAR']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_FT['PARTICULAR']}}</td>
  <td >{{$tipos_becas_ESC_GT['PARTICULAR']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_DT['PARTICULAR']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_LT['PARTICULAR']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Internacional</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_MT['INTERNACIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_FT['INTERNACIONAL']}}</td>
  <td >{{$tipos_becas_ESC_GT['INTERNACIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_DT['INTERNACIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_LT['INTERNACIONAL']}}</td>
</tr>

<tr>
  <td ><strong>Total</strong></td>
  <td bgcolor="white" >{{$tipos_becas_ESC_MT['TOTAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_FT['TOTAL']}}</td>
  <td >{{$tipos_becas_ESC_GT['TOTAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_DT['TOTAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_LT['TOTAL']}}</td>
</tr>
<tr>
  <td colspan="6"align="center" bgcolor="white"><strong>PUERTO ESCONDIDO</strong></td>
</tr>
<tr>
  <td ><strong>Origen de la Beca</strong></td>
  <td bgcolor="white">Hombres</td>
  <td bgcolor="white">Mujeres</td>
  <td ><strong>Total</strong></td>
  <td bgcolor="white">Con discapacidad</td>
  <td bgcolor="white">Hablante de Lengua Índigena</td>
</tr>
<tr>
  <td bgcolor="white" >Propia Institución</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_MPE['INSTITUCIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_FPE['INSTITUCIONAL']}}</td>
  <td >{{$tipos_becas_ESC_GPE['INSTITUCIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_DPE['INSTITUCIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_LPE['INSTITUCIONAL']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Federal</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_MPE['FEDERAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_FPE['FEDERAL']}}</td>
  <td >{{$tipos_becas_ESC_GPE['FEDERAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_DPE['FEDERAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_LPE['FEDERAL']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Estatal</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_MPE['ESTATAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_FPE['ESTATAL']}}</td>
  <td >{{$tipos_becas_ESC_GPE['ESTATAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_DPE['ESTATAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_LPE['ESTATAL']}}</td>    </tr>
<tr>
  <td bgcolor="white" >Beca Municipal</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_MPE['MUNICIPAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_FPE['MUNICIPAL']}}</td>
  <td >{{$tipos_becas_ESC_GPE['MUNICIPAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_DPE['MUNICIPAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_LPE['MUNICIPAL']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Particular</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_MPE['PARTICULAR']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_FPE['PARTICULAR']}}</td>
  <td >{{$tipos_becas_ESC_GPE['PARTICULAR']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_DPE['PARTICULAR']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_LPE['PARTICULAR']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Internacional</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_MPE['INTERNACIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_FPE['INTERNACIONAL']}}</td>
  <td >{{$tipos_becas_ESC_GPE['INTERNACIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_DPE['INTERNACIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_LPE['INTERNACIONAL']}}</td>
</tr>
<tr>
<td ><strong>Total</strong></td>
  <td bgcolor="white" >{{$tipos_becas_ESC_MPE['TOTAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_FPE['TOTAL']}}</td>
  <td >{{$tipos_becas_ESC_GPE['TOTAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_DPE['TOTAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_LPE['TOTAL']}}</td>
</tr>
</table>
  <table class="table table-bordered table-info" style="color: #8181F7;" >
<tr>
  <td colspan="6"align="center"><strong>Modalidad Semiescolarizada</strong></td>
</tr>
<tr>
  <td colspan="6"align="center" bgcolor="white"><strong>CU</strong></td>
</tr>
      <tr>
        <td ><strong>Origen de la Beca</strong></td>
          <td bgcolor="white">Hombres</td>
          <td bgcolor="white">Mujeres</td>
            <td ><strong>Total</strong></td>
          <td bgcolor="white">Con discapacidad</td>
          <td bgcolor="white">Hablante de Lengua Índigena</td>
        </tr>

        <tr>
          <td bgcolor="white" >Propia Institución</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_M['INSTITUCIONAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_F['INSTITUCIONAL']}}</td>
          <td >{{$tipos_becas_SEMI_G['INSTITUCIONAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_D['INSTITUCIONAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_L['INSTITUCIONAL']}}</td>
        </tr>
        <tr>
          <td bgcolor="white" >Beca Federal</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_M['FEDERAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_F['FEDERAL']}}</td>
          <td >{{$tipos_becas_SEMI_G['FEDERAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_D['FEDERAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_L['FEDERAL']}}</td>
        </tr>
        <tr>
          <td bgcolor="white" >Beca Estatal</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_M['ESTATAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_F['ESTATAL']}}</td>
          <td >{{$tipos_becas_SEMI_G['ESTATAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_D['ESTATAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_L['ESTATAL']}}</td>    </tr>
        <tr>
          <td bgcolor="white" >Beca Municipal</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_M['MUNICIPAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_F['MUNICIPAL']}}</td>
          <td >{{$tipos_becas_SEMI_G['MUNICIPAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_D['MUNICIPAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_L['MUNICIPAL']}}</td>
        </tr>
        <tr>
          <td bgcolor="white" >Beca Particular</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_M['PARTICULAR']}}</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_F['PARTICULAR']}}</td>
          <td >{{$tipos_becas_SEMI_G['PARTICULAR']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_D['PARTICULAR']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_L['PARTICULAR']}}</td>
        </tr>
        <tr>
          <td bgcolor="white" >Beca Internacional</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_M['INTERNACIONAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_F['INTERNACIONAL']}}</td>
          <td >{{$tipos_becas_SEMI_G['INTERNACIONAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_D['INTERNACIONAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_L['INTERNACIONAL']}}</td>
        </tr>

        <tr>
        <td ><strong>Total</strong></td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_M['TOTAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_F['TOTAL']}}</td>
          <td >{{$tipos_becas_SEMI_G['TOTAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_D['TOTAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_L['TOTAL']}}</td>
        </tr>
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
