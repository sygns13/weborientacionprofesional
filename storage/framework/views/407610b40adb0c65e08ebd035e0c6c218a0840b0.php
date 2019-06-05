<head>
    <meta charset="UTF-8">
    <title> Sistema de Orientación Vocacional - <?php echo $__env->yieldContent('htmlheader_title', ''); ?> </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link href="<?php echo e(asset('/css/all.css')); ?>" rel="stylesheet" type="text/css" />

        <link href="<?php echo e(asset('/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('/css/dataTables.bootstrap.css')); ?>" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo e(asset('/css/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo e(asset('/css/select2.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('/css/datepicker3.css')); ?>" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo e(asset('/css/alertify.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('/css/fileinput.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('/iCheck/all.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('css/prettyPhoto.css')); ?>" rel="stylesheet" media="screen" type="text/css" charset="utf-8" />
    <link href="<?php echo e(asset('css/color/bootstrap-colorpicker.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('css/estiloadmin.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('css/spinkit.min.css')); ?>" rel="stylesheet" type="text/css" />

<link rel="icon" type="image/png" href="<?php echo e(asset('/img/unasamicono.png')); ?>" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
    </script>
</head>
