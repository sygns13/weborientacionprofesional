<?php $__env->startSection('htmlheader_title'); ?>
	Gestión de Carreras Universitarias UNASAM
<?php $__env->stopSection(); ?>

<style type="text/css">         
          
#modaltamanio{
  width: 70% !important;
}


</style>
<?php $__env->startSection('main-content'); ?>
	<div class="container-fluid spark-screen">



		<div class="row">

<?php echo $__env->make('adminlte::layouts.partials.loaders', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

			<?php if(accesoUser([1,2])): ?>

<template v-if="divcarrerasu" id="divcarrerasu">
	<?php echo $__env->make('carrerasunasam.carrera', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</template>

<template v-if="divcontentCarrera" id="divcontentCarrera">
	<?php echo $__env->make('carrerasunasam.contenidoCarrera', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</template>
			<?php endif; ?>


		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>