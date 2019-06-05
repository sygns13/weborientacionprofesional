<?php $__env->startSection('htmlheader_title'); ?>
	IPP - Test Inventario de Intereses y preferencias profesionales
<?php $__env->stopSection(); ?>

<style type="text/css">         
          
#modaltamanio{
  width: 70% !important;
}

.perfil{
	    font-weight: bold;
    text-decoration: underline;
}

@media  print {
body {-webkit-print-color-adjust: exact!important;}

#btnImpRes{display:none!important;}

}

.perfil{
	    font-weight: bold;
    text-decoration: underline;
}

@page  { size: landscape!important;; }

</style>
<?php $__env->startSection('main-content'); ?>
	<div class="container-fluid spark-screen">



		<div class="row">

<?php echo $__env->make('adminlte::layouts.partials.loaders', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



<template v-if="divTestIPP" id="divTestIPP">
	<?php echo $__env->make('testippr.test', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</template>

<template v-if="divPreguntas" id="divPreguntas">
	<?php echo $__env->make('testippr.preguntas', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</template>

<template v-if="divResultado" id="divResultado">
	<?php echo $__env->make('testippr.resultado', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</template>



		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>