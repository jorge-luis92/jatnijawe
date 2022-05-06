<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_tallerista')
@section('title')
: Mis Grupos
@endsection
@section('seccion')
<h1 style="font-size: 2.0em; color: #000000;" align="center"> Estudiantes cursando Taller actualmente</h1>
<div class="container" id="font7">
</br>
<div class="table-responsive">
<table class="table table-bordered table-info" style="color: #000000;" >
    <thead>
    <tr>
    <th scope="col">MATRICULA</th>
    <th scope="col">NOMBRE</th>
    <th scope="col">SEMESTRE</th>
    <th scope="col">TELFONO</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <th scope="row">238957</th>
    <th scope="row">KAREN CRUZ NUÑEZ</th>
    <th scope="row">8</th>
    <th scope="row">D</th>
    <td>  <a data-toggle="modal" href="#">ACREDITADO</a></td>
    <td>  <a data-toggle="modal" href="#">NO ACREDITADO</a></td>
    </tr>

    </tbody>
    </table>
    </div>
    </form>
    </div>

</div>

  @endsection






<script language="JavaScript">
    function checar(){
        $(".inputText").removeAttr("disabled");
    }

    function nochecar(){
        $(".inputText").attr("disabled","disabled");
    }
</script>

<script language="JavaScript">
    function checar_beca(){
        $(".inputBeca").removeAttr("disabled");
    }

    function nochecar_beca(){
        $(".inputBeca").attr("disabled","disabled");
    }
</script>
