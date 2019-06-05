<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Metodología {{ $nombreMet }} <br><br>
              {{ $tituloMod }}: Gestión de Preguntas del Módulo</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('inventarioInteresesProfesionales')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">
                <div class="form-group">
              <button type="button" class="btn btn-primary" id="btncrearPregunta" @click.prevent="nuevaPregunta()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nueva Pregunta</button>

              <a v-bind:href="'/hoja/imprimir/'+idMet+'/'+idModulo" class="btn btn-warning" id="btnimpHoja" ><i class="fa fa-file-text-o" aria-hidden="true" ></i> Imp. Hoja de Respuestass</a>

              <a v-bind:href="'/plantilla/imprimir/'+idMet+'/'+idModulo" class="btn btn-warning" id="btnimpPlantilla" ><i class="fa fa-file-text-o" aria-hidden="true" ></i> Imp. Plantilla de Corrección</a>
                </div>

          </div>

          </div>

        <div class="box box-success" v-if="divNuevaPregunta">
            <div class="box-header with-border" >
              <h3 class="box-title" id="tituloAgregar">Nueva Pregunta</h3>
            </div>

            <form v-on:submit.prevent="createPregunta">
             <div class="box-body">

             	<div class="col-md-12" >

             	<div class="form-group">
                  <label for="txtpregunta" class="col-sm-2 control-label">Descripción:*</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtpregunta" name="txtpregunta" placeholder="Nombre" maxlength="500" autofocus v-model="newPregunta">
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
                  <label for="cbuOblig" class="col-sm-2 control-label">Obligatiria de Responder:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuOblig" name="cbuOblig" v-model="newoblig">
                    <option value="1">Si</option>
                    <option value="0">No</option>
                  </select>
                   </div>
                </div>

            </div>


                <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuestado" class="col-sm-2 control-label">Estado:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestado" name="cbuestado" v-model="estadoPreg">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                  </select>
                   </div>
                </div>

            </div>

            <div class="col-md-12" style="padding-top: 15px; ">

                <div class="form-group">
                  <label for="cbuCampoLab" class="col-sm-2 control-label">Campo Laboral:*</label>

                  <div class="col-sm-8">
                  <select class="form-control" id="cbuCampoLab" name="cbuCampoLab" style="width: 100%;">
                    <option disabled value="">Seleccione un Campo Laboral</option>
                  
                    <option v-for="campos in campoprofesionals" v-bind:value="campos.id">@{{ campos.orden }}: @{{ campos.nombre }} </option>
               
                  </select>
                  </div>
                </div>
            </div>

              <div class="col-md-12" style="padding-top: 15px; padding-bottom: 15px;">

                <div class="form-group">
                  <label for="cbuActivProf" class="col-sm-2 control-label">Actividad/Profesión:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuActivProf" name="cbuActivProf" v-model="ActivProf">
                    <option value="1">Actividad</option>
                    <option value="2">Profesión</option>
                  </select>
                   </div>
                </div>

            </div>

            </div>

              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info" id="btnGuardar">Guardar</button>

                <button type="reset" class="btn btn-warning" id="btnCancel" @click="cancelFormPreg()">Cancelar</button>

                <button type="button" class="btn btn-default" id="btnClose" @click.prevent="cerrarFormPreg()">Cerrar</button>

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
              <h3 class="box-title">Listado de Preguntas</h3>

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
                  <th style="padding: 5px; width: 62%;">Pregunta</th>
                  <th style="padding: 5px; width: 8%;">Num de Orden</th>
                  <th style="padding: 5px; width: 8%;">Pregunta Obligatoria</th>
                  <th style="padding: 5px; width: 7%;">Estado</th>
                  <th style="padding: 5px; width: 10%;">Gestión</th>
                </tr>
                <tr v-for="pregunta, key in preguntas">
                  <td style="font-size: 12px; padding: 5px;">@{{key+pagination.from}}</td>
                  <td style="font-size: 12px; padding: 5px;"><b>@{{ pregunta.descripcion }}</b>

                    {{--  --}}<br>
                    {{--  --}}<br>
                    <table class="table table-hover table-bordered" >
                      <tbody>
                        <tr> 
                  <th style="padding: 5px; font-size: 10px;" colspan="7">Alternativas
                    <a href="#" class="btn btn-info btn-sm" v-on:click.prevent="addAlternativa(pregunta)" data-placement="top" data-toggle="tooltip" title="Agregar Alternativa"><i class="fa fa-plus"></i></a>
                  </th></tr>
                        <tr>
                  <th style="padding: 5px; font-size: 10px; width: 5%;">Num Orden</th>
                  <th style="padding: 5px; font-size: 10px; width: 5%;">Alternativa</th>
                  <th style="padding: 5px; font-size: 10px; width: 40%;">Descripción</th>
                  <th style="padding: 5px; font-size: 10px; width: 5%;">Puntaje</th>
                  <th style="padding: 5px; font-size: 10px; width: 15%;">Act/Prof</th>
                  <th style="padding: 5px; font-size: 10px; width: 20%;">Campo Laboral</th>
                  <th style="padding: 5px; font-size: 10px; width: 10%;">Gestión</th>
                </tr>

                <template v-for="alternativa, key in alternativas">

                <tr v-if="alternativa.pregunta_id==pregunta.id">
                    <td style="font-size: 12px; padding: 5px;">@{{ alternativa.orden }}</td>
                    <td style="font-size: 12px; padding: 5px;">@{{ alternativa.alternativa }}</td>
                    <td style="font-size: 12px; padding: 5px;">@{{ alternativa.descripcion }}</td>
                    <td style="font-size: 12px; padding: 5px;">@{{ alternativa.puntaje }}</td>
                    <td style="font-size: 12px; padding: 5px;">
                    <span class="label bg-teal-active" v-if="alternativa.detactividadprofesion=='1'">Actividad</span>
                    <span class="label bg-green" v-if="alternativa.detactividadprofesion=='2'">Profesión</span>
                  </td>
                    <td style="font-size: 12px; padding: 5px;">@{{ alternativa.campolaboral }}</td>
                    <td style="font-size: 12px; padding: 5px;">

                    <a href="#" class="btn btn-warning btn-xs" v-on:click.prevent="editAlternativa(alternativa)" data-placement="top" data-toggle="tooltip" title="Editar Alternativa"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-danger btn-xs" v-on:click.prevent="borrarAlternativa(alternativa)" data-placement="top" data-toggle="tooltip" title="Borrar Alternativa"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>

                  
                </template>



                    </table>


                  </td>
                  <td style="font-size: 12px; padding: 5px;">@{{ pregunta.orden }}</td>
                  <td style="font-size: 12px; padding: 5px;">
                    <span class="label label-success" v-if="pregunta.obligatorio=='1'">Si</span>
                    <span class="label label-warning" v-if="pregunta.obligatorio=='0'">No</span>
                  </td>
                  <td style="font-size: 12px; padding: 5px;">
                  	<span class="label label-success" v-if="pregunta.activo=='1'">Activo</span>
                  	<span class="label label-warning" v-if="pregunta.activo=='0'">Inactivo</span>
                  </td>
                  <td style="font-size: 12px; padding: 5px;">

                  	<a href="#" v-if="pregunta.activo=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="bajaPregunta(pregunta)" data-placement="top" data-toggle="tooltip" title="Desactivar Pregunta"><i class="fa fa-arrow-circle-down"></i></a>

                  	<a href="#" v-if="pregunta.activo=='0'" class="btn btn-success btn-sm" v-on:click.prevent="altaPregunta(pregunta)" data-placement="top" data-toggle="tooltip" title="Activar Pregunta"><i class="fa fa-check-circle"></i></a>


                  	<a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editPregunta(pregunta)" data-placement="top" data-toggle="tooltip" title="Editar Pregunta"><i class="fa fa-edit"></i></a>
                  	<a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarPregunta(pregunta)" data-placement="top" data-toggle="tooltip" title="Borrar Pregunta"><i class="fa fa-trash"></i></a>
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

<form method="post" v-on:submit.prevent="updatePregunta(fillPreguntas.id)">
<div class="modal fade bs-example-modal-lg" id="modalEditar"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR PREGUNTA</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTitulo">Pregunta:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
               
        <div class="col-md-12" >

              <div class="form-group">
                  <label for="txtpreguntaE" class="col-sm-2 control-label">Descripción:*</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtpreguntaE" name="txtpreguntaE" placeholder="Pregunta" maxlength="500" autofocus v-model="fillPreguntas.descripcion">
                  </div>
                </div>

                </div>


                <div class="col-md-12" style="padding-top: 15px;">
               <div class="form-group" >
                  <label for="txtNumOrdenE" class="col-sm-2 control-label">Número de Orden:*</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtNumOrdenE" name="txtNumOrdenE" placeholder="N°" maxlength="10" autofocus v-model="fillPreguntas.orden" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);">
                  </div>



                </div>
              </div>


              <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuObligE" class="col-sm-2 control-label">Obligatiria de Responder:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuObligE" name="cbuObligE" v-model="fillPreguntas.obligatorio">
                    <option value="1">Si</option>
                    <option value="0">No</option>
                  </select>
                   </div>
                </div>

            </div>


                <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuestadoE" class="col-sm-2 control-label">Estado:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestadoE" name="cbuestadoE" v-model="fillPreguntas.activo">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                  </select>
                   </div>
                </div>

            </div>


                       <div class="col-md-12" style="padding-top: 15px; ">

                <div class="form-group">
                  <label for="cbuCampoLabE" class="col-sm-2 control-label">Campo Laboral:*</label>

                  <div class="col-sm-8">
                  <select class="form-control" id="cbuCampoLabE" name="cbuCampoLabE" style="width: 100%;">
                    <option disabled value="">Seleccione un Campo Laboral</option>
                  
                    <option v-for="campos in campoprofesionals" v-bind:value="campos.id">@{{ campos.orden }}: @{{ campos.nombre }} </option>
               
                  </select>
                  </div>
                </div>
            </div>

                          <div class="col-md-12" style="padding-top: 15px; padding-bottom: 15px;">

                <div class="form-group">
                  <label for="cbuActivProfE" class="col-sm-2 control-label">Actividad/Profesión:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuActivProfE" name="cbuActivProfE" v-model="fillPreguntas.detactividadprofesion">
                    <option value="1">Actividad</option>
                    <option value="2">Profesión</option>
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

@include('preguntas.alternativas')
