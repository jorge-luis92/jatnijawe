<link rel="shortcut icon" href="{{asset('/logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
: Carga de Datos
@endsection

@section('seccion')
<div class="container" align="center" id="font7" >
      <div class="form">
        @include('flash-message')
        <div class="row">
      <div id="content" class="col-lg-12">

      </div>
  </div>
                        <form class="form-horizontal" method="POST" action="{{ route('cargar_datos_usuarios') }}" validate enctype="multipart/form-data" data-toggle="validator">
                            {{ csrf_field() }}

                            <div class="form-group col-md-8" id="labels">
                              <label  for="archivo">Agregar Archivo de Excel </label>
                              <input name="archivo" id="archivo" type="file" accept=".xlsx, .xls, .csv"  class="form-control @error('archivo') is-invalid @enderror" /><br /><br />
                              @error('archivo')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            </div>
                            <br />
                            <div class="form-group" align="center">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Cargar Datos
                                    </button>
                                </div>
                            </div>
                        </form>
      </div>
  </div>



  @endsection
