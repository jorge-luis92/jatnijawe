<html>
<head>
  <style>
    @page { margin: 150px 100px; }
    #header { position: fixed; left: -60px; top: -100px; right: -50px; height: 150px; color:#0B0B3B; }
    #footer { position: fixed; left: -10px; bottom: -180px; right: -50px; height: 150px; color:#0B0B3B;  }
    #footer .page:after { }
  </style>

  <?php
  $arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
       $arrayDias = array( 'Domingo', 'Lunes', 'Martes',
                   'Miércoles', 'Jueves', 'Viernes', 'Sábado');
     ?>

<body >
  <div id="header" >
<img width="90" height="90" src="image/logos_idiomas/idiomas_logo_azul.jpg" align="right">
<img width="120" height="140" src="image/logos_idiomas/UABJO.jpg" align="left">
    <h4>UNIVERSIDAD AUT&Oacute;NOMA "BENITO JU&Aacute;REZ" DE OAXACA</h4>
    <hr style="border:none; color:#0B0B3B; background-color:#0B0B3B; width:85%; text-align:left; margin: 0 auto 0 0;">
    <h4>FACULTAD DE IDIOMAS</h4>

  </div>
  <BR />
  <BR />
  <div id="footer">
    <img width="110" height="90" src="image/logos_idiomas/logoADM1821.png" align="right">
    <p class="page" align="justify">
    <span style="font-size:10px">
    AV. UNIVERSIDAD S/N, COL. CINCO SE&Ntilde;ORES, C.P. 68120, OAXACA DE JU&Aacute;REZ,OAX., M&Eacute;XICO <BR />
    TEL. DIRECCI&Oacute; 01 (951) 511 30 22 COORDINACI&Oacute;N ACAD&Eacute;MICA F.I.C.U.:01 (951) 572 52 16 <BR />
    TEL. SEDE BURGOA: 01 (951) 514 00 49 TEL.SEDE TEHUANTEPEC 01 (971) 715 13 43 <BR />
    TEL SEDE PUERTO ESCONDIDO: 01 (954)133 38 55 <BR />
    www.uabjo.mx
    </span>
    </p>
  </div>
  <BR /><BR />
  <div id="content">
    <p class="page" align="right">
    <span style="font-size:14px">
    Oaxaca de Ju&aacute;rez,Oax.,
    <?php date_default_timezone_set('UTC'); date_default_timezone_set("America/Mexico_City");
    echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y'); ?>
      <BR />Oficio F.I/CSST/<?php echo date('Y');?>/{{$numero}}<BR />
    ASUNTO: Oficio de Presentaci&oacute;n<BR />
    </span>
    </p>
    <BR />
    <BR />
    <p class="page" align="justify">
    <span style="font-size:14px"><strong>
    <?php if(empty($datos_de->nombre)){ $vacio=null; echo $vacio;} else{ echo $datos_de->nombre." ".$datos_de->apellido_paterno;} ?> <?php if(empty($datos_de->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $datos_de->apellido_materno;} ?>
  </strong><br /><strong>
    <?php if(empty($datos_de->cargo_titular)){ $vacio=null; echo $vacio;} else{ echo $datos_de->cargo_titular;} ?></strong>
    <br /><strong>
      <?php if(empty($datos_de->nombre_dependencia)){ $vacio=null; echo $vacio;} else{ echo $datos_de->nombre_dependencia;} ?></strong>
    <br />
    <strong>PRESENTE</strong><BR />
  </p>
  </span>
    <BR />
    <p class="page" align="justify">
    <span style="font-size:14px">
    A trav&eacute;s de este conducto me permito presentar a usted a el/la C. <strong><?php if(empty($data->nombre)){ $vacio=null; echo $vacio;} else{ echo $data->nombre." ".$data->apellido_paterno;} ?> <?php if(empty($data->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $data->apellido_materno;} ?></strong>
    con n&uacute;mero de matr&iacute;cula:  <strong><?php if(empty($data->matricula)){ $vacio=null; echo $vacio;} else{ echo $data->matricula;} ?> </strong>
    alumno(a) de la LICENCIATURA EN ENSE&Ntilde;ANZA DE IDIOMAS que cursa <strong><?php if(empty($data->semestre)){ $vacio=null; echo $vacio;} else{ echo $data->semestre."°";} ?>  semestre</strong> en la FACULTAD DE IDIOMAS OAXACA en la modalidad <strong><?php if(empty($modalidad)){ $vacio=null; echo $vacio;} else{ echo $modalidad;} ?> </strong>    de la Universidad Auton&oacute;ma "Benito Ju&aacute;rez"
    de Oaxaca, quien desea realizar sus Pr&aacute;cticas Profesionales en esa dependencia a su cargo.
  </p>
  </span>
<p class="page" align="justify">
<span style="font-size:14px">
El/la alumno(a) citado(a) deberá cubrir <?php if(empty($hora)){ $vacio=null; echo $vacio;} else{ echo $hora;} ?>  horas durante <?php if(empty($periodo->periodo_practicas)){ $vacio=null; echo $vacio;} else{ echo $periodo->periodo_practicas;} ?>   a partir de esta fecha.
</p>
</span>
<BR /><BR />
<p class="page" align="CENTER">
<span style="font-size:14px">
ATENTAMENTE
</span>
</p>
<p class="page" align="CENTER">
<span style="font-size:14px">
"CIENCIA ARTE Y LIBERTAD"
</span>
</p>
<BR />
<p class="page" align="CENTER">
<span style="font-size:14px">
LIC. <?php if(empty($datos_coordinadora->nombre)){ $vacio=null; echo $vacio;} else{ echo $datos_coordinadora->nombre." ".$datos_coordinadora->apellido_paterno;} ?> <?php if(empty($datos_coordinadora->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $datos_coordinadora->apellido_materno;} ?> <BR />
COORDINADOR(A) DE SERVICIO SOCIAL Y TITULACI&Oacute;N<BR />
FACULTAD DE IDIOMAS<BR />
</span>
</p>
</div>
</body>
</html>
