<template v-for="perfil, key in alumno" v-if="divPrincipal1">
<div class="col-md-3" id="divTama3">
<div class="box box-primary">
    <div class="box-body box-profile">
        <img alt="User Image" class="profile-user-img img-responsive img-circle imgPerfil" src=""/>
        <h3 class="profile-username text-center">
            {{--$dato->nombres--}} {{--$dato->apellidos--}}  @{{ perfil.apePer }}, @{{ perfil.nombresPer }}
        </h3>
        <p class="text-muted text-center">
            {{--$dato->codigo--}}  Código de Postulante: @{{ perfil.codigopos }}
        </p>
        <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
                <b>
                    DNI
                </b>
                <a class="pull-right">
                    {{--$dato->DNI--}} @{{ perfil.dni }}
                </a>
            </li>
            <li class="list-group-item">
                <b>
                    Teléfono
                </b>
                <a class="pull-right">
                    {{--$dato->telf--}} @{{ perfil.telf }}
                </a>
            </li>
            <li class="list-group-item">
                <b>
                    Dirección
                </b>
                <a class="pull-right">
                    {{--$dato->direccion--}} @{{ perfil.direccion }}
                </a>
            </li>
        </ul>
        <a class="btn btn-primary btn-block" href="javascript:void(0);" ><i class="fa fa-user margin-r-5"></i>
            <b>
                Mi Perfil
            </b>
        </a>
    </div>
    <!-- /.box-body -->
</div>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            Semestre: @{{ perfil.ciclo }}
        </h3>
    </div>
    <div class="box-body">
        <strong>
            <i class="fa fa-book margin-r-5">
            </i>
            {{--$dato->nombres--}} {{--$dato->apellidos--}}  Carrera Profesional a Postular: 
        </strong>
        <p class="text-muted">
            @{{ perfil.carreraProf }}
        </p>
        <hr>
            <strong>
                <i class="fa fa-university margin-r-5">
                </i>
                Área: {{--$dato->esptutor--}} 
            </strong>
            <p class="text-muted">
                {{--$dato->telf--}}@{{ perfil.areaU }}
            </p>
            <hr>
                <strong>
                    <i class="fa fa-calendar margin-r-5">
                    </i>
                    Fecha de Inicio: 
                </strong>
                <p class="text-muted">
                        {{--$dato->email--}}@{{ perfil.fechainicio | fecha}}
                </p>
                <hr>
                    <strong>
                        <i class="fa fa-calendar margin-r-5">
                        </i>
                        Fecha Final: @{{ perfil.fechafin }}
                    </strong>

                    <p class="text-muted">
                    
                        {{--$dato->email--}}@{{ perfil.fechafin | fecha }}
                    
                	</p>


    </div>
</div>

</div>






<div class="col-md-9" id="divTama9">


	          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#actividades" data-toggle="tab">Realizar Test</a></li>
              <li><a href="#historicos" data-toggle="tab">Registro Histórico de Test</a></li>
           {{--     <li><a href="#otros" data-toggle="tab">Otras Funciones</a></li>--}}
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="actividades" style="min-height: 327px;">
                
            <div class="col-lg-4 col-xs-6" >
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 style="font-size: 25px;">IPP-R</h3>

              <p>Inventario de Intereses y Preferencias Profesionales</p>
            </div>
            <div class="icon" style="top: 5px;">
              <i class="fa fa-file-powerpoint-o"></i>
            </div>
            <a href="{{URL::to('testIPP') }}" class="small-box-footer" style="height: 37px; font-size: 25px;">Realizar Test 
            <i style="font-size: 30px; " class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-xs-6" >
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 style="font-size: 25px;">KUDER</h3>

              <p>Inventario de Intereses Vocacionales Kuder Forma C</p>
            </div>
            <div class="icon" style="    top: 5px;">
              <i class="fa fa-picture-o"></i>
            </div>
            <a href="{{ URL::to('testKUDER') }}" class="small-box-footer" style="height: 37px; font-size: 25px;">Realizar Test 
            <i style="font-size: 30px; " class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


                <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="historicos">
                <!-- The timeline -->
            {{--      @include('adminlte::alumnoHistoricos') --}}

             <div class="box-header">
              <h3 class="box-title">Listado de Tests Realizados por los Alumnos</h3>

           {{--    <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 300px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar" v-model="buscar" @keyup.enter="buscarBtn()">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" @click.prevent="buscarBtn()"><i class="fa fa-search"></i></button>
                  </div>


                </div>
              </div> --}}

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-hover table-bordered" >
                <tbody><tr>
                  <th style="padding: 5px; width: 5%;">#</th>
                  <th style="padding: 5px; width: 40%;">Tipo de Test</th>
                  <th style="padding: 5px; width: 10%;">Fecha</th>
                  <th style="padding: 5px; width: 10%;">Hora</th>
                  <th style="padding: 5px; width: 25%;">Estado</th>
                  <th style="padding: 5px; width: 10%;">Gestión</th>
                </tr>
                <tr v-for="test, key in tests">
                  <td style="font-size: 12px; padding: 5px;">@{{key+pagination.from}}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ test.tipo }}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ test.fecha | fecha }} - @{{ test.fechafin | fecha }}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ test.horainicio }} - @{{ test.horafin }}</td>
                  <td style="font-size: 12px; padding: 5px;">
                    <span class="" v-if="test.estado=='2'" style="color: blue;">Finalizado Correcto</span>
                    <span class="" v-if="test.estado=='3'" style="color: red;">Finalizado No Válido</span>
                    <span class="" v-if="test.estado=='4'" style="color: red;">Finalizado Problemas de Consistencia</span>
                  </td>
                  <td style="font-size: 12px; padding: 5px;">
<center>
                    <a href="#" class="btn btn-primary btn-sm" v-on:click.prevent="getRespuesta(test)" data-placement="top" data-toggle="tooltip" title="Ver Resultados del Test"><i class="fa fa-file-text-o"></i></a>
                    </center>

                 {{--     <a href="#" v-if="test.estado=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="bajatest(test)" data-placement="top" data-toggle="tooltip" title="Desactivar Área"><i class="fa fa-arrow-circle-down"></i></a>

                    <a href="#" v-if="test.estado=='0'" class="btn btn-success btn-sm" v-on:click.prevent="altatest(test)" data-placement="top" data-toggle="tooltip" title="Activar Área"><i class="fa fa-check-circle"></i></a>


                    <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edittest(test)" data-placement="top" data-toggle="tooltip" title="Editar Área"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrartest(test)" data-placement="top" data-toggle="tooltip" title="Borrar Área"><i class="fa fa-trash"></i></a>

                    --}}
                  </td>
                </tr>

              </tbody></table>

            </div>
            <!-- /.box-body -->
            <div style="padding: 15px;">
                <div><h5>Registros por Página: @{{ pagination.per_page }}</h5></div>
            <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item" v-if="pagination.current_page>1">
                    <a class="page-link" href="#" @click.prevent="changePage(1)">
                        <span><b>Inicio</b></span>
                    </a>
                </li>

                <li class="page-item" v-if="pagination.current_page>1">
                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page-1)">
                        <span>Atras</span>
                    </a>
                </li>
                <li class="page-item" v-for="page in pagesNumber" v-bind:class="[page=== isActived ? 'active' : '']">
                    <a class="page-link" href="#" @click.prevent="changePage(page)">
                        <span>@{{ page }}</span>
                    </a>
                </li>
                <li class="page-item" v-if="pagination.current_page< pagination.last_page">
                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page+1)">
                        <span>Siguiente</span>
                    </a>
                </li>
                <li class="page-item" v-if="pagination.current_page< pagination.last_page">
                    <a class="page-link" href="#" @click.prevent="changePage(pagination.last_page)">
                        <span><b>Ultima</b></span>
                    </a>
                </li>
            </ul>
        </nav>
    <div><h5>Registros Totales: @{{ pagination.total }}</h5></div>
        </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="otros">
                
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->


</div>
</template>




<template v-for="perfil, key in alumno" v-if="divPrincipal2">

@include('inicio.resultadosAlumno')
</template>