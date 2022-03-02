<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Gestión de Áreas Académicas de la UNASAM</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="<?php echo e(URL::to('home')); ?>"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">
                <div class="form-group">
              <button type="button" class="btn btn-primary" id="btncrearArea" @click.prevent="nuevaArea()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo</button>
                </div>


    	
    	

          </div>

          </div>

        <div class="box box-success" v-if="divNuevaArea">
            <div class="box-header with-border" >
              <h3 class="box-title" id="tituloAgregar">Nueva Área Académica</h3>
            </div>

            <form v-on:submit.prevent="createArea">
             <div class="box-body">

             	<div class="col-md-12" >

             	<div class="form-group">
                  <label for="txtarea" class="col-sm-2 control-label">Nombre del Área:*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtarea" name="txtarea" placeholder="Nombre" maxlength="100" autofocus v-model="newArea">
                  </div>
                </div>



                </div>

                <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuestado" class="col-sm-2 control-label">Estado:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestado" name="cbuestado" v-model="estadoArea">
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

                <button type="reset" class="btn btn-warning" id="btnCancel" @click="cancelFormArea()">Cancelar</button>

                <button type="button" class="btn btn-default" id="btnClose" @click.prevent="cerrarFormArea()">Cerrar</button>

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
              <h3 class="box-title">Listado de Áreas Académicas</h3>

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
                  <th style="padding: 5px; width: 55%;">Área</th>
                  <th style="padding: 5px; width: 25%;">Estado</th>
                  <th style="padding: 5px; width: 15%;">Gestión</th>
                </tr>
                <tr v-for="area, key in areas">
                  <td style="font-size: 12px; padding: 5px;">{{key+pagination.from}}</td>
                  <td style="font-size: 12px; padding: 5px;">{{ area.nombre }}</td>
                  <td style="font-size: 12px; padding: 5px;">
                  	<span class="label label-success" v-if="area.activo=='1'">Activo</span>
                  	<span class="label label-warning" v-if="area.activo=='0'">Inactivo</span>
                  </td>
                  <td style="font-size: 12px; padding: 5px;">

                  	<a href="#" v-if="area.activo=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="bajaArea(area)" data-placement="top" data-toggle="tooltip" title="Desactivar Área"><i class="fa fa-arrow-circle-down"></i></a>

                  	<a href="#" v-if="area.activo=='0'" class="btn btn-success btn-sm" v-on:click.prevent="altaArea(area)" data-placement="top" data-toggle="tooltip" title="Activar Área"><i class="fa fa-check-circle"></i></a>


                  	<a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editArea(area)" data-placement="top" data-toggle="tooltip" title="Editar Área"><i class="fa fa-edit"></i></a>
                  	<a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarArea(area)" data-placement="top" data-toggle="tooltip" title="Borrar Área"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>

              </tbody></table>

            </div>
            <!-- /.box-body -->
            <div style="padding: 15px;">
            	<div><h5>Registros por Página: {{ pagination.per_page }}</h5></div>
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
						<span>{{ page }}</span>
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
    <div><h5>Registros Totales: {{ pagination.total }}</h5></div>
		</div>
          </div>

<form method="post" v-on:submit.prevent="updateArea(fillArea.id)">
<div class="modal fade bs-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR Área</h4>

      </div> 
      <div class="modal-body">
      <input type="hidden" id="idServicio" value="0">

      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTitulo">Área:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
               
               <div class="col-md-12" >
               <div class="form-group">
                  <label for="txtareaE" class="col-sm-2 control-label">Nombre del Área:*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtareaE" name="txtareaE" placeholder="Nombre" maxlength="100" autofocus v-model="fillArea.area">
                  </div>
                </div>
               </div>

               <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  <label for="cbuestado" class="col-sm-2 control-label">Estado:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestado" name="cbuestado" v-model="fillArea.estado">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                  </select>
                   </div>
                </div>
               <div class="col-md-12" >



              </div>
              <!-- /.box-body -->
             

            
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
