<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<?php $__env->startSection('htmlheader'); ?>
    <?php echo $__env->make('adminlte::layouts.partials.htmlheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldSection(); ?>

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

    <?php echo $__env->make('adminlte::layouts.partials.mainheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('adminlte::layouts.partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <?php echo $__env->make('adminlte::layouts.partials.contentheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            <?php echo $__env->yieldContent('main-content'); ?>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php echo $__env->make('adminlte::layouts.partials.controlsidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('adminlte::layouts.partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</div><!-- ./wrapper -->
</div>
<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('adminlte::layouts.partials.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldSection(); ?>

</body>
</html>
<script type="text/javascript">
    function bajar1(){
        //alert("prueba");
        $("#menuBajar1").toggle();
    }

</script>

    <?php if(!isset ($modulo)): ?>
        <?php echo $__env->make('inicio.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php else: ?>

    <?php if($modulo=="areasUnasam"): ?>
        <?php echo $__env->make('areas.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php elseif($modulo=="ciclos"): ?>
        <?php echo $__env->make('ciclos.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php elseif($modulo=="facultades"): ?>
        <?php echo $__env->make('facultades.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

    <?php elseif($modulo=="carreraunasam"): ?>
        <?php echo $__env->make('carrerasunasam.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php elseif($modulo=="alumnos"): ?>
        <?php echo $__env->make('alumnos.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php elseif($modulo=="usuarios"): ?>
        <?php echo $__env->make('usuarios.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php elseif($modulo=="gestionippr"): ?>
        <?php echo $__env->make('ippr.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php elseif($modulo=="gestionkuder"): ?>
        <?php echo $__env->make('kuder.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php elseif($modulo=="gestionCampoProfs"): ?>
        <?php echo $__env->make('campoprofesional.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php elseif($modulo=="gestionCampoProfs2"): ?>
        <?php echo $__env->make('areaprofesional.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php elseif($modulo=="gestionMaestroCarreras"): ?>
        <?php echo $__env->make('maestrocarreras.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php elseif($modulo=="gestionMaestroCarreras2"): ?>
        <?php echo $__env->make('maestrocarreras2.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php elseif($modulo=="gestionPreguntas"): ?>
        <?php echo $__env->make('preguntas.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php elseif($modulo=="gestionPreguntasImp"): ?>
        <?php echo $__env->make('preguntas.vue2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php elseif($modulo=="gestionPreguntas2"): ?>
        <?php echo $__env->make('preguntaskuder.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php elseif($modulo=="gestionPreguntas2Imp"): ?>
        <?php echo $__env->make('preguntaskuder.vue2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


    <?php elseif($modulo=="alumno"): ?>
        <?php echo $__env->make('inicio.vueAlumno', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php elseif($modulo=="testIPPR"): ?>
        <?php echo $__env->make('testippr.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>    

    <?php elseif($modulo=="testKUDER"): ?>
        <?php echo $__env->make('testkuder.vue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    
        
    <?php endif; ?>

    
    <?php endif; ?>


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