<?php 

  $item = "ESTADO_APERTURA";
  $valor = "APERTURA";
  $var=1;
  $item1 = "COD_USUARIO";
  $valor1 =$_SESSION["id_usu"];

  $nombres = explode("/",$_SESSION["idsucursal"]);
  $TOKEN_SUCURSAL=$nombres[0];

  $item2 = "COD_SUCURSAL";
  $valor2= $TOKEN_SUCURSAL;
                          
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
      
   <!-- EMPIEZA LA CABECERA DEL DOCUMENTO -->

  <div class="app-title">         

    <div class="ListarContenido">

      <h4>Administrar ventas emitidas</h4>



        <!-- BOTONES PARA NUEVO ESTA EN DOS DIV PARA AJUSTAR EL TAMAÑO -->

        <div class="p-1">

          <button class="btn btn-primary" id="btnNuevo" type="button" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Crear nueva venta"><span class="d-none d-lg-block d-xl-block "> <i class="fas fa-plus-circle"></i> Agregar Nuevo</span> <span class="d-lg-none d-xl-none"> <i class="fas fa-plus-circle"></i></span></button> 

          <button class="btn btn-primary daterange-btn" type="button" title="Buscar rangos de fecha" id="daterange-btn"><span class="d-none d-lg-block d-xl-block "><i class="fa fa-calendar"></i>Movimiento Hoy <i class="fa fa-caret-down"></i></span><span class="d-lg-none d-xl-none"><i class="fa fa-calendar"></i><i class="fa fa-caret-down"></i></span></button> 

          <a href="ventasAnulada">
           <button class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Ir a ventas anuladas" type="button" title=""><span class="d-none d-lg-block d-xl-block " ><i class="fa-solid fa-ban"></i> Ventas anuladas</span><span class="d-lg-none d-xl-none"><i class="fa fa-ban"></i></button> 

          </a>


        </div>

    </div>
      <!-- CARGAR EL BOTON DE LA VENTA -->
    <div class="CargarVenta  notblock">
            
      <h3 class="text-gray-dark" id="titulo">Cargar ventas</h3>
     
        <button class="btn btn-primary btnListar" type="button"><i class="fas fa-th-list"></i> Listar ventas</button>
        <button class="btn btn-danger btncancelar" type="button"><i class="fa fa-window-close-o"></i>Cancelar</button>

    </div>


    <ul class="app-breadcrumb breadcrumb">

      <li class="notblock salir" title="Salir pantalla completa"  id="salir"><a href="#" title="Pantalla completa"><i class="fa-solid fa-minimize"></i></a></li>
      <li class="breadcrumb-item fullscreen"  id="fullscreen"><a href="#" title="Pantalla completa"><i class="fas fa-expand-arrows-alt"></i></a></li>
      <li class="breadcrumb-item"><a href="inicio"><i class="fa fa-home fa-lg"></i></a></li>
      <li class="breadcrumb-item"><a href="ventas">Ventas</a></li>

    </ul>

  </div>

     <!-- TERMINA LA CABECERA DEL DOCUMENTO -->

<section class="content">



  <div class="row CargarVenta  notblock">

    <div id="cabecera" class="col-lg-5 col-xs-12 d-none d-lg-block d-xl-none d-none d-xl-block">
            
      <div class="tile" id="divcabecera">

        <form onsubmit="return Guardarformulario()" method="post" id="formVenta" class="formularioVenta">

          <div class="box-body">
      
             <div class="box">
                <label class="control-label notblock">Usuario</label>
                <input type="hidden" name="idventas" id="idventas">
                <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $_SESSION["id_usu"].'/'.$_SESSION["tokenUsuario"]; ?>">
                <input type="hidden" name="idSucursal" id="idSucursal" activo=1 value="<?php echo $_SESSION["idsucursal"]; ?>">
                <input class="form-control" id="txtNombreUsuario" type="hidden" value="<?php echo $_SESSION["funcionario"].' - '.$_SESSION["usuario"]; ?>" readonly>
                <input type="hidden" id="avisoStock" value="<?php echo $avisoStock; ?>">
                <input type="hidden" id="avisodescuento" value="<?php echo $avisoDescuento; ?>">
                <input type="hidden" id="avisocuota" value="<?php echo $avisoCuota; ?>">
                <input type="hidden" id="idPedidos" name="idPedidos">
          
                    <!--=====================================
                    ENTRADA DEL VENDEDOR
                    ======================================-->
                <div class="form-row">

                      <!-- PRIMERA FILA -->
                  <div class="form-group col-lg-6">

                    <!--=====================================
                      ENTRADA PARA LA COMPRA
                    ======================================-->                    
                    <label class="control-label" id="lblFactura">N° Factura.</label>
                    <div class="input-group">
                           
                      <?php


                        $item = "EST_CAJA";
                        $valor = 1;
                        $nombres = explode("/",$_SESSION["cod_caja"]);
                        $TOKEN_CAJA=$nombres[1];
                        $item1 ="TOKEN_CAJA";
                        $valor1 =$TOKEN_CAJA;
                        $var=1;
                        $max = ControladorCajas::ctrMostrarCajaSucursal($item, $valor,$item1, $valor1,$var);
                                  
                        $maximoMovimiento=0;
                              //var_dump($max);
                        if(!$max){

                          echo '<input type="text" class="form-control input-lg" id="nuevaVenta" name="nuevaVenta" value="'.'00'.$_SESSION["nroverificadorSucural"].'-'.'00'.$max["NRO_VERIFICADOR"].'-'.'1'.'" readonly>
                                    <input type="hidden" class="form-control input-lg" id="Verificador" name="Verificador" value="'.'00'.$max["NRO_VERIFICADOR"].'" readonly>';

                        }else{
                          $maximoMovimiento=$max["NRO_FACTURA"]+1;
                          echo '<input type="text" class="form-control input-lg" id="nuevaVenta" name="nuevaVenta" value="'.'00'.$_SESSION["nroverificadorSucural"].'-'.'00'.$max["NRO_VERIFICADOR"].'-'.$maximoMovimiento.'" readonly>
                                 <input type="hidden" class="form-control input-lg" id="Verificador" name="Verificador" value="'.'00'.$_SESSION["nroverificadorSucural"].'-'.'00'.$max["NRO_VERIFICADOR"].'" readonly>';

                        }
                              
                      ?>

                    </div>

                  </div>

                  <div class="form-group col-lg-6">

                    <label class="control-label">Nº Caja</label>
                    <div class="input-group">
                      
                      <input type="hidden" name="idCaja" id="idCaja" value="<?php echo $_SESSION["cod_caja"]; ?>">
                      <input type="hidden" name="idApertura" value="<?php echo $_SESSION["id_apertura"]; ?>">
                      <input class="form-control"  type="text" name="nombrecaja" value="<?php echo $_SESSION["nombreCaja"]; ?>" readonly>
                    </div>

                  </div>

                  <div class="notblock form-group col-lg-6">
                    <div class="form-group">
                      <label for="txtFechaVenta">Fecha venta</label>
                      <input class="form-control" name="txtFechaVenta" id="txtFechaVenta" type="date" value="<?php date_default_timezone_set("America/Asuncion");echo date('Y-m-d'); ?>" placeholder="Seleccionar la fecha">
                    </div>

                  </div>

                     
                </div>


                   <!--=====================================
                          ENTRADA EL CLIENTE
                    ======================================-->
              <div class="form-row">

                      <!-- PRIMERA FILA -->
                  <div class="form-group col-md-12">
                        
                          <!--=====================================
                          ENTRADA EL CLIENTES
                          ======================================-->
                  
                    <label class="control-label">Clientes:</label>
                       
                    <div class="messanger">  
                      <div class="sender">
                         
                        <select class="form-control select2" id="cmbClientes" name="cmbClientes"  style="width: 92%;" required>

                          <option value="">Seleccione un cliente</option>

                           <?php 
                            $item="ESTADO_CLIENTE";
                            $valor=1;
                            $var=null;
                            $Clientes= ControladorClientes::ctrMostrarCliente($item, $valor, $var);
                                                 
                           foreach ($Clientes as $key => $value) {

                             echo '<option value="'.$value["COD_CLIENTE"].'/'.$value["TOKEN_CLIENTE"].'/'.$value["TIPO_CLIENTE"].'/'.$value["CATEGORIA_CLIENTE"].'" >'.$value["RUC"].' '.$value["CLIENTE"].'</option>';


                            }

                            ?>

                        </select>


                        <div class="input-group-append">
                          <button class='btn btn-info btn-sm' id="agregarCliente" type="button" data-dismiss="modal" data-toggle="modal" data-target="#ModalClientes"> <i class="fas fa-plus-square"></i></button>
                        </div>
                      </div>
                    </div>

                  </div>

              </div>


                <!-- ======================================================================================================= -->

              <div class="form-group notblock" id="Vertipoclientes">
                <label class="control-label">Tipo cientes</label>
                <div class="input-group mb-3">
                  <input class="form-control" type="text" name="txtTipoClientes" id="txtTipoClientes" readonly>
                  <div class="input-group-append" id="ver">
                    <button class='btn btn-info btn-sm ' id="Verdescuento" type="button"><i class='fa fa-eye text-white'></i></button>
                    <button class='btn btn-info btn-sm notblock' id="nodescuento" type="button"><i class='fa fa-eye-slash text-white' ></i></button>
                  </div>
                </div>

              </div>


                <!-- =========================================== -->

              <div class="notblock" id ="tablaOcultar">

                <table class="table table-responsive-sm table-bordered" id="TablaDescuento">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Cantidad desde</th>
                      <th>Cantidad hasta</th>
                      <th>Descuento</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>

                
                <!-- =========================================== -->

                            <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
              <div class="form-row">

                <div class="form-group col-md-6">
                  <div class="form-group">
                    <label for="cmbEstado">Seleccione tipo de movimiento</label>
                    <select class="form-control" name="cmbTipoMovimiento" id="cmbTipoMovimiento">
                      <option value="FACTURA">FACTURA</option>
                      <option value="TICKET">TICKET</option>                         
                    </select>
                  </div>

                </div>


                <div class="form-group col-md-6">
                  <div class="form-group">
                    <label for="cmbEstado">Seleccione forma de pago</label>
                    <select class="form-control" name="cmbFormaPago" id="cmbFormaPago" required>
                      <option value="CONTADO">CONTADO</option>
                      <option value="CREDITO">CRÉDITO</option>
                    </select>
                  </div>

                </div>

                    
              </div>


                         
  <!-- =========================================================================================================================== -->

                <!-- TABLA PARA AGREGAR LOS PRODUCTOS A SER REMITIDOS -->
                  <div class="text-left d-sm-none d-md-none d-lg-block d-xl-block">
                   <strong><label for="">Items: <span class="Can">0</span></label></strong>                       
                </div> 
              <hr>
              <div class="table-responsive" id="carritoVenta">

                <table class="table table-sm table-hover table-bordered"   id="tablaVenta">

                  <thead>

                    <tr class="cabecera">
                      <th style="width:5px">#</th>
                      <th><center style="width:20px"><i class="fa-solid fa-trash"></i></center></th>
                      <th><center style="width:60px">Cantidad.</center></th>
                      <th><center  style="width:100px">Precio venta</center></th>
                      <th><center  style="width:100px">SubTotal</center></th>
                      <th><center style="width:100px">Código <i class="fas fa-barcode"></i></center></th>
                      <th><center style="width:250px">Producto</center></th>                
                      <th><center style="width:100px">Descuento</center></th>
                      <th><center style="width:100px">Precio Normal</center></th>
                      <th class="notblock"><center>OFERTA</center></th>
                    </tr>

                  </thead>
                  <tbody></tbody>

                </table>

              </div>

                <!-- ==================================================================================================== -->


                <!-- LISTAR LOS PRODUCTOS A SER GUARDADOS -->

               
                <!-- ===================================================================================================== -->
              <hr>

               <!--=====================================
                  ENTRADA IMPUESTOS Y TOTAL
                  ======================================-->
                
                  <!-- PRIMERA FILA -->
              <div class="form-group">

                <div class="form-group">
                  <label class="control-label"><h5>Sub Total</h5></label>
                  <input class="form-control text-right" type="text" name="txtTotalsindescuento" id="txtTotalsindescuento" value="0" required readonly="">
                </div>
              </div>    
              <input class="form-control text-right" type="hidden" name="txtTotalSinOferta" id="txtTotalSinOferta" value="0" required readonly="">

              <div class="form-group">
                  <label class="control-label"><h5>Descuento</h5></label>
                  <input class="form-control text-right" type="text" name="txtTotalDescuento" id="txtTotalDescuento" value="0" required readonly="">
              </div>


                         <!-- PRIMERA FILA -->
              <div class="form-group">
                <label class="control-label"><h5>Total a cobrar</h5></label>
                <input class="form-control text-right" type="text" name="txtTotal" id="txtTotal" value="0" required readonly="">
              </div>

               <!-- ===================================================================================================== -->
                 
                <hr>

                <!-- ENTRADA PARA EL BOTON GUADAR DATOS -->
              <div class="box-footer">

                <div class="text-left">
                  <button type="button" class="btn btn-primary" id="btnGuardarContado" data-dismiss="modal" data-toggle="modal" data-target="#ModalMetodoPagos"><i class="fa-solid fa-share"></i> Guardar</button> 

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
              echo '<li class="nav-item"><a class="nav-link active" data-toggle="tab" id="ProductoSucursalActual" href="#prodcuctoActualSucursal">Sucursal Actual</a></li>
                  <li class="nav-item"><a class="nav-link" data-toggle="tab" id="ProductoActivoOtros" href="#prodcuctoActualSucursal">Otras sucursales</a></li>';
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

                   <!-- GRUPO DE BOTONES PARA BUSCAR MAS VENDIDOS Y RECIENTE -->

                  <div class="bs-component" id="VerporTipo">

                    <div class="alert alert-dismissible alert-info">

                      <div class='btn-group'>
                        <button class='btn btn-info btn-sm ' id="btnTodosProductos" title="Todos los productos"> <i class='fa fa-list-alt'></i></button>
                        <button class='btn btn-dark btn-sm ' id="btncombos" title="Combos de productos"><i class='fa fa-newspaper-o'></i></button>
                        <button class='btn btn-primary btn-sm ' id="btnServicios" title="Servicios"><i class="fa-solid fa-user-gear"></i></button>
                        <button class='btn btn-danger btn-sm' id="btnfletes" title="Ver fletes"><i class='fa fa-truck'></i></button>
                        <button class='btn btn-warning btn-sm ' id="btnMasReciente" title="Reciente"> <i class='fa fa-clock-o'></i></button>
                        <button class='btn btn-success btn-sm ' id="btnMasVendidos" title="Mas vendidos"><i class='fa fa-money'></i></button>

                        
                       
                      </div>

                     <div class='btn-group'>
                       <h5 class="text-info text-lg-center" id="TextoPlataforma">Todos</h5>
                     </div>


                  </div>
                </div>

                    <!-- Busqueda por codigo de barra -->

                  <div class="form-row CodigoBarra" >

                    <!-- PRIMERA FILA -->
                    <div class="form-group col-12">
                       <label class="control-label"><span class="text-primary">Buscar por código barra</span></label>
                       <div class="input-group mb-3">
                        <input class="form-control" type="text" name="txtCodigoBarra" id="txtCodigoBarra" value="" placeholder="Ingresar el codigo de barra a buscar">
                         <div class="input-group-append">
                          <button class='btn btn-success btn-sm' id="btnBusacarCodigoBarra" title="Buscar productos" type="button"><i class='fas fa-plus-square'></i></button>
                        </div>
                        <div class="input-group-append">
                          <button class='btn btn-primary btn-sm' id="btnActualizarProducto" title="Actualizar productos" type="button"><i class='fa-solid fa-rotate-right'></i></button>
                        </div>
                      </div>
                                         
                    </div>

                  </div>
         
                  <div class="table-responsive" id="tablaProductos">

                    <table class="table table-sm table-hover table-bordered tablaProductos">

                      <thead>

                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Accion</th>
                          <th>Código</th>
                          <th style="width: 250px">Descripcion</th>
                          <th style="width: 250px">Marca</th>
                          <th>Stock</th>
                          <th >Precio venta</th>
                          <th >Oferta</th>
                          <th >Imagen</th>
                          <th >Tipo producto</th>
                          <th >Sucursal</th>
                          <th class="notblock">Porcentaje</th>
                          <th class="notblock">Precio Normal</th>
                          <th class="notblock">Descuento</th>
                          <th class="notblock">token</th>
                          <th class="notblock">cod canal</th>
                        

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
        <!-- PRE-VENTA -->
        <div class="col-lg-6">
          <div class="tile">
          <!--   <div class="card-body d-flex justify-content-between align-items-center">
 -->
              <div class="row">
             
                   <!-- PRIMERA FILA -->
                    <div class="form-group col-12">
                       
                       <div class="input-group">
                          <select class="input-group form-control" id="cmbNuetoTipoVenta" name="cmbNuetoTipoVenta" required>
                          <option value="PRE-VENTAS">PRE-VENTAS</option>
                          <option value="PEDIDOS">PEDIDOS</option>
                          <option value="PRESUPUESTOS">PRESUPUESTOS</option>
                          </select>
                        
                         <div class="input-group-append">
                           <button class='btn btn-primary btn-sm' id="btnActualizarPreventa" title="Actualizar Pre venta"><i class="fa-solid fa-rotate-right"></i></button>
                        </div>
                       </div>
                    
                                         
                    </div>


                <div class="col-12">
                  <h5 id="TextoNuevotipoventa">PRE VENTAS</h5>

                </div>



              </div>
              

           
           <!--  </div> -->
                           
            <div class="tile-body">
                 
              <div class="table-responsive">
                <input type="hidden" name="idSucursales" id="idSucursales" activo=1 >

                <table class="table table-hover table-bordered tablasVerPedidos">

                  <thead>
                    <tr>

                        
                      <th>#</th>
                      <th>Acciones</th>
                      <th>Ruc/Cédula</th>
                      <th>Clientes </th>
                      <th>Fecha</th>
                      <th>Total</th>
                      <th>Sucursal</th>
                      <th>Usuario</th>
                                    
                    </tr>
                  </thead>

                  <tbody></tbody>
                </table>

              </div>
            </div>
          </div>
        </div>

                <!-- ================================================================================================ -->

          <!-- POST VENTA -->
        <div class="col-lg-6">
          <div class="tile">
            <h5>VENTA</h5>
            <div class="tile-body">
              
              <div class="table-responsive">
                <input type="hidden" name="idSucursales" id="idSucursales" activo=1 >

                <table class="table table-hover table-bordered tablasVerVentas">

                  <thead>
                    <tr>

                      <th>#</th>
                      <th>Acciones</th>
                      <th>Nº Factura</th>
                      <th>Fecha</th>
                      <th>Total venta </th>
                      <th>Forma de pago</th>
                      <th>Tipo de pago</th>
                      <th>Metodo de pago</th>
                      <th>Clientes </th>
                      <th>Sucursal</th>
                      <th>Usuario</th>
                    </tr>
                  </thead>

                  <tbody></tbody>
                </table>

              </div>
            </div>
          </div>
        </div>
                <!-- =============================================== -->


      </div>
    </div>
      <!-- TERMINA EL LISTADO DEL COMBO BOX -->

    </section>


    <div class="notblock CargarVenta">
      
      <button class="botonF1 d-xl-none d-lg-none" style="bottom:10px;right:10px;position:fixed;z-index:9999;" id="botonFlotante">
         <span><i class="fas fa-cart-arrow-down"></i><h6 class="texto-encima Can" style="bottom:10px;right:10px;position:fixed;z-index:9999;">0</h6></span>
      </button>
    </div>

</main>



 <!-- MODAL PARA VER LOS DETALLES DE LA TRANSFERENCIA DE PRODUCTO -->

<!-- Modal -->
<div class="modal fade" id="ModalDetVenta" tabindex=null role="dialog" >

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="background:#464775; color:white">

        <h6 class="modal-title" id="titulo">Detalle venta</h6>

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

                    <table class="table table-hover table-bordered tablasDetVenta">

                      <thead>
                        <tr>
                          <th>#</th>
                          <th >Nº Factura</th>
                          <th >Fecha</th>
                          <th>Forma de pago</th>
                          <th>Tipo de pago</th>
                          <th >Metodo de pago</th>
                          <th>Clientes </th>
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



 <!-- MODAL PARA VER LOS DETALLES DE LA TRANSFERENCIA DE PRODUCTO -->

<!-- Modal -->
<div class="modal fade" id="ModalDetPedidos" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="background:#464775; color:white">

        <h6 class="modal-title" id="titulo">Detalle pre-venta</h6>

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
                  
                    <table class="table table-hover table-bordered tablasDetPedidos">

                      <thead>
                        <tr>
                          <th>#</th>
                          <th >Fecha</th>
                          <th>Clientes </th>
                          <th>Cod. barra</th>
                          <th>Productos</th>
                          <th>Cantidad</th>
                          <th>Prec. Unitario</th>
                          <th>Prec. Neto</th>
                          <th>Usuario</th>
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

<!--==========================================
                MODAL AGREGAR 
  ===========================================-->

  <div class="modal fade" id="ModalClientes" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

     <div class="modal-dialog modal-lg">

      <div class="modal-content">

        <form method="post" name="formClientes" id="formCliente" onsubmit="return GuardarFormularioClientes()">
          
           <div class="modal-header" style="background:#464775; color:white">

              <h6 class="modal-title" id="titulo">Nuevo cliente</h6>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true">&times;</span>

              </button>

          </div>

          <div class="modal-body" id="modalBody" style="display: block;">

            <input class="form-control" type="hidden" name="idCliente"  id="idCliente" value="">

            <input class="form-control" type="hidden" name="tokenCliente" id= "tokenCliente" value="">

             <!-- INPUT DE TEXTO PARA CARGAR EL NOMBRE Y EL RUC DEL CLIENTE -->
                  
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


             <!-- INPUT DE SELECCIONAMOS LA CIUDAD EL TIPO DE CLIENTES -->

            <div class="form-row" >

              <!-- PRIMERA FILA -->
              <div class="form-group col-md-6">
            

                  <label class="control-label">Ciudad <span style="color:red">*</span></label>

                  <div class="form-group">

                  <select class="input-control select2" name="cmbCiudad" id="cmbCiudad" required="">
                    
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

                
                </div>

              </div>

                <!-- SEGUNDAD FILA -->
              <div class="form-group col-md-6">
              
                <label class="control-label">Canal <span style="color:red">*</span></label>

                 <div class="form-group">

                 <select class="input-control select2" name="cmbTipoCliente" id="cmbTipoCliente" required>

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
                    <option value="D">D</option>
                    <option value="C">C</option>
                    <option value="B">B</option>
                    <option value="A">A</option>
                         
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
                                          
                  </select>

              </div>

            </div>

        <!-- =========================================== -->


         <div class="modal-footer d-flex justify-content-between align-items-start">
              <div class="input-group-append">
                                 
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                          
                <button type="button" class="btn btn-primary " id="btnGuardarClientes">Guardar</button>
              </div> 
            
            </div>

  
         <!--    <div class="modal-footer">

              <div>
                <button type="button" class="btn btn-danger" id="btnCerrar" data-dismiss="modal" style="display: block;">Cerrar</button>
              </div>

              <div>
                <button type="submit" class="btn btn-primary" id="btnGuardarClientes" style="display: block;">Guardar</button>
              </div>

            </div> -->


      </div>

        </form>

      </div>

    </div>

  </div>





  <!--==========================================
               METODO DE PAGOS
  ===========================================-->

  <div class="modal fade" id="ModalMetodoPagos" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

     <div class="modal-dialog modal-lg">

      <div class="modal-content">
          
           <div class="modal-header" style="background:#464775; color:white">

              <h6 class="modal-title" id="titulo">Procesar Venta</h6>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true">&times;</span>

              </button>

          </div>

          <div class="modal-body" id="modalBody" style="display: block;">

            <div class="row">
              
              <div  class="form-group col-lg-6 col-md-6">

                <label for="totalventanuevo">TOTAL COBRAR.</label>
                <input class="form-control text-right" name="totalventanuevo" id="totalventanuevo" type="text" readonly> 

              </div>


              <div  class="form-group col-lg-6 col-md-6">

                <label for="totalNuevoDescuento">TOTAL DESCUENTO.</label>
                <input class="form-control text-right" name="totalNuevoDescuento" id="totalNuevoDescuento" type="text" readonly> 

              </div>

            </div>
       

             <!--=====================================
              CONTADO
                ENTRADA MÉTODO DE PAGO
                ======================================-->
               
                <div  class="card mb-3 border-primary" id="ContadoModal">

                  <div class="card-body">
                    <blockquote class="card-blockquote">

                      <div class="form-row">           
                    
                        <div  class="form-group col-md-4">

                          <label for="nuevoMetodoPago">Método de pago</label>
                            <div class="input-group mb-auto">
                              <select class="form-control Metodonuevopago Metodonuevopago0" id="nuevoMetodoPago" name="nuevoMetodoPago"   style="width: 100%;">
                                <option value="">Método de pago</option>
                                 <?php 
                                   
                                    $item=null;
                                    $valor=null;
                                    $item1="ESTADO_FORMA";
                                    $valor1=1;
                                    $Formapagos = ControladorFormaPagos::ctrMostrarFormapago($item, $valor,$item1, $valor1);
                                  
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
                      
                      <div  class="form-group col-md-4" id="Efectivo">

                           <label for="txtentregaEfectivo">Entrega gs.</label>
                           <input class="form-control txtentregaEfectivo" name="txtentregaEfectivo" id="txtentregaEfectivo" type="text" onkeyup="format(this)" onchange="format(this)"> 

                       </div>

                      <div class="form-group col-md-4" id="recibo">
                    
                          <div class="form-group">
                              <label class="txtnroRecibo" for="txtnroRecibo">Nº Movimiento</label>
                             <input class="form-control txtnroRecibo" name="txtnroRecibo" id="txtnroRecibo" type="text" placeholder="Nº transacción">
                          </div>

                      </div>
                    </div>
                   
                      <!-- PARA ESCRIBRIR EL VUELTO ==================================================-->

                    <div class="row Vuelto">
                      
                      <div  class="form-group col-md-6">

                        <label for="txtdescuentoTotal">Efectivo:</label>
                        <input class="form-control " name="txtEfectivoVuelto" id="txtEfectivoVuelto" type="text" onkeyup="format(this)" onchange="format(this)"> 

                       </div>

                      <div  class="form-group col-md-6" id="Efectivo">

                        <label for="txtdescuentoTotal">Vuelto:</label>
                        <input class="form-control " name="txtVuelto" id="txtVuelto" type="text" readonly> 

                      </div>

                    </div>
                  <!-- ========================================================================= -->

               
                 <div class="metodopago"></div>
              </blockquote>
            </div>

          </div>

        <!-- =========================================== -->


          <!-- CONTROL DE CREDITO -->
        <!-- =============================================== -->

                           <!-- FORMA DE PAGO SI ES MENSUAL QUINCENAL -->
                  <div   class="notblock form-row"  id="CreditoModal">

                    <div class="form-group col-lg-6">
                     
                        <label for="cmbTipoPago">Seleccione tipo de pago</label>
                        <select class="form-control" name="cmbTipoPago" id="cmbTipoPago">
                          <option value="MENSUAL">MENSUAL</option>
                          <option value="QUINCENAL">QUINCENAL</option>
                          <option value="SEMANAL">SEMANAL</option>
                          <option value="DIARIO">DIARIO</option>
                        </select>
                    
                    </div>
                           <!-- CANTIDAD DE CUOTA -->
                     <div class="form-group col-lg-6">
                      
                        <label for="txtCantidadCuota">Cantidad cuota</label>
                       <input class="form-control" name="txtCantidadCuota" id="txtCantidadCuota" type="number" placeholder="Cantidad cuota">
                     
                    </div>
                <!--   </div> -->
              
                    <!-- FECHA DE VENCIMIENTO -->
                <!--   <div   class="form-row" > -->

                     <div class="form-group col-lg-6">
                    
                        <label for="txtFechaVencimiento">Fecha vencimiento</label>
                       <input class="form-control" name="txtFechaVencimiento" id="txtFechaVencimiento" type="date" placeholder="Seleccionar la fecha">
                      </div>

                   <!--  </div> -->


                     <div class="form-group col-lg-6">
                    
                        <label for="txtMontoCuota">Monto de cuota</label>
                       <input class="form-control" name="txtMontoCuota" id="txtMontoCuota" type="text" onkeyup="format(this)" onchange="format(this)" > 
                    
                    </div>

          
                  </div>

<!-- ============================================================================================================================ -->


  
            <div class="modal-footer d-flex justify-content-between align-items-start">
              <div class="input-group-append">
                                 
                <button type="button" class="btn btn-danger" id="btnCerrar" data-dismiss="modal">Cerrar</button>
                          
                <button type="button" class="btn btn-primary " id="btnGuardarPagos">Procesar</button>
              </div> 
            
            </div>


      </div>

   

      </div>

    </div>

  </div>


   <!-- MODAL PARA VER LOS DETALLES DE LA TRANSFERENCIA DE PRODUCTO -->

<!-- Modal -->
<div class="modal fade" id="ModalDetCombos" tabindex=null role="dialog">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="background:#464775; color:white">

        <h6 class="modal-title" id="titulo">Detalle productos de combos</h6>

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
                  <table class="table table-hover table-bordered tablasDetCombos" >

                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Codigo Barra</th>
                          <th>Productos</th>
                          <th>Cantidad</th>
                         
                        </tr>

                      </thead>

                      <tbody></tbody>
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



<script src="vistas/js/ventas.js"></script>