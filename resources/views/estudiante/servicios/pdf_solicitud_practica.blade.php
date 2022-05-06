<html>
<head>
  <style>
    @page { margin: 130px 100px; }
    #header { position: fixed; left: -60px; top: -100px; right: -50px; height: 150px; color:#000000; }
    #footer { position: fixed; left: -10px; bottom: -180px; right: -50px; height: 150px; color:#000000;  }
    #footer .page:after { }
  </style>

  <?php
  $arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
       $arrayDias = array( 'Domingo', 'Lunes', 'Martes',
                   'Miercoles', 'Jueves', 'Viernes', 'Sabado');
     ?>

<body >
<div id="header" >
<img width="80" height="80" src="image/logos_idiomas/logo_idiomas.jpg" align="right">
<img width="80" height="90" src="image/logos_idiomas/UABJO.jpg" align="left">
<p align="center">
<span style="font-size:14px">
<strong>UNIVERSIDAD AUTÓNOMA &quot;BENITO JUÁREZ &quot;DE OAXACA  <br/>
FACULTAD DE IDIOMAS  <br/>
</strong>
</span>
</p>
<p align="center">
<span style="font-size:11px">
<strong align="center">LICENCIATURA EN ENSE&Ntilde;ANZA DE IDIOMAS<br />
</span>
</strong>
</p>

<hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
<h4 align="center"><strong>PRÁCTICAS PROFESIONALES</strong></h4></br>
<p align="center">
<span style="font-size:12px">
<strong align="center">SOLICITUD<br/>
</span>
</strong>
</p>
</div>
<BR/>
<BR/>
<BR/>
<div id="footer">
  <table style="font-size:12px" WIDTH="500">
  <tr>
  <td  align="center">
    Vo. Bo. <BR/>
    LIC. ROLANDO FERNANDO MART&Iacute;NEZ S&Aacute;NCHEZ<BR />
    DIRECTOR<BR />
  </td>
  <td align="center">
      Vo. Bo. <BR/>
    LIC. KIARA R&Iacute;OS R&Iacute;OS<BR />
    COORDINADOR(A) DE SERVICIO SOCIAL Y TITULACI&Oacute;N<BR />
  </td>
  </tr>
  </table>
<p align="right" style="font-size:12px">
FACULTAD DE IDIOMAS, UABJO
</p>
</div>
<BR/>
<div id="content">
  <p class="page" align="justify">
  <span style="font-size:14px">
Por medio de la presente, solicito a la Coordinación de Servicio Social y Titulación de la Facultad de Idiomas
de la U.A.B.J.O., que a partir de esta fecha se me instaure mi expediente como prestador o prestadora de
Prácticas Profesionales, en calidad de:
  <br/>
  <br/>
  </span>
  </p>
  <table id="generales1" style="font-size:14px" WIDTH="500">
  <tr>
  <td width="90"><strong>ALUMNO</strong> </td>
  <td width="140"  align="center">SEMESTRE: <?php if(empty($data->semestre)){ $vacio=null; echo $vacio;} else{ echo $data->semestre;} ?></p></td>
  <td width="100" align="center">GRUPO: <?php if(empty($data->grupo)){ $vacio=null; echo $vacio;} else{ echo $data->grupo;} ?></p></td>
  <div align="center">
  <img width="100" height="110" src="image/logos_idiomas/personaicon.png">
  </div>
  </tr>
  </table>
  <br/>

<p style="font-size:13px; text-align: justify;">De la Carrera: <?php if(empty($carreras->carrera)){ $vacio=null; echo $vacio;} else{ echo $carreras->carrera;} ?>
 en la modalidad: <?php if(empty($modalidad)){ $vacio=null; echo $vacio;} else{ echo $modalidad;} ?>  de nuestra Universidad.</p>

<table id="generales2" style="font-size:14px" WIDTH="500" >
  <tr><td>
  Nombre del alumno(a): <?php if(empty($data->nombre)){ $vacio=null; echo $vacio;} else{ echo $data->nombre." ".$data->apellido_paterno;} ?> <?php if(empty($data->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $data->apellido_materno;} ?>
</td>
  </tr>
</table>

<table id="generales2" style="font-size:14px" WIDTH="450" >
  <tr>
    <td width="10" >Matrícula:<?php if(empty($data->matricula)){ $vacio=null; echo $vacio;} else{ echo $data->matricula;} ?> </td>
    <td width="60">CURP:<?php if(empty($data->curp)){ $vacio=null; echo $vacio;} else{ echo $data->curp;} ?>    </td>
    <td width="10" >Edad: <?php if(empty($data->edad)){ $vacio=null; echo $vacio;} else{ echo $data->edad;} ?>  </td>
  </tr>
</table>

<table id="personales1" style="font-size:14px" WIDTH="500">
<tr>
<td>Domicilio actual:<?php if(empty($di->vialidad_principal)){ $vacio=null; echo $vacio;} else{echo " Calle: "; echo $di->vialidad_principal; echo " Número: "; echo $di->num_exterior;
  echo " C.P: "; echo $di->cp; echo " Colonia: "; echo $di->localidad; echo "<br>"; echo "Municipio: "; echo $di->municipio;}?></td>
</tr>
</table>
<table id="personales2" style="font-size:14px" WIDTH="500">
  <tr>
  <td>Tel&eacute;fono Celular: <?php if(empty($nu_ce->numero)){ $vacio=null; echo $vacio;} else{ echo $nu_ce->numero;} ?>
  </td>
  <td >Correo Electrónico: <?php if(empty($data->email)){ $vacio=null; echo $vacio;} else{ echo $data->email;} ?>
  </td>
  </tr>
</table>
<br/>
<table id="personales2" style="font-size:14px" WIDTH="500">
  <tr>
  <td>Mis estudios iniciarion el día
    <?php
    date_default_timezone_set('UTC'); date_default_timezone_set("America/Mexico_City");
    echo $arrayDias[date('w', strtotime($data->fecha_ingreso))].", ".date('d', strtotime($data->fecha_ingreso))." de ".$arrayMeses[date('m', strtotime($data->fecha_ingreso))-1]." de ".date('Y', strtotime($data->fecha_ingreso)); ?>
  </td>
  </tr>
</table>
<br/>
<hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
<hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
<br/>
<table id="personales1" style="font-size:14px; text-align: justify;" >
<tr>
<td>Nombre de la Institución o Dependencia donde realizará Prácticas Profesionales:
 <?php if(empty($datos_practicas->nombre_dependencia)){ $vacio=null; echo $vacio;} else{ echo $datos_practicas->nombre_dependencia;} ?>
</td>
</tr>
</table>

<table id="personales1" style="font-size:14px; text-align: justify;">
<tr>
<td>Dirección: <?php if(empty($direccion_pra->vialidad_principal)){ $vacio=null; echo $vacio;} else{echo " Calle: "; echo $direccion_pra->vialidad_principal; echo " Número: "; echo $direccion_pra->num_exterior;
  echo " C.P: "; echo $direccion_pra->cp; echo " Colonia: "; echo $direccion_pra->localidad; echo "<br>"; echo "Municipio: "; echo $direccion_pra->municipio;}?>
</td>
</tr>
</table>
<table id="personales2" style="font-size:14px" WIDTH="500">
  <tr>
  <td>Tel&eacute;fono: <?php if(empty($numero_prac->numero)){ $vacio=null; echo $vacio;} else{ echo $numero_prac->numero;} ?>
  </td>
  </tr>
</table>
<table id="generales2" style="font-size:14px;">
  <tr>
    <td width="150" align="justify">Nombre del titular de la Dependencia o persona a quien irá dirigido el Oficio de Presentación: <br/>
   <?php if(empty($datos_practicas->nombre)){ $vacio=null; echo $vacio;} else{ echo $datos_practicas->nombre." ".$datos_practicas->apellido_paterno;} ?> <?php if(empty($datos_practicas->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $datos_practicas->apellido_materno;} ?>

          </td>
  </tr>
  <tr>
    <td>Cargo del titular: <?php if(empty($datos_practicas->cargo_titular)){ $vacio=null; echo $vacio;} else{ echo $datos_practicas->cargo_titular;} ?>
  </td>
</tr>
</table>
<br/>
<hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
<hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
<table id="generales1" style="font-size:14px" WIDTH="500">
<tr>
<td width="150" align="left">Periodo: <?php if(empty($direccion_pra->periodo_practicas)){ $vacio=null; echo $vacio;} else{ echo $direccion_pra->periodo_practicas;} ?></td>

</tr>
</table>
<BR/>
<p class="page" align="right">
<span style="font-size:14px">
Oaxaca de Ju&aacute;rez,Oax.,
<?php date_default_timezone_set('UTC'); date_default_timezone_set("America/Mexico_City");
echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y'); ?>
 <BR/>
</span>
</p>
<BR/>
<p class="page" align="CENTER">
<span style="font-size:14px; text-decoration: underline;">
<?php if(empty($data->nombre)){ $vacio=null; echo $vacio;} else{ echo $data->nombre." ".$data->apellido_paterno;} ?> <?php if(empty($data->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $data->apellido_materno;} ?>
<br/></span>
<strong style="font-size: 14px;">NOMBRE Y FIRMA DEL SOLICITANTE</strong>

</p>


</div>
</body>
</html>
