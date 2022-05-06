<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_admin')
@section('title')
: Búsqueda Estudiantes
 @endsection

 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Búsqueda de Estudiantes</h1>


 <div class="container" id="font7">
     @include('flash-message')
 </br>
 <form action="{{route ('busqueda_estudiantes')}}" method="POST" role="search">
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
     <table class="table table-bordered table-striped" >
         <thead>
             <tr style="color: #000000;">
                 <th>Matricula</th>
                 <th>Nombre</th>
                 <th>Semestre</th>
                 <th>Modalidad</th>
                 <th colspan="4" >ACCIONES</th>
             </tr>
         </thead>
         <tbody>
             @foreach($details as $user)
             <tr style="color: #000000;">
                 <td>{{$user->matricula}}</td>
                 <td>{{$user->nombre}} {{$user->apellido_paterno}} {{$user->apellido_materno}}</td>
                 <td>{{$user->semestre}}</td>
                 <td>{{$user->modalidad}}</td>
                 <td><a href="editar_estudiante/{{$user->matricula}}">EDITAR</a></td>
                  <td><a href="desactivar_estudiante/{{$user->id_user}}">DESACTIVAR</a></td>
                    <td><a href="restablecer_contrasenia/{{$user->matricula}}" >RESTABLECER CONTRASEÑA</a></td>
                   <td><a href="hoja_de_d/{{$user->matricula}}"  target="_blank">HOJA DE DATOS PERSONALES</a></td>
             @endforeach
         </tbody>
     </table>
   </div>
     @if (count($details))
       {{ $details->links() }}
     @endif
     @endif
</div>
 </div>
</div>
 @endsection

 <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
