<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Avance Estudiante
@endsection
 @section('seccion')

 <form method="POST" action="{{ route('busqueda_encuesta') }}"  >
       @csrf
	    <label for="id_periodo"><strong>Seleccione un Periodo:</strong></label>
 <div class="form-row">
 
   <div class="form-group col-md-6">
             <select name="id_periodo" id="id_periodo" style="background: #0B173B; color: white;" required class="form-control">
         @foreach ($fechas_p as $curricular)
         <option value="{!! $curricular->id_periodo !!}">  {!! date('F Y', strtotime($curricular->inicio)); !!} - {!! date('F Y', strtotime($curricular->final)) !!}</option>
           @endforeach
       </select>

   </div>
   
   <span class="input-group-btn">
                   <button class="btn btn-info" type="submit"><span>&nbsp;
                <i class="fa fa-search" ></i>Consultar</span>
                   </button>
                </span>
</div>


  </form>
  @if(isset($details))
<h1 style="font-size: 1.5em; color: #000000;" align="left"> Resultados de encuestas a los Estudiantes: <strong> Periodo ({!! date('F - Y', strtotime($otro_p->inicio)); !!} - {!! date('F - Y', strtotime($otro_p->final)) !!})<strong></h1>
<h1 style="font-size: 1.5em; color: #000000;" align="left"> </h1>

<h2 style="font-size: 1.3em; color: #000000;" align="left">Valor Máximo de Desempeño de Tutor = 5   </h2>
<label><strong> Encuestados: {{$details}}</strong> </label></br>
<label style="font-size: 1.0em; color: #000000;"><strong>Datos generales</strong> </label>
       <div class="table-responsive" style="border:1px solid #819FF7;">
         <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;margin:auto;"  >
             <thead>
               <tr style="color: #000000;">
                   <th>Preguntas</th>
                   <th>Total</th>

                               </tr>
           </thead>
           <tbody>
               <tr style="color: #000000;">
                 <td>Estudiantes con acompañamiento de un tutor</td>
                 <td>{{$si_tu}}</td >
               </tr>
               <tr style="color: #000000;">
                 <td>Promedio Desempeño Tutores</td>
                 <td>{{$dese}}</td >
               </tr>
               <tr style="color: #000000;">
                 <td>Estudiantes sin acompañamiento de un tutor</td>
                 <td>{{$no_tu}}</td >
               </tr>
               <tr style="color: #000000;">
                 <td>Número de Estudiantes que optan por trabajar con su tutor en el Área Académica</td>
                 <td>{{$voto_a}}</td >
               </tr>
               <tr style="color: #000000;">
                 <td>Número de Estudiantes que optan por trabajar con su tutor en el Área Emocional </td>
                 <td>{{$voto_e}}</td >
               </tr>
               <tr style="color: #000000;">
                 <td>Número de Estudiantes que optan por trabajar con su tutor en el Áreas de Cuidado de la Salud  </td>
                 <td>{{$voto_s}}</td >
               </tr>
               <tr style="color: #000000;">
                 <td>Número de Estudiantes que optan por trabajar con su tutor en el Área de Actitudes y Valores    </td>
                 <td>{{$voto_v}}</td >
               </tr>
               <tr style="color: #000000;">
                 <td>Número de Estudiantes que optan por trabajar con su tutor en el Área de Relaciones inter e intra personales  </td>
                 <td>{{$voto_r}}</td >
               </tr>
           </tbody>
       </table>
 </div>
 </br>
   <label style="font-size: 1.0em; color: #000000;"><strong>Datos específicos </strong> </label>
    </br>
   <div class="table-responsive" style="border:1px solid #819FF7;">
     <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;margin:auto;"  >
         <thead>
           <tr style="color: #000000;">
               <th>Acompañamiento de tutor</th>
               <th>Desempeño de Tutor</th>
               <th>Área Acádemica</th>
               <th>Área Emocional</th>
               <th>Área Cuidado de Salud</th>
               <th>Área Actitudes y Valores</th>
               <th>Área Relaciones inter e intra personales</th>

                           </tr>
       </thead>
       <tbody>
         @foreach($datos_encuesta as $estudiant)
           <tr style="color: #000000;">
             <td><?php if(empty($estudiant->acompaniamiento_tutor)){ echo "NO";}else {echo "SI";} ?></td>
             <td><?php if(empty($estudiant->desempenio_tutor)){ echo "";}else {echo $estudiant->desempenio_tutor;} ?></td >
             <td><?php if(empty($estudiant->area_academico)){ echo "NO";}else {echo "SI";} ?></td>
             <td><?php if(empty($estudiant->area_emocional)){ echo "NO";}else {echo "SI";} ?></td >
             <td><?php if(empty($estudiant->area_salud)){ echo "NO";}else {echo "SI";} ?></td>
             <td><?php if(empty($estudiant->area_valores)){ echo "NO";}else {echo "SI";} ?></td >
             <td><?php if(empty($estudiant->area_relaciones)){ echo "NO";}else {echo "SI";} ?></td>
                        </tr>
@endforeach
       </tbody>
   </table>
   </div>
   </br>
       @endif
  @endsection
