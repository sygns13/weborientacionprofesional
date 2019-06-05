<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Realizar Test</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">
                	<template v-for="metodologiaD, key in metodologiaData">
<div class="callout callout-info">
             <center>   <h4>@{{metodologiaD.nombre}}</h4></center>
    <div v-html="metodologiaD.descmostrar">
	</div>

</div>

 <div class="col-md-12" v-for="modulo, key in modulos">

<h4 style="padding-top: 20px;">Instrucciones</h4>



              <table class="table table-hover table-bordered" >
                <tbody><tr>

                  <th style="padding: 5px; width: 70%;">Descripción</th>
                </tr>


    <template v-for="regla, key2 in reglas" >
      <template v-if="modulo.id==regla.modulovocacional_id" >
          <tr>
                  <td style="font-size: 12px; padding: 5px;" v-html="regla.descripcion"></td>
            </tr>
         </template>  

      </template> 

              </tbody></table> 

</div>


<div class="box-footer" style="padding-top: 20px;">

<div class="col-md-12">


<div class="form-group">

<button type="button" class="btn btn-success btn-lg" id="btnIniciarTest" @click.prevent="iniciarTest()"><i class="fa fa-edit" aria-hidden="true" ></i> @{{ textoTest }}</button>

</div>

</div>
</div>

</template>
              </div>

</div>
