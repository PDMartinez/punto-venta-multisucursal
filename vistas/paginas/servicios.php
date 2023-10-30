    <main class="app-content">
      <div class="app-title">
        

          <h5><button class="btn btn-primary btnNuevo" type="button"  data-toggle="modal" data-target="#ModalProductos"><i class="fas fa-plus-circle"></i> Agregar Nuevo</button> Crear Servicio</h5>

            <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        </ul>

         <input type="hidden" id="idsucursal" value="<?php echo $_SESSION["idsucursal"] ?>">
          <input type="hidden" id="idusuario" value="<?php echo $_SESSION["id_usu"] ?>">
           <input type="hidden" id="idStock">
           <input type="hidden" id="activo" value="1">
         <!--  <p>En este módulo, puedes crear, modificar,eliminar Sucursales</p> -->
        </div>

        
<div class="mostrarGrilla">
  <div class="row">
    <div class="col-md-12">
                     
      <div class="bs-component">
          
                <div class="tile">
              <div class="tile-body">
                  <div class="table-responsive">
               
                    <table class="table table-hover table-bordered tablaProductos">

                      <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th style="width:100px">Acciones</th>
                            <th>Codigo</th>
                            <th>Descripcion del servicio</th>
                            <th>Precio del servicio</th>
                            <th>Tipo movimiento</th>
                            <th>Dar de baja</th>
                           
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

    </div>
</div>

<!-- CARD PARA SELECCIONAR SUCURSALES -->

<div class="notblock seleccioneSucursal">

<div class="card">
  <div class="card-header text-white bg-primary">
    SELECCIONE UNA SUCURSAL PARA REALIZAR LA CLONACIÓN
  </div>
  <div class="card-body">
    <input type="hidden" id="tokenproducto">
    <input type="hidden" id="clonarnuevo">
    <h5 class="card-title">Puedes clonar este producto a la sucursal que quieras</h5>
      <label class="control-label">Sucursal a donde:</label>
        <div class="input-group">

                           
            <select class="form-control" id="cmbSucursalHasta" name="cmbSucursalHasta" required>

              <option value="<?php echo $_SESSION["idsucursal"] ?>"><?php echo $_SESSION["sucursal"] ?></option>

                <?php 
                $item="ESTADO_SUCURSAL";
                $valor=1;
                $SucursalHasta= ControladorSucursales::ctrMostrarSucursal($item, $valor,null);
                         
                  foreach ($SucursalHasta as $key => $value) {
                    $actual=$_SESSION["idsucursal"];
                    $nuevo=$value["COD_SUCURSAL"].'/'.$value["TOKEN_SUCURSAL"];
                    if($actual!=$nuevo){
                         echo '<option value="'.$value["COD_SUCURSAL"].'/'.$value["TOKEN_SUCURSAL"].'" >'.$value["SUCURSAL"].'</option>';
                    }

                  


                      }

                  ?>

              </select>


                    </div>

                    <hr>
    <button type="button" class="btn btn-danger" id="CerrarVentaClonar">Cerrar</button>
    <button type="button" class="btn btn-primary" data-dismiss="modal" title='Clonar producto' data-toggle='modal' data-target='#ModalProductos' id="btnCargar">Cargar</button>

     
  </div>
</div>
</div>



    </main>


    <!-- MODAL AGREGAR -->

<!-- Modal -->
<div class="modal fade" id="ModalProductos" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg ">

    <div class="modal-content">

      <form  onsubmit="return Guardarformulario()" method="post" name="formProducto" id="formProducto">

        <div class="modal-header" style="background:#464775; color:white">

          <h6 class="modal-title" id="titulo">Nuevo Servicio</h6>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

          </button>

        </div>

        <div class="modal-body" id="modalBody" style="display: block;">

                  <input class="form-control" type="hidden" name="idProducto"  id="idProducto">
                  <input class="form-control" type="hidden" name="TokenProducto" id= "TokenProducto">

                    <label class="control-label">Codigo <span style="color:red">*</span></label>
                      <div class="input-group mb-3">
                        <input class="form-control" type="text" name="txtCodigoBarra" id="txtCodigoBarra" placeholder="Ingresar el codigo" required>
                        <div class="input-group-append">
                          <button class='btn btn-info btn-sm GenerarCodigo' type="button"><i class='fa fa-refresh text-white'></i></button>
                        </div>
                      </div>

                   
                   <div id="divBarCode" class="notblock textcenter">
                            <div id="printCode">
                                <svg id="barcode"></svg> 
                            </div>
                            <button class="btn btn-success btn-sm" type="button" onClick="fntPrintBarcode('#printCode')"><i class="fas fa-print"></i> Imprimir</button>
                    </div>

                <!-- =========================================== -->

                
               
                    <!-- PRIMERA FILA -->
                    <div class="form-group">
                       <label class="control-label" id="lblclave">Descripción del servicio <span style="color:red">*</span></label>
                         <div class="input-group">
                            <input class="form-control" type="text" id="txtDescripcion" name="txtDescripcion"  placeholder="Ingresar una descripción del servicio" required  />  
                        </div>
                
                     
                    </div>

             
                <!-- =========================================== -->                  

                   <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-12">
                     <label class="control-label">Precio del servicio <span style="color:red">*</span></label>
                         <div class="input-group">          
                        
                            <input class="form-control" type="text" id ="txtPrecioVenta" name="txtPrecioVenta" placeholder="Ingresar el precio del servicio" onkeyup="format(this)" onchange="format(this)" required='required'>
                        </div>
                      </div>

            </div>

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
                   
          </div>


    </div>

  </div> 

<script src="vistas/js/servicios.js"></script>

