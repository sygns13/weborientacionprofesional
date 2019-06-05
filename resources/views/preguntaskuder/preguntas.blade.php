<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Metodología {{ $nombreMet }} <br><br>
              {{ $tituloMod }}: Gestión de Preguntas del Módulo</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('kuder')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">
                <div class="form-group">
              <button type="button" class="btn btn-primary" id="btncrearPregunta" @click.prevent="nuevaPregunta()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nueva Triada de Preguntas</button>

               <a v-bind:href="'/hojakuder/imprimir/'+idMet+'/'+idModulo" class="btn btn-warning" id="btnimpHoja"><i class="fa fa-file-text-o" aria-hidden="true" ></i> Imp. Hoja de Respuestass</a>

              <a v-bind:href="'/plantillakuder/imprimir/'+idMet+'/'+idModulo" class="btn btn-warning" id="btnimpPlantilla"><i class="fa fa-file-text-o" aria-hidden="true" ></i> Imp. Plantilla de Corrección</a>


                </div>

          </div>

          </div>

        <div class="box box-success" v-if="divNuevaPregunta">
            <div class="box-header with-border" >
              <h3 class="box-title" id="tituloAgregar">Nueva Triada de Preguntas</h3>
            </div>

            <form v-on:submit.prevent="createPregunta">
             <div class="box-body">

             	<div class="col-md-12" >

             	<div class="form-group">
                  <label for="txtpregunta1" class="col-sm-2 control-label">Pregunta 01:*</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtpregunta1" name="txtpregunta1" placeholder="Nombre" maxlength="500" autofocus v-model="newPregunta1">
                  </div>
                </div>

                </div>

                <div class="col-md-12" style="padding-top: 15px;">

              <div class="form-group">
                  <label for="txtpregunta2" class="col-sm-2 control-label">Pregunta 02:*</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtpregunta2" name="txtpregunta2" placeholder="Nombre" maxlength="500"  v-model="newPregunta2">
                  </div>
                </div>

                </div>

                <div class="col-md-12" style="padding-top: 15px;">

              <div class="form-group">
                  <label for="txtpregunta3" class="col-sm-2 control-label">Pregunta 03:*</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtpregunta3" name="txtpregunta3" placeholder="Nombre" maxlength="500"  v-model="newPregunta3">
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
{{--  
              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 300px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar" v-model="buscar" @keyup.enter="buscarBtn()">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default" @click.prevent="buscarBtn()"><i class="fa fa-search"></i></button>
                  </div>


                </div>
              </div>
--}}

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-hover table-bordered" >
                <tbody><tr>
                  <th style="padding: 5px; width: 5%;">#</th>
                  <th style="padding: 5px; width: 62%;">Triadas de Pregunta</th>
                  <th style="padding: 5px; width: 8%;">Num de Orden</th>
                  <th style="padding: 5px; width: 8%;">Pregunta Obligatoria</th>
                  <th style="padding: 5px; width: 7%;">Estado</th>
                  <th style="padding: 5px; width: 10%;">Gestión</th>
                </tr>

                <tr v-for="pregs, key in preguntasMain">
                  <td style="font-size: 12px; padding: 5px;">@{{key+((pagination.from-1)/3)+1}}</td>
                  <td style="font-size: 12px; padding: 5px;">

                    <template v-for="pregunta, key2 in preguntas" v-if="pregunta.orden==pregs.orden">
                    <b>@{{key2+pagination.from}}.- @{{ pregunta.descripcion }}</b><br><br>

                    <table class="table table-hover table-bordered">
                      <tr> 
                  <th style="padding: 5px; font-size: 10px;" colspan="2">Puntuación de Alternativas
                    <a href="#" class="btn btn-info btn-sm" v-on:click.prevent="addAlternativa(pregunta,key2+pagination.from)" data-placement="top" data-toggle="tooltip" title="Agregar Puntuación de Alternativa"><i class="fa fa-plus"></i></a>
                  </th></tr>
                        <tr>
                  <th style="padding: 5px; font-size: 10px; width: 50%;">Le Agrada Más</th>
                  <th style="padding: 5px; font-size: 10px; width: 50%;">Le Gusta Menos</th>
                        </tr>

                    <tr>
                      <td> 
                        <template v-for="alternativa, key in alternativas" v-if="alternativa.pregunta_id==pregunta.id && alternativa.alternativa=='mas'">
                         - @{{ alternativa.campolaboral }} <a href="#" class="btn btn-danger btn-xs" v-on:click.prevent="borrarAlternativa(alternativa)" data-placement="top" data-toggle="tooltip" title="Borrar Alternativa"><i class="fa fa-trash"></i></a><br> 
                        </template>  
                        
                      </td>
                      <td> 
                        <template v-for="alternativa, key in alternativas" v-if="alternativa.pregunta_id==pregunta.id && alternativa.alternativa=='menos'">
                         - @{{ alternativa.campolaboral }} <a href="#" class="btn btn-danger btn-xs" v-on:click.prevent="borrarAlternativa(alternativa)" data-placement="top" data-toggle="tooltip" title="Borrar Alternativa"><i class="fa fa-trash"></i></a><br>
                        </template>  
                      </td>

                    </tr>

                    </table>  
                      
                    

                    </template>

                  </td>
                  <td style="font-size: 12px; padding: 5px;">@{{ pregs.orden }}</td>
                  <td style="font-size: 12px; padding: 5px;">
                    <span class="label label-success" v-if="pregs.obligatorio=='1'">Si</span>
                    <span class="label label-warning" v-if="pregs.obligatorio=='0'">No</span>
                  </td>
                  <td style="font-size: 12px; padding: 5px;">
                  	<span class="label label-success" v-if="pregs.activo=='1'">Activo</span>
                  	<span class="label label-warning" v-if="pregs.activo=='0'">Inactivo</span>
                  </td>
                  <td style="font-size: 12px; padding: 5px;">

                  	<a href="#" v-if="pregs.activo=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="bajaPregunta(pregs)" data-placement="top" data-toggle="tooltip" title="Desactivar Pregunta"><i class="fa fa-arrow-circle-down"></i></a>

                  	<a href="#" v-if="pregs.activo=='0'" class="btn btn-success btn-sm" v-on:click.prevent="altaPregunta(pregs)" data-placement="top" data-toggle="tooltip" title="Activar Pregunta"><i class="fa fa-check-circle"></i></a>


                  	<a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editPregunta(pregs)" data-placement="top" data-toggle="tooltip" title="Editar Pregunta"><i class="fa fa-edit"></i></a>
                  	<a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarPregunta(pregs)" data-placement="top" data-toggle="tooltip" title="Borrar Triada de Preguntas"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>

              </tbody></table>

            </div>
            <!-- /.box-body -->
            <div style="padding: 15px;">
            	<div><h5>Registros por Página: @{{ pagination.per_page }} Preguntas</h5></div>
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

<form method="post" v-on:submit.prevent="updatePregunta(fillPreguntas1.id)">
<div class="modal fade bs-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
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
                  <label for="txtpregunta1E" class="col-sm-2 control-label">Pregunta 01:*</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtpregunta1E" name="txtpregunta1E" placeholder="Pregunta" maxlength="500" autofocus v-model="fillPreguntas1.descripcion">
                  </div>
                </div>

                </div>

                            <div class="col-md-12" style="padding-top: 15px;">

              <div class="form-group">
                  <label for="txtpregunta2E" class="col-sm-2 control-label">Pregunta 02:*</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtpregunta2E" name="txtpregunta2E" placeholder="Nombre" maxlength="500"  v-model="fillPreguntas1.descripcion2">
                  </div>
                </div>

                </div>

                <div class="col-md-12" style="padding-top: 15px;">

              <div class="form-group">
                  <label for="txtpregunta3E" class="col-sm-2 control-label">Pregunta 03:*</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtpregunta3E" name="txtpregunta3E" placeholder="Nombre" maxlength="500"  v-model="fillPreguntas1.descripcion3">
                  </div>
                </div>

                </div>


                <div class="col-md-12" style="padding-top: 15px;">
               <div class="form-group" >
                  <label for="txtNumOrdenE" class="col-sm-2 control-label">Número de Orden:*</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtNumOrdenE" name="txtNumOrdenE" placeholder="N°" maxlength="10" autofocus v-model="fillPreguntas1.orden" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);">
                  </div>



                </div>
              </div>


              <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuObligE" class="col-sm-2 control-label">Obligatiria de Responder:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuObligE" name="cbuObligE" v-model="fillPreguntas1.obligatorio">
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
                  <select class="form-control" id="cbuestadoE" name="cbuestadoE" v-model="fillPreguntas1.activo">
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

@include('preguntaskuder.alternativas')
