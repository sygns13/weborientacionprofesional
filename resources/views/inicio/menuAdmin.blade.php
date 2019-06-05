@if(accesoUser([1,2]))
<div class="col-lg-12 col-xs-12">
				<h4>Administración Sistema Web</h4>
			</div>



		<div class="col-lg-3 col-xs-6" >
          <div class="small-box bg-green">
            <div class="inner">
              <h3 style="font-size: 25px;">Áreas Académicas</h3>

              <p>Gestión de Áreas</p>
            </div>
            <div class="icon" style="    top: 5px;">
              <i class="fa fa-object-ungroup"></i>
            </div>
            <a href="{{URL::to('areasUNASAM')}}" class="small-box-footer" style="height: 37px; font-size: 25px;">Ingresar 
            <i style="font-size: 30px; " class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 style="font-size: 25px;">Ciclos Académicos</h3>
              <p>Gestión de Ciclos</p>
            </div>
            <div class="icon" style="    top: 5px;">
              <i class="fa fa-calendar"></i>
            </div>
            <a href="{{ URL::to('ciclos')}}" class="small-box-footer" style="height: 37px; font-size: 25px;">Ingresar 
            <i style="font-size: 30px; " class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 style="font-size: 25px;">Facultades UNASAM</h3>

              <p>Gestión de Facultades de la UNASAM</p>
            </div>
            <div class="icon" style="    top: 5px;">
              <i class="fa fa-bank"></i>
            </div>
            <a href="{{URL::to('facultades') }}" class="small-box-footer" style="height: 37px; font-size: 25px;">Ingresar 
            <i style="font-size: 30px; " class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 style="font-size: 25px;">Carreras UNASAM</h3>

              <p>Gestión de Carreras UNASAM</p>
            </div>
            <div class="icon" style="    top: 5px;">
              <i class="fa fa-book"></i>
            </div>
            <a href="{{URL::to('carrerasUNASAM') }}" class="small-box-footer" style="height: 37px; font-size: 25px;">Ingresar 
            <i style="font-size: 30px; " class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

         <div class="col-lg-3 col-xs-6" >
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 style="font-size: 25px;">Alumnos CPU</h3>

              <p>Gestión de Alumnos CPU</p>
            </div>
            <div class="icon" style="    top: 5px;">
              <i class="fa fa-users"></i>
            </div>
            <a href="{{URL::to('alumnos') }}" class="small-box-footer" style="height: 37px; font-size: 25px;">Ingresar 
            <i style="font-size: 30px; " class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

@endif

@if(accesoUser([1]))
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 style="font-size: 25px;">Usuarios del Sistema</h3>

              <p>Gestión de Usuarios</p>
            </div>
            <div class="icon" style="    top: 5px;">
              <i class="fa fa-user-secret"></i>
            </div>
            <a href="{{ URL::to('usuarios')}}" class="small-box-footer" style="height: 37px; font-size: 25px;">Ingresar 
            <i style="font-size: 30px; " class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

@endif

 
@if(accesoUser([1,3]))


        <div class="col-lg-12 col-xs-12">
				<h4>Administración Base de Conocimientos</h4>
			</div>

		<div class="col-lg-3 col-xs-6" >
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 style="font-size: 25px;">IPP-R</h3>

              <p>Gestión Metodología IPP-R</p>
            </div>
            <div class="icon" style="top: 5px;">
              <i class="fa fa-file-powerpoint-o"></i>
            </div>
            <a href="{{URL::to('inventarioInteresesProfesionales') }}" class="small-box-footer" style="height: 37px; font-size: 25px;">Ingresar 
            <i style="font-size: 30px; " class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6" >
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 style="font-size: 25px;">KUDER</h3>

              <p>Gestión Metodología KUDER</p>
            </div>
            <div class="icon" style="    top: 5px;">
              <i class="fa fa-picture-o"></i>
            </div>
            <a href="{{ URL::to('kuder') }}" class="small-box-footer" style="height: 37px; font-size: 25px;">Ingresar 
            <i style="font-size: 30px; " class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6" >
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3 style="font-size: 25px;">Reportes Analíticos</h3>

              <p>Consulta de Reportes Analíticos</p>
            </div>
            <div class="icon" style="    top: 5px;">
              <i class="fa fa-print"></i>
            </div>
            <a href="{{ URL::to('reportes') }}" class="small-box-footer" style="height: 37px; font-size: 25px;">Ingresar 
            <i style="font-size: 30px; " class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        
@endif 