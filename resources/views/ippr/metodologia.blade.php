<template v-for="metodologiaD, key in metodologiaData">
<div class="callout callout-info">
             <center>   <h4>@{{metodologiaD.nombre}}</h4></center>
    <div v-html="metodologiaD.descripcion">		
	</div>

</div>



	<center><h4 style="text-decoration: underline;">Descripción Para Mostrar al Alumno</h4></center>

	<div v-html="metodologiaD.descmostrar">
	</div>





<div class="box-footer" style="padding-top: 20px;">

<div class="col-md-12">


<div class="form-group">

<button type="button" class="btn btn-warning" id="btnEditMeto" @click.prevent="editMetodologia(metodologiaD)"><i class="fa fa-edit" aria-hidden="true" ></i> Editar Contenido Principal</button>

<button type="button" class="btn btn-primary" id="btnNuevoModu" @click.prevent="nuevoModulo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Módulo</button>

<a v-bind:href="'campoprofesionalippr/' + metodologiaD.id" class="btn btn-success"><i class="fa fa-mortar-board" aria-hidden="true" ></i> Gestión de Campos Profesionales</a>
</div>

</div>
</div>

</template>



<form method="post" v-on:submit.prevent="updateMetodologia(fillMetodologia.id)">
<div class="modal fade bs-example-modal-lg" id="modalEditarM" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR METODOLOGÍA IPP-R</h4>

      </div> 
      <div class="modal-body">


      <div class="row">

      <div class="box" id="o" style="border:0px; box-shadow:none;" >
            <div class="box-header with-border">
              <h3 class="box-title" id="boxTitulo">Metodología:</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
               
               <div class="col-md-12" >
               <div class="form-group">
                  <label for="txtNombre" class="col-sm-2 control-label">Nombre:*</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre" maxlength="500" autofocus v-model="fillMetodologia.nombre">
                  </div>
                </div>
               </div>


<div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="txtdescripcionE" class="col-sm-2 control-label">Descripción:*</label>

                  <div class="col-sm-10">
                    <ckeditora v-model="contentD"></ckeditora>

                  </div>
                </div>

</div>


<div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="txtdescripcionE" class="col-sm-2 control-label">Descripción Para Mostrar al Alumno:*</label>

                  <div class="col-sm-10">
                    <ckeditore v-model="contentDM"></ckeditore>

                  </div>
                </div>

</div>





      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="btnSaveEM"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

      <button type="button" id="btnCancelEM" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>

      <div class="sk-circle" v-show="divloaderEditM">
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