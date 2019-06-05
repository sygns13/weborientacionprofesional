@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Plantilla de Corrección
@endsection


@section('main-content')

	<div class="container-fluid spark-screen">



		<div class="row">

@include('adminlte::layouts.partials.loaders')

@if(accesoUser([1,3]))

<template v-if="divPreguntas" id="divPreguntas">
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Metodología {{ $nombreMet }} <br><br>
              {{ $tituloMod }}: Gestión de Preguntas del Módulo</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('preguntaskuder/'.$idModulo)}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">

                
<div class="col-md-12">
                <div class="form-group">
                  <label for="cbuCampoLab" class="col-sm-2 control-label">Seleccione Área de Interés:*</label>

                  <div class="col-sm-8">
                  <select class="form-control" id="cbuCampoLab" name="cbuCampoLab" style="width: 100%;" onChange="onChange();">
                    <option disabled value="">Seleccione un Campo Laboral</option>
                  
                    <option v-for="campos in campoprofesionals" v-bind:value="campos.id">@{{ campos.orden }}: @{{ campos.nombre }} </option>
               
                  </select>
                  </div>
                </div>
                </div>
          

                <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group" >
              <button type="button" class="btn btn-success" id="btnImprimirPlantilla" @click.prevent="imprimirPlantilla()"><i class="fa fa-print" aria-hidden="true" ></i> Imprimir Plantilla de Corrección</button>
                </div>

                </div>

          </div>

          </div>

<center>

 <div style="width: 21cm; height: 29cm; background-color: white;" id="divImp">
  <div style="padding-top: 1.5cm;padding-left: 1cm; padding-right: 0.7cm;">

    <template v-for="campoprofesional, key in campoprofesionals">
    <center v-if="campoprofesional.id==newcampoprofesional_id"><b>PLANTILLA DE CORRECCIÓN KUDER @{{campoprofesional.nombre}}</b></center>
    </template>



      <div style="padding-top: 0.5cm;">
      <table style=" width: 100%;font-size: 9px!important;">
        <template v-for="arr, key in array">
        <tr>
          <td style="padding:3px;width: 10%;border:1px solid gray; text-align: center;font-size: 20px;">
            <b>@{{ parseInt(key)+1 }}</b>
          </td>
        
        <template v-for="arr2, key2 in array2">
          <td style="padding:3px;width: 9%;border:1px solid gray; text-align: center;">

          <template v-for="pregs, keypregs in preguntasMain">
            <template v-if="pregs.orden==(parseInt(key2)+(10*parseInt(key)))">
              <template v-for="pregunta, keypregs2 in preguntas">

            <div style="width: 100%;font-weight: bold;" v-if="pregs.orden==pregunta.orden">

             

               <template v-if="array3[parseInt(pregunta.activo)+(3*parseInt(keypregs))]==0">
                 <table style="width: 100%;" >
                  <tr>
                    <td style="font-size: 13px!important; padding-right:5px; padding-left: 2px;">
                      o
                    </td>
                    <td style="font-size: 13px!important; padding-right:5px; padding-left: 5px;">
                      @{{ parseInt(pregunta.activo)+(3*parseInt(keypregs))+1 }}
                    </td>
                    <td style="font-size: 13px!important; padding-right:2px; padding-left: 5px; text-align: right;">
                      o
                    </td>
                  </tr>
                </table>
               </template>

               <template v-if="array3[parseInt(pregunta.activo)+(3*parseInt(keypregs))]==1">

                <table style="width: 100%;">
                  <tr>
                    <td style="font-size: 13px!important; padding-right:5px; padding-left: 2px; background-color: #000000!important;">
                      o
                    </td>
                    <td style="font-size: 13px!important; padding-right:5px; padding-left: 5px;">
                      @{{ parseInt(pregunta.activo)+(3*parseInt(keypregs))+1 }}
                    </td>
                    <td style="font-size: 13px!important; padding-right:2px; padding-left: 5px;text-align: right;">
                      o
                    </td>
                  </tr>
                </table>

               </template>

               <template v-if="array3[parseInt(pregunta.activo)+(3*parseInt(keypregs))]==-1">
               <table style="width: 100%;">
                  <tr>
                    <td style="font-size: 13px!important; padding-right:5px; padding-left: 2px;">
                      o
                    </td>
                    <td style="font-size: 13px!important; padding-right:5px; padding-left: 5px;">
                      @{{ parseInt(pregunta.activo)+(3*parseInt(keypregs))+1 }}
                    </td>
                    <td style="font-size: 13px!important; padding-right:2px; padding-left: 5px;background-color: #000000!important;text-align: right;">
                      o
                    </td>
                  </tr>
                </table>

               </template>

               <template v-if="array3[parseInt(pregunta.activo)+(3*parseInt(keypregs))]==2">
                <table style="width: 100%;">
                  <tr>
                    <td style="font-size: 13px!important; padding-right:5px; padding-left: 2px;background-color: #000000!important;">
                      o
                    </td>
                    <td style="font-size: 13px!important; padding-right:5px; padding-left: 5px;">
                      @{{ parseInt(pregunta.activo)+(3*parseInt(keypregs))+1 }}
                    </td>
                    <td style="font-size: 13px!important; padding-right:2px; padding-left: 5px;background-color: #000000!important;text-align: right;">
                      o
                    </td>
                  </tr>
                </table>
               </template>


            {{--     @{{ parseInt(pregunta.activo)+(3*parseInt(keypregs))+1 }}
            o&nbsp;&nbsp;&nbsp; @{{ pregunta.activo }}&nbsp;&nbsp;&nbsp; o

              <template v-for="alternativa, keyalter in alternativas" v-if="alternativa.pregunta_id==pregunta.id && alternativa.campoprofesional_id==newcampoprofesional_id">

                <div v-if="alternativa.alternativa=='mas' || alternativa.alternativa=='menos'">

                <div v-if="alternativa.alternativa=='mas'">
              ||&nbsp;&nbsp;&nbsp; @{{ pregunta.activo }}&nbsp;&nbsp;&nbsp; o
                </div>

                <div v-if="alternativa.alternativa=='menos'">
              o&nbsp;&nbsp;&nbsp; @{{ pregunta.activo }}&nbsp;&nbsp;&nbsp; ||
                </div>

                </div>
              </template>

              <template v-else>
                o&nbsp;&nbsp;&nbsp; @{{ pregunta.activo }}&nbsp;&nbsp;&nbsp; o
              </template>

               --}}
            </div>


            </template>
         </template>
          </template>
          </td>

        </template>

        </tr>
      </template>
      </table>
      </div>





  </div>
 	

 </div>
</center>

</template>
@endif


		</div>
	</div>
@endsection
