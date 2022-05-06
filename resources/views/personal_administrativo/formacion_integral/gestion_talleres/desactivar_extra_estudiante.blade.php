@extends('layouts.plantilla_formacion_integral')
@section('title')
@endsection
@section('seccion')
<div class="container">
@include('flash-message')
  <div class="row justify-content-center">
      <div class="col-md-8">
          <div class="card">
              <div class="card-header" align="center">{{ __('Desactivar Extracurricular') }}</div>
            </br>
   <label align="center">*Nota: Al dar clic en Finalizar no se podrá deshacer está acción </label>
              <div class="card-body">
                <form method="POST" action="{{ route('desactivar_extra') }}">
                @csrf


                <div class="form-group row">
                    <label for="id_user" class="col-md-4 col-form-label text-md-right" >{{ __('Nombre de estudiante') }}</label>

                    <div class="col-md-6">
                      <input id="nombre_estudiante" type="text" value="{{$datos_estudiante->nombre}} {{$datos_estudiante->apellido_paterno}} {{$datos_estudiante->apellido_materno}}"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control" name="nombre_estudiante" disabled >
                        @error('nombre_estudiante')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                </div>

    <div class="form-group row">
        <label for="nombre_taller" class="col-md-4 col-form-label text-md-right" >{{ __('Nombre de la Actividad:') }}</label>
        <div class="col-md-6">
            <input id="nombre_taller" value="{{$datos_taller->nombre_ec}}" name="nombre_taller" type="text" class="form-control" disabled>
    </div>
  </div>
                <input name="id_extracurricular" hidden id="id_extracurricular" type="text" value="{{$datos->id_extracurricular}}">

    <div class="form-group row">
        <label for="observaciones" class="col-md-4 col-form-label text-md-right" >{{ __('Observaciones de Taller:') }}</label>
        <div class="col-md-6">
            <textarea id="observaciones" name="observaciones" rows="6" style="resize: both;" class="form-control" required ></textarea>
            @error('observaciones')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="id_user" class="col-md-4 col-form-label text-md-right" >{{ __('Correo:') }}</label>
        <div class="col-md-6">
            <input id="email" type="email" disabled value="{{$datos_estudiante->email}}" onKeyUp="this.value = this.value.toUpperCase()" class="form-control" name="email">
            @error('email')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
    </div>
    <input type="text" name="matricula"  hidden class="form-control" value="{{$estudiante_matricula}}">

    <div class="form-group row">
    <label for="asunto" class="col-md-4 col-form-label text-md-right" >{{ __('Asunto:') }}</label>
    <div class="col-md-6">
        <input id="asunto" name="asunto" type="text" value="Taller Cancelado" onKeyUp="this.value = this.value.toUpperCase()" class="form-control" required >
        @error('asunto')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
</div>

<div class="form-group row">
    <label for="contenido" class="col-md-4 col-form-label text-md-right" >{{ __('Contenido del Mensaje:') }}</label>
    <div class="col-md-6">
        <textarea id="contenido" name="contenido" rows="6" style="resize: both;" class="form-control" required ></textarea>
        @error('contenido')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
</div>

<div class="form-group">
    <div class="col-xs-offset-2 col-xs-9" align="center">
        <button class="btn btn-primary" type="submit" >
          {{ __('Desactivar Taller') }}
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
