
<main class="app-content">

  <div class="app-title">

    <h5><button class="btn btn-primary btnNuevo" type="button"  data-toggle="modal" data-target="#ModalCanales"><i class="fas fa-plus-circle"></i> Agregar Nuevo </button> Crear canal de descuento de productos </h5>

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
                
            <table class="table table-sm table-hover table-bordered tablaCanales">

              <thead>

                <tr>

                  <th style="width:10px">#</th>
                  <th style="width:100px">Acciones</th>
                  <th>Canal</th>
                                        
                </tr>

              </thead>

              <tbody>

              </tbody>

            </table>

          </div>

        </div>

      </div>

    </div>

  </div>

</main>


<!-- MODAL AGREGAR -->

<div class="modal fade" id="ModalCanales" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="background:#464775; color:white">

        <h6 class="modal-title" id="titulo">Nuevo canal</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <!-- FORMULARIOS -->
        <form  method="post" name="formCanal" id="formCanal" onsubmit="return guardarFormulario()">

          <input class="form-control" type="hidden" name="idCanal"  id="idCanal">

          <input class="form-control" type="hidden" name="tokenCanal" id= "tokenCanal">

          <!-- =========================================== -->
          <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
          <div class="form-row" >

            <!-- PRIMERA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">

                <label class="control-label">Canal de productos <span style="color:red">*</span></label>

                <input class="form-control" type="text" name="txtCanal" id="txtCanal" placeholder="Ingresar canal" required>

              </div>

            </div>

            <!-- SEGUNDA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">

                <label for="cmbEstado">Seleccione el estado</label>

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



    <!-- MODAL AGREGAR DESCUENTO POR CANTIAD PRODUCTO -->

<!-- Modal -->
<div class="modal fade" id="ModalDescuento" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="background:#464775; color:white">

        <h6 class="modal-title" id="titulo">Nuevo Descuento</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <!-- FORMULARIOS -->
        <form  method="post" name="formDescuento" id="formDescuento" onsubmit="return guardarFormularioDescuento()">

          <input class="form-control" type="hidden" name="idCanalProductos"  id="idCanalProductos">

          <input class="form-control" type="hidden" name="tokenCanalProductos" id= "tokenCanalProductos">

          <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
          <div class="form-row">

                    <!-- PRIMERA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">

                <label class="control-label">Canal de Productos</label>

                <input class="form-control" type="text" name="txtCanalDescuento" id="txtCanalDescuento" readonly>
                       
              </div>

            </div>

            <!-- SEGUNDA FILA -->

            <div class="form-group col-md-6">

              <div class="form-group">

                <label class="control-label">Descuento % <span style="color:red">*</span></label>

                <input class="form-control" type="text" name="txtDescuento" id="txtDescuento" placeholder="Ingresar Porcentaje de Descuento" required>

              </div>

            </div>

          </div>

          <!-- =========================================== -->
          <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
          <div class="form-row" >

            <!-- PRIMERA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">

                <label class="control-label">Cantidad Desde <span style="color:red">*</span></label>

                <input class="form-control" type="text" name="txtDesde" id="txtDesde" placeholder="Ingresar cantidad desde" required>

                <input class="form-control" type="hidden" name="desde" id= "desde">

              </div>

            </div>

            <!-- SEGUNDA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">
              
                <label class="control-label">Cantidad Hasta <span style="color:red">*</span></label>
                <input class="form-control" type="text" name="txtHasta" id="txtHasta" placeholder="Ingresar cantiadad hasta" required>

                <input class="form-control" type="hidden" name="hasta" id= "hasta">

              </div>

            </div>
    
          </div>

          <!-- =========================================== -->
          <!-- INPUT DE TABLA DE DESCUENTOS-->

           <table class="table table-responsive-sm table-bordered" id="TablaDescuento">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Cantidad desde</th>
                  <th>Cantidad hasta</th>
                  <th>Descuento</th>
                </tr>
              </thead>
              <tbody>
                                
              </tbody>
            </table>

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

 
<script src="vistas/js/canalesProductos.js"></script>