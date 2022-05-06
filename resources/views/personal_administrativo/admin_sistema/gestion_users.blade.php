<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_admin')
@section('title')
: Búsqueda Estudante
@endsection

@section('seccion')
 @include('flash-message')
<div class="container" id="font5">
  </br>
<div class="table-responsive">
  <table class="table table-bordered table-info" style="color: #000000;" >
    <thead>
      <tr>
        <th scope="col">MATRÍCULA</th>
        <th scope="col">NOMBRE</th>
        <th colspan="2" >ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      <tr>
             <th scope="row">1</th>
             <td>JORGE</td>
             <td>  <a data-toggle="modal" href="#talleres_detalle">DETALLES</a></td>
             <td><a href="pdfs">GENERAR CONSTANCIA</a></td>
           </tr>

    </tbody>
  </table>
</div>


</div>
<div class="modal fade" tabindex="-1" role="dialog" id="talleres_detalle" aria-labelledby="#talleres_detalle " aria-hidden="true">
  <div class="modal-dialog modal-none">
    <div class="modal-content">
      <div class="container" id="font5">
        </br>
      <div class="table-responsive">
        <table class="table table-bordered table-info" style="color: #000000;" >
          <thead>
            <tr>
              <th scope="col">Horas Acumuladas</th>
              <th scope="col">Area</th>

            </tr>
          </thead>
          <tbody>

            <tr>
              <td>25</td>
              <td>Cultural</td>

            </tr>

          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>
</div>

  @endsection
