<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Contenido Informativo de la Carrera Profesional: <b>@{{ carreraProf }}</b></h3>
              <a style="float: right;" type="button" class="btn btn-default" href="#" @click.prevent="volverCarreras()"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">
                <div class="form-group">
              <button type="button" class="btn btn-primary" id="btncrearinformacion" @click.prevent="nuevaInformacion()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Contenido Informativo</button>
                </div>


    	
    	{{--  
              <div class="box-footer">
                <button type="button" class="btn btn-primary" onclick="enviarMSj();" id="btnEnviarMsj"><i class="fa fa-envelope-o" aria-hidden="true" ></i> Enviar Mensaje</button>
                <div id="divCarga0" style="display: inline-block;"><div id="dcarga0" style="display: none;"><img src="{{ asset('/img/ajax-loader.gif')}}"/></div></div>
              </div>
   		--}}

          </div>

          </div>

        <div class="box box-success" v-if="divNuevaInformacion">
            <div class="box-header with-border" >
              <h3 class="box-title" id="tituloAgregar">Nuevo Contenido Informativo</h3>
            </div>

            <form v-on:submit.prevent="createInformacion" enctype="multipart/form-data" id="formulario">
             <div class="box-body">





             	<div class="col-md-12" >

             	<div class="form-group">
                  <label for="txttitulo" class="col-sm-2 control-label">Título:*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txttitulo" name="txttitulo" placeholder="Título" maxlength="500" autofocus v-model="newTitulo">
                  </div>
                </div>
              </div>

              <div class="col-md-12" style="padding-top: 15px;">

              <div class="form-group">
                  <label for="txtorden" class="col-sm-2 control-label">Orden de Publicación:*</label>

                  <div class="col-sm-2">
                    <input type="number" v-model.number="newOrden"  class="form-control" id="txtorden" name="txtorden" placeholder="N°" onKeyUp="if(this.value.length>4){this.value='9999';}else if(this.value<0){this.value='0';}" placeholder="N°">
                  </div>
                </div>
              </div>



<div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="txtdescripcion" class="col-sm-2 control-label">Descripción:*</label>

                  <div class="col-sm-8">
                   {{--   <textarea class="form-control" id="txtdescripcion" name="txtdescripcion" placeholder="Descripción" rows="6"  v-model="newDescripcion">
                    </textarea> --}}
                    <ckeditora v-model="content"></ckeditora>
                  </div>
                </div>

</div>

 <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuestado" class="col-sm-2 control-label">Estado:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestado" name="cbuestado" v-model="estadoContenido">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                  </select>
                   </div>
                </div>

            </div>

<div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuestado" class="col-sm-2 control-label">Imagen: (Opcional)</label>

                  <div class="col-sm-8">
                     <input name="archivo" type="file" id="archivo" class="archivo form-control" @change="getImage"
          accept=".png, .jpg, .jpeg, .gif, .jpe, .PNG, .JPG, .JPEG, .GIF, .JPE"/>

         

      
                   </div>
                </div>

            </div>


<div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="txtArchivoAdjunto" class="col-sm-2 control-label">Archivo Adjunto: (Opcional: pdf, docx, xlsx, pptx)</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtArchivoAdjunto" name="txtArchivoAdjunto" placeholder="Nombre del Archivo" maxlength="500" autofocus v-model="newNombreArchivo">
                  </div>

                  <div class="col-sm-8">
                     <input v-if="uploadReady" name="archivo2" type="file" id="archivo2" class="archivo form-control" @change="getArchivo" 
          accept=".pdf, .doc, .docx, .xls, .xlsx, ppt, .pptx, .PDF, .DOC, .DOCX, .XLS, .XLSX, .PPT, .PTTX"/>

         

      
                   </div>
                </div>

            </div>
               

            </div>

              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info" id="btnGuardar">Guardar</button>

                <button type="reset" class="btn btn-warning" id="btnCancel" @click.prevent="cancelFormInformacion()">Cancelar</button>

                <button type="button" class="btn btn-default" id="btnClose" @click.prevent="cerrarFormInformacion()">Cerrar</button>

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
              <h3 class="box-title">Listado de Contenido Informativo de la Carrera Profesional: <b>@{{ carreraProf }}</b></h3>

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
                  <th style="padding: 5px; width: 15%;">Título</th>
                  <th style="padding: 5px; width: 25%;">Descripción</th>
                  <th style="padding: 5px; width: 10%;">N° de Orden</th>
                  <th style="padding: 5px; width: 10%;">Imagen</th>
                  <th style="padding: 5px; width: 10%;">Archivo Adjunto</th>
                  <th style="padding: 5px; width: 10%;">Estado</th>
                  <th style="padding: 5px; width: 15%;">Gestión</th>
                </tr>
                <tr v-for="informacion, key in informacions">
                  <td style="font-size: 12px; padding: 5px;">@{{key+pagination.from}}</td>

                  <td style="font-size: 12px; padding: 5px;">@{{ informacion.titulo }}</td>

                  <td style="font-size: 12px; padding: 5px;" v-html="informacion.descripcion"></td>                

                  <td style="font-size: 12px; padding: 5px;">@{{ informacion.orden }}</td>

                  <td style="font-size: 12px; padding: 5px;">
                    <span class="label label-default" v-if="informacion.urlimagen==''">None</span>
                      <a href="#" v-if="informacion.urlimagen.length>0" class="btn bg-teal btn-sm" v-on:click.prevent="verImg(informacion)" data-placement="top" data-toggle="tooltip" title="Ver Imagen"><i class="fa fa-image"></i></a>
                  </td>

                  <td style="font-size: 12px; padding: 5px;">
                    <span class="label label-default" v-if="informacion.urldocumento==''">None</span>
                      <a href="#" v-if="informacion.urldocumento.length>0" class="btn bg-purple btn-sm" v-on:click.prevent="verArcivo(informacion)" data-placement="top" data-toggle="tooltip" title="Ver Archivo Adjunto"><i class="fa fa-list-alt"></i></a>
                  </td>

                  <td style="font-size: 12px; padding: 5px;">
                  	<span class="label label-success" v-if="informacion.activo=='1'">Activo</span>
                  	<span class="label label-warning" v-if="informacion.activo=='0'">Inactivo</span>
                  </td>

                  <td style="font-size: 12px; padding: 5px;">

     

                  	<a href="#" v-if="informacion.activo=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="bajaInformacion(informacion)" data-placement="top" data-toggle="tooltip" title="Desactivar Contenido"><i class="fa fa-arrow-circle-down"></i></a>

                  	<a href="#" v-if="informacion.activo=='0'" class="btn btn-success btn-sm" v-on:click.prevent="altaInformacion(informacion)" data-placement="top" data-toggle="tooltip" title="Activar Contenido"><i class="fa fa-check-circle"></i></a>


                  	<a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editInformacion(informacion)" data-placement="top" data-toggle="tooltip" title="Editar Contenido"><i class="fa fa-edit"></i></a>
                  	<a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarInformacion(informacion)" data-placement="top" data-toggle="tooltip" title="Borrar Contenido"><i class="fa fa-trash"></i></a>
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

<form  v-on:submit.prevent="updateInformacion(fillinformacion.id)" enctype="multipart/form-data" id="formulario2">
<div class="modal fade bs-example-modal-lg" id="modalEditar"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR CONTENIDO INFORMATIVO</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTitulo">Contenido Informativo:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body" >


              
                            <div class="col-md-12" >

              <div class="form-group">
                  <label for="txttituloE" class="col-sm-2 control-label">Título:*</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txttituloE" name="txttituloE" placeholder="Título" maxlength="500" autofocus v-model="fillinformacion.titulo">
                  </div>
                </div>
              </div>

              <div class="col-md-12" style="padding-top: 15px;">

              <div class="form-group">
                  <label for="txtordenE" class="col-sm-2 control-label">Orden de Publicación:*</label>

                  <div class="col-sm-2">
                    <input type="number" v-model.number="fillinformacion.orden"  class="form-control" id="txtordenE" placeholder="N°" onKeyUp="if(this.value.length>4){this.value='9999';}else if(this.value<0){this.value='0';}" placeholder="N°">

                  </div>
                </div>
              </div>



<div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="txtdescripcion" class="col-sm-2 control-label">Descripción:*</label>

                  <div class="col-sm-8">
                   {{--   <textarea class="form-control" id="txtdescripcion" name="txtdescripcion" placeholder="Descripción" rows="6"  v-model="newDescripcion">
                    </textarea> --}}
                    <ckeditore v-model="contentE"></ckeditore>
                  </div>
                </div>

</div>

 <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuestadoE" class="col-sm-2 control-label">Estado:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestadoE" name="cbuestadoE" v-model="fillinformacion.estado">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                  </select>
                   </div>
                </div>

            </div>

<div class="col-md-12" style="padding-top: 15px;">
  <center><h5>Ingrese una Imagen o un archivo adjunto solo si va a editar o agregar archivos</h5></center>
</div>
<div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="archivoE" class="col-sm-2 control-label">Imagen: (Opcional)</label>

                  <div class="col-sm-8" v-if="uploadReadyE">
                     <input  name="archivoE" type="file" id="archivoE" class="archivo form-control" @change="getImageE"
          accept=".png, .jpg, .jpeg, .gif, .jpe, .PNG, .JPG, .JPEG, .GIF, .JPE"/>

         

      
                   </div>
                </div>

            </div>


<div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="txtArchivoAdjuntoE" class="col-sm-2 control-label">Archivo Adjunto: (Opcional: pdf, docx, xlsx, pptx)</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtArchivoAdjuntoE" name="txtArchivoAdjuntoE" placeholder="Nombre del Archivo" maxlength="500" autofocus v-model="fillinformacion.archivonombre">
                  </div>

                  <div class="col-sm-8" v-if="uploadReadyE">
                     <input  name="archivo2E" type="file" id="archivo2E" class="archivo form-control" @change="getArchivoE" 
          accept=".pdf, .doc, .docx, .xls, .xlsx, ppt, .pptx, .PDF, .DOC, .DOCX, .XLS, .XLSX, .PPT, .PTTX"/>

         

      
                   </div>
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
</form>




<form  v-on:submit.prevent="deleteFoto(fillinformacion.id)">
<div class="modal fade bs-example-modal-lg" id="modalFoto"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document"  id="modaltamanio2">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">IMAGEN DEL CONTENIDO INFORMATIVO</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloImg">Imagen:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body" >


              
                            <div class="col-md-12" >

              <div class="form-group">

                  <div class="col-sm-12">
                    <center>
                    <img src="" style="max-height: 600px;max-width: 600px;" class="img-responsive" alt="Imagen del Contenido Informativo" id="imgInformacion">
                    </center>
                  </div>
                </div>
              </div>


            
          </div>



      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnDeleteImg"><i class="fa fa-floppy-o" aria-hidden="true"></i> Eliminar Foto</button>

      <button type="button" id="btnCancelFoto" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

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
</form>





<form  v-on:submit.prevent="deleteAdjunto(fillinformacion.id)">
<div class="modal fade bs-example-modal-lg" id="modalArchivo"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document"  id="modaltamanio3">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">ARCHIVO ADJUNTO DEL CONTENIDO INFORMATIVO</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloFile">Archivo Adjunto de:</h3>
            </div>

           
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body" >


              
                            <div class="col-md-12" >

              <div class="form-group">
                <label for="adjunto" class="col-sm-2 control-label">Archivo (Click para acceder):</label>
                  <div class="col-sm-8">
                    <p>
                    <a v-if="iflink" v-bind:href="urlAdjunto" v-bind:download="nameAdjunto">@{{ nameAdjunto }}</a>
                    </p>
                  </div>
                </div>
              </div>

<div class="col-md-12" >
               <hr style="padding-top: 10px;padding-bottom: 10px;">
</div>
              <div class="col-md-12" >

              <div class="form-group">
                  <label for="txtnameAdjuntoE" class="col-sm-2 control-label">Nombre del Archivo Adjunto:</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtnameAdjuntoE" name="txtnameAdjuntoE" placeholder="Nombre del Archivo" maxlength="500"  v-model="nameAdjuntoE" @keyup.enter="pressBtnEdit()"  @keydown="$event.keyCode === 13 ? $event.preventDefault() : false">
                  </div>

                  <div class="col-sm-2">
                    <a href="#" class="btn btn-info btn-sm" v-on:click.prevent="editNombreAdjunto(fillinformacion.id)" id="btnEditarNA">Cambiar</a>
                  </div>

                </div>
              </div>


            
          </div>



      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnDeleteImg"><i class="fa fa-floppy-o" aria-hidden="true"></i> Eliminar Archivo</button>

      <button type="button" id="btnCancelFoto" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

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
</form>