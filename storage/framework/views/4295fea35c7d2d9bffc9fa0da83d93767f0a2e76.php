<?php $__env->startSection('htmlheader_title'); ?>
	Gestión de Usuarios
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

			<?php if(accesoUser([1])): ?>

<template v-if="divusuario" id="divusuario">
	<?php echo $__env->make('usuarios.usuario', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</template>
			<?php endif; ?>


		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>