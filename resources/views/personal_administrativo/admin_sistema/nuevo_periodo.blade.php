<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_admin')
@section('title')
: Períodos
@endsection

@section('seccion')
 @include('flash-message')
<h1 style="font-size: 2.0em; color: #000000;" align="center"> Registro de Períodos - Semestre</h1>
<div class="container" id="font7">
</br>                    <form method="POST" action="{{ route('nuevo_periodo_agregar')}}">
                        @csrf
    <div class="form-row">
  <div class="form-group col-md-6">
    <label for="inicio" >{{ __('* Fecha de inicio') }}</label>
    <input id="inicio" type="date"  name="inicio" min= "<?php echo date("Y-m-d");?>" class="form-control"  required>
    </div>

    <div class="form-group col-md-6">
      <label for="final" >{{ __('* Fecha Final') }}</label>
      <input id="final" type="date" onchange="vamo()" name="final" min= "<?php echo date("Y-m-d");?>"  class="form-control"  required>
            </div>
            </div>
        <div class="form-group">
              <div class="col-xs-offset-2 col-xs-9" align="center">
                <a  class="btn btn-primary" href="#" data-toggle="modal" data-target="#logoutModales">Nuevo Período </a>
                <!--  <button type="button"  class="btn btn-secondary" data-dismiss="modal">Cancelar</button>-->
              </div>
          </div>
          <div class="modal fade" id="logoutModales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmar</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Al dar clic en aceptar se agregará el nuevo semestre, los estudiantes tendrán que aceptar los lineamientos
        nuevamente y el nuevo periodo para enviar solicitudes en Formación Integral se abrirá.</div>
      <div class="modal-footer">

        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary"  type="submit" >Aceptar</button>

      </div>
    </div>
  </div>
</div>


                    </form>

                    <hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
                  </br>
                    <h3 style="font-size: 1.0em; color: #0A122A; max-width: 280px;" align="left"><strong>Periodos Registrados</strong></h3>
                                          <div class="table-responsive" style="border:1px solid #819FF7;">
                          <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >
                        <thead>
                          <tr>
                            <th scope="col">Inicio Periodo</th>
                            <th scope="col">Final de Periodo</th>
                            <th scope="col">Tipo de Periodo</th>
                            <th scope="col">Fecha de Creación</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($guardados as $p_guar)
                          <tr style="color: #000000;">

                              <td>{{ date('d-m-Y', strtotime($p_guar->inicio))}}</td>
                              <td>{{ date('d-m-Y', strtotime($p_guar->final))}}</td>
                              <td>{{$p_guar->estatus}}</td>
                              <td>{{ date('d-m-Y', strtotime($p_guar->created_at))}}</td>
                              </tr>
                              @endforeach
                         </tbody>
                         </table>
                       </br>
                         </div>
                         @if (count($guardados))
                         {{ $guardados->links() }}
                         @endif
                </div>

@endsection
<script>
function vamo(){
    var ed = document.getElementById('inicio').value; //fecha de nacimiento en el formulario
    var fecha_inicio = ed.split("-");
    var anio = fecha_inicio[0];
    var mes = fecha_inicio[1];
    var dia = fecha_inicio[2];
  var mm = parseInt(mes);
  var anios= parseInt(anio);
var j=anio;
var hey;
j=anios+1;
if(mes >= 1 || mes <12){
  mm=1+mm;

  hey=mm;
  if(mm >=1 || mm <=9){

  document.getElementById("final").min = anios+'-'+'0'+hey+'-'+dia;
       document.getElementById("hola").value = '2-9 mes cal: '+mm;
  }
if(mm >= 10 || mm < 12){
  document.getElementById("final").min = anios+'-'+hey+'-'+dia;
  document.getElementById("hola").value = '10 - 11 mes cal: '+mm;
}
  if(mm == 12){
  j=anios+1;
  hey=mm;
  document.getElementById("final").min = j+'-'+hey+'-'+dia;
       document.getElementById("hola").value = '12 mes cal: '+mm;
  }
}

  if(mes == 12){
    j=anios+1;
     document.getElementById("hola").value = 'mes: '+mes+' año: '+j;
     document.getElementById("final").min = j+'-'+'01'+'-'+dia;

}
}
//min="<?php echo date("Y-m-d");?>"
</script>
