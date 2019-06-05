 <form v-on:submit.prevent="createAlumno">
             <div class="box-body" style="font-size: 12px;">

             	<div class="col-md-12" >

             	<div class="form-group">
                  <label for="txtDNI" class="col-sm-1 control-label">DNI:*</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtDNI" name="txtDNI" placeholder="N° de DNI" maxlength="8" autofocus v-model="newDNI" @keyup.enter="pressNuevoDNI(newDNI)" required @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" :disabled="validated == 1" onkeypress="return soloNumeros(event);">
                  </div>
                  <div  class="col-sm-8">
                    <a href="#" class="btn btn-info btn-sm" v-on:click.prevent="pressNuevoDNI(newDNI)">Validar</a>
                  </div>
                </div>



                </div>

                <template v-if="formularioCrear">


                  <div class="col-md-12">
                    <hr style="border-top: 3px solid #1b5f43;">
                  </div>

                  <center><h4>Datos Personales del Alumno</h4></center>

              <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
                  <label for="txtnombres" class="col-sm-1 control-label">Nombres:*</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="txtnombres" name="txtnombres" placeholder="Nombres" maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="newNombres">
                  </div>

                  <label for="txtapellidos" class="col-sm-1 control-label">Apellidos:*</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="txtapellidos" name="txtapellidos" placeholder="Apellidos" maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="newApellidos">
                  </div>
                </div>
              </div>


              <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuGenero" class="col-sm-1 control-label">Género:*</label>

                  <div class="col-sm-2">
                  <select class="form-control" id="cbuGenero" name="cbuGenero" v-model="newGenero">
                    <option value="1">Masculino</option>
                    <option value="0">Femenino</option>
                  </select>
                   </div>

                     <label for="txtfono" class="col-sm-1 control-label">Teléfono/Cell:</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtfono" name="txtfono" placeholder="N°" maxlength="25" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="newTelefono">
                  </div>

                  <label for="txtDir" class="col-sm-1 control-label">Dirección:</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="txtDir" name="txtDir" placeholder="Av. Jr. Psje." maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="newDireccion">
                  </div>

                </div>

            </div>

            <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="archivo" class="col-md-1 control-label">Imagen de Perfil: (Opcional)</label>
                 
                  <div class="col-md-5" style="padding-top: 10px;">
                     <input name="archivo" type="file" id="archivo" class="archivo form-control" @change="getImage"
          accept=".png, .jpg, .jpeg, .gif, .jpe, .PNG, .JPG, .JPEG, .GIF, .JPE"/>

                   </div>

                 
                </div>

            </div>


                  <div class="col-md-12">
                    <hr>
                  </div>

                  <center><h4>Datos Académicos</h4></center>


                   <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
                  <label for="txtcodigo" class="col-sm-2 control-label">Código de Postulante:*</label>

                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="txtcodigo" name="txtcodigo" placeholder="Código" maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="newcodigopos">
                  </div>

                  <label for="cbuQuinto" class="col-sm-2 control-label">Se Encuentra en 5° de Secs:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuQuinto" name="cbuQuinto" v-model="newQuinto">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                  </select>
                   </div>

                </div>
              </div>

              <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuCarreras" class="col-sm-2 control-label">Carrera Profesional:*</label>
                    <div class="col-sm-8">
                  <select class="form-control" id="cbuCarreras" name="cbuCarreras">
                    <option disabled value="">Seleccione una Carrera Profesional</option>

                    <option v-for="carrera, key in carreras" v-bind:value="carrera.id">{{ carrera.nombre }} </option>
 
                  </select>
                   </div>
                  
                </div>

            </div>


             <template v-for="ciclo, key in ciclos">

                  <div class="col-md-12" style="padding-top: 15px;" v-if="ciclo.segundacarrera==1">

                <div class="form-group">
                  <label for="cbuCarrerasOp" class="col-sm-2 control-label">Seegunda Opción:*</label>
                    <div class="col-sm-8">
                  <select class="form-control" id="cbuCarrerasOp" name="cbuCarrerasOp">
                    <option disabled value="">Seleccione una Carrera Profesional</option>

                    <option v-for="carrera, key in carreras" v-bind:value="carrera.id">{{ carrera.nombre }} </option>
 
                  </select>
                   </div>
                  
                </div>

            </div>


            </template>


       

                <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuestado" class="col-sm-2 control-label">Estado Alumno:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestado" name="cbuestado" v-model="newActivoAlumno">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                  </select>
                   </div>
                </div>

            </div>



             <div class="col-md-12">
                    <hr>
                  </div>

                  <center><h4>Datos de Usuario</h4></center>



                  <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
                  <label for="txtuser" class="col-sm-1 control-label">Username:*</label>

                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="txtuser" name="txtuser" placeholder="Username" maxlength="255" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="newUsername">
                  </div>

                </div>
              </div>

              <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
                  <label for="txtmail" class="col-sm-1 control-label">Correo:*</label>

                  <div class="col-sm-4">
                    <input type="email"  class="form-control" id="txtmail" name="txtmail" placeholder="example@mail.com" maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="newEmail">
                  </div>

                </div>
              </div>

              <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
                  <label for="txtclave" class="col-sm-1 control-label">Password:*</label>

                  <div class="col-sm-4">
                    <input type="password" class="form-control" id="txtclave" name="txtclave" placeholder="********" maxlength="500"  v-model="newPassword">
                  </div>

                </div>
              </div>



            </template>

            </div>

              <!-- /.box-body -->
              <div class="box-footer" >
                <button v-if="formularioCrear" type="submit" class="btn btn-info" id="btnGuardar">Guardar</button>

                <button v-if="formularioCrear" type="reset" class="btn btn-warning" id="btnCancel" @click="cancelFormAlumno()">Cancelar</button>

                <button type="button" class="btn btn-default" id="btnClose" @click.prevent="cerrarFormAlumno()">Cerrar</button>

      <div class="sk-circle" v-show="divloaderNuevo">
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
              <!-- /.box-footer -->
           
		</form>