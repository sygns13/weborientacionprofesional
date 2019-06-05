<!DOCTYPE html>
<!--
Landing page based on Pratt: http://blacktie.co/demo/pratt/
-->
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema Web de Orientación Vocacional">
    <meta name="author" content="Cristian Fernando Chávez Torres">

    <meta property="og:title" content="Adminlte-laravel" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="SISTEMA EXPERTO WEB DE ORIENTACION VOCACIONAL PARA DETERMINAR EL PERFIL VOCACIONAL DE LOS POSTULANTES DEL CENTRO PRE UNIVERSITARIO A LA UNASAM" />

    <title>Sistema Web de Orientación Vocacional"</title>

    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/all-landing.css') }}" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="{{ asset('/img/unasamicono.png') }}" />

</head>

<body data-spy="scroll" data-offset="0" data-target="#navigation">

<div id="app">
    <!-- Fixed navbar -->
    <div id="navigation" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><b>Home</b></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="https://www.unasam.edu.pe/" class="smoothScroll" target="_blank">Página Web UNASAM</a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                    @else
                        <li><a href="/home">{{ Auth::user()->name }}</a></li>
                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>


    <section id="home" name="home"></section>
    <div id="headerwrap">
        <div class="container">
            <div class="row centered">
                <div class="col-lg-12">
                    <center><img class="img-responsive" src="{{ asset('/img/logo.png') }}"></center>
                    <h1 style="color: #3bc492;"><b>Sistema Web de Orientación Vocacional</b></h1>
                    <h3>Sistema experto web de Orientación vocacional para determinar el perfil vocacional de los postulantes del Centro Pre Universitario a la UNASAM</h3>
                    <p style="text-align: justify; line-height: 20px;">Ingrese al sistema y realize el test de Orientación Vocacional, una vez concluida la prueba el Sistema Procesará sus resultados y se los mostrará en tiempo real, posteriormente los podrá guardar o enviar mediante correo electrónico. El sistema mantiene el principio de confidencialidad y resguardo e integridad de la información. Puede acceder a su cuenta de usuario y observar sus resultados obtenidos previamente.</p>
                    <h3><a href="{{ url('/login') }}" class="btn btn-lg btn-success">Iniciar Sesión</a></h3>
                </div>
                <div class="col-lg-2">
                    <h5>Joven Postulante</h5>
                    <p>Accede al Sistema e ingresa tus respuestas con sinceridad y sin ninguna presión.</p>
  
                </div>
                <div class="col-lg-8">
                    <img class="img-responsive" src="{{ asset('/img/imgov1.jpg') }}" alt="">
                </div>
                <div class="col-lg-2">
                    <br>

                    <h5>En este Ciclo 2018-I</h5>
                    <p>Tu Usuario y Contraseña es tu DNI. Tus respuestas son totalmente confidenciales y seguras.</p>
                </div>
            </div>
        </div> <!--/ .container -->
    </div><!--/ #headerwrap -->


   


    <div id="c">
        <div class="container">
            <p>
                <strong>Copyright &copy; 2018 Todos los Derechos Reservados por el <a href="https://www.facebook.com/Cristian.Sygns" target="_blank">Desarrollador Web</a></strong>
                <br/>
               Cristian Fernando Chávez Torres <a href="http://ogtise.unasam.edu.pe" target="_blank">https://ogtise.unasam.edu.pe</a>
                <br/>
                Bach. en Ingeniería de Sistemas e Informática de la <a href="https://unasam.edu.pe" target="_blank">UNASAM</a>
            </p>

        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('/js/app.js') }}"></script>
<script src="{{ asset('/js/smoothscroll.js') }}"></script>
<script>
    $('.carousel').carousel({
        interval: 3500
    })
</script>
</body>
</html>
