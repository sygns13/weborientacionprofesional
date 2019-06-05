 <div class="box box-info" v-for="modulo, key in modulos">
            <div class="box-header">
              <h3 class="box-title" style="text-decoration: underline;"><b>@{{ modulo.titulo }}</b></h3>

              <button type="button" style="float: right;" type="button" class="btn btn-danger btn-sm" v-on:click.prevent="borrarModulo(modulo)"><i class="fa fa-remove" aria-hidden="true"></i> 
          Eliminar Módulo</button>

            </div>
            <!-- /.box-header -->


            <div class="box-body table-responsive">

<h4>Datos del Módulo: </h4>

              <dl class="dl-horizontal">
                <dt>Fase :</dt>
                <dd>@{{ modulo.fase }}</dd>
                <dt>Preguntas Aleatorias :</dt>
                <dd v-if="modulo.pregaleatorias=='0'">No</dd>
                <dd v-if="modulo.pregaleatorias=='1'">Si</dd>
                <dt>Descripción :</dt>
                <dd v-html="modulo.descripcion"></dd>
              </dl>

              <div class="form-group">
              <button type="button" class="btn btn-warning btn-sm" id="btnEditMeto" @click.prevent="editModulo(modulo)"><i class="fa fa-edit" aria-hidden="true" ></i> Editar Datos del Módulo</button>
              </div>


              <h4 style="padding-top: 20px;">Reglas de Validez: </h4>

       
       <template v-for="validez, key in validezs" >
        <template v-if="modulo.id==validez.modulovocacional_id">
                <b>Mínimo de Preguntas Contestadas :</b> @{{ validez.minpreguntas }} Pregunta (s) <br>
                <b>Máximo de Alternativas Marcadas :</b> @{{ validez.maxalternativas }} Alternativa (s)
         

                <div class="form-group" style="padding-top: 20px;">
              <button type="button" class="btn btn-warning btn-sm" id="btnEditMeto" @click.prevent="editValidez(validez)"><i class="fa fa-edit" aria-hidden="true" ></i> Editar Reglas de Validez</button>
              </div>

        </template>      
      </template>

                <h4 style="padding-top: 20px;">Reglas del Módulo Para Mostrar a los Alumnos: </h4>


            <div class="form-group">
            <button type="button" class="btn btn-primary btn-sm" id="btnNuevoModu" @click.prevent="nuevaRegla(modulo)"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nueva Regla</button>
            </div>

              <table class="table table-hover table-bordered" >
                <tbody><tr>

                  <th style="padding: 5px; width: 70%;">Descripción</th>
                  <th style="padding: 5px; width: 25%;">Gestión</th>
                </tr>


    <template v-for="regla, key2 in reglas" >
      <template v-if="modulo.id==regla.modulovocacional_id" >



          <tr>

                  <td style="font-size: 12px; padding: 5px;" v-html="regla.descripcion"></td>

                  <td style="font-size: 12px; padding: 5px;">
                    <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editRegla(regla)" data-placement="top" data-toggle="tooltip" title="Editar Regla"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarRegla(regla)" data-placement="top" data-toggle="tooltip" title="Borrar Regla"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
         </template>  

      </template> 

              </tbody></table> 


              <h4 style="padding-top: 20px;">Preguntas del Módulo:</h4>
              <div class="form-group">
            <a v-bind:href="'preguntasippr/' + modulo.id" class="btn btn-success btn-sm"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Gestionar Preguntas</a>
            </div>

            </div>
            <!-- /.box-body -->
   
          </div>





@include('ippr.reglas')










<form method="post" v-on:submit.prevent="createModulo()">
<div class="modal fade bs-example-modal-lg" id="modalCrearMod" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio2">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTituloMod" style="font-weight: bold;text-decoration: underline;">CREAR MÓDULO</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloNewMod">Nuevo Módulo:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
               
               <div class="col-md-12" >
               <div class="form-group">
                  <label for="txtTituloModNew" class="col-sm-2 control-label">Título:*</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtTituloModNew" name="txtTituloModNew" placeholder="Nombre" maxlength="500" autofocus v-model="newTitulo" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false">
                  </div>
                </div>
               </div>

              <div class="col-md-12" style="padding-top: 15px;">
               <div class="form-group" >
                  <label for="txtfaseN" class="col-sm-2 control-label">Fase:*</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtfaseN" name="txtfaseN" placeholder="N°" maxlength="2" autofocus v-model="newFase" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);">
                  </div>


                   <label for="cbuGenero" class="col-sm-2 control-label">Preguntas Aleatorias:*</label>

                  <div class="col-sm-2">
                  <select class="form-control" id="cbuGenero" name="cbuGenero" v-model="newPregalestoria">
                    <option value="1">Si</option>
                    <option value="0">No</option>
                  </select>
                   </div>

                </div>
              </div>


                <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="txtdescripcionE" class="col-sm-2 control-label">Descripción:*</label>

                  <div class="col-sm-10">
                    <ckeditornm v-model="contentNMod"></ckeditornm>

                  </div>
                </div>

              </div>


        <h4 style="padding-top: 20px;">Reglas de Validez: </h4>

              <div class="col-md-12" style="padding-top: 15px;">
               <div class="form-group" >
                  <label for="txtMinPregsN" class="col-sm-4 control-label">Mínimo de Preguntas Contestadas:*</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="txtMinPregsN" name="txtMinPregsN" placeholder="N°" maxlength="10" autofocus v-model="newMinPregs" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);">
                  </div>

                </div>
              </div>

              <div class="col-md-12" style="padding-top: 15px;">
               <div class="form-group" >
                  <label for="txtMaxAlterN" class="col-sm-4 control-label">Máximo de Alternativas Marcadas:*</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="txtMaxAlterN" name="txtMaxAlterN" placeholder="N°" maxlength="2" autofocus v-model="newMaxAlter" required  onkeypress="return soloNumeros(event);">
                  </div>

                </div>
              </div>


      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnSaveModN"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

      <button type="button" id="btnCancelModN" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

      <div class="sk-circle" v-show="divloaderNewMod">
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

















<form method="post" v-on:submit.prevent="updateModulo(fillModulo.id)">
<div class="modal fade bs-example-modal-lg" id="modalEditarMod" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio2">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTituloMod" style="font-weight: bold;text-decoration: underline;">EDITAR MÓDULO</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloMod">Módulo:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
               
               <div class="col-md-12" >
               <div class="form-group">
                  <label for="txtTituloMod" class="col-sm-2 control-label">Título:*</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtTituloMod" name="txtTituloMod" placeholder="Nombre" maxlength="500" autofocus v-model="fillModulo.titulo" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false">
                  </div>
                </div>
               </div>

              <div class="col-md-12" style="padding-top: 15px;">
               <div class="form-group" >
                  <label for="txtfase" class="col-sm-2 control-label">Fase:*</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtfase" name="txtfase" placeholder="N°" maxlength="2" autofocus v-model="fillModulo.fase" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);">
                  </div>


                   <label for="cbuGenero" class="col-sm-2 control-label">Preguntas Aleatorias:*</label>

                  <div class="col-sm-2">
                  <select class="form-control" id="cbuGenero" name="cbuGenero" v-model="fillModulo.pregaleatorias">
                    <option value="1">Si</option>
                    <option value="0">No</option>
                  </select>
                   </div>

                </div>
              </div>


                <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="txtdescripcionE" class="col-sm-2 control-label">Descripción:*</label>

                  <div class="col-sm-10">
                    <ckeditorm v-model="contentMod"></ckeditorm>

                  </div>
                </div>

              </div>


      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnSaveModE"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

      <button type="button" id="btnCancelModE" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

      <div class="sk-circle" v-show="divloaderEditMod">
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
















<form method="post" v-on:submit.prevent="updateValidez(fillValidez.id)">
<div class="modal fade bs-example-modal-lg" id="modalEditarVal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio3">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTituloMod" style="font-weight: bold;text-decoration: underline;">EDITAR REGLAS DE VALIDEZ</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloVal">Criterios de Validez:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
               


              <div class="col-md-12" style="padding-top: 15px;">
               <div class="form-group" >
                  <label for="txtMinPregs" class="col-sm-4 control-label">Mínimo de Preguntas Contestadas:*</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="txtMinPregs" name="txtMinPregs" placeholder="N°" maxlength="10" autofocus v-model="fillValidez.minpreguntas" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);">
                  </div>

                </div>
              </div>

              <div class="col-md-12" style="padding-top: 15px;">
               <div class="form-group" >
                  <label for="txtMaxAlter" class="col-sm-4 control-label">Máximo de Alternativas Marcadas:*</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="txtMaxAlter" name="txtMaxAlter" placeholder="N°" maxlength="2" autofocus v-model="fillValidez.maxalternativas" required  onkeypress="return soloNumeros(event);">
                  </div>

                </div>
              </div>





      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnSaveValE"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

      <button type="button" id="btnCancelValE" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

      <div class="sk-circle" v-show="divloaderEditVal">
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