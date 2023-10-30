<?php 

  if($_SESSION["superperfil"]==0){
      echo '<script type="text/javascript">
        window.location = "inicio";
        </script>';
        }
?>
<main class="app-content">

      <div class="app-title">

      <h5><button class="btn btn-primary btnNuevo" type="button"  data-toggle="modal" data-target="#ModalDescuento"><i class="fas fa-plus-circle"></i> Agregar Nuevo </button> Crear descuentos </h5>

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
                
                <table class="table table-sm table-hover table-bordered tablaDescuentos">

                  <thead>

                    <tr>
                        <th style="width:10px">#</th>
                        <th style="width:100px">Acciones</th>
                        <th>Canal</th>
                        <th>Descuento %</th>
                        <th>Desde Gs.</th>
                        <th>Hasta Gs.</th>
                        <th>Fecha Reg.</th>
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


    <!-- MODAL AGREGAR -->

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
        <form  method="post" name="formDescuento" id="formDescuento" onsubmit="return guardarFormulario()">

          <input class="form-control" type="hidden" name="idDescuento"  id="idDescuento">

          <input class="form-control" type="hidden" name="tokenDescuento" id= "tokenDescuento">

          <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
          <div class="form-row">

                    <!-- PRIMERA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">

                <label class="control-label">Canal</label>

                <label class="control-label" style="color:red">*</label>
                       
                <select class="form-control select2" name="cmbCanal" id="cmbCanal" style="width: 100%;" required="">

                  <option value="" selected="selected">Seleccione un Canal</option>

                    <?php 

                      $item="ESTADO";
                      $valor=1;
                      $var=null;
                      $order="COD_CANAL ASC";

                      $canales = ControladorCanales::ctrMostrarCanal($item, $valor, $var, $order);
                                         
                        foreach ($canales as $key => $value) {

                          echo '<option value="'.$value["COD_CANAL"].'/'.$value["TOKEN_CANAL"].'" >'.$value["DESCRIPCION_CANAL"].'</option>';

                        }

                    ?>

                </select>

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

                <label class="control-label">Monto Desde <span style="color:red">*</span></label>

                <input class="form-control" type="text" name="txtDesde" id="txtDesde" placeholder="Ingresar Monto Desde" onkeyup="format(this)" onchange="format(this)" required>

                <input class="form-control" type="hidden" name="desde" id= "desde">

              </div>

            </div>

            <!-- SEGUNDA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">
              
                <label class="control-label">Monto Hasta <span style="color:red">*</span></label>
                <input class="form-control" type="text" name="txtHasta" id="txtHasta" placeholder="Ingresar Monto Hasta" onkeyup="format(this)" onchange="format(this)" required>

                <input class="form-control" type="hidden" name="hasta" id= "hasta">

              </div>

            </div>
    
          </div>

          <!-- =========================================== -->
          <!-- INPUT DE TABLA DE DESCUENTOS-->

          <div class="tablaDescuento">

            <div class="table-responsive tablaDesc">

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
 
<script src="vistas/js/descuentos.js"></script>

