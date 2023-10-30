
    <main class="app-content">

      <div class="app-title">
        
        <div>

          <h5><button class="btn btn-primary btnNuevo" type="button"  data-toggle="modal" data-target="#ModalProveedor"><i class="fas fa-plus-circle"></i> Agregar Nuevo </button> Crear proveedores </h5>

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
                
                <table class="table table-hover table-bordered tablaProveedores">

                  <thead>

                    <tr>
                        <th style="width:10px">#</th>
                        <th style="width:100px">Acciones</th>
                        <th>RUC</th>
                        <th>Nombre</th>
                        <th>Ciudad</th>
                        <th>Dirección</th>
                        <th>Email</th>
                        <th>Linea Baja</th>
                        <th>Celular</th>
                        <th>Fecha Registro</th>
                        <th>Última Mod.</th>
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

  <div class="modal fade" id="ModalProveedor" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">

      <div class="modal-content">

        <div class="modal-header" style="background:#464775; color:white">

          <h6 class="modal-title" id="titulo">Nuevo proveedor</h6>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

          </button>

        </div>

        <div class="modal-body">

          <!-- FORMULARIOS -->

          <form method="post" name="formProveedor" id="formProveedor" onsubmit="return guardarFormulario()">

            <input class="form-control" type="hidden" name="idProveedor"  id="idProveedor" value="">

            <input class="form-control" type="hidden" name="tokenProveedor" id= "tokenProveedor" value="">

            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  
            <div class="form-row">

              <!-- PRIMERA FILA -->

              <div class="form-group col-md-6">

                <div class="form-group">

                    <label class="control-label">NOMBRE</label>

                    <label class="control-label" style="color:red">*</label>

                    <input class="form-control" type="text" name="txtEmpresa" placeholder="Ingresar Empresa">

                </div>

              </div>

              <!-- SEGUNDA FILA -->

              <div class="form-group col-md-6">

                <div class="form-group">

                  <label class="control-label">RUC</label>

                  <label class="control-label" style="color:red">*</label>

                  <input class="form-control" type="text" name="txtRUC" placeholder="Ingresar RUC">

                </div>

              </div>

            </div>

            <!-- =========================================== -->

            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->

            <div class="form-row" >

              <!-- PRIMERA FILA -->
              <div class="form-group col-md-6">

                  <label class="control-label">Ciudad</label>

                  <label class="control-label" style="color:red">*</label>

                  <select class="form-control select2" name="cmbCiudad" id="cmbCiudad" style="width: 100%;" required="">
                    
                    <option selected="selected" value="0">Seleccione una opción</option>
                          
                      <?php 

                        $item="";
                        $valor= "";

                        $ciudad = ControladorCiudades::ctrMostrarCiudad($item, $valor);
                       
                        foreach ($ciudad as $key => $value) {

                          echo '<option value="'.$value["COD_CIUDAD"].'/'.$value["TOKEN_CIUDAD"].'" >'.$value["DESCRIPCION_CIUDAD"].'</option>';

                        }

                   ?>

                  </select>

              </div>

              <!-- SEGUNDAD FILA -->
              <div class="form-group col-md-6">

                <label class="control-label">Dirección</label>

                <label class="control-label" style="color:red">*</label>

                <div class="input-group">       

                  <input class="form-control" type="text" name="txtDireccion" placeholder="Ingresar dirección" required >

                </div>

              </div>

            </div>

            <!-- =========================================== -->

            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->

            <div class="form-row">

              <!-- PRIMERA FILA -->
              <div class="form-group col-md-6">

                <div class="form-group">

                  <label class="control-label">Teléfono</label>

                  <label class="control-label" style="color:red">*</label>

                  <input class="form-control" type="text" id="txtTelefono" name="txtTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'(9999) 999-999'" data-mask required>

                </div>

              </div>

              <!-- SEGUNDAD FILA -->
              <div class="form-group col-md-6">

                <div class="form-group">

                  <label class="control-label">Celular</label>

                  <label class="control-label" style="color:red">*</label>

                  <input class="form-control" type="text" id="txtCelular" name="txtCelular" placeholder="Ingresar celular" required>

                </div>

              </div>

            </div>

            <!-- =========================================== -->

            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->

            <div class="form-row">

              <!-- PRIMERA FILA -->
              <div class="form-group col-md-6">

                <div class="form-group">

                  <label class="control-label">E-mail</label>

                  <label class="control-label" style="color:red">*</label>

                  <input class="form-control" type="email" id="txtEmail" name="txtEmail" placeholder="Ingresar correo electrónico" required>

                </div>

              </div>

              <!-- SEGUNDAD FILA -->
              <div class="form-group col-md-6">

                <div class="form-group">

                  <label class="control-label">Estado</label>

                  <label class="control-label" style="color:red">*</label>

                  <br>

                  <select class="form-control" name="cmbEstado" id="cmbEstado" required>

                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                         
                  </select>

                </div>

              </div>

            </div>

            <!-- =========================================== -->

            <div class="modal-footer">

              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>

              <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>

            </div>

          </form>
                     
        </div>

      </div>

    </div>

  </div>
 
  <script src="vistas/js/proveedores.js"></script>
