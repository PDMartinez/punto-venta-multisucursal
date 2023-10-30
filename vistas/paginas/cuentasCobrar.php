<?php 

      $item = "ESTADO_APERTURA";
      $valor = "APERTURA";
      $var = 1;
      $item1 = "COD_USUARIO";
      $valor1 =$_SESSION["id_usu"];

      $nombres = explode("/",$_SESSION["idsucursal"]);
      $TOKEN_SUCURSAL=$nombres[0];

      $item2 = "COD_SUCURSAL";
      $valor2 = $TOKEN_SUCURSAL;
                          
      $cajaApertura = ControladorAperturas::ctrMostrarAperturasucursalCaja($item, $valor,$item1,$valor1,$item2,$valor2,$var);
     
        
      if(!$cajaApertura){

        $_SESSION["id_apertura"]= null;
        $_SESSION["gastos"]=null;

        echo '<script>

            window.location = "apertura";

            </script>';

      }else{

          $_SESSION["id_apertura"]= $cajaApertura["COD_APERTURA"];
          $_SESSION["nombreCaja"]= $cajaApertura["NROCAJA"];
          $_SESSION["cod_caja"]= $cajaApertura["COD_CAJA"].'/'.$cajaApertura["TOKEN_CAJA"];
          $_SESSION["gastos"]=null;
         
      }

      $cantidades =ControladorSucursales:: ctrMostrarCantidadSucursal(null, null);
     
      foreach ($cantidades as $key => $value){

        $avisoDescuento=$value["DESCUENTO"];
        $avisoCuota=$value["CUOTA"];
        $avisoStock=$value["AVISO_STOCK"];
          
      }

?>
<main class="app-content">

      <div class="app-title">
        <!--=====================================
          CABECERA LISTAR CUENTAS A PAGAR
        ======================================-->

        <div class="listarCuentasCobrar">

          <h4>Administrar Cuentas a Cobrar </h4>

          <div>

            <!--=====================================-->
            <button class="btn btn-primary btnNuevo" type="button" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Crear nuevo pago"><span class="d-none d-lg-block d-xl-block "> <i class="fas fa-plus-circle"></i> Agregar Nuevo</span> <span class="d-lg-none d-xl-none"> <i class="fas fa-plus-circle"></i></span></button>
            <!--======================================-->

            <!--=====================================-->
            <button class="btn">

              <select class="form-control select2 cmbClienteCuenta" id="cmbClienteCuenta" name="cmbClienteCuenta">

                <option value="">Seleccione un cliente</option>

                  <?php 

                    $item="cc.ESTADO_CUENTA";
                    $valor="CREDITO";
                    $where="WHERE cc.ESTADO_CUENTA = 'CREDITO' GROUP BY c.COD_CLIENTE";

                    $clientes = ControladorCuentasCobrar::ctrMostrarClientesCuentaCobrar($item, $valor, $where);
                      
                    foreach ($clientes as $key => $value) {

                      echo '<option value="'.$value["COD_CLIENTE"].'/'.$value["TOKEN_CLIENTE"].'" >'.$value["RUC"].' '.$value["CLIENTE"].'</option>';

                    }

                  ?>

              </select>

            </button>
            <!--=====================================-->

            <!--=====================================-->

            <button class="btn btn-primary daterange-btn" type="button" title="Buscar rangos de fecha" id="daterange-btn">
                  
              <span class="d-none d-lg-block d-xl-block "><i class="fa fa-calendar"></i>Movimiento Hoy <i class="fa fa-caret-down"></i></span><span class="d-lg-none d-xl-none"><i class="fa fa-calendar"></i><i class="fa fa-caret-down"></i></span>
                     
            </button> 

            <!--=====================================-->

            <!--=====================================-->
            <a href="cuentasCobrarCanceladas">
                <button class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Ir a Cuentas Canceladas" type="button" title=""><span class="d-none d-lg-block d-xl-block " ><i class="fa-solid fa-ban"></i> Cuentas Canceladas</span><span class="d-lg-none d-xl-none"><i class="fa-solid fa-ban"></i>
                </button> 
            </a>

            <!--=====================================-->

          </div>

        </div>

        <!--=====================================
          FIN CABECERA LISTAR CUENTAS A PAGAR
        ======================================-->

        <!--=====================================
          CABECERA CARGAR CUENTAS A PAGAR
        ======================================-->

        <div class="notblock cargarCuentasCobrar">

          <div>

            <div class="contador">

              <h5>Cuentas a Cobrar</h5>

                <button class="btn btn-primary btnListar" type="button" title="Agregar nuevo cobro"><i class="fas fa-plus-circle"></i> Listar Cuentas </button>
          
            </div>

          </div>
          
        </div>

        <ul class="app-breadcrumb breadcrumb">

            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>

            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>

          </ul>
        <!--=====================================
          FIN CABECERA CARGAR CUENTAS A PAGAR
        ======================================-->

      </div>

      <!--=====================================
        CONTENIDO DEL FORMULARIO
      ======================================-->

      <section class="content">

        <!--=====================================
        EL FORMULARIO PARA LISTAR CUENTAS A PAGAR
        ======================================-->

        <div class="row listarCuentasCobrar">

          <div class="col-md-12">

            <div class="tile">

              <div class="tile-body">

                <div class="table-responsive">
                  
                  <table class="table table-sm table-hover table-bordered tablaListadoCuentas" id="tablaListadoCuentas">

                    <thead>

                      <tr>

                        <th style="width:10px">#</th>
                        <th>Acciones</th>
                        <th>Nro Movimiento</th>
                        <th>Cliente</th>
                        <th>RUC</th>
                        <th>Fecha Venta</th>
                        <th>Fecha Venc.</th>
                        <th>Total Cuenta</th>
                        <th>Monto Cuota</th>
                        <th>Cuotas Pagadas</th>
                        <th>Saldo</th>
                        <th>Tipo Venta</th>
                        <th>Estado Cuenta</th>
                         
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

        <!--==========================================
        FIN DEL FORMULARIO PARA LISTAR CUENTAS A PAGAR
        ===========================================-->

        <!--=====================================
        EL FORMULARIO PARA CARGAR CUENTAS A PAGAR
        ======================================-->

        <div class="row notblock cargarCuentasCobrar">

          <div class="col-lg-6">
                
            <div class="tile" id="divProductos">

              <form method="post" id="formularioCobro" class="formularioCobro" onsubmit="return guardarFormulario()">

                <div class="box-body">
          
                  <div class="box">

                    <div class="form-row">

                      <!-- PRIMERA FILA -->
                      <div class="form-group col-md-6">

                        <div class="form-group">

                          <label class="control-label">Usuario</label>

                            <div class="input-group">

                              <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $_SESSION["id_usu"].'/'.$_SESSION["tokenUsuario"]; ?>">
                              <input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $_SESSION["idsucursal"]; ?>">
                              <input class="form-control" id="txtNombreUsuario" type="text" value="<?php echo $_SESSION["funcionario"].' - '.$_SESSION["usuario"]; ?>" readonly>

                            </div>

                        </div>

                      </div>

                      <!-- SEGUNDA FILA -->

                      <div class="form-group col-md-6">

                        <label class="control-label">Nº Caja</label>

                        <div class="input-group">
                      
                            <input type="hidden" name="idCaja" id="idCaja" value="<?php echo $_SESSION["cod_caja"]; ?>">
                            <input type="hidden" name="idApertura" id="idApertura" value="<?php echo $_SESSION["id_apertura"]; ?>">
                            <input class="form-control"  type="text" name="nombrecaja" value="<?php echo $_SESSION["nombreCaja"]; ?>" readonly>

                        </div>

                      </div>

                    </div>

                    <div class="form-row notblock">

                      <div class="form-group col-md-6">

                        <div class="form-group">

                          <label for="txtFechaVenta">Fecha de Cobro</label>

                          <input class="form-control" name="txtFechaPago" id="txtFechaPago" type="date" value="" placeholder="Seleccionar la fecha" required>

                        </div>
     
                      </div>                

                    </div>


                    <!--=========================================
                    ENTRADA PARA AGREGAR LOS PAGOS
                    ===========================================-->

                    <div class="form-group row nuevoProducto">

                    </div>


                    <div class="table-responsive">

                      <table class="table table-sm tablaCuentaCobrar" id="tablaCuentaCobrar">

                        <thead>

                          <tr>

                            <th><center><i class="fas fa-trash"></i></center></th>
                            <th class="notblock"><center>Código</center></th>
                            <th class="notblock"><center>Cantidad</center></th>
                            <th><center>N° Recibo</center></th>
                            <th><center>Auto.</center></th>
                            <th><center>Tipo Pago</center></th>
                            <th><center>N° Comprob.</center></th>
                            <th><center>Monto Cuota</center></th>
                            <th><center>Monto Pagar</center></th>
                             <th><center>Monto Saldo</center></th><!-- DEBO RECUPERAR EL SALDO -->

                          </tr>

                        </thead>

                        

                      </table>

                    </div>


                    <input type="hidden" id="listaDetalleCuenta" name="listaDetalleCuenta">

                    <hr>
                      
                    <!-- <button type="button" class="btn btn-primary float-right"><i class="fas fa-comment-dots" aria-hidden="true"></i> Comentario</button> -->

                    <!--=====================================
                    ENTRADA IMPUESTOS Y TOTAL
                    ======================================-->
                    
                    <!-- PRIMERA FILA -->
                    <div class="form-group">

                      <div class="form-group">

                        <label class="control-label"><h3>Total</h3></label>
                        <input class="form-control text-right" type="text" name="txtNuevoTotalCuenta" id="txtNuevoTotalCuenta" required readonly="">
                        <input type="hidden" name="txtTotalCuenta" id="txtTotalCuenta">

                      </div>

                    </div>

                    <hr>


                  </div>
                   
                </div>

                
                <div class="box-footer">

                  <div class="text-left">

                    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar Cobro</button>

                    <div class="text-right d-sm-none d-md-none d-lg-block d-xl-block">
                      
                         <h6>Items: </h6><h3 class="Can"></h3>
                        
                    </div>

                  </div>

                </div>

              </form>

            </div>
                    
          </div>

                 
          <!--=====================================
          LA TABLA DE PRODUCTOS
          ======================================-->
                
          <div id="cabecera" class="col-lg-6 col-xs-12 d-none d-lg-block d-xl-none d-none d-xl-block">

            <div class="bs-component" id="divcabecera" >

              <ul id="tab" class="nav nav-tabs">

                <li class="nav-item"><a class="nav-link active" data-toggle="tab" id="ventasCred" href="#ventasCredito">Ventas a Crédito</a></li>

                <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" id="ventasCreditoDet">Detalle de la venta</a></li> -->

                <li class="nav-item"><a class="nav-link" data-toggle="tab" id="facturaCancel" href="#facturaCancelada">Facturas Canceladas</a></li>
                                 
              </ul>

              <div class="tab-content" id="myTabContentCuenta">

                <div class="tab-pane fade active show" id="ventasCredito">

                    <div class="tile">

                      <div class="tile-body">

                        <div class="table-responsive">

                          <div class="form-row">

                            <div class="form-group col-md-12">
                        
                              <label class="control-label">Clientes:</label>
                              
                              <div class="form-group">
                               
                                <select class="form-control select2" id="cmbClienteCuentas" name="cmbClienteCuentas" required>

                                  <option value="">Seleccione el Cliente</option>

                                  <?php

                                    $item="cc.ESTADO_CUENTA";
                                    $valor="CREDITO";
                                    $where="WHERE cc.ESTADO_CUENTA = 'CREDITO' GROUP BY c.COD_CLIENTE";

                                    $clientes= ControladorCuentasCobrar::ctrMostrarClientesCuentaCobrar($item, $valor, $where);
                                    // var_dump($proveedores);
                                    // return;
                               
                                    foreach ($clientes as $key => $value) {

                                      echo '<option value="'.$value["COD_CLIENTE"].'/'.$value["TOKEN_CLIENTE"].'" >'.$value["RUC"].' '.$value["CLIENTE"].'</option>';

                                    }

                                  ?>

                                </select>

                              </div>

                            </div>

                          </div>


                          <table class="table table-sm table-hover table-bordered tablaCuentasCobrar">

                            <thead>

                              <tr>

                                <th>Acciones</th>
                                <th>N° Movimiento</th>
                                <th>Fecha Venta</th>
                                <th>Fecha Venc.</th>
                                <th>Cuotas Pagadas</th>
                                <th>Monto Cuota</th>
                                <th>Monto Total</th>
                                <th>Saldo</th>

                              </tr>

                            </thead>

                             <tbody>

                            </tbody>

                          </table>

                        </div>

                      </div>

                    </div>
                     
                </div>

                <div class="tab-pane fade" id="facturaCancelada">

                    <div class="tile">

                      <div class="tile-body">

                        <div class="table-responsive">

                          <div class="form-row">

                            <div class="form-group col-md-12">
                        
                              <label class="control-label">Clientes:</label>
                              
                              <div class="form-group">
                               
                                <select class="form-control select2" id="cmbClienteCuentaCancelada" name="cmbClienteCuentaCancelada" required>

                                  <option value="">Seleccione el Cliente</option>

                                  <!-- INNER JOIN CON CUENTAS A PAGAR PARA FILTRAR PROVEEDORES A QUIENES SE DEBE -->

                                  <?php

                                    $item="cc.ESTADO_CUENTA";
                                    $valor="CANCELADO";
                                    $where="WHERE cc.ESTADO_CUENTA = 'CANCELADO' GROUP BY c.COD_CLIENTE";

                                    $clientes= ControladorCuentasCobrar::ctrMostrarClientesCuentaCobrar($item, $valor, $where);
                                    // var_dump($proveedores);
                                    // return;
                               
                                    foreach ($clientes as $key => $value) {

                                      echo '<option value="'.$value["COD_CLIENTE"].'/'.$value["TOKEN_CLIENTE"].'" >'.$value["RUC"].' '.$value["CLIENTE"].'</option>';

                                    }

                                  ?>

                                </select>

                              </div>

                            </div>

                          </div>

                          <table class="table table-sm table-hover table-bordered tablaCuentasCanceladas">

                            <thead>

                              <tr>
                                <th>Acciones</th>
                                <th>N° Movimiento</th>
                                <th>Fecha Venta</th>
                                <th>Fecha Venc.</th>
                                <th>Cuotas Pagadas</th>
                                <th>Monto Cuota</th>
                                <th>Monto Total</th>
                                <th>Saldo</th>
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

        <!--==========================================
        FIN DEL FORMULARIO PARA CARGAR CUENTAS A PAGAR
        ===========================================-->

      </section>

      <div class="notblock cargarCuentasCobrar">
      
        <button class="botonF1 d-xl-none d-lg-none" style="bottom:10px;right:10px;position:fixed;z-index:9999;" id="botonFlotante">
           <span><i class="fas fa-cart-arrow-down"></i><h6 class="texto-encima Can" style="bottom:10px;right:10px;position:fixed;z-index:9999;">0</h6></span>
        </button>
        
      </div>    

</main>

<!--============================================= 
  MODAL - VER DETALLES DE CUENTA A COBRAR
=============================================-->
<div class="modal fade" id="ModalVerDetalle" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="background:#464775; color:white">

        <h6 class="modal-title" id="titulo">Detalle de la Venta</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <!-- FORMULARIOS -->
        <form  method="post" name="formCuentaDetalle" id="formCuentaDetalle" onsubmit="">

          <!-- =========================================== -->
          <div class="card rounded-lg card-secondary card-outline">
                  
            <div class="card-header pl-2 pl-sm-3">

              <h5>Venta</h5>

            </div>

            <!-- =========================================== -->
            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
            <div style="margin: 10px;">

              <div class="form-row" >

                <!-- PRIMERA FILA -->
                <div class="form-group col-md-4">

                  <div class="form-group">

                    <label class="control-label">Cliente </label>

                    <input class="form-control" type="text" name="txtCli" id="txtCli" readonly required>

                  </div>

                </div>

                <!-- SEGUNDA FILA -->
                <div class="form-group col-md-4">

                  <div class="form-group">
                  
                    <label class="control-label">Usuario </label>
                    <input class="form-control" type="text" name="txtUsuario" id="txtUsuario" readonly required>

                  </div>

                </div>

                <!-- TERCERA FILA -->
                <div class="form-group col-md-4">

                  <div class="form-group">

                    <label class="control-label">Sucursal </label>

                    <input class="form-control" type="text" name="txtSucursal" id="txtSucursal" readonly required>

                  </div>

                </div>
        
              </div>

              <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->

              <div class="form-row" >

                <!-- PRIMERA FILA -->
                <div class="form-group col-md-3">

                  <div class="form-group">

                    <label class="control-label">Nro Movimiento </label>

                    <input class="form-control" type="text" name="txtNroFactura" id="txtNroFactura" readonly required>

                  </div>

                </div>

                <!-- SEGUNDA FILA -->
                <div class="form-group col-md-3">

                  <div class="form-group">
                  
                    <label class="control-label">Fecha Venta </label>
                    <input class="form-control" type="text" name="txtFechaVenta" id="txtFechaVenta" readonly required>

                  </div>

                </div>

                <!-- TERCERA FILA -->
                <div class="form-group col-md-3">

                  <div class="form-group">
                  
                    <label class="control-label">Forma Pago </label>
                    <input class="form-control" type="text" name="txtTipoPago" id="txtTipoPago" readonly required>

                  </div>

                </div>

                <!-- CUARTA FILA -->

                <div class="form-group col-md-3">

                  <div class="form-group">
                  
                    <label class="control-label">Total Venta </label>
                    <input class="form-control" type="text" name="txtTotalVenta" id="txtTotalVenta" readonly required>

                  </div>

                </div>
        
              </div>

              <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->

              <div class="form-row" >
        
              </div>

            </div>

          </div>

          <br>

          <!-- =========================================== -->
          <div class="card rounded-lg card-secondary card-outline">
                  
            <div class="card-header pl-2 pl-sm-3">

              <h5>Detalles de la Venta</h5>

            </div>

            <div style="margin: 5px;">

              <div class="table-responsive">

                <table class="table table-sm table-hover table-bordered tablaCuentaDetalle" id="tablaCuentaDetalle">

                  <thead>

                    <tr>

                      <th style="width:10px">#</th>
                      <th style="width:10px">Cod. Barra.</th>
                      <th>Producto</th>
                      <th>Cantidad</th>
                      <th>Precio</th>
                      <th>Descuento</th>
                      <th>Stock Anterior</th>
                      <th>Importe</th>

                    </tr>

                  </thead>

                  <tbody>
                  
                  </tbody>

                </table>

              </div>

            </div>

          </div>

          <!-- =========================================== -->

          <div class="modal-footer">

            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <!-- <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button> -->

          </div>

        </form>
                   
      </div>

    </div>

  </div>

</div>

<!--============================================= 
  MODAL - VER HISTORIAL DE COBRO
=============================================-->
<div class="modal fade" id="ModalVerCobro" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="background:#464775; color:white">

        <h6 class="modal-title" id="titulo">Historial de Cobro</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <!-- FORMULARIOS -->
        <form  method="post" name="formCuentaHistorial" id="formCuentaHistorial">

          <br>

          <div class="card rounded-lg card-secondary card-outline">
                  
            <div class="card-header pl-2 pl-sm-3">

              <h5>Datos del Cliente:</h5>

            </div>

            <!-- =========================================== -->
            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
            <div style="margin: 10px;">

              <div class="form-row" >

                <!-- PRIMERA FILA -->
                <div class="form-group col-md-3">

                  <div class="form-group">

                    <label class="control-label">Cliente </label>

                    <input class="form-control" type="text" name="txtCliente" id="txtCliente" readonly required>

                  </div>

                </div>

                <!-- SEGUNDA FILA -->
                <div class="form-group col-md-3">

                  <div class="form-group">
                  
                    <label class="control-label">RUC </label>
                    <input class="form-control" type="text" name="txtRuc" id="txtRuc" readonly required>

                  </div>

                </div>

                <!-- PRIMERA FILA -->
                <div class="form-group col-md-3">

                  <div class="form-group">

                    <label class="control-label">Teléfono </label>

                    <input class="form-control" type="text" name="txtTelefono" id="txtTelefono" readonly required>

                  </div>

                </div>

                <!-- SEGUNDA FILA -->
                <div class="form-group col-md-3">

                  <div class="form-group">
                  
                    <label class="control-label">Total</label>

                    <input class="form-control" type="text" name="txtTotal" id="txtTotal" readonly required>

                  </div>

                </div>
        
              </div>

              <label class="control-label">Observaciones</label>

              <div class="input-group mb-12">

                <textarea class="form-control input-lg" style="color: red;" name="txtComentario" id="txtComentario" rows="3" cols="50" placeholder="Escribir comentario (opcional)"></textarea>  

                <div class="input-group-append">
                  <button class="btn btn-primary btn-sm" id="agregarComentario" idCuenta="" type="button"> <i class="fas fa-save" aria-hidden="true"  title="" data-original-title="Guardar Observación"></i></button>
                </div>

              </div>

            </div>

          </div>

          <br>

          <!-- =========================================== -->
          <div class="card rounded-lg card-secondary card-outline">
                  
            <div class="card-header pl-2 pl-sm-3">

              <div class="form-row">

                <div class="form-group col-md-6">

                  <h5>Historial de Cobro</h5>

                </div>

                <div class="form-group col-md-6">
                  <label class="control-label float-right h5">Dias Adelantado:  <span id="txtDiasAdelanto" class="h4"></span></label>
                </div>
                
              </div>


            </div>

            <div style="margin: 5px;">

              <div class="table-responsive">

                <table class="table table-sm table-hover table-bordered tablaCuentaHistorial" id="tablaCuentaHistorial">
                  <!-- <table class="table table-responsive-sm table-bordered tablaCuentaHistorial" id="tablaCuentaHistorial"> -->

                  <thead>

                    <tr>

                      <th>#</th>
                      <th>Acciones</th>
                      <!-- <th>Nro Movimiento</th> -->
                      <th>N° Recibo</th>
                      <th>Tipo Recibo</th>
                      <th>Método Pago</th>
                      <th>Monto Pago</th>
                      <th>Fecha Venc.</th>
                      <th>Fecha Pago</th>
                      <th>Dias Adelanto</th>
                      <th>Saldo</th>
                      <th>Usuario</th>

                    </tr>

                  </thead>

                  <tbody>
                  
                  </tbody>

                </table>

              </div>

            </div>

          </div>

          <!-- =========================================== -->

          <div class="modal-footer">

            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <!-- <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button> -->

          </div>

        </form>
                   
      </div>

    </div>

  </div>

</div>

<!--============================================= 
  MODAL - VER HISTORIAL DE COBRO
=============================================-->
<div class="modal fade" id="modalVerAnulado" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="background:#464775; color:white">

        <h6 class="modal-title" id="titulo">Historial de Cobro</h6>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <!-- FORMULARIOS -->
        <form  method="post" name="formCuentaHistorial" id="formCuentaHistorial">

          <br>

          <div class="card rounded-lg card-secondary card-outline">
                  
            <div class="card-header pl-2 pl-sm-3">

              <h5>Datos del Cliente:</h5>

            </div>

            <!-- =========================================== -->
            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
            <div style="margin: 10px;">


            </div>

          </div>

          <!-- =========================================== -->

          <div class="modal-footer">

            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <!-- <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button> -->

          </div>

        </form>
                   
      </div>

    </div>

  </div>

</div>

<script src="vistas/js/cuentasCobrar.js"></script>

<script type="text/javascript">
  $('.bs-component [data-toggle="popover"]').popover();
  $('.bs-component [data-toggle="tooltip"]').tooltip();
</script>
