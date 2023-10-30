  <?php 

    if($_SESSION["superperfil"]==0){
        echo '<script type="text/javascript">
          window.location = "inicio";
          </script>';
          }
  ?>

    <main class="app-content">

      <div class="app-title">
        
        <div>

          <h5><button class="btn btn-primary btnNuevo" type="button"  data-toggle="modal" data-target="#ModalClientes"><i class="fas fa-plus-circle"></i> Agregar Nuevo </button> Crear clientes </h5>

        </div>

        <ul class="app-breadcrumb breadcrumb">

          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>

        </ul>

      </div>
    

      <div class="row">

        <div class="col-md-12">

          <div class="tile">

            <div class="tile-body">

              <div class="table-responsive">
                
                <table class="table table-hover table-bordered tablaClientes">

                  <thead>

                    <tr>
                        <th style="width:10px">#</th>
                        <th style="width:100px">Acciones</th>
                        <th>Cliente</th>
                        <th>Cédula/RUC</th>
                        <th>Ciudad</th>
                        <th>Dirección</th>
                        <!-- <th>Celular</th> -->
                        <th>Email</th>
                        <!-- <th>Fecha Nac.</th> -->
                        <!-- <th>Estado</th> -->
                        <th>Foto</th>
                        <th>Canal</th>
                        <th>Categoría</th>

                    </tr>

                  </thead>

                  <tbody>

                  </tbody>

                </table>

              </div>

            </div>

          </div>

        </div>

    </main>


  <!--==========================================
                MODAL AGREGAR 
  ===========================================-->

  <div class="modal fade" id="ModalClientes" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">

      <div class="modal-content">

        <form method="post" name="formClientes" id="formCliente" onsubmit="return GuardarFormulario()">

        <div class="modal-header" style="background:#464775; color:white">

          <h6 class="modal-title" id="titulo">Nuevo cliente</h6>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

          </button>

        </div>

        <div class="modal-body" id="modalBody" style="display: block;">

          <!-- FORMULARIOS -->

          <!-- <form method="post" name="formClientes" id="formCliente" onsubmit="return GuardarFormulario()"> -->

            <input class="form-control" type="hidden" name="idCliente"  id="idCliente" value="">

            <input class="form-control" type="hidden" name="tokenCliente" id= "tokenCliente" value="">

            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  
            <div class="form-row">

              <!-- PRIMERA FILA -->

              <div class="form-group col-md-6">

                <div class="form-group">

                    <label class="control-label">Empresa/Nombre <span style="color:red">*</span></label>

                    <input class="form-control" type="text" name="txtCliente" id="txtCliente" placeholder="Ingresar Cliente" required>

                </div>

              </div>

              <!-- SEGUNDA FILA -->

              <div class="form-group col-md-6">

                <div class="form-group">

                  <label class="control-label">Cédula/RUC <span style="color:red">*</span></label>

                  <input class="form-control" type="text" name="txtRUC" id="txtRUC" placeholder="Ingresar RUC" required>

                </div>

              </div>

            </div>

            <!-- =========================================== -->

            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->

            <div class="form-row" >

              <!-- PRIMERA FILA -->
              <div class="form-group col-md-6">
            

                  <label class="control-label">Ciudad <span style="color:red">*</span></label>

                 <div class="messanger">  
                        
                    <div class="sender">
                      <select class="input-control select2" name="cmbCiudad" id="cmbCiudad" style="width: 92%;" required="">
                        
                        <option selected="selected" value="">Seleccione una opción</option>
                              
                          <?php 

                            $item="";
                            $valor= "";

                            $ciudad = ControladorCiudades::ctrMostrarCiudad($item, $valor);
                           
                            foreach ($ciudad as $key => $value) {

                              echo '<option value="'.$value["COD_CIUDAD"].'/'.$value["TOKEN_CIUDAD"].'" >'.$value["DESCRIPCION_CIUDAD"].'</option>';

                            }

                       ?>

                      </select>

                      <div class="input-group-append">
                        <button class='btn btn-info btn-sm' type="button" id="btnAgregarCiudad" data-toggle="modal" data-target="#ModalCiudad"> <i class="fas fa-plus-square"></i></button>
                      </div>

                  </div>
                </div>

              </div>

              <!-- SEGUNDAD FILA -->
              <div class="form-group col-md-6">

                <label class="control-label">Dirección <span style="color:red">*</span></label>

                <div class="input-group">       

                  <input class="form-control" type="text" name="txtDireccion" id="txtDireccion" placeholder="Ingresar dirección" required >

                </div>

              </div>

            </div>

            <!-- =========================================== -->

            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->

            <div class="form-row">

              <!-- PRIMERA FILA -->
              <div class="form-group col-md-6">

                <div class="form-group">

                  <label class="control-label">Celular <span style="color:red">*</span></label>

                  <textarea class="form-control input-lg pClavesCelular" name="pClavesCelular" id="pClavesCelular" rows="1" cols="50" placeholder="Ingresar referencia laboral" required></textarea>
                  <!-- <input type="text" class="form-control input-lg pClavesCelular tagsInput" data-role="tagsinput" placeholder="Separe valores con coma" name="pClavesCelular" id="pClavesCelular" required> -->

                </div>

              </div>

              <!-- SEGUNDAD FILA -->
              <div class="form-group col-md-6">


                <div class="form-group">

                  <label class="control-label">E-mail</label>

                  <input class="form-control" type="email" id="txtEmail" name="txtEmail" placeholder="Ingresar correo electrónico">

                </div>

              </div>

            </div>

            <!-- =========================================== -->

            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->

            <div class="form-row">

              <!-- PRIMERA FILA -->
              <div class="form-group col-md-6">

                <div class="form-group">

                  <label class="control-label">Fecha Nacimiento</label>

                  <!-- <input class="form-control demoDate" type="text" id="txtFechaNac" name="txtFechaNac" placeholder="Ingresar fecha nacimiento" required> -->
                  <input class="form-control" type="date" id="txtFechaNac" name="txtFechaNac" placeholder="Ingresar fecha nacimiento">

                </div>

              </div>

              <!-- SEGUNDAD FILA -->
              <div class="form-group col-md-6">
              <label class="control-label">Canal <span style="color:red">*</span></label>

                  <div class="messanger">  
                        
                    <div class="sender">

                       <select class="input-control select2" style="width: 89%;" name="cmbTipoCliente" id="cmbTipoCliente" required>

                            <option selected="selected" value="">Seleccione una opción</option>
                                  
                              <?php 

                                $item="ESTADO";
                                $valor=null;
                                $var=null;
                                $order="COD_CANAL ASC";

                                $canales = ControladorCanales::ctrMostrarCanal($item, $valor, $var, $order);
                               
                                foreach ($canales as $key => $value) {

                                  echo '<option value="'.$value["COD_CANAL"].'/'.$value["TOKEN_CANAL"].'" >'.$value["DESCRIPCION_CANAL"].'</option>';

                                }

                           ?>
                                 
                          </select>

                       <div class="input-group-append" id="ver">
                          <button class='btn btn-info btn-sm ' id="Verdescuento" type="button"><i class='fa fa-eye text-white'></i></button>
                          <button class='btn btn-info btn-sm notblock' id="nodescuento" type="button"><i class='fa fa-eye-slash text-white' ></i></button>
                        </div>

                    </div>
                   </div>

              </div>

            </div>

              <!-- =========================================== -->

                <div class="notblock" id ="tablaOcultar">

                   <table class="table table-responsive-sm table-bordered" id="TablaDescuento">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Monto desde</th>
                          <th>Monto hasta</th>
                          <th>Descuento%</th>
                        </tr>
                      </thead>
                      <tbody>
                                        
                      </tbody>
                </table>
         

                </div>

                
                <!-- =========================================== -->

           <!--  <div class="tablaDescuento">

              <div class="table-responsive tablaDesc">

              </div>             

            </div> -->

            <!-- =========================================== -->

            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->

            <div class="form-row" >

              <!-- PRIMERA FILA -->
              <div class="form-group col-md-6">

                <div class="form-group">

                  <label class="control-label">Garante</label>
                  <input class="form-control" type="text" id="txtGarante" name="txtGarante" placeholder="Ingresar el nombre del garante">

                </div>

              </div>

              <!-- SEGUNDA FILA -->

              <div class="form-group col-md-6">

                <div class="form-group">

                  <label class="control-label">Cédula Garante</label>

                  <input class="form-control" type="text" id="txtCedulaGarante" name="txtCedulaGarante" placeholder="Ingresar cédula del garante">

                </div>

              </div>

            </div>

            <!-- =========================================== -->

            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->

            <div class="form-row">

              <!-- PRIMERA FILA -->
              <div class="form-group col-md-6">

                <div class="form-group">

                  <label class="control-label">Ref. Laboral</label>

                  <textarea class="form-control input-lg pClavesRefLaboral" name="pClavesRefLaboral" id="pClavesRefLaboral" rows="3" cols="50" placeholder="Ingresar referencia laboral"></textarea>

                  <!-- <label class="control-label">Ref. Laboral</label>
                  <input type="text" class="form-control input-lg pClavesRefLaboral tagsInput" data-role="tagsinput" placeholder="Separe valores con coma" name="pClavesRefLaboral" id="pClavesRefLaboral">   -->

                </div>

              </div>

              <!-- SEGUNDA FILA -->

              <div class="form-group col-md-6">

                <div class="form-group">

                  <label class="control-label">Referencia Personal</label>

                  <textarea class="form-control input-lg pClavesRefPersonal" name="pClavesRefPersonal" id="pClavesRefPersonal" rows="3" cols="50" placeholder="Ingresar referencia laboral"></textarea>
                  <!-- <input type="text" class="form-control input-lg pClavesRefPersonal tagsInput" data-role="tagsinput" placeholder="Separe valores con coma" name="pClavesRefPersonal" id="pClavesRefPersonal"> -->

                </div>

              </div>

            </div>

            <!-- =========================================== -->

            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->

            <div class="form-row">

              <!-- PRIMERA FILA -->
              <div class="form-group col-md-6">

                <div class="form-group">

                  <label class="control-label">Categoría</label>
                  <select class="form-control" name="cmbCategoria" id="cmbCategoria" required>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                         
                  </select>

                </div>

              </div>

              <!-- SEGUNDAD FILA -->
              <div class="form-group col-md-6">

                  <label class="control-label">Estado</label>

                  <label class="control-label" style="color:red">*</label>

                  <br>

                  <select class="form-control" name="cmbEstado" id="cmbEstado" required>

                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                         
                  </select>

              </div>

            </div>

            <!-- ================== MOSTRAR MAPA ======================== -->

            <div class="form-group">

                <div class="card rounded-lg card-secondary card-outline">
                  
                    <div class="card-header pl-2 pl-sm-12">

                      <h5>Ubicación del Cliente:</h5>

                    </div>

                </div>

                <!-- =================== MAPA ======================== -->

                <div class="row">

                  <div class="form-group col-md-12">

                    <!-- <div class="card-footer"> -->
                    
                      <div id="mapa" style="width: 100%; height: 250px;"></div>

                    <!-- </div> -->
                      
                  </div>

                </div>

                <input class="form-control" type="hidden" id="txtLatitud" name="txtLatitud" placeholder="Ingresar latitud"  required>

                <input class="form-control" type="hidden" id="txtLongitud" name="txtLongitud" placeholder="Ingresar longitud"  required>

            </div>

            <!-- =========================================== -->

            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->

            <div class="form-row">

              <!-- PRIMERA FILA -->
              <div class="form-group col-md-12">

                <!-- Foto del usuario -->

                <div class="card rounded-lg card-secondary card-outline">
                  
                    <div class="card-header pl-2 pl-sm-3">

                      <h5>Foto del Cliente:</h5>

                    </div>

                    <div class="card-body">  

                      <ul class="row p-0 vistaGaleria">

                        
                      </ul>

                    </div>

                    <input type="hidden" class="inputNuevaGaleria">
                    <input type="hidden" class="inputGaleria">
                    <input type="hidden" class="inputAntiguaGaleria">
                    <input type="hidden" class="inputAntiguaGaleriaEstatica">

                    <div class="card-footer">
                  
                      <input type="file" multiple name="galeria[]" id="galeria" class="d-none" accept="image/jpeg,image/png">

                      <label for="galeria" class="text-dark text-center py-5 border rounded bg-white w-100 subirGaleria">

                         Haz clic aquí o arrastra las imágenes <br>
                         <span class="help-block small">Formato: JPG-PNG-GIF</span>
                         
                      </label>

                    </div>

                  </div>

              </div>

              <!-- SEGUNDA FILA -->
              <div class="form-group col-md-12">

                <!-- Foto cedula frontal -->

                <div class="card rounded-lg card-secondary card-outline">
                  
                    <div class="card-header pl-2 pl-sm-3">

                      <h5>Foto Frontal Cédula:</h5>

                    </div>

                    <div class="card-body">  

                      <ul class="row p-0 vistaCedulaFrontal">

                        
                      </ul>

                    </div>

                    <input type="hidden" class="inputNuevaCedulaFrontal">
                    <input type="hidden" class="inputCedulaFrontal">
                    <input type="hidden" class="inputAntiguaCedulaFrontal">
                    <input type="hidden" class="inputAntiguaCedulaFrontalEstatica">

                    <div class="card-footer">
                  
                      <input type="file" multiple name="cedulaFrontal[]" id="cedulaFrontal" class="d-none" accept="image/jpeg,image/png">

                      <label for="cedulaFrontal" class="text-dark text-center py-5 border rounded bg-white w-100 subirCedulaFrontal">

                         Haz clic aquí o arrastra las imágenes <br>
                         <span class="help-block small">Formato: JPG-PNG-GIF</span>
                         
                      </label>

                    </div>

                  </div>

              </div>

              <!-- TERCERA FILA -->
              <div class="form-group col-md-12">

                <!-- Foto cedula trasera -->

                <div class="card rounded-lg card-secondary card-outline">
                  
                    <div class="card-header pl-2 pl-sm-3">

                      <h5>Foto Trasera Cédula:</h5>

                    </div>

                    <div class="card-body">  

                      <ul class="row p-0 vistaCedulaTrasera">

                        
                      </ul>

                    </div>

                    <input type="hidden" class="inputNuevaCedulaTrasera">
                    <input type="hidden" class="inputCedulaTrasera">
                    <input type="hidden" class="inputAntiguaCedulaTrasera">
                    <input type="hidden" class="inputAntiguaCedulaTraseraEstatica">

                    <div class="card-footer">
                  
                      <input type="file" multiple name="cedulaTrasera[]" id="cedulaTrasera" class="d-none" accept="image/jpeg,image/png">

                      <label for="cedulaTrasera" class="text-dark text-center py-5 border rounded bg-white w-100 subirCedulaTrasera">

                         Haz clic aquí o arrastra las imágenes <br>
                         <span class="help-block small">Formato: JPG-PNG-GIF</span>
                         
                      </label>

                    </div>

                  </div>

              </div>

            </div>

          </div>

            <!-- Mensaje de Cargando... -->

            <div class="padre">

              <img id="mostrar_loading" class="mx-auto" src="vistas/img/extras/cargando74.gif" alt="..." style="display:none;" />

            </div>

            <!-- =========================================== -->

            <div class="modal-footer">

              <div>
                <button type="button" class="btn btn-danger" id="btnCerrar" data-dismiss="modal" style="display: block;">Cerrar</button>
              </div>

              <div>
                <button type="submit" class="btn btn-primary btnGuardar" id="btnGuardar" style="display: block;">Guardar</button>
              </div>

            </div>

          </form>
                     
        <!-- </div> -->


      </div>

    </div>

  </div>
 
  <script src="vistas/js/clientes.js"></script>

  <!-- =================Referencias necesarias para agregar mapa========================== -->

  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

  <script src="https://maps.googleapis.com/maps/api/js?API_KEY=AIzaSyBrSOFnFlzjX3ocWpDbgMiuK68bx-pmk1U&callback=iniciarMapa"></script>;
   
  <!-- =================================================================================== -->