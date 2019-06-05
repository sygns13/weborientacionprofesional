<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
    @include('adminlte::layouts.partials.htmlheader')
@show

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-blue sidebar-mini ">

<div id="app" v-cloak>
    <div class="wrapper">

    @include('adminlte::layouts.partials.mainheader')

    @include('adminlte::layouts.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @include('adminlte::layouts.partials.contentheader')

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('main-content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    @include('adminlte::layouts.partials.controlsidebar')

    @include('adminlte::layouts.partials.footer')

</div><!-- ./wrapper -->
</div>
@section('scripts')
    @include('adminlte::layouts.partials.scripts')
@show

</body>
</html>
<script type="text/javascript">
    function bajar1(){
        //alert("prueba");
        $("#menuBajar1").toggle();
    }

</script>

    @if(!isset ($modulo))
        @include('inicio.vue')
    @else

    @if($modulo=="areasUnasam")
        @include('areas.vue')

    @elseif($modulo=="ciclos")
        @include('ciclos.vue')

    @elseif($modulo=="facultades")
        @include('facultades.vue') 

    @elseif($modulo=="carreraunasam")
        @include('carrerasunasam.vue')

    @elseif($modulo=="alumnos")
        @include('alumnos.vue')

    @elseif($modulo=="usuarios")
        @include('usuarios.vue')

    @elseif($modulo=="gestionippr")
        @include('ippr.vue')

    @elseif($modulo=="gestionkuder")
        @include('kuder.vue')

    @elseif($modulo=="gestionCampoProfs")
        @include('campoprofesional.vue')

    @elseif($modulo=="gestionCampoProfs2")
        @include('areaprofesional.vue')

    @elseif($modulo=="gestionMaestroCarreras")
        @include('maestrocarreras.vue')

    @elseif($modulo=="gestionMaestroCarreras2")
        @include('maestrocarreras2.vue')

    @elseif($modulo=="gestionPreguntas")
        @include('preguntas.vue')

    @elseif($modulo=="gestionPreguntasImp")
        @include('preguntas.vue2')

    @elseif($modulo=="gestionPreguntas2")
        @include('preguntaskuder.vue')

    @elseif($modulo=="gestionPreguntas2Imp")
        @include('preguntaskuder.vue2')

{{-- Usuario Alumno --}}
    @elseif($modulo=="alumno")
        @include('inicio.vueAlumno')

    @elseif($modulo=="testIPPR")
        @include('testippr.vue')    

    @elseif($modulo=="testKUDER")
        @include('testkuder.vue')

    
        
    @endif

    
    @endif


    <script type="text/javascript">
        function redondear(num) {
    return +(Math.round(num + "e+2")  + "e-2");
}

function recorrertb(idtb){

    var cont=1;
        $("#"+idtb+" tbody tr").each(function (index)
        {

            $(this).children("td").each(function (index2)
            {
               //alert(index+'-'+index2);

               if(index2==0){
                  $(this).text(cont);
                  cont++;
               }


            })

        })
  }

  function isImage(extension)
{
    switch(extension.toLowerCase()) 
    {
        case 'jpg': case 'gif': case 'png': case 'jpeg': case 'JPG': case 'GIF': case 'PNG': case 'JPEG': case 'jpe': case 'JPE':
            return true;
        break;
        default:
            return false;
        break;
    }
}

function soloNumeros(e){
  var key = window.Event ? e.which : e.keyCode
  return ((key >= 48 && key <= 57) || (key==8) || (key==35) || (key==34) || (key==46));
}

function noEscribe(e){
  var key = window.Event ? e.which : e.keyCode
  return (key==null);
}

function EscribeLetras(e,ele){
  var text=$(ele).val();
  text=text.toUpperCase();
   var pos=posicionCursor(ele);
  $(ele).val(text);

  ponCursorEnPos(pos,ele);
}


function ponCursorEnPos(pos,laCaja){  
    if(typeof document.selection != 'undefined' && document.selection){        //método IE 
        var tex=laCaja.value; 
        laCaja.value='';  
        laCaja.focus(); 
        var str = document.selection.createRange();  
        laCaja.value=tex; 
        str.move("character", pos);  
        str.moveEnd("character", 0);  
        str.select(); 
    } 
    else if(typeof laCaja.selectionStart != 'undefined'){                    //método estándar 
        laCaja.setSelectionRange(pos,pos);  
        //forzar_focus();            //debería ser focus(), pero nos salta el evento y no queremos 
    } 
}  

function posicionCursor(element)
{
       var tb = element;
        var cursor = -1;

        // IE
        if (document.selection && (document.selection != 'undefined'))
        {
            var _range = document.selection.createRange();
            var contador = 0;
            while (_range.move('character', -1))
                contador++;
            cursor = contador;
        }
       // FF
        else if (tb.selectionStart >= 0)
            cursor = tb.selectionStart;

       return cursor;
}

function pad (n, length) {
    var  n = n.toString();
    while(n.length < length)
         n = "0" + n;
    return n;
}

    </script>