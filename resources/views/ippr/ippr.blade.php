<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Gestión de la Metodología Vocacional IPP-R</h3>
              <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
            </div>

              <div class="box-body">
                @include('ippr.metodologia')
              </div>

</div>




<div class="box box-success" v-if="divNuevoModulo">
    <div class="box-header with-border" >
        <h3 class="box-title" id="tituloModulo">Nuevo Módulo de la Metodología</h3>
    </div>
</div>

 <h3>Listado de Módulos de la Metodología </h3> 
         @include('ippr.modulos')

