@extends('adminlte::layouts.app')

@section('htmlheader_title')
	IPP - Gestión de Carreras Profesionales y Técnicas
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

			@if(accesoUser([1,3]))

<template v-if="divMaestroCarreras" id="divMaestroCarreras">
	@include('maestrocarreras.carreras')
</template>
			@endif


		</div>
	</div>
@endsection
