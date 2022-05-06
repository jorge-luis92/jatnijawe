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

<script>
function curpValida(curp) {
    var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
        validado = curp.match(re);

    if (!validado)  //Coincide con el formato general?
    	return false;

    //Validar que coincida el dígito verificador
    function digitoVerificador(curp17) {
        //Fuente https://consultas.curp.gob.mx/CurpSP/
        var diccionario  = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
            lngSuma      = 0.0,
            lngDigito    = 0.0;
        for(var i=0; i<17; i++)
            lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
        lngDigito = 10 - lngSuma % 10;
        if (lngDigito == 10) return 0;
        return lngDigito;
    }

    if (validado[2] != digitoVerificador(validado[1]))
    	return false;

    return true; //Validado
}


//Handler para el evento cuando cambia el input
//Lleva la CURP a mayúsculas para validarlo
function validarInput(input) {
    var curp = input.value.toUpperCase(),
        resultado = document.getElementById("resultado"),
        valido = "No válido";

    if (curpValida(curp)) { // ?? Acá se comprueba
    	valido = "Válido"
        resultado.classList.add("ok");
    } else {
    	resultado.classList.remove("ok");
    }

    resultado.innerText =  "Formato: " + valido;
}
</script>
<script>
function calcular_edad()
{
    var form = document.getElementById('fecha_nacimiento').value; //fecha de nacimiento en el formulario
    var fechaNacimiento = form.split("-");
    var ano = fechaNacimiento[0];
    var mes = fechaNacimiento[1];
    var dia = fechaNacimiento[2];
    var fechaHoy = new Date(); // detecto la fecha actual y asigno el dia, mes y anno a variables distintas
    var ahora_ano = fechaHoy.getFullYear();
    var ahora_mes = fechaHoy.getMonth()+1;
    var ahora_dia = fechaHoy.getDate();

    var edad = (ahora_ano + 1900) - ano;
    if(ano < ahora_ano && edad >1899){
    if ( ahora_mes < mes )
    {
        edad--;
    }
    if (mes == ahora_mes && ahora_dia < dia)
    {
        edad--;
    }
    if (edad > 1900)
    {
        edad -= 1900;
    }
    if (edad == 1900)
    {
        edad =0;
    }
  }
  else {
    edad=0;
  }
    var meses=0;
    if(ahora_mes>mes)
        meses=ahora_mes-mes;
    if(ahora_mes<mes)
        meses=12-(mes-ahora_mes);
    document.getElementById('edad').value = edad;
    document.getElementById('mes').value = mes;}


    function setearFecha() {
        var form = document.getElementById('curp').value;
    var  a = form.substring(16,17);
    //var che= form.substring(4,6);
    if(a == 0){
    var anio =  "19"+form.substring(4,6)+"-"+ form.substring(6,8)+ "-"+  form.substring(8,10);

    document.getElementById('fecha_nacimiento').value = anio ;}
    else {
      var anio ="20"+form.substring(4,6)+"-"+ form.substring(6,8)+ "-"+  form.substring(8,10);

      document.getElementById('fecha_nacimiento').value = anio ;
    }
  }
    //alert(fe);HEVJ920901HOCRLR08
    function setearGenero() {
        var form = document.getElementById('curp').value;
    var  a = form.substring(10,11);
    if( a == 'H'){
    document.getElementById('genero').value = "MASCULINO" ;
    //alert(fe);HEVJ920901HOCRLR08
    }
    if( a == 'M'){
      document.getElementById('genero').value = "FEMEMINO" ;
    }
    }

</script>
