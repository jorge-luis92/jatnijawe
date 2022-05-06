<style>
body{
  margin: 0;
}
#datos {border:2px solid; width:50%; text-align:center}
#datos tr {border:2px solid;}
#datos tr td{border:2px solid;}
</style>
<?php
$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$arrayDias = array('Domingo', 'Lunes', 'Martes','Miercoles', 'Jueves', 'Viernes', 'Sabado');
?>

<body style="background:url(/image/logos_idiomas/logo_fon.png) center center no-repeat; text-align:justify;">

  <table id="encabezado" >
    <tr class="fila" align="center">
    <td id="col_1" >
    <img src="image/logos_idiomas/image1247.jpg">
    </td>
    <td id="col_2">
    <span id="span4" >La Facultad de Idiomas<BR /> de la  <BR /> Universidad Aut&oacute;noma Benito Ju&aacute;rez de Oaxaca </span>
    </td>

    <td id="col_4">
    <img width="90" height="100" src="image/logos_idiomas/logo_idiomas.jpg">
    </td>
    </tr>
    <tr>
    <td height="0px"></td>
    </tr>
    <tr>
    <td colspan="3" align="center"><img src="image/logos_idiomas/barra.jpg"></td>
    </tr>
  </table>

  <table  width="auto" >
  <tr>
  <td align="center">
  <br /><br /> <span style="text-align:center; font-size:14px">Otorga la presente</span> <br /><br /><br />
  <span style="text-align:center; font-size:22px"><strong>C O N S T A N C I A<br /></strong></span> <br />
  </tr>

  <tr class="fila">
</br></br>
  <td>
	</br>
</br>
</br>
	A el/la C. {{$data->nombre}}

        <strong style="font-size:14px"> </strong><br />

  Alumno(a) de la <strong style="font-size:14px">LICENCIATURA EN ENSE&Ntilde;ANZA DE IDIOMAS...................................
    <BR /></strong>Por haber cumplido satisfactoriamente con las Horas Extracurriculares en el:
    <br />
  </td>

  </tr>

  <tr>
  <td >
      <br />
  <table align="center" id="datos">
  <tr class="fila" style="background-color:#999;">
  <td style="width:70%">
    &Aacute;REA
  </td>
  <td style="width:30%">
  HORAS
  </td>
  </tr>
  <tr class="fila">
  <td style="width:70%">
  ACAD&Eacute;MICA
  </td>
  <td style="width:30%;text-align:center">{{$aca}}
  </td>
  </tr>
  <tr class="fila">
  <td style="width:70%">
  CULTURAL
  </td>
  <td style="width:30%; text-align:center">{{$cul}}

  </td>
  </tr>
  <tr class="fila">
  <td style="width:70%">
  DEPORTIVA
  </td>
  <td style="width:30%; text-align:center">{{$dep}}
  </td>
  </tr>
  <tr class="fila">
  <td style="width:70%">
  TOTAL DE HORAS
  </td>
  <td style="width:30%; text-align:center">{{$suma}}
  </td>
  </tr>
  </table>
  </td>
  </tr>
  <tr>
  <td style="text-align: justify;">

  <br />Expediendose las presente por tener cumplidos los requisitos previstos por el reglamento de horas extracurriculares.
  <br /><br />
  A petici&oacute;n del o la interesado(a) se extiende la presente para los usos administrativos y acad&eacute;micos a que haya lugar,
  en la ciudad de Oaxaca de Ju&aacute;rez, Oax. <?php date_default_timezone_set('UTC'); date_default_timezone_set("America/Mexico_City"); echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y'); ?><br /><br /><br />
  <div id="firma" style="text-align: center;">  Atentamente
  <br /><br /><br />
  CIENCIA ARTE Y LIBERTAD

  <br /><br /><br /><br /><br />
  </div>
  </td>
  </tr>
</table>
</br>
  <div style="float: left; width: 50%">
  <p class="page" align="CENTER">
  <span style="font-size:12px">
  LIC.<?php if(empty($director->nombre)){ $vacio=null; echo $vacio;} else{ echo $director->nombre." ".$director->apellido_paterno;} ?> <?php if(empty($director->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $director->apellido_materno;} ?><BR />
  DIRECTOR<B<BR />
</span>
</p>
</div>
<div style="float: right; width: 50%">
  <p class="page" align="CENTER">
  <span style="font-size:12px">
  LIC. <?php if(empty($datos_coordinadora->nombre)){ $vacio=null; echo $vacio;} else{ echo $datos_coordinadora->nombre." ".$datos_coordinadora->apellido_paterno;} ?> <?php if(empty($datos_coordinadora->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $datos_coordinadora->apellido_materno;} ?><BR />
 COORDINADOR(A) DE FORMACI&Oacute;N INTEGRAL<BR />
</span>
</p>
</div>
<br />
<br />
<br />
  <table id="footer">
    <tr>
    <td style="text-align: right;    width: 50%"></td>
    </tr>
      <tr class="fila">
      <td >
        <img src="./image/logos_idiomas/barra.jpg">
      </td>
      </tr>
      <tr>
      <td style="text-align: left;    width: 50%"></td>
      </tr>

   </table>

</body>
