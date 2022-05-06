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
    <p class="page" align="right">
    <span style="font-size:14px">
    Oaxaca de Ju&aacute;rez,Oax.,
    <?php date_default_timezone_set('UTC'); date_default_timezone_set("America/Mexico_City");
    echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y'); ?>
     <BR />Oficio F.I/CSST/<?php echo date('Y');?>/201<BR />
    ASUNTO: Oficio de Presentaci&oacute;n<BR />
    </span>
    </p>
    <BR />
    <BR />
    <p class="page" align="justify">
    <span style="font-size:14px">
    <strong> TITULAR DE LA DEPENDENCIA </strong><BR />
    <strong> CARGO DEL TITULAR </strong><BR />
    <strong> NOMBRE DE LA DEPENDENCIA </strong><BR />
    <strong>PRESENTE</strong><BR />
  </p>
  </span>
    <BR />
    <p class="page" align="justify">
    <span style="font-size:14px">
    A trav&eacute;s de este conducto me permito presentar a usted a el/la C. <strong>
  </strong>
    con n&uacute;mero de matr&iacute;cula <strong></strong>
    alumno(a) de la carrera de la LICENCIATURA EN ENSE&Ntilde;ANZA DE IDIOMAS que cursa el
    <strong></strong>
    semestre en la FACULTAD DE IDIOMAS OAXACA de la modalidad
    <strong></strong>
    de la Universidad Auton&oacute;ma "Benito Ju&aacute;arez"
    de Oaxaca, quien desea realizar sus Pr&aacute;cticas Profesionales en esa dependencia en su cargo.
  </p>
  </span>
<p class="page" align="justify">
<span style="font-size:14px">
El/la alumno(a) citado(a) deberá cubrir ______ horas durante ______ meses a partir de esta fecha.
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
LIC. KIARA RIOS RIOS<BR />
COORDINADOR(A) DE SERVICIO SOCIAL Y TITULACI&Oacute;N<BR />
FACULTAD DE IDIOMAS<BR />
</span>
</p>
</div>
</body>
</html>
