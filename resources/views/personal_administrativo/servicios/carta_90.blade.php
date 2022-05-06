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
    <h4>UNIVERSIDAD AUT&Oacute;NOMA "BENITO JU&Aacute;REZ" DE OAXACA</h4></br>
    <hr style="height:1px; border:none; color:#0B0B3B; background-color:#0B0B3B; width:85%; text-align:left; margin: 0 auto 0 0;">
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
    <p class="page" align="justify">
    <span style="font-size:14px">
    LIC. EMILIO OSORIO CRUZ<BR />
    DIRECTOR DE SERVICIO SOCIAL<BR />
    DE LA UABJO<BR />
    <strong>PRESENTE</strong><BR />
    <BR />
  </p>
  </span>
    <BR />
    <p class="page" align="justify">
    <span style="font-size:14px;">
    {{$gencor}} que suscribe LIC. <?php if(empty($datos_coordinadora->nombre)){ $vacio=null; echo $vacio;} else{ echo $datos_coordinadora->nombre." ".$datos_coordinadora->apellido_paterno;} ?> <?php if(empty($datos_coordinadora->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $datos_coordinadora->apellido_materno;} ?>,
		{{$mincor}} de Servicio Social y Titulaci&oacute;n
    de la Facultad de Idiomas de la Universidad Aut&oacute;noma "Benito Ju&aacute;rez" de Oaxaca,<BR/>
  </p>
  </span>
  <p class="page" align="CENTER">
  <span style="font-size:16px">
  <strong>HACE CONSTAR </strong><BR />
  </p>
  </span>
  <p class="page" align="justify">
  <span style="font-size:14px;">
  Que el/la C. <strong><?php if(empty($data->nombre)){ $vacio=null; echo $vacio;} else{ echo $data->nombre." ".$data->apellido_paterno;} ?> <?php if(empty($data->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $data->apellido_materno;} ?></strong>
  con matrícula escolar <strong>{{$data->matricula}} </strong> y que cursa el <strong>{{$semest}} semestre</strong> cuenta con el <strong><?php if(empty($datos_di->procentaje_avance)){ $vacio=null; echo $vacio;} else{ echo $datos_di->procentaje_avance;} ?> %</strong> de los cr&eacute;ditos totales de la
<strong>  LICENCIATURA EN ENSE&Ntilde;ANZA DE IDIOMAS</strong> en la modalidad
<strong> <?php if(empty($modalidad)){ $vacio=null; echo $vacio;} else{ echo $modalidad;} ?></strong>.
</p>
</span>

<p class="page" align="justify">
<span style="font-size:14px" >
A petici&oacute;n del/la interesado/a y para los usos legales que el estime convenientes, 
se extiende la presente en la Ciudad de Oaxaca de Ju&aacute;rez, Oax., a los
<?php date_default_timezone_set('UTC'); date_default_timezone_set("America/Mexico_City");
echo date('d')." días del mes de  ".$arrayMeses[date('m')-1]." del año ".date('Y'); ?>.
</span>
</p>

<BR /><BR />
<p class="page" align="CENTER">
<span style="font-size:14px">
ATENTAMENTE
</span>
</p>
<p class="page" align="CENTER">
<span style="font-size:14px">
<strong>"CIENCIA, ARTE, LIBERTAD"</strong>
</span>
</p>
<BR />
<p class="page" align="CENTER">
<span style="font-size:14px">
<strong>
LIC. <?php if(empty($datos_coordinadora->nombre)){ $vacio=null; echo $vacio;} else{ echo $datos_coordinadora->nombre." ".$datos_coordinadora->apellido_paterno;} ?> <?php if(empty($datos_coordinadora->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $datos_coordinadora->apellido_materno;} ?><BR />
	{{$elcor}} DE SERVICIO SOCIAL Y TITULACI&Oacute;N<BR />
</strong>
</span>
</p>
</div>
</body>
</html>
