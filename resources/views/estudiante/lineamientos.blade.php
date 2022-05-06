<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_estudiante')
@section('title')
: Lineamientos
@endsection

@section('seccion')
@include('flash-message')
<div class="container" id="font2">
  </br>
  <h1 style="font-size: 2.0em; color: #000000;" align="center">Perfil del Estudiante</h1>
  <h4 style="font-size: 2.0em; color: #000000;" align="center">Lineamientos</h4>

<h6 style="font-size: 1.0em; color: #000000;" align="center"><strong>
Lineamientos para la licenciatura en la Enseñanza de Idiomas de la Uiversidad Autónoma "Benito Juárez" de Oaxaca:
</strong></h6></br>
 <form method="POST" action="{{ route('acepto_lineamientos') }}">
    @csrf
<div class="form-row">
<div class="form-group col-md-1">
<input type="checkbox" name="manual-bienvenida" value="verificado" required>
</div>
<div class="form-group col-md-7">
MANUAL DE BIENVENIDA
</div>
<div class="form-group col-md-2">
<a target="_blank"  href="{{asset('lineamientos_es/manual-bienvenida.pdf')}}"  ><i class="fa fa-eye" aria-hidden="true"> </i> VER</a>
</div>
<div class="form-group col-md-2">
<a  href="download/{{'manual-bienvenida.pdf'}}"><i class="fa fa-download" aria-hidden="true"></i> DESCARGAR</a>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-1">
<input type="checkbox" name="manual-organizacion" value="verificado" required>
</div>
<div class="form-group col-md-7">
MANUAL DE ORGANIZACIÓN Y FUNCIONES
</div>
<div class="form-group col-md-2">
<a target="_blank"  href="{{asset('lineamientos_es/manual-organizacion.pdf')}}"><i class="fa fa-eye" aria-hidden="true"></i> VER</a>
</div>
<div class="form-group col-md-2">
<a href="download/{{'manual-organizacion.pdf'}}"><i class="fa fa-download" aria-hidden="true"></i> DESCARGAR</a>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-1">
<input type="checkbox" name="plan-desarrollo" value="verificado" required>
</div>
<div class="form-group col-md-7">
PLAN DE DESARROLLO 2018 - 2021
</div>
<div class="form-group col-md-2">
<a target="_blank"  href="{{asset('lineamientos_es/plan-desarrollo.pdf')}}"><i class="fa fa-eye" aria-hidden="true"></i> VER</a>
</div>
<div class="form-group col-md-2">
<a href="download/{{'plan-desarrollo.pdf'}}"><i class="fa fa-download" aria-hidden="true"></i> DESCARGAR</a>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-1">
<input type="checkbox" name="reglamento-ingreso-permanencia-egreso" value="verificado" required>
</div>
<div class="form-group col-md-7">
REGLAMENTO PARA EL INGRESO, PERMANENCIA Y EGRESO
</div>
<div class="form-group col-md-2">
<a target="_blank"  href="{{asset('lineamientos_es/reglamento-ingreso-permanencia-egreso.pdf')}}"><i class="fa fa-eye" aria-hidden="true"></i> VER</a>
</div>
<div class="form-group col-md-2">
<a href="download/{{'reglamento-ingreso-permanencia-egreso.pdf'}}"><i class="fa fa-download" aria-hidden="true"></i> DESCARGAR</a>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-1">
<input type="checkbox" name="reglamento-defernsoria" value="verificado" required>
</div>
<div class="form-group col-md-7">
REGLAMENTO DE LA DEFENSORÍA DE LOS DERECHOS UNIVERSITARIOS
</div>
<div class="form-group col-md-2">
<a target="_blank"  href="{{asset('lineamientos_es/reglamento-defensoria.pdf')}}"><i class="fa fa-eye" aria-hidden="true"></i> VER</a>
</div>
<div class="form-group col-md-2">
<a href="download/{{'reglamento-defensoria.pdf'}}"><i class="fa fa-download" aria-hidden="true"></i> DESCARGAR</a>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-1">
<input type="checkbox" name="reglamento-leyorganica" value="verificado" required>
</div>
<div class="form-group col-md-7">
REGLAMENTO DE LA LEY ORGÁNICA
</div>
<div class="form-group col-md-2">
<a target="_blank"  href="{{asset('lineamientos_es/reglamentodelaLeyOrganica.pdf')}}"><i class="fa fa-eye" aria-hidden="true"></i> VER</a>
</div>
<div class="form-group col-md-2">
<a href="download/{{'reglamentodelaLeyOrganica.pdf'}}"><i class="fa fa-download" aria-hidden="true"></i> DESCARGAR</a>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-1">
<input type="checkbox" name="equipamiento-salon" value="verificado" required>
</div>
<div class="form-group col-md-7">
REGLAMENTO DE EQUIPAMIENTO DEL SALÓN
</div>
<div class="form-group col-md-2">
<a target="_blank"  href="{{asset('lineamientos_es/equipamiento-salon.pdf')}}"><i class="fa fa-eye" aria-hidden="true"></i> VER</a>
</div>
<div class="form-group col-md-2">
<a href="download/{{'equipamiento-salon.pdf'}}"><i class="fa fa-download" aria-hidden="true"></i> DESCARGAR</a>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-1">
<input type="checkbox" name="reglamento-cc" value="verificado" required>
</div>
<div class="form-group col-md-7">
REGLAMENTO DEL CENTRO DE CÓMPUTO
</div>
<div class="form-group col-md-2">
<a target="_blank"  href="{{asset('lineamientos_es/reglamento-cc.pdf')}}"><i class="fa fa-eye" aria-hidden="true"></i> VER</a>
</div>
<div class="form-group col-md-2">
<a href="download/{{'reglamento-cc.pdf'}}"><i class="fa fa-download" aria-hidden="true"></i> DESCARGAR</a>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-1">
<input type="checkbox" name="reglamento-biblioteca" value="verificado" required>
</div>
<div class="form-group col-md-7">
REGLAMENTO DE BIBLIOTECA
</div>
<div class="form-group col-md-2">
<a target="_blank"  href="{{asset('lineamientos_es/reglamento-biblioteca.pdf')}}"><i class="fa fa-eye" aria-hidden="true"></i> VER</a>
</div>
<div class="form-group col-md-2">
<a href="download/{{'reglamento-biblioteca.pdf'}}"><i class="fa fa-download" aria-hidden="true"></i> DESCARGAR</a>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-1">
<input type="checkbox" name="reglamento-areasverdes" value="verificado" required>
</div>
<div class="form-group col-md-7">
REGLAMENTO DE ÁREAS VERDES Y DEPORTIVAS
</div>
<div class="form-group col-md-2">
<a target="_blank"  href="{{asset('lineamientos_es/reglamento-areasverdes.pdf')}}"><i class="fa fa-eye" aria-hidden="true"></i> VER</a>
</div>
<div class="form-group col-md-2">
<a href="download/{{'reglamento-areasverdes.pdf'}}"><i class="fa fa-download" aria-hidden="true"></i> DESCARGAR</a>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-1">
<input type="checkbox" name="reglamento-ss" value="verificado" required>
</div>
<div class="form-group col-md-7">
REGLAMENTO DE SERVICIO SOCIAL
</div>
<div class="form-group col-md-2">
<a target="_blank"  href="{{asset('lineamientos_es/reglamento-ss.pdf')}}"><i class="fa fa-eye" aria-hidden="true"></i> VER</a>
</div>
<div class="form-group col-md-2">
<a href="download/{{'reglamento-ss.pdf'}}"><i class="fa fa-download" aria-hidden="true"></i> DESCARGAR</a>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-1">
<input type="checkbox" name="reglamento-titulacion" value="verificado" required>
</div>
<div class="form-group col-md-7">
REGLAMENTO DE TITULACIÓN PROFESIONAL
</div>
<div class="form-group col-md-2">
<a target="_blank"  href="{{asset('lineamientos_es/reglamento-titulacion.pdf')}}"><i class="fa fa-eye" aria-hidden="true"></i> VER</a>
</div>
<div class="form-group col-md-2">
<a href="download/{{'reglamento-titulacion.pdf'}}"><i class="fa fa-download" aria-hidden="true"></i> DESCARGAR</a>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-1">
<input type="checkbox" name="reglamento-posgrado" value="verificado" required>
</div>
<div class="form-group col-md-7">
REGLAMENTO DE ESTUDIOS DE POSGRADO
</div>
<div class="form-group col-md-2">
<a target="_blank"  href="{{asset('lineamientos_es/reglamento-posgrado.pdf')}}"><i class="fa fa-eye" aria-hidden="true"></i> VER</a>
</div>
<div class="form-group col-md-2">
<a href="download/{{'reglamento-posgrado.pdf'}}"><i class="fa fa-download" aria-hidden="true"></i> DESCARGAR</a>
</div>
</div>
<div class="form-group" id="labels">
 <br>
   <div class="form-group">
       <div class="col-xs-offset-2 col-xs-9" align="center">
         <a  class="btn btn-primary" href="#" data-toggle="modal" data-target="#logoutModales">Aceptar </a>
         <!--  <button type="button"  class="btn btn-secondary" data-dismiss="modal">Cancelar</button>-->
       </div>
   </div>
</div>

</div>


<div class="modal fade" id="logoutModales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">¿Confirmar?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Al enviar aceptas haber leído todos los lineamientos, reglamentos y manuales de tu Facultad, confirmando estar enterado y de acuerdo con los mismos.</div>
      <div class="modal-footer">
	 
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" name="lineamiento_aceptado" value="1" type="submit" >Enviar</button>

      </div>
    </div>
  </div>
  </form>
</div>

  @endsection
