<!-- Content Header (Page header) -->
<section class="content-header" v-show="divtitulo" style="display: none;">
    <h1>
        {{ titulo }}
        <small>{{ subtitulo }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i v-bind:class="classTitle"></i> {{ titulo }}</a></li>
        <li class="active">{{ subtitulo }}</li>
        <li v-if="subtitle2">{{ subtitulo2 }}</li>
    </ol>
</section>