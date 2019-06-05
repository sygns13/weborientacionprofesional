<div class="box box-info">
            <div class="box-header" style="padding-bottom: 30px;">
              <h3 class="box-title">KUDER INVENTARIO DE PREFERENCIAS VOCACIONALES Listado de Preguntas</h3>

              <div class="box-tools">
                <a style="float: right;" type="button" id="btnAtrasMove" class="btn btn-default" href="#" @click.prevent="volverTest()"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-hover table-bordered" >
                <tbody>

                <tr>
                  <th style="padding: 5px; width: 5%;">#</th>
                  <th style="padding: 5px; width: 75%;">Triadas de Preguntas</th>
                  <th style="padding: 5px; width: 20%;">Respuesta: <br>Le gusta más |N°| Le gusta menos</th>
              
                </tr>

                <tr v-for="pregs, key in preguntasMain">

                  <td style="font-size: 12px; padding: 5px;">{{key+((pagination.from-1)/3)+1}}</td>

                  <td>
                  <template v-for="pregunta, key2 in preguntas" v-if="pregunta.orden==pregs.orden">
                     {{key2+pagination.from}}.- {{ pregunta.descripcion }}<br><br>
                   </template>  
                  </td>

                <td>
                  <template v-for="pregunta, key2 in preguntas" v-if="pregunta.orden==pregs.orden">
                     <b> más:
                      <input type="checkbox" v-bind:id="pregunta.id"  v-bind:value="pregunta.id" v-bind:class="'claschek1-'+pregunta.orden" @click="marca(pregunta.id,'mas',pregunta.orden,'menos')" v-model="checked1" > &nbsp;&nbsp;&nbsp;

                     | {{key2+pagination.from}} | &nbsp;&nbsp;&nbsp; menos:

                      <input type="checkbox" v-bind:id="pregunta.id"  v-bind:value="pregunta.id" v-bind:class="'claschek2-'+pregunta.orden" @click="marca(pregunta.id,'menos',pregunta.orden,'mas')" v-model="checked2"> 

                    </b><br><br>
                   </template>  
                  </td>

                  </tr> 

              </tbody></table>

            </div>
            <!-- /.box-body -->
            <div style="padding: 15px;">
            	<div><h5>Preguntas por Página: {{ pagination.per_page }}</h5></div>
            <nav aria-label="Page navigation example">
			<ul class="pagination">
				<li class="page-item" v-if="pagination.current_page>1">
					<a class="page-link" href="#" @click.prevent="changePage(1)">
						<span><b>Inicio</b></span>
					</a>
				</li>

				<li class="page-item" v-if="pagination.current_page>1">
					<a class="page-link" href="#" @click.prevent="changePage(pagination.current_page-1)">
						<span>Atras</span>
					</a>
				</li>
				<li class="page-item" v-for="page in pagesNumber" v-bind:class="[page=== isActived ? 'active' : '']">
					<a class="page-link" href="#" @click.prevent="changePage(page)">
						<span>{{ page }}</span>
					</a>
				</li>
				<li class="page-item" v-if="pagination.current_page< pagination.last_page">
					<a class="page-link" href="#" @click.prevent="changePage(pagination.current_page+1)">
						<span>Siguiente</span>
					</a>
				</li>
				<li class="page-item" v-if="pagination.current_page< pagination.last_page">
					<a class="page-link" href="#" @click.prevent="changePage(pagination.last_page)">
						<span><b>Ultima</b></span>
					</a>
				</li>
			</ul>
		</nav>

    <div><h5>Preguntas Totales: {{ pagination.total }}</h5></div>
		</div>

    <div class="form-group" style="padding-bottom: 15px;padding-left: 15px;">

<button type="button" class="btn btn-info btn-lg" id="btnllenaralter" @click.prevent="llenarAuto()"><i class="fa fa-save" aria-hidden="true" ></i> Llenar Auto</button>

<button type="button" class="btn btn-primary btn-lg" id="btnCrearTest" @click.prevent="crearTest()"><i class="fa fa-save" aria-hidden="true" ></i> Finalizar Test</button>

</div>

 <div class="form-group" style="padding-bottom: 15px;padding-left: 15px;" v-show="divloaderNuevo">
<div class="sk-circle" >
        <div class="sk-circle1 sk-child"></div>
        <div class="sk-circle2 sk-child"></div>
        <div class="sk-circle3 sk-child"></div>
        <div class="sk-circle4 sk-child"></div>
        <div class="sk-circle5 sk-child"></div>
        <div class="sk-circle6 sk-child"></div>
        <div class="sk-circle7 sk-child"></div>
        <div class="sk-circle8 sk-child"></div>
        <div class="sk-circle9 sk-child"></div>
        <div class="sk-circle10 sk-child"></div>
        <div class="sk-circle11 sk-child"></div>
        <div class="sk-circle12 sk-child"></div>
      </div>
</div>

          </div>

