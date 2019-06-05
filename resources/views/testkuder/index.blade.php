@extends('adminlte::layouts.app')

@section('htmlheader_title')
	KUDER - Test Preferencias Vocacionales - Forma C
@endsection

<style type="text/css">         
          
#modaltamanio{
  width: 70% !important;
}

.perfil{
	    font-weight: bold;
    text-decoration: underline;
}

@media print {
body {-webkit-print-color-adjust: exact!important;}

#btnImpRes{display:none!important;}

}

.perfil{
	    font-weight: bold;
    text-decoration: underline;
}

@page { size: landscape!important;; }

</style>
@section('main-content')
	<div class="container-fluid spark-screen">



		<div class="row">

@include('adminlte::layouts.partials.loaders')



<template v-if="divTestKuder" id="divTestKuder">
	@include('testkuder.test')
</template>

<template v-if="divPreguntas" id="divPreguntas">
	@include('testkuder.preguntas')
</template>

<template v-if="divResultado" id="divResultado">
	@include('testkuder.resultado')
</template>



		</div>
	</div>
@endsection
