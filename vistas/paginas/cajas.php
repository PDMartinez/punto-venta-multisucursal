<?php 

  if($_SESSION["superperfil"]==0){
      echo '<script type="text/javascript">
        window.location = "inicio";
        </script>';
        }
?>
<main class="app-content">

      <div class="app-title">

        <h5><button class="btn btn-primary btnNuevo" type="button"  data-toggle="modal" data-target="#ModalCaja"><i class="fas fa-plus-circle"></i> Agregar Nuevo </button> Crear cajas </h5>

        <div class="box-header with-border texto" >

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
                
                <table class="table table-sm table-hover table-bordered tablaCajas">

                  <thead>

                    <tr>
                        <th style="width:10px">#</th>
                        <th style="width:100px">Acciones</th>
                        <th>Sucursal</th>
                        <th>N° Caja</th>
                        <th>N° Factura</th>
                        <th>Timbrado</th>
                        <th>Inicio Vigencia</th>
                        <th>Fin Vigencia</th>
                        <th>Equipo</th>
                        <th>N° Verificador</th>
                        <th>N° Ticket</th>
                        <th>N° NC</th>
                        <!-- <th>Estado</th> -->
                       
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


    <!-- MODAL AGREGAR -->

<!-- Modal -->
<div class="modal fade" id="ModalCaja" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="background:#464775; color:white">

        <h6 class="modal-title" id="titulo">Nueva Caja</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <!-- FORMULARIOS -->
        <form  method="post" name="formCaja" id="formCaja" onsubmit="return guardarFormulario()">

          <input class="form-control" type="hidden" name="idCaja"  id="idCaja">

          <input class="form-control" type="hidden" name="tokenCaja" id= "tokenCaja">

          <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
          <div class="form-row">

                    <!-- PRIMERA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">

                <label class="control-label">Sucursal</label>

                <label class="control-label" style="color:red">*</label>
                       
                <select class="form-control select2" name="cmbSucursal" id="cmbSucursal" style="width: 100%;" required="">

                  <option value="" selected="selected">Seleccione una Sucursal</option>

                    <?php 

                      $item="ESTADO_SUCURSAL";
                      $valor=1;
                      $Sucursales = ControladorSucursales::ctrMostrarSucursal($item,$valor,null);
                         
                        foreach ($Sucursales as $key => $value) {

                          echo '<option value="'.$value["COD_SUCURSAL"].'/'.$value["TOKEN_SUCURSAL"].'" >'.$value["SUCURSAL"].'</option>';

                        }

                    ?>

                </select>

              </div>

            </div>

            <!-- SEGUNDA FILA -->

            <div class="form-group col-md-6">

              <div class="form-group">
              
                <label class="control-label">N° Caja <span style="color:red">*</span></label>

                <input class="form-control" type="text" name="txtNroCaja" id="txtNroCaja" value="" required readonly>

              </div>

            </div>

          </div>

          <!-- =========================================== -->
          <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
          <div class="form-row" >

            <!-- PRIMERA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">

                <label class="control-label">N° Factura <span style="color:red">*</span></label>

                <input class="form-control" type="text" name="txtNroFactura" id="txtNroFactura" placeholder="Ingresar N° de Factura" required>

              </div>

            </div>

            <!-- SEGUNDA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">
              
                <label class="control-label">Timbrado <span style="color:red">*</span></label>
                <input class="form-control" type="text" name="txtTimbrado" id="txtTimbrado" placeholder="Ingresar timbrado" required>

              </div>

            </div>
    
          </div>

          <!-- =========================================== -->
          <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
          <div class="form-row" >

            <!-- PRIMERA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">
              
                <label class="control-label">Inicio Vigencia <span style="color:red">*</span></label>

                <input class="form-control" name="txtInicioVigencia" id="txtInicioVigencia" type="date" placeholder="Seleccionar la fecha">

              </div>

            </div>

            <!-- SEGUNDA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">
              
                <label class="control-label">Fin de Vigencia <span style="color:red">*</span></label>

                <input class="form-control" name="txtFinVigencia" id="txtFinVigencia" type="date" placeholder="Seleccionar la fecha">

              </div>

            </div>
    
          </div>

          <!-- =========================================== -->
          <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
          <div class="form-row" >

            <!-- PRIMERA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">
              
                <label class="control-label">N° Verificador <span style="color:red">*</span></label>

                <input class="form-control" type="text" name="txtVerificador" id="txtVerificador" value="" required readonly>

              </div>

            </div>

            <!-- SEGUNDA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">
              
                <label class="control-label">N° Ticket <span style="color:red">*</span></label>
                <input class="form-control" type="text" name="txtTicket" id="txtTicket" placeholder="Ingresar ticket" required>

              </div>

            </div>
    
          </div>

          <!-- =========================================== -->
          <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
          <div class="form-row" >

            <!-- PRIMERA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">
              
                <label class="control-label">N° Nota de Crédito <span style="color:red">*</span></label>
                <input class="form-control" type="text" name="txtNC" id="txtNC" placeholder="Ingresar nota de crédito" required>

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
 
<script src="vistas/js/cajas.js"></script>