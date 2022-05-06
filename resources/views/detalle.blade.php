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
  <td width="150">ALUMNO (  )</td>
  <td width="150"  align="center">SEMESTRE: 3

  </td>
  <td width="100" align="center">GRUPO: F
    </td>
  </tr>
  </table>
  <br/>
<table id="generales1" style="font-size:14px" WIDTH="500">
  <td width="110">De la Carrera
  <input name="matpend"  type="text" required id="matpend" value="" size="35"/></td>
  <td width="150"  align="center">de la modalidad:

  </td>
</table>
<table id="generales1" style="font-size:14px" WIDTH="500">
<td width="150"  align="left">  de nuestra Universidad. </td>
</table>
<table id="generales2" style="font-size:14px" WIDTH="500" >
  <tr>
    <td width="150">Nombre del alumno(a):

    </td>
  </tr>
</table>

<table id="generales2" style="font-size:14px" WIDTH="500" >
  <tr>
    <td width="10" align="left">Matrícula:

    </td>
    <td width="80">CURP:

    </td>
    <td width="10" align="left">Edad:

    </td>
  </tr>
</table>

<table id="personales1" style="font-size:14px" WIDTH="500">
<tr>
<td>Domicilio actual:
<input name="matpend"  type="text" required id="matpend" value="" size="55"/>
</td>
</tr>
</table>
<table id="personales2" style="font-size:14px" WIDTH="500">
  <tr>
  <td>Tel&eacute;fono Celular:
<input name="matpend"  type="text" required id="matpend" value="" size="16"/>
  </td>
  <td >Correo Electrónico:
 <input name="email" type="text" required id="email" value="<?php if(empty($data->email)){ $vacio=null; echo $vacio;} else{ echo $data->email;} ?>" size="20"/></td>
  </td>
  </tr>
</table>
<br/>
<table id="personales2" style="font-size:14px" WIDTH="500">
  <tr>
  <td>Mis estudios iniciarion el día
    <?php
    $practicas_dependencia = DB::table('practicas')
   ->select('practicas.id_practicas', 'practicas.nombre_dependencia', 'practicas.cargo_titular', 'practicas.fecha',
   'personas.nombre', 'personas.apellido_paterno', 'personas.apellido_materno')
   ->join('personas', 'personas.id_persona', '=', 'practicas.titular')
   ->where('practicas.matricula', '=', '13161458')
   ->take(1)
   ->first();
    date_default_timezone_set('UTC'); date_default_timezone_set("America/Mexico_City");
    echo $arrayDias[date('w', strtotime($practicas_dependencia->fecha))].", ".date('d', strtotime($practicas_dependencia->fecha))." de ".$arrayMeses[date('m', strtotime($practicas_dependencia->fecha))-1]." de ".date('Y', strtotime($practicas_dependencia->fecha)); ?>
  </td>
  </tr>
</table>
<br/>
<hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
<hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
<br/>
<table id="personales1" style="font-size:14px" WIDTH="500">
<tr>
<td>Nombre de la Institución o Dependencia donde realizará Prácticas Profesionales:
</td>
</tr>
</table>
<table id="personales1" style="font-size:14px" WIDTH="500">
<tr>
<td>
  <input name="matpend"  type="text" required id="matpend" value="" size="60"/>
</td>
</tr>
</table>
<table id="personales1" style="font-size:14px" WIDTH="500">
<tr>
<td>Dirección:
<input name="matpend"  type="text" required id="matpend" value="" size="53"/>
</td>
</tr>
</table>
<table id="personales2" style="font-size:14px" WIDTH="500">
  <tr>
  <td>Tel&eacute;fono:
<input name="matpend"  type="text" required id="matpend" value="" size="16"/>
  </td>
  </tr>
</table>
<table id="generales2" style="font-size:14px" WIDTH="500" >
  <tr>
    <td width="150" align="justify">Nombre del titular de la Dependencia o persona a quien irá dirigido el Oficio de Presentación: <br/>
          </td>
  </tr>
  <tr>
    <td> Cargo del titular:
    <input name="matpend"  type="text" required id="matpend" value="" size="48"/>
  </td>
</tr>
</table>
<br/>
<hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
<hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
<table id="generales1" style="font-size:14px" WIDTH="500">
<tr>
<td width="150" align="right">Periodo:</td>

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
<span style="font-size:14px">
<strong>__________________________________________</strong>
<br/>
<strong>NOMBRE Y FIRMA DEL SOLICITANTE</strong>
</span>
</p>


</div>
</body>
</html>
