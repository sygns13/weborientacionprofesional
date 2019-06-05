<?php $__env->startSection('htmlheader_title'); ?>
	<?php echo e(trans('adminlte_lang::message.home')); ?>

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

			<?php if(accesoUser([1,2,3])): ?>

<template v-if="divhome" id="divhome" v-show="divhome">
	<?php echo $__env->make('inicio.menuAdmin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>		
</template>

			<?php elseif(accesoUser([4])): ?>

<template v-if="divhome" id="divhome" v-show="divhome">
	<?php echo $__env->make('inicio.menuAlumno', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>		
</template>		
			<?php endif; ?>


		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>