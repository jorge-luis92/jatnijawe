<html>
<head>
  <style>
    @page { margin: 130px 100px; }
    #header { position: fixed; left: -60px; top: -100px; right: -50px; height: 150px; color:#000000; }
    #footer { position: fixed; left: -10px; bottom: -180px; right: -50px; height: 180px; color:#000000;  }
    #footer .page:after { }
  </style>

  <?php
  $arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
       $arrayDias = array( 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
     ?>

<body >

<div id="header" >
<img width="95" height="95" src="image/logos_idiomas/image1247.jpg" align="left">
<img width="85" height="95" src="image/logos_idiomas/logo_idiomas.jpg" align="right">
<p align="center">
<span style="font-size:16px">
<BR />
<strong>Universidad Autónoma &quot;Benito Juárez&quot; de Oaxaca</strong><br/>
FACULTAD DE IDIOMAS  <br/>
</span>
</span>
</p>

<p align="center">
<img width="730" src="image/logos_idiomas/barra.jpg">
</p>
</div>

<BR />

<div id="footer">
<p align="right">
<img width="730" src="image/logos_idiomas/barra.jpg">
<span style="text-align:center; font-size:12px">
<center>Burgoa s/n, Col Centro, C.P. 68000, Tel. y Fax. 51 4 00 49 <BR />
Av. Universidad s/n, Ex. Hacienda de 5 Señores, C.P. 68120, Tel. y Fax. 57 2 52 16<BR />
  Correo electrico: idiomas@uabjo.mx Página web: www.idiomas.uabjo.mx</center>
</span>
</p>
</div>

<div id="content">
<p class="page" align="center">
<br />
<span style="text-align:center; font-size:18px"><strong><em>OTORGA LA PRESENTE</em></strong></span><br/>
<span style="text-align:center; font-size:28px"><strong>C O N S T A N C I A<br /></strong></span> <br />
</p>

<p class="page" align="center">
<span style="text-align:center; font-size:16px">
  <strong> A: {{$data->nombre}} {{$data->apellido_paterno}} {{$data->apellido_materno}}</strong>
</span> <br />
</p>

<p class="page" align="center">
<br />
<span style="text-align:center; font-size:14px">
<strong>Por haber concluido con el total de horas extracurriculares en las siguientes actividades:
</strong>
</span>
</p>
<br />
  <table class="page">
            	<tr>
                	<td>
                   
                   <span style="font-size:14px"> <strong> ACAD&Eacute;MICA</strong></span><br />
                    @foreach($aca as $acade)
                       &nbsp;&nbsp;&nbsp;»&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$acade->nombre_ec}} <br />
    @endforeach
                    </td>
                    </tr>
                    <tr>
                    <td>
                    <br />
                   
                   <span style="font-size:14px"> <strong>CULTURAL</strong></span><br />
                     @foreach($cul as $cultu)
    &nbsp;&nbsp;&nbsp;»&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$cultu->nombre_ec}} <br />
    @endforeach
                    </td>
                    
                </tr>
                <tr>
                    <td>
                    <br />
                   
                   <span style="font-size:14px"> <strong>DEPORTIVA</strong></span><br />
                     @foreach($dep as $depor)
    &nbsp;&nbsp;&nbsp;»&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$depor->nombre_ec}} <br />
    @endforeach
                    </td>
                    
                </tr>
               
            </table>

<br />

<div style="page-break-before: auto;"></div>

<p class="page" align="left">
<span style="text-align:center; font-size:12px">
A petici&oacute;n del o la interesado(a) se extiende la presente para los usos administrativos y acad&eacute;micos a que haya lugar,
en la ciudad de Oaxaca de Ju&aacute;rez, Oax. <?php date_default_timezone_set('UTC'); date_default_timezone_set("America/Mexico_City");
echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y'); ?><br /><br /><br />
</span>
</p>
<br />
<br /><br /><br />

  <span style="text-align:center; font-size:18px"><center></strong><em>"CIENCIA ARTE Y LIBERTAD" </em></center></strong><span>

<br/>

<div style="page-break-before: auto;"></div>

</div>

</body>

</html>
