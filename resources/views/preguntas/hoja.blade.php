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
              <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('preguntasippr/'.$idModulo)}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
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
    <center><b>IPP – HOJA DE RESPUESTAS</b></center>

      <div style="float: left; padding-top: 0.5cm;">Nombre: ___________________________________________________ Edad: ________ Fecha: _______________
      </div>

      <div style="padding-top: 1.3cm;">
      <table style="border: 1px solid gray; width: 100%;">
        <tr>
          <td style="padding: 10px;">
          {{--    <template v-for="regla, key2 in reglas">

              <div v-html="regla.descripcion"></div>

            </template>--}}

            <b>En cada frase debes marcar:</b>

            <table style="width: 100%; font-size: 12px;">
              <tr>
                <td style="width: 50%;">
                  <b>A</b> para contestar <b>ME GUSTA</b>
                </td>
                <td style="width: 50%;">
                  <b>B</b> para contestar <b>ME ES INDIFERENTE O TENGO DUDAS</b>
                </td>
              </tr>

              <tr>
                <td style="width: 50%;">
                  <b>C</b> para contestar <b>NO ME GUSTA</b>
                </td>
                <td style="width: 50%;">
                  <b>D</b> si no conoces esa actividad o profesión
                </td>
              </tr>
            </table>

          </td>
        </tr>
      </table>
      </div>

<div style="padding-top: 0.4cm;">
      <table style="border: 1px solid gray; width: 19%; float: left;font-size: 10px;">

        <tr>
          <th style="width: 14.8%;border:1px solid gray; text-align: center;"></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>A</b></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>B</b></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>C</b></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>D</b></th>
        </tr>

        <template v-for="campoprofesional, key in campoprofesionals">
          <template v-for="pregunta, key in preguntas" v-if="pregunta.orden<46"> 
        <tr v-if="pregunta.campoprofesional_id==campoprofesional.id" >
         <template v-if="pregunta.activo=='1'">
          <td v-bind:rowspan="array[campoprofesional.orden-1]" style="padding:3px;width: 14.8%;border:1px solid gray; text-align: center;" ></td>
          </template>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;" v-if="pregunta.detactividadprofesion=='1'"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;" v-if="pregunta.detactividadprofesion=='2'"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"><b>@{{ pregunta.orden }}</b></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
        </tr>
          </template>
        </template>


      </table>

      <table style="border: 1px solid gray; width: 19%; float: left;font-size: 10px; margin-left: 9px;">
        <tr>
          <th style="width: 14.8%;border:1px solid gray; text-align: center;"></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>A</b></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>B</b></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>C</b></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>D</b></th>
        </tr>

        <template v-for="campoprofesional, key in campoprofesionals">
          <template v-for="pregunta, key in preguntas" v-if="pregunta.orden>45 && pregunta.orden<91"> 
        <tr v-if="pregunta.campoprofesional_id==campoprofesional.id" >
          <template v-if="pregunta.activo=='1'">
          <td v-bind:rowspan="array[campoprofesional.orden+16]" style="padding:3px;width: 14.8%;border:1px solid gray; text-align: center;" ></td>
          </template>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;" v-if="pregunta.detactividadprofesion=='1'"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;" v-if="pregunta.detactividadprofesion=='2'"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"><b>@{{ pregunta.orden }}</b></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
        </tr>
          </template>
        </template>

      </table>

      <table style="border: 1px solid gray; width: 19%; float: left;font-size: 10px; margin-left: 9px;">
        <tr>
          <th style="width: 14.8%;border:1px solid gray; text-align: center;"></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>A</b></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>B</b></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>C</b></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>D</b></th>
        </tr>


         <template v-for="campoprofesional, key in campoprofesionals">
          <template v-for="pregunta, key in preguntas" v-if="pregunta.orden>90 && pregunta.orden<136"> 
        <tr v-if="pregunta.campoprofesional_id==campoprofesional.id" >
          <template v-if="pregunta.activo=='1'">
          <td v-bind:rowspan="array[campoprofesional.orden+33]" style="padding:3px;width: 14.8%;border:1px solid gray; text-align: center;" ></td>
          </template>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;" v-if="pregunta.detactividadprofesion=='1'"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;" v-if="pregunta.detactividadprofesion=='2'"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"><b>@{{ pregunta.orden }}</b></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
        </tr>
          </template>
        </template>



      </table>

      <table style="border: 1px solid gray; width: 19%; float: left;font-size: 10px; margin-left: 9px;">
        <tr>
          <th style="width: 14.8%;border:1px solid gray; text-align: center;"></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>A</b></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>B</b></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>C</b></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>D</b></th>
        </tr>

                 <template v-for="campoprofesional, key in campoprofesionals">
          <template v-for="pregunta, key in preguntas" v-if="pregunta.orden>135 && pregunta.orden<181"> 
        <tr v-if="pregunta.campoprofesional_id==campoprofesional.id" >
          <template v-if="pregunta.activo=='1'">
          <td v-bind:rowspan="array[campoprofesional.orden+50]" style="padding:3px;width: 14.8%;border:1px solid gray; text-align: center;" ></td>
          </template>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;" v-if="pregunta.detactividadprofesion=='1'"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;" v-if="pregunta.detactividadprofesion=='2'"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"><b>@{{ pregunta.orden }}</b></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
        </tr>
          </template>
        </template>

      </table>

       <table style="border: 1px solid gray; width: 19%; float: left;font-size: 10px; margin-left: 9px;">
        <tr>
          <th style="width: 14.8%;border:1px solid gray; text-align: center;"></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>A</b></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>B</b></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>C</b></th>
          <th style="width: 14.6%;border:1px solid gray; text-align: center;"><b>D</b></th>
        </tr>

          <template v-for="campoprofesional, key in campoprofesionals">
          <template v-for="pregunta, key in preguntas" v-if="pregunta.orden>180 && pregunta.orden<226"> 
        <tr v-if="pregunta.campoprofesional_id==campoprofesional.id" >
          <template v-if="pregunta.activo=='1'">
          <td v-bind:rowspan="array[campoprofesional.orden+67]" style="padding:3px;width: 14.8%;border:1px solid gray; text-align: center;" ></td>
          </template>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;" v-if="pregunta.detactividadprofesion=='1'"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;" v-if="pregunta.detactividadprofesion=='2'"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"><b>@{{ pregunta.orden }}</b></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
          <td style="padding:3px;width: 14.6%;border:1px solid gray; text-align: center;"></td>
        </tr>
          </template>
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
