<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_servicios')
@section('title')
:Solicitudes
@endsection
 @section('seccion')
 @include('flash-message')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Solicitudes de Practicas Profesionales </h1>
 <div class="container" id="font7">
 </br>
 <form action="{{route ('busqueda_solicitudes_pr')}}" method="POST" role="search">
        {{ csrf_field() }}
         <div class="form-row">

           <div class="input-group col-md-6">
             <!--   <input type="text" ng-model="test" class="search-query form-control" placeholder="Nombre de familia"><p>&nbsp;</p>
    --><input type="text" class="form-control" name="q" placeholder="Ingrese Matrícula"><p>&nbsp;</p>
                   <span class="input-group-btn">
                     <button class="btn btn-danger" type="submit"><span>&nbsp;
                   <i class="fa fa-search" ></i></span>
                      </button>
                   </span>
            </div>
    </div>
    </form>
	 @if(isset($details))
 <div class="table-responsive" style="border:1px solid #819FF7;">
                                <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >

                                 <thead>
                                   <tr>
                                    <th scope="col">ESTUDIANTE</th>
                                    <th scope="col">NOMBRE</th>
                                    <th scope="col">DEPENDENCIA</th>
                                    <th scope="col">CARGO DE TITULAR</th>
                                    <th scope="col">ESTATUS</th>
                                    <th scope="col">PERIODO DE PRÁCTICAS</th>
                                    <th scope="col">FECHA SOLICITUD</th>
                                    <th colspan="2" style="text-align: center;" >ACCIONES</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                   @foreach($details as $detalles)
                                   <tr style="color: #000000;">
                                   <td>{{$detalles->matricula}}</td>
                                   <td>{{$detalles->nombre}} {{$detalles->apellido_paterno}} {{$detalles->apellido_materno}}</td>
                                   <td>{{$detalles->nombre_dependencia}}</td>
                                   <td>{{$detalles->cargo_titular}}</td>
                                   <td>{{$detalles->estatus_practica}}</td>
                                   <td>{{$detalles->periodo_practicas}}</td>
                                   <td>{{date("d-m-y", strtotime($detalles->fecha))}}</td>
                                   <td><a href="pdf_solicitud_practica_estudiantes/{{$detalles->matricula}}" target="_blank">VER SOLICITUD</a></td>
                                   <td> <a href="practicas_aprobar/{{$detalles->id_practicas}}">APROBAR</a></td>


                                       </tr>
                                       @endforeach
                                   </tbody>
                               </table>
                             </div>
                              @if (count($details))
    {{ $details->links() }}
  @endif
  @endif
  
                             <br />	
 <div class="table-responsive" style="border:1px solid #819FF7;">
                                <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >

                                 <thead>
                                   <tr>
                                    <th scope="col">ESTUDIANTE</th>
                                    <th scope="col">NOMBRE</th>
                                    <th scope="col">DEPENDENCIA</th>
                                    <th scope="col">CARGO DE TITULAR</th>
                                    <th scope="col">ESTATUS</th>
                                    <th scope="col">PERIODO DE PRÁCTICAS</th>
                                    <th scope="col">FECHA SOLICITUD</th>
                                    <th colspan="2"  style="text-align: center;">ACCIONES</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                   @foreach($practicas as $detalles)
                                   <tr style="color: #000000;">
                                   <td>{{$detalles->matricula}}</td>
                                   <td>{{$detalles->nombre}} {{$detalles->apellido_paterno}} {{$detalles->apellido_materno}}</td>
                                   <td>{{$detalles->nombre_dependencia}}</td>
                                   <td>{{$detalles->cargo_titular}}</td>
                                   <td>{{$detalles->estatus_practica}}</td>
                                   <td>{{$detalles->periodo_practicas}}</td>
                                   <td>{{date("d-m-y", strtotime($detalles->fecha))}}</td>
                                   <td><a href="pdf_solicitud_practica_estudiantes/{{$detalles->matricula}}" target="_blank">VER SOLICITUD</a></td>
                                   <td> <a href="practicas_aprobar/{{$detalles->id_practicas}}">APROBAR</a></td>


                                       </tr>
                                       @endforeach
                                   </tbody>
                               </table>
                             </div>
                             @if (count($practicas))
                             {{ $practicas->links() }}
                             @endif
                             <br />
                             </div>
 @endsection
