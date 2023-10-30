<?php 

  if($_SESSION["superperfil"]==0){
      echo '<script type="text/javascript">
        window.location = "inicio";
        </script>';
        }
?>
<main class="app-content">

      <div class="app-title">

      <h5><button class="btn btn-primary btnNuevo" type="button"  data-toggle="modal" data-target="#ModalCuotas"><i class="fas fa-plus-circle"></i> Agregar Nuevo </button> Agregar cuotero</h5>

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
                
                <table class="table table-sm table-hover table-bordered tablaCuotero">

                  <thead>

                    <tr>
                        <th style="width:10px">#</th>
                        <th style="width:100px">Acciones</th>
                        <th>Recarga % </th>
                        <th>Monto desde</th>
                        <th>Monto hasta</th>
                        <th>Fecha Reg.</th>
                        <th>Última Mod.</th> 
                        <th>Usuario</th>                       
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

<!-- Modal -->
<div class="modal fade" id="ModalCuotas" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="background:#464775; color:white">

        <h6 class="modal-title" id="titulo">Nuevo Cuotero</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <!-- FORMULARIOS -->
        <form  method="post" name="formCuota" id="formCuota" onsubmit="return guardarFormulario()">

          <input class="form-control" type="hidden" name="idCuota"  id="idCuota">

            <input class="form-control" type="hidden" name="idUsuario"  id="idUsuario" value="<?php echo $_SESSION["id_usu"].'/'.$_SESSION["tokenUsuario"]; ?>">

          <input class="form-control" type="hidden" name="tokenCuota" id= "tokenCuota">

         
          <!-- =========================================== -->
          <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
          <div class="form-row" >

            <!-- PRIMERA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">

                <label class="control-label">Monto Desde <span style="color:red">*</span></label>

                <input class="form-control" type="text" name="txtDesde" id="txtDesde" placeholder="Ingresar Monto desde" onkeyup="format(this)" onchange="format(this)" required>

                <input class="form-control" type="hidden" name="desde" id= "desde">

              </div>

            </div>

            <!-- SEGUNDA FILA -->
            <div class="form-group col-md-6">

              <div class="form-group">
              
                <label class="control-label">Monto Hasta <span style="color:red">*</span></label>
                <input class="form-control" type="text" name="txtHasta" id="txtHasta" placeholder="Ingresar Monto hasta" onkeyup="format(this)" onchange="format(this)" required>

                <input class="form-control" type="hidden" name="hasta" id= "hasta">

              </div>

            </div>
    
          </div>


 <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
          <div class="form-row">

                    <!-- PRIMERA FILA -->
           
            <div class="form-group col-md-6">

              <div class="form-group">

                <label class="control-label">Recarga % <span style="color:red">*</span></label>

                <input class="form-control" type="text" name="txtRecarga" id="txtRecarga" placeholder="Ingresar Porcentaje de recarga" required>

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

        

          <div class="modal-footer">

            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>

          </div>

      </form>
                   
          </div>


    </div>

  </div>

</div>
 
<script src="vistas/js/cuotas.js"></script>

