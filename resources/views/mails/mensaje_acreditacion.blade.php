<!doctype html>
<html >
<head>
<title>Acreditación de Taller</title>
</head>

<body >

</body>
<p><strong>Coordinación de Formación Integral<strong></p>
<p>De: Lic. Ana Edith López Cruz(Coordinadora de Formación Integral)
<p>Para:  {{ $datos_correo->nombre}} {{ $datos_correo->apellido_paterno}} {{ $datos_correo->apellido_materno}} </p>
<p>Asunto:  {{ $datos_recibidos['asunto']}}</p>
<p>Nombre del Taller:  {{ $datos_taller->nombre_ec}} </p>
<p>Mensaje: {{ $datos_recibidos['contenido']}}</p>
</html>
