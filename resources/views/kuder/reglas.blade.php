<form method="post" v-on:submit.prevent="createReglas()">
<div class="modal fade bs-example-modal-lg" id="modalCrearReg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio3">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTituloMod" style="font-weight: bold;text-decoration: underline;">CREAR REGLAS</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloNewReg">Nueva Regla:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
               

                <div class="col-md-12" >

                <div class="form-group">
                  <label for="txtdescripcionE" class="col-sm-2 control-label">Descripción de la Regla:*</label>

                  <div class="col-sm-10">
                    <ckeditornr v-model="contentNReg"></ckeditornr>

                  </div>
                </div>

              </div>





      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnSaveRegN"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

      <button type="button" id="btnCancelRegN" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

      <div class="sk-circle" v-show="divloaderNewReg">
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




<form method="post" v-on:submit.prevent="updateRegla(fillReglas.id)">
<div class="modal fade bs-example-modal-lg" id="modalEditReg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio4">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTituloMod" style="font-weight: bold;text-decoration: underline;">EDITAR REGLA</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTituloEditReg">Regla:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
               

                <div class="col-md-12" >

                <div class="form-group">
                  <label for="txtdescripcionE" class="col-sm-2 control-label">Descripción de la Regla:*</label>

                  <div class="col-sm-10">
                    <ckeditorer v-model="contentEReg"></ckeditorer>

                  </div>
                </div>

              </div>





      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnSaveRegE"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

      <button type="button" id="btnCancelRegE" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

      <div class="sk-circle" v-show="divloaderEditReg">
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
