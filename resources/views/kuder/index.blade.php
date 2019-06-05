@extends('adminlte::layouts.app')

@section('htmlheader_title')
	KUDER - Gestión de Metodología
@endsection

<style type="text/css">         
          
#modaltamanio{
  width: 80% !important;
}

</style>
@section('main-content')
	<div class="container-fluid spark-screen">



		<div class="row">

@include('adminlte::layouts.partials.loaders')

			@if(accesoUser([1,3]))

<template v-if="divkuder" id="divkuder">
	@include('kuder.kuder')
</template>
			@endif


		</div>
	</div>
@endsection
