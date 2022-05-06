<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
:Talleres
@endsection
 @section('seccion')

 <p align="left">&nbsp;&nbsp;
 <a href="/lista_inscritos_talleres/{{$detalles->id_extracurricular}}/{{$detalles->id_tutor}}" target="_blank"><i class="fas fa-file-download"></i> Lista Inscritos </a>
</p>
                 
<div class="container" style="background-color:#87CEFA; " id="font7">
 </br>
       @include('flash-message')  
	    <h2 style="font-size: 1.3em; color: #000000;" align="center">Detalles del Taller: {{$detalles->nombre_ec}}</h2>


<div class="form-row">
<div class="form-group col-md-3">
<label for="cupo"><strong>Fecha de Registro</strong></label>
<input type="" name="created_at" disabled class="form-control" id="labels" onKeyUp="this.value = this.value.toUpperCase()" value="{{ date('d-m-Y H:i a', strtotime($detalles->created_at))}}" >
</div>
<div class="form-group col-md-1">
<label for="cupo"><strong>Cupo</strong></label>
<input type="" name="cupo" disabled class="form-control" value="{{$detalles->cupo}}" onKeyUp="this.value = this.value.toUpperCase()"  id="labels">
</div>
<div class="form-group col-md-1">
<label for="inscritos"><strong>Inscritos</strong></label>
<input type="" name="insccritos" disabled value="<?php $inscritos= ($detalles->cupo)-($detalles->control_cupo); echo $inscritos;?>" class="form-control" onKeyUp="this.value = this.value.toUpperCase()"  id="labels">
</div>
<div class="form-group col-md-2">
<label for="inscritos"><strong>Lugares Disponibles</strong></label>
<input type="" name="insccritos" disabled value="{{$detalles->control_cupo}}" class="form-control" onKeyUp="this.value = this.value.toUpperCase()" id="labels">
</div>
<div class="form-group col-md-3">
<label for="inscritos"><strong>Modalidad</strong></label>
<input type="" name="insccritos" disabled value="{{$detalles->modalidad}}" class="form-control" onKeyUp="this.value = this.value.toUpperCase()" id="labels">
</div>
<div class="form-group col-md-2">
<label for="inscritos"><strong>Area</strong></label>
<input type="" name="insccritos" disabled value="{{$detalles->area}}" class="form-control" onKeyUp="this.value = this.value.toUpperCase()" id="labels">
</div>

</div>

<div class="form-row">
<div class="form-group col-md-3" >
<label for="fecha_inicio"><strong>Fecha de Inicio</strong></label>
<input type="date" id="labels" class="form-control" disabled id="fecha_inicio" value="{{ $detalles->fecha_inicio }}" >
</div>
<div class="form-group col-md-3" id="labels">
<label for="fecha_fin"><strong>Fecha Final</strong></label>
<input type="date"  id="labels" class="form-control" disabled id="fecha_fin" value="{{ $detalles->fecha_fin }}" >
</div>
<div class="form-group col-md-3">
<label for="hora_inicio"><strong>Hora de Entrada</strong></label>
<input type="text"class="form-control" id="labels" disabled name="hora_inicio" value="<?php if(empty($detalles->hora_inicio)){ $vacio=null; echo $vacio;} else{ echo date("H:i a", strtotime($detalles->hora_inicio));}?>">
</div>
<div class="form-group col-md-3" >
<label for="hora_fin"><strong>Hora de Salida</strong></label>
<input type="text" class="form-control"  id="labels" disabled name="hora_fin"  value="<?php if(empty($detalles->hora_fin)){ $vacio=null; echo $vacio;} else{ echo date("H:i a", strtotime($detalles->hora_fin));}?>" id="hora_fin">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="dias_sem"><strong>Días de la semana:</strong></label>
<input type="text"class="form-control" disabled name="dias_sem" value="<?php if(empty($detalles->dias_sem)){ $vacio=null; echo $vacio;} else{ echo $detalles->dias_sem;}?>" onKeyUp="this.value = this.value.toUpperCase()" id="labels">
</div>
<div class="form-group col-md-8">
<label for="lugar"><strong>Lugar</strong></label>
<input type="text" class="form-control" id="labels" disabled name="lugar" value="<?php if(empty($detalles->lugar)){ $vacio=null; echo $vacio;} else{ echo $detalles->lugar;}?>" onKeyUp="this.value = this.value.toUpperCase()" id="lugar" onKeyUp="this.value = this.value.toUpperCase();">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-10">
<label for="materiales"><strong>Materiales</strong></label>
<input type="text"class="form-control" disabled value="<?php if(empty($detalles->materiales)){ $vacio=null; echo $vacio;} else{ echo $detalles->materiales;}?>"  name="materiales" onKeyUp="this.value = this.value.toUpperCase()" id="labels">
</div>
<div class="form-group col-md-2">
<label for="inscritos"><strong>Créditos</strong></label>
<input type="" name="insccritos" disabled value="{{$detalles->creditos}}" class="form-control" onKeyUp="this.value = this.value.toUpperCase()" id="labels">
</div>
</div>
</div>
</br>

  @endsection
