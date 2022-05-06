<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
: 911.9A
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('reporte911_9A3') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">


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
          <td >Menos de 18 años</td>
          <td bgcolor="white" >{{$inscritos_edadCU['1']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU['2']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU['3']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU['4']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU['5']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU['6']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU['7']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU['8']}}</td>
          <td >{{$inscritos_edadCU['TOTAL']}}</td>
        </tr>

        <tr>
          <td >18 años</td>
          <td bgcolor="white" >{{$inscritos_edadCU18['1']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU18['2']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU18['3']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU18['4']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU18['5']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU18['6']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU18['7']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU18['8']}}</td>
          <td >{{$inscritos_edadCU18['TOTAL']}}</td>
        </tr>
        <tr>
          <td >19 años</td>
          <td bgcolor="white" >{{$inscritos_edadCU19['1']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU19['2']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU19['3']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU19['4']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU19['5']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU19['6']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU19['7']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU19['8']}}</td>
          <td >{{$inscritos_edadCU19['TOTAL']}}</td>
        </tr>
        <tr>
          <td >20 años</td>
          <td bgcolor="white" >{{$inscritos_edadCU20['1']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU20['2']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU20['3']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU20['4']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU20['5']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU20['6']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU20['7']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU20['8']}}</td>
          <td >{{$inscritos_edadCU20['TOTAL']}}</td>
        </tr>
        <tr>
          <td >21 años</td>
          <td bgcolor="white" >{{$inscritos_edadCU21['1']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU21['2']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU21['3']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU21['4']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU21['5']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU21['6']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU21['7']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU21['8']}}</td>
          <td >{{$inscritos_edadCU21['TOTAL']}}</td>
        </tr>
        <tr>
          <td >22 años</td>
          <td bgcolor="white" >{{$inscritos_edadCU22['1']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU22['2']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU22['3']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU22['4']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU22['5']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU22['6']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU22['7']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU22['8']}}</td>
          <td >{{$inscritos_edadCU22['TOTAL']}}</td>
        </tr>
        <tr>
          <td >23 años</td>
          <td bgcolor="white" >{{$inscritos_edadCU23['1']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU23['2']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU23['3']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU23['4']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU23['5']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU23['6']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU23['7']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU23['8']}}</td>
          <td >{{$inscritos_edadCU23['TOTAL']}}</td>
        </tr>
        <tr>
          <td >24 años</td>
          <td bgcolor="white" >{{$inscritos_edadCU24['1']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU24['2']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU24['3']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU24['4']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU24['5']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU24['6']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU24['7']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU24['8']}}</td>
          <td >{{$inscritos_edadCU24['TOTAL']}}</td>
        </tr>
        <tr>
          <td >25 años</td>
          <td bgcolor="white" >{{$inscritos_edadCU25['1']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU25['2']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU25['3']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU25['4']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU25['5']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU25['6']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU25['7']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU25['8']}}</td>
          <td >{{$inscritos_edadCU25['TOTAL']}}</td>
        </tr>
        <tr>
          <td >26 años</td>
          <td bgcolor="white" >{{$inscritos_edadCU26['1']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU26['2']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU26['3']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU26['4']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU26['5']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU26['6']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU26['7']}}</td>
          <td bgcolor="white" >{{$inscritos_edadCU26['8']}}</td>
          <td >{{$inscritos_edadCU26['TOTAL']}}</td>
          </tr>
          <tr>
            <td >27 años</td>
            <td bgcolor="white" >{{$inscritos_edadCU27['1']}}</td>
            <td bgcolor="white" >{{$inscritos_edadCU27['2']}}</td>
            <td bgcolor="white" >{{$inscritos_edadCU27['3']}}</td>
            <td bgcolor="white" >{{$inscritos_edadCU27['4']}}</td>
            <td bgcolor="white" >{{$inscritos_edadCU27['5']}}</td>
            <td bgcolor="white" >{{$inscritos_edadCU27['6']}}</td>
            <td bgcolor="white" >{{$inscritos_edadCU27['7']}}</td>
            <td bgcolor="white" >{{$inscritos_edadCU27['8']}}</td>
            <td >{{$inscritos_edadCU27['TOTAL']}}</td>
          </tr>
            <tr>
              <td >28 años</td>
              <td bgcolor="white" >{{$inscritos_edadCU28['1']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU28['2']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU28['3']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU28['4']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU28['5']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU28['6']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU28['7']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU28['8']}}</td>
              <td >{{$inscritos_edadCU28['TOTAL']}}</td>
            </tr>
            <tr>
              <td >29 años</td>
              <td bgcolor="white" >{{$inscritos_edadCU29['1']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU29['2']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU29['3']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU29['4']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU29['5']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU29['6']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU29['7']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU29['8']}}</td>
              <td >{{$inscritos_edadCU29['TOTAL']}}</td>
            </tr>
            <tr>
              <td >30 a 34 años</td>
              <td bgcolor="white" >{{$inscritos_edadCU30['1']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU30['2']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU30['3']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU30['4']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU30['5']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU30['6']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU30['7']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU30['8']}}</td>
              <td >{{$inscritos_edadCU30['TOTAL']}}</td>
            </tr>
            <tr>
              <td >35 a 39 años</td>
              <td bgcolor="white" >{{$inscritos_edadCU35['1']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU35['2']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU35['3']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU35['4']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU35['5']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU35['6']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU35['7']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU35['8']}}</td>
              <td >{{$inscritos_edadCU35['TOTAL']}}</td>
            </tr>
            <tr>
              <td >40 años o más</td>
              <td bgcolor="white" >{{$inscritos_edadCU40['1']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU40['2']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU40['3']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU40['4']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU40['5']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU40['6']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU40['7']}}</td>
              <td bgcolor="white" >{{$inscritos_edadCU40['8']}}</td>
              <td >{{$inscritos_edadCU40['TOTAL']}}</td>
            </tr>
        <tr>
        <td ><strong>Total</strong></td>
          <td bgcolor="white">{{$inscritos_edadCU['1'] + $inscritos_edadCU18['1'] + $inscritos_edadCU19['1']
                              + $inscritos_edadCU20['1'] + $inscritos_edadCU21['1'] + $inscritos_edadCU22['1']
                              + $inscritos_edadCU23['1'] + $inscritos_edadCU24['1'] + $inscritos_edadCU25['1']
                              + $inscritos_edadCU26['1'] + $inscritos_edadCU27['1'] + $inscritos_edadCU28['1']
                              + $inscritos_edadCU29['1'] + $inscritos_edadCU30['1'] + $inscritos_edadCU35['1']
                              + $inscritos_edadCU40['1']}}</td>
         <td bgcolor="white">{{$inscritos_edadCU['2'] + $inscritos_edadCU18['2'] + $inscritos_edadCU19['2']
                              + $inscritos_edadCU20['2'] + $inscritos_edadCU21['2'] + $inscritos_edadCU22['2']
                              + $inscritos_edadCU23['2'] + $inscritos_edadCU24['2'] + $inscritos_edadCU25['2']
                              + $inscritos_edadCU26['2'] + $inscritos_edadCU27['2'] + $inscritos_edadCU28['2']
                              + $inscritos_edadCU29['2'] + $inscritos_edadCU30['2'] + $inscritos_edadCU35['2']
                              + $inscritos_edadCU40['2']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU['3'] + $inscritos_edadCU18['3'] + $inscritos_edadCU19['3']
                              + $inscritos_edadCU20['3'] + $inscritos_edadCU21['3'] + $inscritos_edadCU22['3']
                              + $inscritos_edadCU23['3'] + $inscritos_edadCU24['3'] + $inscritos_edadCU25['3']
                              + $inscritos_edadCU26['3'] + $inscritos_edadCU27['3'] + $inscritos_edadCU28['3']
                              + $inscritos_edadCU29['3'] + $inscritos_edadCU30['3'] + $inscritos_edadCU35['3']
                              + $inscritos_edadCU40['3']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU['4'] + $inscritos_edadCU18['4'] + $inscritos_edadCU19['4']
                              + $inscritos_edadCU20['4'] + $inscritos_edadCU21['4'] + $inscritos_edadCU22['4']
                              + $inscritos_edadCU23['4'] + $inscritos_edadCU24['4'] + $inscritos_edadCU25['4']
                              + $inscritos_edadCU26['4'] + $inscritos_edadCU27['4'] + $inscritos_edadCU28['4']
                              + $inscritos_edadCU29['4'] + $inscritos_edadCU30['4'] + $inscritos_edadCU35['4']
                              + $inscritos_edadCU40['4']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU['5'] + $inscritos_edadCU18['5'] + $inscritos_edadCU19['5']
                              + $inscritos_edadCU20['5'] + $inscritos_edadCU21['5'] + $inscritos_edadCU22['5']
                              + $inscritos_edadCU23['5'] + $inscritos_edadCU24['5'] + $inscritos_edadCU25['5']
                              + $inscritos_edadCU26['5'] + $inscritos_edadCU27['5'] + $inscritos_edadCU28['5']
                              + $inscritos_edadCU29['5'] + $inscritos_edadCU30['5'] + $inscritos_edadCU35['5']
                              + $inscritos_edadCU40['5']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU['6'] + $inscritos_edadCU18['6'] + $inscritos_edadCU19['6']
                              + $inscritos_edadCU20['6'] + $inscritos_edadCU21['6'] + $inscritos_edadCU22['6']
                              + $inscritos_edadCU23['6'] + $inscritos_edadCU24['6'] + $inscritos_edadCU25['6']
                              + $inscritos_edadCU26['6'] + $inscritos_edadCU27['6'] + $inscritos_edadCU28['6']
                              + $inscritos_edadCU29['6'] + $inscritos_edadCU30['6'] + $inscritos_edadCU35['6']
                              + $inscritos_edadCU40['6']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU['7'] + $inscritos_edadCU18['7'] + $inscritos_edadCU19['7']
                              + $inscritos_edadCU20['7'] + $inscritos_edadCU21['7'] + $inscritos_edadCU22['7']
                              + $inscritos_edadCU23['7'] + $inscritos_edadCU24['7'] + $inscritos_edadCU25['7']
                              + $inscritos_edadCU26['7'] + $inscritos_edadCU27['7'] + $inscritos_edadCU28['7']
                              + $inscritos_edadCU29['7'] + $inscritos_edadCU30['7'] + $inscritos_edadCU35['7']
                              + $inscritos_edadCU40['7']}}</td>
          <td bgcolor="white">{{$inscritos_edadCU['8'] + $inscritos_edadCU18['8'] + $inscritos_edadCU19['8']
                              + $inscritos_edadCU20['8'] + $inscritos_edadCU21['8'] + $inscritos_edadCU22['8']
                              + $inscritos_edadCU23['8'] + $inscritos_edadCU24['8'] + $inscritos_edadCU25['8']
                              + $inscritos_edadCU26['8'] + $inscritos_edadCU27['8'] + $inscritos_edadCU28['8']
                              + $inscritos_edadCU29['8'] + $inscritos_edadCU30['8'] + $inscritos_edadCU35['8']
                              + $inscritos_edadCU40['8']}}</td>
                           <td >{{$inscritos_edadCU['TOTAL'] + $inscritos_edadCU18['TOTAL'] + $inscritos_edadCU19['TOTAL']
                              + $inscritos_edadCU20['TOTAL'] + $inscritos_edadCU21['TOTAL'] + $inscritos_edadCU22['TOTAL']
                              + $inscritos_edadCU23['TOTAL'] + $inscritos_edadCU24['TOTAL'] + $inscritos_edadCU25['TOTAL']
                              + $inscritos_edadCU26['TOTAL'] + $inscritos_edadCU27['TOTAL'] + $inscritos_edadCU28['TOTAL']
                              + $inscritos_edadCU29['TOTAL'] + $inscritos_edadCU30['TOTAL'] + $inscritos_edadCU35['TOTAL']
                              + $inscritos_edadCU40['TOTAL']}}</td>
        </tr>

        </table>
<a> Páginas</a>
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A0')}}>1</a>
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A1')}}>2</a>
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A2')}}>3</a>
        <a class="siguiente" align="rigth" href={{ route('reporte911_9A3')}}><strong>4</strong></a>

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
