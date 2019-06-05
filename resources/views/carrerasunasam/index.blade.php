@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Gestión de Carreras Universitarias UNASAM
@endsection

<style type="text/css">         
          
#modaltamanio{
  width: 70% !important;
}


</style>
@section('main-content')
	<div class="container-fluid spark-screen">



		<div class="row">

@include('adminlte::layouts.partials.loaders')

			@if(accesoUser([1,2]))

<template v-if="divcarrerasu" id="divcarrerasu">
	@include('carrerasunasam.carrera')
</template>

<template v-if="divcontentCarrera" id="divcontentCarrera">
	@include('carrerasunasam.contenidoCarrera')
</template>
			@endif


		</div>
	</div>
@endsection
