@extends('layouts.plantilla_tallerista')
@section('title')
@endsection
@section('seccion')
<div class="container">
@include('flash-message')
  <div class="row justify-content-center">
      <div class="col-md-8">
          <div class="card">
              <div class="card-header" align="center">{{ __('Finalizar Extracurricular') }}</div>
            </br>
      <label align="center">*Nota: Al dar clic en Finalizar no se podrá deshacer está acción </label>
              <div class="card-body">
                <form method="POST" action="{{ route('finalizar_talleres_tallerista') }}">
                @csrf

    <div class="form-group row">
        <label for="nombre_taller" class="col-md-4 col-form-label text-md-right" >{{ __('Nombre de la Actividad:') }}</label>
        <div class="col-md-6">
            <input id="nombre_taller" value="{{$datos->nombre_ec}}" name="nombre_taller" type="text" class="form-control" disabled>
    </div>
  </div>
<input type="text" name="id_extracurricular" id="id_extracurricular" value="{{$datos->id_extracurricular}}" hidden>

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
        <button class="btn btn-primary" type="submit" >
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
@endsection
