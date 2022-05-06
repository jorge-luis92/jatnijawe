@extends('layouts.plantilla_formacion_integral')
@section('title')
@endsection
@section('seccion')
<div class="container">
@include('flash-message')
  <div class="row justify-content-center">
      <div class="col-md-8">
          <div class="card">
              <div class="card-header" align="center">{{ __('Finalizar Extracurricular') }}</div>

              <div class="card-body">
                <form method="POST" action="">
                @csrf

    <div class="form-group row">
        <label for="nombre_taller" class="col-md-4 col-form-label text-md-right" >{{ __('Nombre de la Actividad:') }}</label>
        <div class="col-md-6">
            <input id="nombre_taller" value="{{$datos->nombre_ec}}" name="nombre_taller" type="text" class="form-control" disabled>
    </div>
  </div>


    <div class="form-group row">
        <label for="observaciones" class="col-md-4 col-form-label text-md-right" >{{ __('Observaciones:') }}</label>
        <div class="col-md-6">
            <textarea id="observaciones" name="observaciones" rows="6" style="resize: both;" class="form-control" required ></textarea>
            @error('observaciones')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
    </div>
<div class="form-group">
    <div class="col-xs-offset-2 col-xs-9" align="center">
        <button  class="btn btn-primary" data-toggle="modal" data-target="#logoutModal">
          {{ __('Finalizar Taller') }}
        </button>
    </div>
</div>
<a class="dropdown-item" >

</form>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <button class="btn btn-primary" type="submit" >Enviar</button>

      </div>
    </div>
  </div>
</div>

@endsection
