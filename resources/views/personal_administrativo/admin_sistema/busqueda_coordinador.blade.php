<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_admin')
@section('title')
: Búsqueda Coordinadores
 @endsection
 @section('seccion')
 <div class="container" id="font7">
     @include('flash-message')
 </br>
 <form action="{{route ('busqueda_coordinadores')}}" method="POST" role="search">
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
                 <th>Nombre</th>
                 <th>Puesto</th>
                 <th>Semestre</th>
                 <th>Modalidad</th>
                 <th colspan="2" >ACCIONES</th>
             </tr>
         </thead>
         <tbody>
             @foreach($details as $user)
             <tr style="color: #000000;">
                 <td>{{$user->matricula}}</td>
                 <td>{{$user->nombre}} {{$user->apellido_paterno}} {{$user->apellido_materno}}</td>
                 <td>{{$user->semestre}}</td>
                 <td>{{$user->modalidad}}</td>
                 <td><a href="editar_estudiante/{{$user->id_user}}">EDITAR</a></td>
                  <td><a href="desactivar_estudiante/{{$user->id_user}}">DESACTIVAR</a></td>
                 </tr>
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
