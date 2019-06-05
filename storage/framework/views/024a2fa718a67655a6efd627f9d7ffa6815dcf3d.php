<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="<?php echo e(asset('/js/app.js')); ?>" type="text/javascript"></script>



<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('js/jquery.prettyPhoto.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('js/jquery.dataTables.min.js')); ?>"  type="text/javascript"></script>
<script src="<?php echo e(asset('js/dataTables.bootstrap.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('js/sweetalert2.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('js/select2.full.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('js/bootstrap-datepicker.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('js/alertify.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('js/jquery.PrintArea.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('js/fileinput.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('js/locales/es.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('iCheck/icheck.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('Ckeditor/ckeditor.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap-colorpicker.js')); ?>"  type="text/javascript"></script>
<script src="<?php echo e(asset('js/axios.js')); ?>"  type="text/javascript"></script>


<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>;
</script>
