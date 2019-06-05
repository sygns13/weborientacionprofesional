<div class="box box-primary" v-if="mostrarPalenIni">
            <div class="box-header with-border"> 
              <h3 class="box-title">Gestión de Usuarioss</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">



                       <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
              <button type="button" class="btn btn-primary btn-sm" id="btncrearusuario" @click.prevent="nuevoUsuario()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Usuario</button>
                </div>
                </div>





                
              </div>

          </div>

        <div class="box box-success" v-if="divNuevoUsuario">
            <div class="box-header with-border" >
              <h3 class="box-title" id="tituloAgregar">Nuevo Usuarioo


              </h3>
            </div>
       
        @include('usuarios.formulario')  

         </div>


         <div class="box box-warning" v-if="divEditUsuario">
            <div class="box-header with-border" >
              <h3 class="box-title" id="tituloAgregar">Editar Usuario: @{{ fillPersona.apellidos }} @{{ fillPersona.nombres }}


              </h3>
            </div>
       
        @include('usuarios.editar')  

         </div>

          <div class="box box-info" >
            <div class="box-header">
              <h3 class="box-title">Listado de Usuarios del Sistema
              </h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 300px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar" v-model="buscar" @keyup.enter="buscarBtn()">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" @click.prevent="buscarBtn()"><i class="fa fa-search"></i></button>
                  </div>


                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-hover table-bordered" >
                <tbody><tr>
                  <th style="padding: 5px; width: 5%;">#</th>
                  <th style="padding: 5px; width: 16%;">Tipo de Usuario</th>
                  <th style="padding: 5px; width: 16%;">Apellidos y Nombres</th>
                  <th style="padding: 5px; width: 7%;">DNI</th>
                  <th style="padding: 5px; width: 7%;">Teléfono</th>
                  <th style="padding: 5px; width: 9%;">Usuario</th>
                  <th style="padding: 5px; width: 15%;">Email</th>
                  <th style="padding: 5px; width: 6%;">Estado</th>
                  <th style="padding: 5px; width: 13%;">Gestión</th>
                </tr>
                <tr v-for="usuario, key in usuarios">
                  <td style="font-size: 12px; padding: 5px;">@{{key+pagination.from}}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ usuario.tipouser }}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ usuario.apePer }}, @{{ usuario.nombresPer }}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ usuario.dni }}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ usuario.telf }}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ usuario.username }}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ usuario.email }}</td>
                  <td style="font-size: 12px; padding: 5px;">
                  	<span class="label label-success" v-if="usuario.activo=='1'">Activo</span>
                  	<span class="label label-warning" v-if="usuario.activo=='0'">Inactivo</span>
                  </td>
                  <td style="font-size: 12px; padding: 5px;">

                    <a href="#" class="btn btn-info btn-sm" v-on:click.prevent="impFicha(usuario)" data-placement="top" data-toggle="tooltip" title="Imprimir Ficha de Usuario"><i class="fa fa-print"></i></a>


                  	<a href="#" v-if="usuario.activo=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="bajaUsuario(usuario)" data-placement="top" data-toggle="tooltip" title="Desactivar Usuario"><i class="fa fa-arrow-circle-down"></i></a>

                  	<a href="#" v-if="usuario.activo=='0'" class="btn btn-success btn-sm" v-on:click.prevent="altaUsuario(usuario)" data-placement="top" data-toggle="tooltip" title="Activar Usuario"><i class="fa fa-check-circle"></i></a>


                  	<a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editUsuario(usuario)" data-placement="top" data-toggle="tooltip" title="Editar usuario"><i class="fa fa-edit"></i></a>
                  	<a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarUsuario(usuario)" data-placement="top" data-toggle="tooltip" title="Borrar usuario"><i class="fa fa-trash"></i></a>
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



<form  v-on:submit.prevent="Imprimir()">
<div class="modal fade bs-example-modal-lg" id="modalFicha" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document"  id="modaltamanio1">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">IMPRIMIR FICHA DE ALUMNO</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloAgre"></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div id="FichaUsuario"> 
       @include('usuarios.ficha')  
                
            </div>
          </div>



      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnImprimir"><i class="fa fa-print" aria-hidden="true"></i> Imprimir Ficha</button>

      <button type="button" id="btnCancelFoto" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>



      </div>
    </div>
  </div>
</div>
</div>
</form>
