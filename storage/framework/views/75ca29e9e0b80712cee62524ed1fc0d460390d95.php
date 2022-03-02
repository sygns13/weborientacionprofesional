<?php $__env->startSection('htmlheader_title'); ?>
   Iniciar Sesión
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<body class="hold-transition login-page" style="background: url('<?php echo e(asset('/img/imgv5.jpg')); ?>')no-repeat center center fixed; height: auto;-webkit-background-size: cover;">

   


    <div id="app">
         <center>

<img src="<?php echo e(asset('/img/unasam.png')); ?>" class="img-responsive" id="logo-login" style="width: 100px; padding-top: 100px;" >

</center>
        <div class="login-box" style="margin-top: 30px;">

            <div class="login-logo">
                <a href="<?php echo e(url('/home')); ?>" style="color: white;"><b>Sistema Experto de </b>Orientación Vocacional</a>
            </div><!-- /.login-logo -->

        <?php if(count($errors) > 0): ?>
            <div class="alert alert-danger">
                <strong>Error !</strong> <?php echo e(trans('adminlte_lang::message.someproblems')); ?><br><br>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php if($error=="The name field is required."): ?>
                        <li>El campo Usuario es necesario.</li>
                    <?php endif; ?>

                    <?php if($error=="The password field is required."): ?>
                        <li>El campo Contraseña es necesario.</li>
                    <?php endif; ?>

                    <?php if($error=="These credentials do not match our records."): ?>
                    <li>Estas credenciales no coinciden con nuestros registros.</li>
                    <?php endif; ?>

                    <?php if($error=="usuarioActiv"): ?>
                    <li>El usuario del sistema se encuentra desactivado, comuncarse con el administrador del sistema.</li>
                    <?php endif; ?>

                    <?php if($error=="alumnoSemestre"): ?>
                    <li>El semestre al que pertenece el alumno se encuentra cerrado, comuniquese con el administrador del sistema.</li>
                    <?php endif; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="login-box-body" style="background: rgb(255, 255, 255);
    padding: 20px;
    border-top: 0;
    color: #020202;
    border-radius: 5%;
    font-weight: bold;">
        <p class="login-box-msg"> <?php echo e(trans('adminlte_lang::message.siginsession')); ?> </p>
        <form action="<?php echo e(url('/login')); ?>" method="post">
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">


            
<div class="form-group has-feedback">
    <input type="text" name="name" class="form-control" id="name" placeholder="Usuario"/>
    <span class="glyphicon glyphicon-user form-control-feedback"></span>
</div>

            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="<?php echo e(trans('adminlte_lang::message.password')); ?>" name="password"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">

                <div class="col-xs-6">
                    <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo e(trans('adminlte_lang::message.buttonsign')); ?></button>
                </div>
                <div class="col-xs-6">
                    <a href="/" class="btn btn-default btn-block btn-flat">Cancelar</a>
                </div><!-- /.col -->
            </div>
        </form>

       

        

    </div><!-- /.login-box-body -->

    </div><!-- /.login-box -->
    </div>
    <?php echo $__env->make('adminlte::layouts.partials.scripts_auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::layouts.auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>