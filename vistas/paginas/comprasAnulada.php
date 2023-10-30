
<main class="app-content">

      
   <!-- EMPIEZA LA CABECERA DEL DOCUMENTO -->

    <div class="app-title">         

      <div class="ListarContenido">

        <h4>Administrar compras anuladas</h4>
            <!-- FECHA ENTRE RANGOS -->


           <button class="btn btn-primary" type="button" title="Buscar rangos de fecha" id="daterange-btn">
            <span>
              <i class="fa fa-calendar"></i> Movimiento hoy
            </span>
              <i class="fa fa-caret-down"></i>
          </button> 

         <a href="compras">
              <button class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Ir a compras emitidas" type="button" title=""> Ir a compras emitidas
        </button> 
        </a>

           
      </div>

     
      <ul class="app-breadcrumb breadcrumb">

          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>

          <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>

      </ul>

    </div>

     <!-- TERMINA LA CABECERA DEL DOCUMENTO -->

    <section class="content">

      <div class="row  notblock CargarCompra">

        <div id="cabecera" class="col-lg-5 col-xs-12 d-none d-lg-block d-xl-none d-none d-xl-block">
            
          <div class="tile" id="divcabecera">

            <form onsubmit="return Guardarformulario()" method="post" id="formCompra" class="formularioCompra">

              <div class="box-body">
      
                <div class="box">

                   <!-- SEGUNDA FILA -->
                      <div class="form-group">

                      <label class="control-label notblock">Usuario</label>
                        <div class="input-group">
                          <input type="hidden" name="idCompras" id="idCompras">
                          <input type="hidden" name="idUsuario" value="<?php echo $_SESSION["id_usu"].'/'.$_SESSION["tokenUsuario"]; ?>">
                           <input type="hidden" name="idSucursal" id="idSucursal" activo=0 value="<?php echo $_SESSION["idsucursal"]; ?>">
                          <input class="form-control" id="txtNombreUsuario" type="hidden" value="<?php echo $_SESSION["funcionario"].' - '.$_SESSION["usuario"]; ?>" readonly>
                        </div>


                      </div>

                    <!--=====================================
                    ENTRADA DEL VENDEDOR
                    ======================================-->
                    <div class="form-row">

                      <!-- PRIMERA FILA -->
                      <div class="form-group col-lg-6">

                        <!--=====================================
                        ENTRADA PARA LA COMPRA
                        ======================================-->                    
                            <label class="control-label">N° Factura de compra.</label>
                            <div class="input-group">

                             <input type="text" class="form-control input-lg" id="nuevaCompra" name="nuevaCompra">

                            </div>

                      </div>

                      <div class="form-group col-lg-6">
                      <div class="form-group">
                        <label for="txtFechaCompra">Fecha compra</label>
                       <input class="form-control" name="txtFechaCompra" id="txtFechaCompra" type="date" value="<?php date_default_timezone_set("America/Asuncion");echo date('Y-m-d'); ?>" placeholder="Seleccionar la fecha">
                      </div>

                    </div>

                     
                    </div>


                   <!--=====================================
                          ENTRADA EL PROVEEDOR
                          ======================================-->

                    <div class="form-row">

                      <!-- PRIMERA FILA -->
                      <div class="form-group col-md-12">
                        
                  
                        <label class="control-label">Proveedor:</label>
                        <div class="form-group">

                         
                          <select class="form-control select2" id="cmbProveedor" name="cmbProveedor" style="width: 100%;" required>

                            <option value="">Seleccionar un proveedor</option>

                           <?php 
                            $item="ESTADO_PROVEEDOR";
                            $valor=1;
                            $var=null;
                            $Proveedores= ControladorProveedores::ctrMostrarProveedor($item, $valor, $var);
                       
                           foreach ($Proveedores as $key => $value) {

                             echo '<option value="'.$value["COD_PROVEEDOR"].'/'.$value["TOKEN_PROVEEDOR"].'" >'.$value["RUC"].' '.$value["NOMBRE"].'</option>';


                          }

                   ?>

                          </select>


                        </div>

                      </div>
                    </div>

                <!-- ======================================================================================================= -->

                            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                     <div class="form-group col-md-6">
                      <div class="form-group">
                        <label for="cmbEstado">Seleccione tipo de movimiento</label>
                        <select class="form-control select2" name="cmbTipoMovimiento" id="cmbTipoMovimiento">
                          <option value="FACTURA">FACTURA</option>
                          <option value="TICKET">TICKET</option>                         
                        </select>
                      </div>

                    </div>


                    <div class="form-group col-md-6">
                      <div class="form-group">
                        <label for="cmbEstado">Seleccione forma de pago</label>
                        <select class="form-control select2" name="cmbFormaPago" id="cmbFormaPago" required>
                          <option value="CONTADO">CONTADO</option>
                          <option value="CREDITO">CRÉDITO</option>
                         
                        </select>
                      </div>

                    </div>

                    
                  </div>

<!-- ======================================================================================================================== -->

                           <!-- FORMA DE PAGO SI ES MENSUAL QUINCENAL -->
                  <div   class="form-row" >
                    <div class="notblock form-group col-md-6" id="Credito">
                      <div class="form-group">
                        <label for="cmbTipoPago">Seleccione tipo de pago</label>
                        <select class="form-control select2" name="cmbTipoPago" id="cmbTipoPago">
                          <option value="MENSUAL">MENSUAL</option>
                          <option value="QUINCENAL">QUINCENAL</option>
                          <option value="SEMANAL">SEMANAL</option>
                          <option value="DIARIO">DIARIO</option>
                        </select>
                      </div>

                    </div>
                           <!-- CANTIDAD DE CUOTA -->
                     <div class="notblock form-group col-md-6" id="cantidadCuota">
                      <div class="form-group">
                        <label for="txtCantidadCuota">Cantidad cuota</label>
                       <input class="form-control" name="txtCantidadCuota" id="txtCantidadCuota" type="number" placeholder="Cantidad cuota">
                      </div>

                    </div>
                  </div>
              
                    <!-- FECHA DE VENCIMIENTO -->
                  <div   class="form-row" >

                     <div class=" notblock form-group col-md-6" id="Vencimiento">
                      <div class="form-group">
                        <label for="txtFechaVencimiento">Fecha vencimiento</label>
                       <input class="form-control" name="txtFechaVencimiento" id="txtFechaVencimiento" type="date" placeholder="Seleccionar la fecha">
                      </div>

                    </div>


                     <div class="notblock form-group col-md-6" id="montocuota">
                      <div class="form-group">
                        <label for="txtMontoCuota">Monto de cuota</label>
                       <input class="form-control" name="txtMontoCuota" id="txtMontoCuota" type="text" onkeyup="format(this)" onchange="format(this)" > 
                      </div>

                    </div>

          
                  </div>
<!-- ============================================================================================================================ -->

                   <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->
               
                 <div  class="card mb-3 border-primary metodopago">

                   <div class="card-body">
                  <blockquote class="card-blockquote">
                    <div class="form-row">           
                    
                     <div  class="form-group col-md-12">

                       <label for="nuevoMetodoPago">Seleccione método de pago</label>
                    <div class="input-group mb-auto">
                      <select class="form-control Metodonuevopago Metodonuevopago0" id="nuevoMetodoPago" name="nuevoMetodoPago" style="width: 100%;">
                        <option value="">Seleccione método de pago</option>
                         <?php 
                           
                            $item=null;
                            $valor=null;
                            $Formapagos = ControladorFormaPagos::ctrMostrarFormapago($item, $valor,"ESTADO_FORMA",1);
                          
                           foreach ($Formapagos as $key => $value) {

                             echo '<option value="'.$value["COD_FORMAPAGO"].'/'.$value["TOKEN_FORMAPAGO"].'" >'.$value["DESCRIPCION_FORMA"].'</option>';


                          }

                        ?>
                  
                      </select>   

                       <div class=" notblock input-group-append">
                          <button class='btn btn-info btn-sm' id="btnagregarMetodopago" type="button"> <i class="fas fa-plus-square"></i></button>
                        </div> 

                      </div>

                    </div>

               
                </div>

                <div class="form-row">           
                    
                     <div  class="form-group col-md-6" id="Efectivo">

                       <label for="txtdescuentoTotal">Entrega gs.</label>
                       <input class="form-control txtentregaEfectivo" name="txtentregaEfectivo" id="txtentregaEfectivo" type="text" onkeyup="format(this)" onchange="format(this)"> 

                    </div>



                       <div class="form-group col-md-6" id="recibo">
                  
                        <div class="form-group">
                        <label class="NroMovimiento" for="txtnroRecibo">Nº Movimiento</label>
                       <input class="form-control txtnroRecibo" name="txtnroRecibo" id="txtnroRecibo" type="text" placeholder="Nº recibo">
                      </div>

                    </div>

                 
                </div>
              </blockquote>
            </div>

            </div>
  <!-- =========================================================================================================================== -->



     <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->

                
  <!-- =========================================================================================================================== -->


                      
                        <!-- DESCUENTO TOTAL DE PRODUCTOS -->
                    <div class="form-row">
                   
                      <div class="form-group col-md-12">
                        <label for="txtdescuentoTotal">Descuento total gs.</label>
                       <input class="form-control" name="txtdescuentoTotal" id="txtdescuentoTotal" type="text" onkeyup="format(this)" onchange="format(this)" > 
                      </div>

                    </div>


                <!-- TABLA PARA AGREGAR LOS PRODUCTOS A SER REMITIDOS -->
                <hr>
                 <div class="table-responsive">

                    <table class="table table-sm" id="tablaCompra">

                      <thead>

                        <tr>
                          <th><center><i class="fas fa-trash"></i></center></th>
                          <th><center>Cant.</center></th>
                          <th><center><i class="fas fa-barcode"></i></center></th>
                          <th><center>Producto</center></th>
                          <th><center>Costo</center></th>
                          <th><center>Descuento</center></th>
                          <th><center>SubTotal</center></th>
                        </tr>

                      </thead>

                    </table>

                  </div>

                <!-- ==================================================================================================== -->


                <!-- LISTAR LOS PRODUCTOS A SER GUARDADOS -->

                <input type="hidden" id="listaProductos" name="listaProductos">

                <!-- ===================================================================================================== -->
              <hr>

                <!-- ENTRADA PARA EL TOTAL DE PRODUCTOS A REMITIR -->
                
                  <div class="form-group">

                    <label class="control-label"><h3>Total</h3></label>
                    <input class="form-control text-right" type="text" name="txtTotal" id="txtTotal" required readonly="">

                  </div>

               <!-- ===================================================================================================== -->

               
                   
                <hr>

                <!-- ENTRADA PARA EL BOTON GUADAR DATOS -->
                <div class="box-footer">

                  <div class="text-left">

                    <button type="submit" class="btn btn-primary" id="btnGuardar"><i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar compra</button>

                  </div>

                </div>


                <!-- =========================================================================================================== -->


                </div>

              </div>

            </form>

          </div>
        </div>

         <!--=====================================
          LA TABLA DE PRODUCTOS
          ======================================-->
            
      <div class="col-lg-7">

        <div class="bs-component" id="divProductos" >

          <ul class="nav nav-tabs">

          
            <?php 

            if($_SESSION["var_sucursal"]>0){
              echo '<li class="nav-item"><a class="nav-link active" data-toggle="tab" id="ProductoSucursalActual" href="#prodcuctoActualSucursal">Productos Sucursal Actual</a></li>
                  <li class="nav-item"><a class="nav-link" data-toggle="tab" id="ProductoActivoOtros" href="#prodcuctoActualSucursal">Productos Otras sucursales</a></li>';
             }else{
              echo '<li class="nav-item"><a class="nav-link active" data-toggle="tab" id="ProductoSucursalActual" href="#prodcuctoActualSucursal">Busqueda de productos</a></li>';
             }
            
             ?>
           
                                
          </ul>

          <!-- PRODUCTO ACTIVO SE PROGRAMA EN ESTE LUGAR -->
          <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade active show" id="prodcuctoActualSucursal">

              <div class="tile">

                <div class="tile-body">

                  <div class="table-responsive">

                    <table class="table table-sm table-hover table-bordered tablaProductos">

                      <thead>

                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Accion</th>
                          <th>Cód</th>
                          <th style="width: 250px">Descripcion</th>
                          <th>Stock</th>
                          <th>Imagen</th>
                          <?php 
                          if($_SESSION["var_sucursal"]>0){
                            echo '<th>sucursal</th>';
                           }
                           ?>
                         
                        </tr>

                      </thead>

                      <tbody></tbody>

                    </table>

                  </div>

                </div>

                  <!-- PRIMERA FILA -->
                  <div class="form-group d-sm-block d-md-none d-lg-none d-xl-none">

                    <div class="form-group">
                      <label class="control-label"><h3>Total</h3></label>
                      <input class="form-control text-right" type="text" name="txtTotalArticulos" id="txtTotalArticulos" readonly="">
                    </div>
                  </div>

                </div>

            </div>

          </div>
          <!-- ======================================================= -->

        </div>

      </div>
      <!-- ====================================================================================================================== -->

      </div>

      <!-- TERMINA EL ROW DE LAS 2 PARTES -->



 <!-- EMPIEZA LISTAR CONTENIDO -->

    <div class="ListarContenido">

        <div class="row">
          <div class="col-md-12">
            <div class="tile">
              <div class="tile-body">
              
                <div class="table-responsive">
                  <input type="hidden" name="idSucursales" id="idSucursales" activo=1 >

                    <table class="table table-hover table-bordered tablasVerCompra">

                      <thead>
                        <tr>

                           <th>#</th>
                          <th >Acciones</th>
                          <th >Nº Factura compra</th>
                          <th >Fecha Emitida</th>
                          <th >Fecha Anulada</th>
                          <th>Total compra </th>
                          <th>Forma de pago</th>
                          <th>Tipo de pago</th>
                          <th >Metodo de pago</th>
                          <th>Proveedor </th>
                          <th>Sucursal</th>
                          <th>Usuario remitido</th>
                          <th>Usuario anulado</th>
                          <th>Descripcion Anulacion</th>
    
                                              
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
      <!-- TERMINA EL LISTADO DEL COMBO BOX -->

    </section>


    <div class="notblock CargarCompra">
      
      <button class="botonF1 d-xl-none d-lg-none" style="bottom:10px;right:10px;position:fixed;z-index:9999;" id="botonFlotante">
         <span><i class="fas fa-cart-arrow-down"></i><h6 class="texto-encima Can" style="bottom:10px;right:10px;position:fixed;z-index:9999;">0</h6></span>
      </button>
    </div>

</main>



 <!-- MODAL PARA VER LOS DETALLES DE LA TRANSFERENCIA DE PRODUCTO -->

<!-- Modal -->
<div class="modal fade" id="ModalDetCompra" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="background:#464775; color:white">

        <h6 class="modal-title" id="titulo">Detalle Compra</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

        <div class="modal-body">

          <div class="row">
          <div class="col-md-12">
            <div class="tile">
              <div class="tile-body">
              
                <div class="table-responsive">
                  <input type="hidden" name="idSucursales" id="idSucursales" activo=1 >

                    <table class="table table-hover table-bordered tablasDetCompra">

                      <thead>
                        <tr>
                          <th>#</th>
                          <th >Nº Factura compra</th>
                          <th >Fecha</th>
                          <th>Nº Recibo</th>
                          <th>Forma de pago</th>
                          <th>Tipo de pago</th>
                          <th >Metodo de pago</th>
                          <th>Proveedor </th>
                          <th>Cod. barra</th>
                          <th>Productos</th>
                          <th>Cantidad</th>
                          <th>Prec. Unitario</th>
                          <th>Prec. Neto</th>
                          <th>Descuento</th>
                          <th>Usuario</th>
                          <th>Cantidad Anterior</th>
                          <th>Sucursal</th>
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

  </div>

</div>

<script src="vistas/js/compras.js"></script>