@extends('adminlte::layouts.app')

@section('htmlheader_title')
	IPP - Gestión de Preguntas del Test
@endsection

<style type="text/css">         
          
#modaltamanio{
  width: 70% !important;
}
#modaltamanio2{
  width: 70% !important;
}#modaltamanio3{
  width: 70% !important;
}

</style>
@section('main-content')
	<div class="container-fluid spark-screen">



		<div class="row">

@include('adminlte::layouts.partials.loaders')

			@if(accesoUser([1,3]))

<template v-if="divPreguntas" id="divPreguntas">
	@include('preguntas.preguntas')
</template>
			@endif


		</div>
	</div>
@endsection
