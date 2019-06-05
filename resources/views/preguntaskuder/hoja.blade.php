@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Imprimir Hoja de Respuestas
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
                <div class="form-group">
              <button type="button" class="btn btn-success" id="btnImprimirPlantilla" @click.prevent="imprimirPlantilla()"><i class="fa fa-print" aria-hidden="true" ></i> Imprimir Hoja de Respuestas</button>
                </div>

          </div>

          </div>

<center>

 <div style="width: 21cm; height: 29cm; background-color: white;" id="divImp">
  <div style="padding-top: 1.5cm;padding-left: 1cm; padding-right: 0.7cm;">
    <center><b>HOJA DE RESPUESTAS KUDER</b></center>

      <div style="float: left; padding-top: 0.5cm;">Nombres y Apellidos: _________________________________________ Edad: ________ Fecha: _______________
      </div>

      <div style="padding-top: 1.3cm;">
      <table style=" width: 100%;font-size: 11px;">
        <template v-for="arr, key in array">
        <tr>
          <td style="padding:3px;width: 10%;border:1px solid gray; text-align: center;font-size: 20px;">
            <b>@{{ parseInt(key)+1 }}</b>
          </td>
        
        <template v-for="arr2, key2 in array2">
          <td style="padding:3px;width: 9%;border:1px solid gray; text-align: center;">

          <template v-for="pregs, keypregs in preguntasMain">
            <template v-if="pregs.orden==(parseInt(key2)+(10*parseInt(key)))">
            <div style="width: 100%;font-weight: bold;">
              o&nbsp;&nbsp;&nbsp; @{{ 0+(3*parseInt(keypregs))+1 }}&nbsp;&nbsp;&nbsp; o
            </div>
            <div style="width: 100%;font-weight: bold;">
              o&nbsp;&nbsp;&nbsp; @{{ 1+(3*parseInt(keypregs))+1 }}&nbsp;&nbsp;&nbsp; o
            </div>
            <div style="width: 100%;font-weight: bold;">
              o&nbsp;&nbsp;&nbsp; @{{ 2+(3*parseInt(keypregs))+1 }}&nbsp;&nbsp;&nbsp; o
            </div>
         </template>
          </template>
          </td>

        </template>

        </tr>
      </template>
      </table>
      </div>

      <div style="padding-top: 0.3cm;">
      <table style=" width: 100%;font-size: 10px;">
        <tr>
          <template v-for="campoprofesional, key in campoprofesionals">
          <td style="padding:1px;width: 9%;border:1px solid gray; text-align: center;">
            @{{ campoprofesional.nombre }}
          </td>
        </template>
        </tr>

        <tr>
          <template v-for="campoprofesional, key in campoprofesionals">
          <td style="height:30px;border:1px solid gray; text-align: center;">
          </td>
        </template>
        </tr>

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
