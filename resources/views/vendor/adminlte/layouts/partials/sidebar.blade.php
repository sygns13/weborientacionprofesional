<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ asset('/img/perfil/noPerfil.png')}}" class="img-circle imgPerfil" alt="User Image" style="height: 45px;"/>
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional)
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            
            <!-- Optionally, you can add icons to the links -->
            <li v-bind:class="classMenu0"><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>Inicio</span></a></li>


            @if(accesoUser([1,2]))

            <li class="header">MENÚ ADMINISTRADOR WEB</li>

            <li class="treeview" v-bind:class="classMenu1">
                <a href="#"><i class='fa  fa-cogs'></i> <span>Config. Académica</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{URL::to('areasUNASAM')}}">Áreas Académicas</a></li>
                    <li><a href="{{ URL::to('ciclos')}}">Ciclos Académicos</a></li>
                    <li><a href="{{ URL::to('facultades')}}">Facultades UNASAM</a></li>
                    <li><a href="{{ URL::to('carrerasUNASAM')}}">Carreras UNASAM</a></li>
                    <li><a href="{{ URL::to('alumnos')}}">Alumnos CPU</a></li>
                </ul>
            </li>
            @endif

            @if(accesoUser([1]))
            
            <li v-bind:class="classMenu2"><a href="{{ URL::to('usuarios')}}"><i class='fa fa-user-secret'></i> <span>Administrar Usuarios</span></a></li>

             @endif

             @if(accesoUser([1,3]))

             <li class="header">MENÚ ADMINISTRADOR EXPERTO</li>

            <li class="treeview" v-bind:class="classMenu3">
                <a href="#"><i class='fa  fa-cogs'></i> <span>Base de Conocimientos</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ URL::to('inventarioInteresesProfesionales')}}">Metodología IPP-R</a></li>
                    <li><a href="{{ URL::to('kuder')}}">Metodología KUDER</a></li>
                </ul>
            </li>

            <li class="treeview" v-bind:class="classMenu4">
                <a href="#"><i class='fa fa-print'></i> <span>Reportes Analíticos</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Resultados por Alumno</a></li>
                    <li><a href="#">Resultados Históricos</a></li>
                    <li><a href="#">Reportes Estadísticos</a></li>
                </ul>
            </li>
            @endif



            @if(accesoUser([4]))
            <li class="header">MENÚ ALUMNOS</li>

            <li class="treeview" v-bind:class="classMenu5">
                <a href="#"><i class='fa fa-file-text-o'></i> <span>Iniciar Test</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                    <li><a href="{{ URL::to('testIPP')}}">Test IPP</a></li>
                    <li><a href="{{ URL::to('testKUDER')}}">Test KUDER</a></li>
                </ul>
            </li>

            <li class="treeview" v-bind:class="classMenu6" style="display: none;">
                <a href="#"><i class='fa fa-mortar-board'></i> <span>Información Académica</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Carreras Profesionales UNASAM</a></li>
                    <li><a href="#">Número de Vacantes</a></li>
                    <li><a href="#">Temario de Admisión</a></li>
                </ul>
            </li>

            <li class="treeview" v-bind:class="classMenu7" style="display: none;">
                <a href="#"><i class='fa fa-print'></i> <span>Resultados</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Resultados Históricos</a></li>
                    <li><a href="#">Reportes Estadísticos</a></li>
                </ul>
            </li>

             @endif


             @if(accesoUser([1,3]))
            <li class="treeview" v-bind:class="classMenu7">
                <a href="#"><i class='fa fa-print'></i> <span>Resultados</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Resultados Históricos</a></li>
                    <li><a href="#">Reportes Estadísticos</a></li>
                </ul>
            </li>

            @endif


        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
