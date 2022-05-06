<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_planeacion')
@section('title')
: 911.9A
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('reporte911_9A') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">
    <table class="table table-bordered table-info" style="color: #8181F7;" >
    <thead>
    <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ALUMNOS DE PRIMER INGRESO DEL CICLO ESCOLAR ANTERIOR</strong></h4>

    <h5 style="font-size: 1.0em; color: #000000;" align="rigt">Número de alumnos de primer ingreso a la carrera del ciclo escolar anterior</h5>
    <tr>
      <th scope="row">Hombres </th>
      <th scope="row">Mujeres</th>
      <th scope="row">Total</th>

    </tr>
    <tr>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>

    </tr>
    </table>


    <div class="form-row" >
          <div class="form-group col-md-6">
          <label for="fecha_inicio" >{{ __('Fecha de inicio de Cursos del ciclo escolar actual') }}</label>
          <input id="fecha_inicio" type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" name="fecha_inicio" required>
          @error('fecha_inicio')
          <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
          </span>
          @enderror
          </div>
    </div>

    <table class="table table-bordered table-info" style="color: #8181F7;" >

    <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ALUMNOS DE PRIMER INGRESO DEL CICLO ESCOLAR ACTUAL</strong></h4>
    <h5 style="font-size: 1.0em; color: #000000;" align="rigt">Número de alumnos de primer ingreso a la carrera del ciclo escolar actual</h5>

    <tr>
      <th scope="row">Hombres </th>
      <th scope="row">Mujeres</th>
      <th scope="row">Total</th>
      <th scope="row">Con Discapacidad</th>
      <th scope="row">Hablante de Lengua</th>
    </tr>

    <tr>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
    </tr>
    </table>


<table class="table table-bordered table-info" style="color: #8181F7;" >

  <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ALUMNOS DE PRIMER INGRESO SEGÚN EL LUGAR DONDE ESTUDIARON EL BACHILLERATO</strong></h4>
  <h5 style="font-size: 1.0em; color: #000000;" align="rigt">En el país</h5>
  <tr>
    <th scope="row">Estado de la República</th>
    <th scope="row">Total</th>
  </tr>
  <tr>
    <td bgcolor="white"> </td>
    <td bgcolor="white"> </td>

  </tr>

  </table>

  <table class="table table-bordered table-info" style="color: #8181F7;" >
  <h5 style="font-size: 1.0em; color: #000000;" align="rigt">Fuera de México</h5>

<tr>
    <th scope="col" WIDTH="50%">Estados Unidos</th>
    <td bgcolor="white"> </td>
</tr>
  <tr>
    <th scope="col">Canadá</th>
    <td bgcolor="white"> </td>
  </tr>
  <tr>
    <th scope="col">Centro América y el Caribe</th>
    <td bgcolor="white"> </td>
  </tr>
  <tr>
    <th scope="col">Sudámerica</th>
    <td bgcolor="white"> </td>
  </tr>

  <tr>
    <th scope="col">África</th>
    <td bgcolor="white"> </td>
  </tr>

  <tr>
    <th scope="col">Asia</th>
    <td bgcolor="white"> </td>
  </tr>
  <tr>
    <th scope="col">Europa</th>
    <td bgcolor="white"> </td>
  </tr>
  <tr>
    <th scope="col">Oceanía</th>
    <td bgcolor="white"> </td>
  </tr>
  <tr>
    <th scope="col">Oceanía</th>
    <td bgcolor="white"> </td>
  </tr>
  <tr>
    <th scope="col">Total</th>
    <td bgcolor="white"> </td>
  </tr>
  </table>

  <table class="table table-bordered table-info" style="color: #8181F7;" >
    <th scope="col">Total General</th>
    <td bgcolor="white"> </td>
  </tr>
  </table>



  <table class="table table-bordered table-info" style="color: #8181F7;" >

    <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>NÚMERO DE ALUMNOS DE PRIMER INGRESO A LA CARRERA SEGÚN SU LUGAR DE NACIMIENTO</strong></h4>

    <tr>
      <th scope="row">Lugar de Nacimiento</th>
      <th scope="row">Total</th>
    </tr>
    <tr>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>

    </tr>

    </table>

    <table class="table table-bordered table-info" style="color: #8181F7;" >

    <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>MATRÍCULA TOTAL DE LA CARRERA</strong></h4>
    <h5 style="font-size: 1.0em; color: #000000;" align="rigt">Alumnos inscritos en el ciclo escolar actual</h5>

    <tr>
      <th scope="row">Semestre</th>
      <th scope="row">Hombres </th>
      <th scope="row">Mujeres</th>
      <th scope="row">Total</th>
      <th scope="row">Con Discapacidad</th>
      <th scope="row">Hablante de Lengua</th>
      <th scope="row">Nacidos fuera de México</th>
    </tr>
    <tr>
      <td bgcolor="white">Primero</td>
      <td bgcolor="white"></td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
    </tr>
  <tr>
      <td bgcolor="white">Segundo</td>
      <td bgcolor="white"></td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
  </tr>
  <tr>
      <td bgcolor="white">Tercero</td>
      <td bgcolor="white"></td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
  </tr>
  <tr>
      <td bgcolor="white">Cuarto</td>
      <td bgcolor="white"></td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
  <tr>
      <td bgcolor="white">Quinto</td>
      <td bgcolor="white"></td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
  </tr>
  <tr>
      <td bgcolor="white">Sexto</td>
      <td bgcolor="white"></td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
  </tr>
  <tr>
      <td bgcolor="white">Séptimo</td>
      <td bgcolor="white"></td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
  </tr>
  <tr>
      <td bgcolor="white">Octavo</td>
      <td bgcolor="white"></td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
  </tr>

    <tr>
      <th>Total</th>
      <td bgcolor="white"></td>
      <td bgcolor="white"> </td>
      <td> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
      <td bgcolor="white"> </td>
    </tr>

    </table>

    <table class="table table-bordered table-info" style="color: #8181F7;" >

      <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ALUMNOS INSCRITOS SEGÚN SU LUGAR DE NACIMIENTO</strong></h4>

      <tr>
        <th scope="row">Lugar de Nacimiento</th>
        <th scope="row">Total</th>
      </tr>
      <tr>
        <td bgcolor="white"> </td>
        <td bgcolor="white"> </td>

      </tr>

      </table>
      <table class="table table-bordered table-info" style="color: #8181F7;" >

        <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ALUMNOS INSCRITOS POR EDAD Y GRADO DE AVANCE</strong></h4>


      <tr>
        <td colspan="10"align="center"><strong>Grado de Avance</strong></td>
     </tr>
        <tr>
          <td ><strong>Edad</strong></td>
          <td bgcolor="white">Primero</td>
          <td bgcolor="white">Segundo</td>
          <td bgcolor="white">Tercero</td>
          <td bgcolor="white">Cuarto</td>
          <td bgcolor="white">Quinto</td>
          <td bgcolor="white">Sexto</td>
          <td bgcolor="white">Séptimo</td>
          <td bgcolor="white">Octavo</td>
          <td ><strong>Total</strong></td>
        </tr>

        <tr>
          <td ></td>
          <td bgcolor="white" ></td>
          <td bgcolor="white" ></td>
          <td bgcolor="white"></td>
          <td bgcolor="white"></td>
          <td bgcolor="white"></td>
          <td bgcolor="white"></td>
          <td bgcolor="white"></td>
          <td bgcolor="white"></td>
          <td ></td>
        </tr>
        <tr>
        <td ><strong>Total</strong></td>
          <td bgcolor="white" ></td>
          <td bgcolor="white" ></td>
          <td bgcolor="white"></td>
          <td bgcolor="white"></td>
          <td bgcolor="white"></td>
          <td bgcolor="white"></td>
          <td bgcolor="white"></td>
          <td bgcolor="white"></td>
          <td ></td>
        </tr>

        </table>

        <table class="table table-bordered table-info" style="color: #8181F7;" >

          <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ALUMNOS INSCRITOS POR TIPO DE DISCAPACIDAD</strong></h4>
            <h5 style="font-size: 1.0em; color: #000000;" align="rigt">Tipo de Discapacidad y Género</h5>

          <tr>
            <th scope="row">Discapacidad que presentan</th>
            <th scope="row">Hombres</th>
            <th scope="row">Mujeres</th>
            <th scope="row">Total</th>
          </tr>
          <tr>
            <td>Física/Motríz</td>
            <td bgcolor="white"> </td>
            <td bgcolor="white"> </td>
            <td> </td>
          </tr>
          <tr>
            <td>Intelectual</td>
            <td bgcolor="white"> </td>
            <td bgcolor="white"> </td>
            <td> </td>
          </tr>
          <tr>
            <td>Múltiple</td>
            <td bgcolor="white"> </td>
            <td bgcolor="white"> </td>
            <td> </td>
          </tr>

          <tr>
            <td colspan="1"align="left"><strong>Auditiva</strong></td>
          </tr>
            <tr>
              <td >Hipoacusia</td>
              <td bgcolor="white"> </td>
              <td bgcolor="white"> </td>
              <td> </td>
            </tr>
            <tr>
              <td >Sordera</td>
              <td bgcolor="white"> </td>
              <td bgcolor="white"> </td>
              <td> </td>
            </tr>
            <tr>
              <td colspan="1"align="left"><strong>Visual</strong></td>
            </tr>
              <tr>
                <td >Baja Visión</td>
                <td bgcolor="white"> </td>
                <td bgcolor="white"> </td>
                <td> </td>
              </tr>
              <tr>
                <td >Ceguera</td>
                <td bgcolor="white"> </td>
                <td bgcolor="white"> </td>
                <td> </td>
              </tr>

              <tr>
                <td><strong>Psicosocial</strong></td>
                <td bgcolor="white"> </td>
                <td bgcolor="white"> </td>
                <td> </td>
              </tr>

          </table>

          <table class="table table-bordered table-info" style="color: #8181F7;" >

            <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ALUMNOS INSCRITOS HABLANTES DE LENGUA INDÍGENA</strong></h4>
              <h5 style="font-size: 1.0em; color: #000000;" align="rigt">Hablante de Lengua y Discapacidad</h5>

            <tr>
              <th scope="row">Hombres</th>
              <th scope="row">Mujeres</th>
              <th scope="row">Total</th>
              <th scope="row">Con Discapacidad</th>
            </tr>
            <tr>
              <td bgcolor="white"> </td>
              <td bgcolor="white"> </td>
              <td > </td>
              <td bgcolor="white"> </td>

            </tr>

            </table>

  <table class="table table-bordered table-info" style="color: #8181F7;" >

  <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ALUMNOS INSCRITOS POR TIPO DE INGRESO</strong></h4>
  <h5 style="font-size: 1.0em; color: #000000;" align="rigt">Número de alumnos inscritos de nuevo ingreso y reingreso</h5>

  <tr>
    <td colspan="4"align="center"><strong>Primer Ingreso</strong></td>
 </tr>
    <tr>
      <td ><strong>Edad</strong></td>
      <td bgcolor="white">Hombres</td>
      <td bgcolor="white">Mujeres</td>
        <td ><strong>Total</strong></td>
    </tr>

    <tr>
      <td bgcolor="white" ></td>
      <td bgcolor="white" ></td>
      <td bgcolor="white" ></td>
      <td ></td>
    </tr>

    <tr>
    <td ><strong>Total</strong></td>
      <td bgcolor="white" ></td>
      <td bgcolor="white" ></td>
      <td ></td>
    </tr>
  </table>

    <table class="table table-bordered table-info" style="color: #8181F7;" >
    <tr>
      <td colspan="4"align="center"><strong>Reingreso</strong></td>
   </tr>
      <tr>
        <td ><strong>Edad</strong></td>
        <td bgcolor="white">Hombres</td>
        <td bgcolor="white">Mujeres</td>
          <td ><strong>Total</strong></td>
      </tr>

      <tr>
        <td bgcolor="white" ></td>
        <td bgcolor="white" ></td>
        <td bgcolor="white" ></td>
        <td ></td>
      </tr>

      <tr>
      <td ><strong>Total</strong></td>
        <td bgcolor="white" ></td>
        <td bgcolor="white" ></td>
        <td ></td>
      </tr>


              </table>
    </div>
  </form>
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
