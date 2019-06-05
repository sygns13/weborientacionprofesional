
<form method="post" v-on:submit.prevent="createAlternativa">
<div class="modal fade bs-example-modal-lg" id="modalAddAlternativa"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio2">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">NUEVA PUNTUACIÓN DE ALTERNATIVA</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloPreg">Pregunta:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
               



 <div class="col-md-12" style="padding-top: 15px;">

              <div class="form-group">
                  <label for="txtAlterMarcar" class="col-sm-2 control-label">Alternativa:*</label>

                  <div class="col-sm-4">

                    <select class="form-control" id="txtAlterMarcar" name="txtAlterMarcar" v-model="newAlternativaMarca">
                    <option value="mas">Le agrada más</option>
                    <option value="menos">Le gusta menos</option>
                  </select>


                  </div>


                </div>
              </div>



           <div class="col-md-12" style="padding-top: 15px; padding-bottom: 15px;">

                <div class="form-group">
                  <label for="cbuCampoLab" class="col-sm-2 control-label">Área de Interés Beneficiada:*</label>

                  <div class="col-sm-8">
                  <select class="form-control" id="cbuCampoLab" name="cbuCampoLab" style="width: 100%;">
                    <option disabled value="">Seleccione un Campo Laboral</option>
                  
                    <option v-for="campos in campoprofesionals" v-bind:value="campos.id">@{{ campos.orden }}: @{{ campos.nombre }} </option>
               
                  </select>
                  </div>
                </div>
            </div>



      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnSaveAlter"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

      <button type="button" id="btnCancelAlter" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

      <div class="sk-circle" v-show="divloaderAlter">
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




















<form method="post" v-on:submit.prevent="updateAlternativa(fillAlternativas.id)">
<div class="modal fade bs-example-modal-lg" id="modalAddAlternativaE"  role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio3">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR ALTERNATIVA</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloPregE">Pregunta:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
               
        <div class="col-md-12" >

              <div class="form-group">
                  <label for="txtAlternativaE" class="col-sm-2 control-label">Descripción:*</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtAlternativaE" name="txtAlternativaE" placeholder="Alternativa" maxlength="500" autofocus v-model="fillAlternativas.descripcion">
                  </div>
                </div>

                </div>


 <div class="col-md-12" style="padding-top: 15px;">

              <div class="form-group">
                  <label for="txtAlterMarcarE" class="col-sm-2 control-label">Alternativa a Marcar:*</label>

                  <div class="col-sm-2">

           <select class="form-control" id="txtAlterMarcarE" name="txtAlterMarcarE" v-model="fillAlternativas.alternativa">
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                  </select>

                  </div>


                  <label for="txtNumOrdenAlterE" class="col-sm-2 control-label">Número de Orden:*</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtNumOrdenAlterE" name="txtNumOrdenAlterE" placeholder="N°" maxlength="10"  v-model="fillAlternativas.orden" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);">
                  </div>



                </div>
              </div>



 <div class="col-md-12" style="padding-top: 15px;">



                  <label for="txtPuntajeE" class="col-sm-2 control-label">Puntaje:*</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtPuntajeE" name="txtPuntajeE" placeholder="N°" maxlength="10" autofocus v-model="fillAlternativas.puntaje" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);">
                  </div>



                </div>
              </div>



              <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuActivProfE" class="col-sm-2 control-label">Actividad/Profesión:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuActivProfE" name="cbuActivProfE" v-model="fillAlternativas.detactividadprofesion">
                    <option value="1">Actividad</option>
                    <option value="2">Profesión</option>
                  </select>
                   </div>
                </div>

            </div>


           <div class="col-md-12" style="padding-top: 15px; padding-bottom: 15px;">

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



      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnSaveAlterE"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

      <button type="button" id="btnCancelAlterE" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

      <div class="sk-circle" v-show="divloaderAlterE">
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