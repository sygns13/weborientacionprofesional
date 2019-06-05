<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Test Completado</h3>
<button type="button" style="float: right;"  class="btn btn-default" @click.prevent="volverPrincipal()"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</button>
            </div>

              <div class="box-body" id="impResultados">
                	<template v-for="metodologiaD, key in metodologiaData">

<div class="callout callout-info" v-if="metodologiaD.id==1">

             <center>   <h4>@{{metodologiaD.nombre}}</h4></center>

</div>

<div class="callout callout-success" v-if="metodologiaD.id==2">

             <center>   <h4>@{{metodologiaD.nombre}}</h4></center>

</div>

 <div class="col-md-12">

<h4 style="padding-top: 20px;">Resultados del Test</h4>

</div>


<div class="box-footer" style="padding-top: 20px;">

<div class="col-md-12">

	<div class="perfil" v-html="resultados"></div>

<div class="description" v-html="descresultados"></div>


<div class="form-group" style="    padding-top: 30px;">

<button type="button" class="btn btn-warning" id="btnImpRes" @click.prevent="imprimirResults()"><i class="fa fa-print" aria-hidden="true" ></i> Imprimir Resultados</button>

</div>

</div>
</div>

</template>
              </div>

</div>
