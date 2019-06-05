 <form method="post" v-on:submit.prevent="updateAlumno(fillPersona.id,fillAlumno.id,filluser.id)">
             <div class="box-body" style="font-size: 12px;">


                  <center><h4>Datos Personales del Alumno</h4></center>

            <div class="col-md-12" style="padding-top: 15px;">

              <div class="form-group">
                  <label for="txtDNIE" class="col-sm-1 control-label">DNI:*</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtDNIE" name="txtDNIE" placeholder="N° de DNI" maxlength="8" autofocus v-model="fillPersona.dni" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" :disabled="validated == 1" onkeypress="return soloNumeros(event);">
                  </div>

                </div>

                </div>



              <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
                  <label for="txtnombresE" class="col-sm-1 control-label">Nombres:*</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="txtnombresE" name="txtnombresE" placeholder="Nombres" maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillPersona.nombres">
                  </div>

                  <label for="txtapellidosE" class="col-sm-1 control-label">Apellidos:*</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="txtapellidosE" name="txtapellidosE" placeholder="Apellidos" maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillPersona.apellidos">
                  </div>
                </div>
              </div>


              <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuGeneroE" class="col-sm-1 control-label">Género:*</label>

                  <div class="col-sm-2">
                  <select class="form-control" id="cbuGeneroE" name="cbuGeneroE" v-model="fillPersona.genero">
                    <option value="1">Masculino</option>
                    <option value="0">Femenino</option>
                  </select>
                   </div>

                  <label for="txtfonoE" class="col-sm-1 control-label">Teléfono/Cell:</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtfonoE" name="txtfonoE" placeholder="N°" maxlength="25" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillPersona.telf">
                  </div>

                  <label for="txtDirE" class="col-sm-1 control-label">Dirección:</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="txtDirE" name="txtDirE" placeholder="Av. Jr. Psje." maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillPersona.direccion">
                  </div>

                </div>

            </div>

            <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="archivo" class="col-md-1 control-label">Imagen de Perfil: (Opcional)</label>
                    <div class="col-md-11">
                     <img v-if="fillPersona.genero==1" src="{{ asset('/img/av3.png') }}" class="img-responsive" style="width: 130px; border: 2px solid black;" id="ImgPerfilNuevoE">

                     <img v-if="fillPersona.genero==0" src="{{ asset('/img/av2.jpg') }}" class="img-responsive" style="width: 130px; border: 2px solid black;" id="ImgPerfilNuevoE">
                   </div>

                   <div class="col-md-1"></div>
                  <div class="col-md-5" style="padding-top: 10px;">
                     <input name="archivoE" type="file" id="archivoE" class="archivo form-control" @change="getImageE"
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
                  <label for="txtcodigoE" class="col-sm-2 control-label">Código de Postulante:*</label>

                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="txtcodigoE" name="txtcodigoE" placeholder="Código" maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillAlumno.codigopos">
                  </div>

                  <label for="cbuQuinto" class="col-sm-2 control-label">Se Encuentra en 5° de Secs:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuQuinto" name="cbuQuinto" v-model="fillAlumno.quinto">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                  </select>
                   </div>

                </div>
              </div>

              <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuCarrerasE" class="col-sm-2 control-label">Carrera Profesional:*</label>
                    <div class="col-sm-8">
                  <select class="form-control" id="cbuCarrerasE" name="cbuCarrerasE">
                    <option disabled value="">Seleccione una Carrera Profesional</option>

                    <option v-for="carrera, key in carreras" v-bind:value="carrera.id">@{{ carrera.nombre }} </option>
 
                  </select>
                   </div>
                  
                </div>

            </div>


             <template v-for="ciclo, key in ciclos">

                  <div class="col-md-12" style="padding-top: 15px;" v-if="ciclo.segundacarrera==1">

                <div class="form-group">
                  <label for="cbuCarrerasOpE" class="col-sm-2 control-label">Seegunda Opción:*</label>
                    <div class="col-sm-8">
                  <select class="form-control" id="cbuCarrerasOpE" name="cbuCarrerasOpE">
                    <option disabled value="">Seleccione una Carrera Profesional</option>

                    <option v-for="carrera, key in carreras" v-bind:value="carrera.id">@{{ carrera.nombre }} </option>
 
                  </select>
                   </div>
                  
                </div>

            </div>


            </template>


      {{--       <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuQuinto" class="col-sm-2 control-label">Se Encuentra en 5° de Secs:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuQuinto" name="cbuQuinto" v-model="newQuinto">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                  </select>
                   </div>
                </div>

            </div>

 --}} 

                <div class="col-md-12" style="padding-top: 15px;">

                <div class="form-group">
                  <label for="cbuestadoE" class="col-sm-2 control-label">Estado Alumno:*</label>

                  <div class="col-sm-4">
                  <select class="form-control" id="cbuestadoE" name="cbuestadoE" v-model="fillAlumno.activo">
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
                  <label for="txtuserE" class="col-sm-1 control-label">Username:*</label>

                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="txtuserE" name="txtuserE" placeholder="Username" maxlength="255" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filluser.name">
                  </div>

                </div>
              </div>

              <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
                  <label for="txtmailE" class="col-sm-1 control-label">Correo:*</label>

                  <div class="col-sm-4">
                    <input type="email"  class="form-control" id="txtmailE" name="txtmailE" placeholder="example@mail.com" maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filluser.email">
                  </div>

                </div>
              </div>

              <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
                  <label for="txtclaveE" class="col-sm-1 control-label">Password:*</label>

                  <div class="col-sm-4">
                    <input type="password" class="form-control" id="txtclaveE" name="txtclaveE" placeholder="********" maxlength="500"  v-model="filluser.token2">
                  </div>

                </div>
              </div>





            </div>

              <!-- /.box-body -->
              <div class="box-footer" >
                <button type="submit" class="btn btn-primary" id="btnSaveE"><i class="fa fa-floppy-o" aria-hidden="true"></i> Modificar</button>

                <button type="button" class="btn btn-default" id="btnCloseE" @click.prevent="cerrarFormAlumnoE()">Cancelar</button>

      <div class="sk-circle" v-show="divloaderEditAlumno">
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