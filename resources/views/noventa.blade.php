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
                   'Miercoles', 'Jueves', 'Viernes', 'Sabado');
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
    <span style="font-size:14px">
    El/la que suscribe LIC. KIARA RÍOS RÍOS, Coordinador(a) de Servicio Social y Titulaci&oacute;n
    de la Facultad de Idiomas de la Universidad Aut&oacute;noma "Benito Ju&acute;arez" de Oaxaca,<BR/>
  </p>
  </span>
  <p class="page" align="CENTER">
  <span style="font-size:16px">
  <strong>HACE CONSTAR</strong><BR />
  </p>
  </span>
  <p class="page" align="justify">
  <span style="font-size:14px">
  Que el/la C. <strong>
  </strong>
  cuenta con el <strong>90 %</strong> de los cr&eacute;ditos totales de la
<strong>  LICENCIATURA EN ENSE&Ntilde;ANZA DE IDIOMAS</strong> de la modalidad
<strong></strong>.
</p>
</span>

<p class="page" align="justify">
<span style="font-size:14px">
A petici&oacute;n del/la interesado(a) se extiende la presente para los usos legales a que haya lugar,
en la Ciudad de Oaxaca de Ju&aacute;rez, Oax., a
<?php date_default_timezone_set('UTC'); date_default_timezone_set("America/Mexico_City");
echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y'); ?>.
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
<strong>"CIENCIA ARTE Y LIBERTAD"</strong>
</span>
</p>
<BR />
<p class="page" align="CENTER">
<span style="font-size:14px">
<strong>
LIC. KIARA RIOS RIOS<BR />
COORDINADOR(A) DE SERVICIO SOCIAL Y TITULACI&Oacute;N<BR />
</strong>
</span>
</p>
</div>
</body>
</html>
