<?php $__env->startSection('htmlheader_title'); ?>
	KUDER - Gestión de Metodología
<?php $__env->stopSection(); ?>

<style type="text/css">         
          
#modaltamanio{
  width: 80% !important;
}

</style>
<?php $__env->startSection('main-content'); ?>
	<div class="container-fluid spark-screen">



		<div class="row">

<?php echo $__env->make('adminlte::layouts.partials.loaders', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

			<?php if(accesoUser([1,3])): ?>

<template v-if="divkuder" id="divkuder">
	<?php echo $__env->make('kuder.kuder', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</template>
			<?php endif; ?>


		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>