<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Búsqueda Estudiantes
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Búsqueda de Estudiantes</h1>
   <div class="container" id="font7">
       @include('flash-message')
   </br>
   <form action="{{route ('busqueda_estudiante_formacion')}}" method="POST" role="search">
       {{ csrf_field() }}
        <div class="form-row">

          <div class="input-group col-md-6">
            <!--   <input type="text" ng-model="test" class="search-query form-control" placeholder="Nombre de familia"><p>&nbsp;</p>
   --><input type="text" class="form-control" name="q" placeholder="Buscar Estudiante"><p>&nbsp;</p>
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
               <tr style="color: #000000;">
                   <th>Matricula</th>
                   <th>Nombre</th>
                   <th>Semestre</th>
                   <th>Modalidad</th>
                   <th>Avance</th>
                   <th colspan="4" style="text-align: center;" >ACCIONES</th>
               </tr>
           </thead>
           <tbody>
               @foreach($details as $user)
               <tr style="color: #000000;">
                   <td>{{$user->matricula}}</td>
                   <td>{{$user->nombre}} {{$user->apellido_paterno}} {{$user->apellido_materno}}</td>
                   <td>{{$user->semestre}}</td>
                   <td>{{$user->modalidad}}</td>
                   <td><a href="avance_estudiante/{{ $user->matricula }}">Detalles</a></td>
                    <td><a href="constancia_parcial/{{ $user->matricula}}" target="_blank">Generar Comprobante</a></td>
                    <td><a href="constancia_valida/{{ $user->matricula}}" target="_blank">Generar Constancia</a></td>
                    <td><a href="registro_horas/{{ $user->matricula}}">Registro de Horas</a></td>
					  <td><a href="colaborador/{{ $user->matricula}}">Colaborador</a></td>
                         </tr>
               @endforeach
           </tbody>
       </table>
       @if (count($details))
         {{ $details->links() }}
         @endif
         @endif
     </div>
   </div>
   </div>
   </div>
 @endsection

 <script>
 function numeros(e){
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = " 0123456789";
  especiales = [8,37,39,46];

  tecla_especial = false
  for(var i in especiales){
 if(key == especiales[i]){
   tecla_especial = true;
   break;
      }
  }

  if(letras.indexOf(tecla)==-1 && !tecla_especial)
      return false;
 }
 </script>
