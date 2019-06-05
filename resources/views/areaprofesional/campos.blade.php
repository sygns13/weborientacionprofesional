<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Gestión de Áreas de Interés de la Metodología KUDER FORMA C</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('kuder')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">
                <div class="form-group">
              <button type="button" class="btn btn-primary" id="btncrearArea" @click.prevent="nuevoCampoProf()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo</button>
                </div>

          </div>

          </div>

        <div class="box box-success" v-if="divNuevoCampoProf">
            <div class="box-header with-border" >
              <h3 class="box-title" id="tituloAgregar">Nueva Área de Interés Profesional</h3>
            </div>

            <form v-on:submit.prevent="createCampoProf">
             <div class="box-body">

             	<div class="col-md-12" >

             	<div class="form-group">
                  <label for="txtNombre" class="col-sm-2 control-label">Nombre del Área:*</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre" maxlength="500" autofocus v-model="newNombre" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false">
                  </div>
                </div>



                </div>

                <div class="col-md-12" style="padding-top: 15px;">
               <div class="form-group" >
                  <label for="txtNumOrden" class="col-sm-2 control-label">Número de Orden:*</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtNumOrden" name="txtNumOrden" placeholder="N°" maxlength="10" autofocus v-model="newOrden" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);">
                  </div>



                </div>
              </div>

                <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuestado" class="col-sm-2 control-label">Estado:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestado" name="cbuestado" v-model="estadoCampoProf">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                  </select>
                   </div>
                </div>

            </div>

            </div>

              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info" id="btnGuardar">Guardar</button>

                <button type="reset" class="btn btn-warning" id="btnCancel" @click="cancelFormCampoProf()">Cancelar</button>

                <button type="button" class="btn btn-default" id="btnClose" @click.prevent="cerrarFormCampoProf()">Cerrar</button>

      <div class="sk-circle" v-show="divloaderNuevo">
        <div class="sk-circle1 sk-child"></div>
        <div class="sk-circle2 sk-child"></div>
        <div class="sk-circle3 sk-child"></div>
        <div class="sk-circle4 sk-child"></div>
        <div class="sk-circle5 sk-child"></div>
        <div class="sk-circle6 sk-child"></div>
        <div class="sk-circle7 sk-child"></div>
        <div class="sk-circle8 sk-child"></div>
        <div class="sk-circle9 sk-child"></div>
        <div class="sk-circle10 sk-child"></div>
        <div class="sk-circle11 sk-child"></div>
        <div class="sk-circle12 sk-child"></div>
      </div>
                
              </div>
              <!-- /.box-footer -->
           
		</form>
          </div>




          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Listado de Áreas de Interés</h3>

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
                  <th style="padding: 5px; width: 50%;">Área de Interés</th>
                  <th style="padding: 5px; width: 15%;">Num de Orden</th>
                  <th style="padding: 5px; width: 15%;">Estado</th>
                  <th style="padding: 5px; width: 15%;">Gestión</th>
                </tr>
                <tr v-for="campoprofesional, key in campoprofesionals">
                  <td style="font-size: 12px; padding: 5px;">@{{key+pagination.from}}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ campoprofesional.nombre }}</td>
                  <td style="font-size: 12px; padding: 5px;">@{{ campoprofesional.orden }}</td>
                  <td style="font-size: 12px; padding: 5px;">
                  	<span class="label label-success" v-if="campoprofesional.activo=='1'">Activo</span>
                  	<span class="label label-warning" v-if="campoprofesional.activo=='0'">Inactivo</span>
                  </td>
                  <td style="font-size: 12px; padding: 5px;">

                    <a v-bind:href="'/maestrocarreras2/' + campoprofesional.id" class="btn btn-success btn-sm"><i class="fa fa-book" aria-hidden="true" data-placement="top" data-toggle="tooltip" title=" Gestión de Carreras Profesionales"></i></a>

                  	<a href="#" v-if="campoprofesional.activo=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="bajaCampoProf(campoprofesional)" data-placement="top" data-toggle="tooltip" title="Desactivar Área de Interés"><i class="fa fa-arrow-circle-down"></i></a>

                  	<a href="#" v-if="campoprofesional.activo=='0'" class="btn btn-success btn-sm" v-on:click.prevent="altaCampoProf(campoprofesional)" data-placement="top" data-toggle="tooltip" title="Activar Área de Interés"><i class="fa fa-check-circle"></i></a>


                  	<a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editCampoProf(campoprofesional)" data-placement="top" data-toggle="tooltip" title="Editar Área de Interés"><i class="fa fa-edit"></i></a>
                  	<a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarCampoProf(campoprofesional)" data-placement="top" data-toggle="tooltip" title="Borrar Área de Interés"><i class="fa fa-trash"></i></a>
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




<form method="post" v-on:submit.prevent="updateCampos(fillCamposProfs.id)">
<div class="modal fade bs-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR ÁREA DE INTERÉS</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTitulo">Área de Interéss:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
               
               <div class="col-md-12" >

              <div class="form-group">
                  <label for="txtNombreE" class="col-sm-2 control-label">Nombre del Área:*</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtNombreE" name="txtNombreE" placeholder="Nombre" maxlength="500" autofocus v-model="fillCamposProfs.nombre" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false">
                  </div>
                </div>



                </div>

                <div class="col-md-12" style="padding-top: 15px;">
               <div class="form-group" >
                  <label for="txtNumOrdenE" class="col-sm-2 control-label">Número de Orden:*</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtNumOrdenE" name="txtNumOrdenE" placeholder="N°" maxlength="10" autofocus v-model="fillCamposProfs.orden" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);">
                  </div>



                </div>
              </div>

                <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuestadoE" class="col-sm-2 control-label">Estado:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestadoE" name="cbuestadoE" v-model="fillCamposProfs.activo">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                  </select>
                   </div>
                </div>

            </div>



      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnSaveE"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

      <button type="button" id="btnCancelE" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

      <div class="sk-circle" v-show="divloaderEdit">
        <div class="sk-circle1 sk-child"></div>
        <div class="sk-circle2 sk-child"></div>
        <div class="sk-circle3 sk-child"></div>
        <div class="sk-circle4 sk-child"></div>
        <div class="sk-circle5 sk-child"></div>
        <div class="sk-circle6 sk-child"></div>
        <div class="sk-circle7 sk-child"></div>
        <div class="sk-circle8 sk-child"></div>
        <div class="sk-circle9 sk-child"></div>
        <div class="sk-circle10 sk-child"></div>
        <div class="sk-circle11 sk-child"></div>
        <div class="sk-circle12 sk-child"></div>
      </div>

      </div>
    </div>
  </div>
</div>
</div>
</div>
</form>
