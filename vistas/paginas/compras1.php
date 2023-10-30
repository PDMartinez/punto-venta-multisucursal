<main class="app-content">

      <div class="app-title">

        <div>

        <div class="contador">
         <h5>  Listado de compras</h5>
            <a href="verRemision">

        <button class="btn btn-primary btnNuevo" type="button"><i class="fas fa-th-list"></i> Listar compra</button>
        </a>
    
        </div>
        </div>

        <ul class="app-breadcrumb breadcrumb">

          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>

          <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>

        </ul>

      </div>


      <section class="content">

        <div class="row">

          <!--=====================================
          EL FORMULARIO
          ======================================-->
          
           <div id="cabecera" class="col-lg-5 col-xs-12 d-none d-lg-block d-xl-none d-none d-xl-block">
            
            <div class="tile" id="divcabecera">

              <form onsubmit="return Guardarformulario()" method="post" id="formCompra" class="formularioCompra">

                <div class="box-body">
      
                  <div class="box">

                       <!-- SEGUNDA FILA -->
                      <div class="form-group">

                      <label class="control-label">Usuario</label>
                        <div class="input-group">

                          <input type="hidden" name="idUsuario" value="<?php echo $_SESSION["id_usu"].'/'.$_SESSION["tokenUsuario"]; ?>">
                           <input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $_SESSION["idsucursal"]; ?>">
                          <input class="form-control" id="txtNombreUsuario" type="text" value="<?php echo $_SESSION["funcionario"].' - '.$_SESSION["usuario"]; ?>" readonly>
                        </div>


                      </div>

                    <!--=====================================
                    ENTRADA DEL VENDEDOR
                    ======================================-->
                    <div class="form-row">

                      <!-- PRIMERA FILA -->
                      <div class="form-group col-lg-6">

                        <!--=====================================
                        ENTRADA PARA LA REMISION
                        ======================================-->                    
                            <label class="control-label">N° Compra.</label>
                            <div class="input-group">

                             <input type="text" class="form-control input-lg" id="nuevaCompra" name="nuevaCompra">

                            </div>

                      </div>

                      <div class="form-group col-lg-6">
                      <div class="form-group">
                        <label for="txtFechaCompra">Fecha compra</label>
                       <input class="form-control demoDate" name="txtFechaCompra" id="txtFechaCompra" type="text" placeholder="Seleccionar la fecha">
                      </div>

                    </div>

                     
                    </div>

                    <!--=====================================
                    ENTRADA DE LA SUCURSAL DESDE
                    ======================================-->

                  


                    <div class="form-row">

                      <!-- PRIMERA FILA -->
                      <div class="form-group col-md-12">
                          <!--=====================================
                          ENTRADA EL PROVEEDOR
                          ======================================-->

                  
                        <label class="control-label">Proveedor:</label>
                        <div class="form-group">

                         
                          <select class="form-control select2" id="cmbProveedor" name="cmbProveedor" required>

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


                              <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                     <div class="form-group col-md-6">
                      <div class="form-group">
                        <label for="cmbEstado">Seleccione tipo de movimiento</label>
                        <select class="form-control" name="cmbTipoMovimiento" id="cmbTipoMovimiento">
                          <option value="Factura">Factura</option>
                          <option value="Ticket">Ticket</option>                         
                        </select>
                      </div>

                    </div>


                    <div class="form-group col-md-6">
                      <div class="form-group">
                        <label for="cmbEstado">Seleccione forma de pago</label>
                        <select class="form-control" name="cmbFormaPago" id="cmbFormaPago" required>
                          <option value="Contado">Contado</option>
                          <option value="Credito">Crédito</option>
                         
                        </select>
                      </div>

                    </div>

                    
                  </div>


                              <!-- FORMA DE PAGO SI ES MENSUAL QUINCENAL -->
                  <div   class="form-row" >
                    <div style="display:none"  class="form-group col-md-6" id="Credito">
                      <div class="form-group">
                        <label for="cmbTipoPago">Seleccione tipo de pago</label>
                        <select class="form-control" name="cmbTipoPago" id="cmbTipoPago">
                          <option value="">Seleccione tipo de pago</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Quincenal">Quincenal</option>
                          <option value="Semanal">Semanal</option>
                         
                        </select>
                      </div>

                    </div>
                           <!-- CANTIDAD DE CUOTA -->
                     <div style="display:none" class="form-group col-md-6" id="cantidadCuota">
                      <div class="form-group">
                        <label for="txtCantidadCuota">Cantidad cuota</label>
                       <input class="form-control" name="txtCantidadCuota" id="txtCantidadCuota" type="number" placeholder="Cantidad cuota">
                      </div>

                    </div>
                  </div>
              
                    <!-- FECHA DE VENCIMIENTO -->
                  <div   class="form-row" >

                     <div style="display:none" class="form-group col-md-6" id="Vencimiento">
                      <div class="form-group">
                        <label for="txtFechaVencimiento">Fecha vencimiento</label>
                       <input class="form-control demoDate" name="txtFechaVencimiento" id="txtFechaVencimiento" type="text" placeholder="Seleccionar la fecha">
                      </div>

                    </div>


                     <div style="display:none" class="form-group col-md-6" id="montocuota">
                      <div class="form-group">
                        <label for="txtMontoCuota">Monto de cuota</label>
                       <input class="form-control" name="txtMontoCuota" id="txtMontoCuota" type="text" onkeyup="format(this)" onchange="format(this)" > 
                      </div>

                    </div>

          
                  </div>


                <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->

                <div class="form-row">           
                    
                     <div  class="form-group col-md-6" id="metodopago">
                       <label for="nuevoMetodoPago">Seleccione método de pago</label>
                      <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago">
                        <option value="">Seleccione método de pago</option>
                        <option value="EFECTIVO">Efectivo</option>
                        <option value="TC">Tarjeta Crédito</option>
                        <option value="TD">Tarjeta Débito</option>                  
                      </select>    

                    </div>

                     <div class="form-group col-md-6" id="recibo">
                  
                        <div class="form-group">
                        <label for="txtnroRecibo">Nº recibo</label>
                       <input class="form-control" name="txtnroRecibo" id="txtnroRecibo" type="text" placeholder="Nº recibo">
                      </div>

                    </div>

                </div>


                    <!--=========================================
                    ENTRADA PARA AGREGAR LOS PRODUCTOS PARA VENTA
                    ===========================================-->

                    <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 

                <div class="form-group row nuevoProducto">

                

                </div>


                <div class="table-responsive">

                              <table class="table table-sm">

                                <thead>

                                  <tr>
                                    <th><center><i class="fas fa-trash"></i></center></th>
                                     <th><center>Cant.</center></th>
                                    <th><center><i class="fas fa-barcode"></i></center></th>
                                    <th><center>Producto</center></th>
                                    <th><center>Costo</center></th>
                                    <th><center>descuento</center></th>
                                    <th><center>SubTotal</center></th>
                                  </tr>

                                </thead>

                                <tbody>

                                  <!-- Boton de quitar -->

                                  <td class="tdQuitar" style="width:50px">


                                  </td>

                                   <!-- Cantidad del producto -->

                                  <td class="tdNuevoCantidad">


                                  </td>

                                    <!-- Boton de Numeración -->

                                  <td class="tdNumero" style="width:50px">


                                  </td>

                                  <!-- Descripción del producto -->

                                  <td class="tdNuevoProducto">


                                  </td>

                                 
                                  <!-- Precio del producto -->

                                  <td class="tdNuevoPrecio" style="width:50px">


                                  </td>

                                  <!-- Precio del producto -->

                                  <td class="tdNuevoDescuento" style="width:50px">


                                  </td>

                                  <!-- Sub total -->

                                  <td class="tdNuevoSubTotal" style="width:50px">


                                  </td>
                               

                                </tbody>

                              </table>

                            </div>



                <input type="hidden" id="listaProductos" name="listaProductos">

                                       
                <hr>

              

                  <!--=====================================
                  ENTRADA IMPUESTOS Y TOTAL
                  ======================================-->
                
                  <!-- PRIMERA FILA -->
                    <div class="form-group">

                      <div class="form-group">
                        <label class="control-label"><h3>Total</h3></label>
                        <input class="form-control text-right" type="text" name="txtTotal" id="txtTotal" required readonly="">
                     </div>
                    </div>

               

                <hr>


                  </div>
               
            </div>

                  


                <div class="box-footer">

                  <div class="text-left">

                    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar compra</button>

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
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#prodcuctoActualSucursal">Sucursal Actual</a></li>

            <?php 
             if( $_SESSION["var_sucursal"]==1){
            echo '<li class="nav-item"><a class="nav-link" data-toggle="tab" id="ProductoActivoOtros" href="#productosOtrasSucursales">Otras sucursales</a></li>';
               }
              
             ?>
           
                                
          </ul>

              <!-- PRODUCTO ACTIVO SE PROGRAMA EN ESTE LUGAR -->
          <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade active show" id="prodcuctoActualSucursal">

                <div class="tile">

                  <div class="tile-body">

                    <div class="table-responsive">

                      <table class="table table-sm table-hover table-bordered tablaCompras">

                        <thead>

                          <tr>
                            <th style="width: 10px">#</th>
                            <th>Accion</th>
                            <th>Cód</th>
                            <th style="width: 250px">Descripcion</th>
                            <th>Stock</th>
                            <th>Imagen</th>
                          </tr>

                        </thead>

                         <tbody>

                        </tbody>

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
   

              <!-- =========================================================== -->

           <div class="tab-pane fade" id="productosOtrasSucursales">
                <div class="tile">
                  <div class="tile-body">
                    <div class="table-responsive">
                 
                        <table class="table table-hover table-bordered tablaComprasSucursales">

                          <thead>

                            <tr>
                              <th style="width: 10px">#</th>
                              <th>Cód</th>
                              <th>Descripcion</th>
                              <th>Stock</th>
                              <th>Imagen</th>
                              <th>Sucursales</th>
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
                <!-- ========================================================= -->
                    

          </div>
      </div>

</div>


  </section>
  <button class="botonF1 d-xl-none d-lg-none" style="bottom:10px;right:10px;position:fixed;z-index:9999;" id="botonFlotante">
    <span><i class="fas fa-cart-arrow-down"></i></span>
  </button>

</main>

<script src="vistas/js/compras.js"></script>