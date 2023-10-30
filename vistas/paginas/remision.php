  <?php 

  if($_SESSION["var_sucursal"]==0){
      echo '<script type="text/javascript">
        window.location = "inicio";
        </script>';
        }
   ?>


<main class="app-content">

      
   <!-- EMPIEZA LA CABECERA DEL DOCUMENTO -->

    <div class="app-title">         

      <div class="ListarContenido">

        <h4>Administrar remisiones emitidas</h4>

           <div class="row">

                <!-- BOTONES PARA NUEVO ESTA EN DOS DIV PARA AJUSTAR EL TAMAÑO -->

                <div class="p-1">

                   <button class="btn btn-primary btnNuevo" type="button" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Crear nueva venta"><span class="d-none d-lg-block d-xl-block "> <i class="fas fa-plus-circle"></i> Agregar Nuevo</span> <span class="d-lg-none d-xl-none"> <i class="fas fa-plus-circle"></i></span></button> 

                     <button class="btn btn-primary daterange-btn" type="button" title="Buscar rangos de fecha" id="daterange-btn">
                  
                       <span class="d-none d-lg-block d-xl-block "><i class="fa fa-calendar"></i>Movimiento Hoy <i class="fa fa-caret-down"></i></span><span class="d-lg-none d-xl-none"><i class="fa fa-calendar"></i><i class="fa fa-caret-down"></i></span>
                   
                     
                  </button> 

                   <a href="remisionAnulada">
                          <button class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Ir a ventas anuladas" type="button" title=""><span class="d-none d-lg-block d-xl-block " ><i class="fa-solid fa-ban"></i> Remisiones anuladas</span><span class="d-lg-none d-xl-none"><i class="fa fa-ban"></i>
                          </button> 

                    </a>
                
                </div>


              </div>

           
      </div>

      <div class=" notblock CargarRemision">
            
        <h3 class="text-gray-dark" id="titulo">Cargar remisión</h3>
        <div class='btn-group'>
            
            
          <button class="btn btn-primary btnListar" type="button"><i class="fas fa-th-list"></i> Listar remisión</button>

                     
          <button class="btn btn-danger btncancelar" type="button"><i class="fa fa-window-close-o"></i>Cancelar cargar</button>

          
          
        </div>

        

      </div>


      <ul class="app-breadcrumb breadcrumb">

          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>

          <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>

      </ul>

    </div>

     <!-- TERMINA LA CABECERA DEL DOCUMENTO -->

    <section class="content">

      <div class="row  notblock CargarRemision">

        <div id="cabecera" class="col-lg-5 col-xs-12 d-none d-lg-block d-xl-none d-none d-xl-block">
            
          <div class="tile" id="divcabecera">
            <form onsubmit="return Guardarformulario()" method="post" id="formRemision" class="formularioRemision">

              <div class="box-body">
      
                <div class="box">

                  <!--=================================================================-->
                  <div class="form-row">

                      <!-- PRIMERA FILA -->
                    <div class="form-group col-md-4">

                      <!--=====================================
                        ENTRADA PARA LA REMISION
                      ======================================-->                    
                      <label class="control-label">N° Rem.</label>
                      <div class="input-group">

                        <?php
                               
                          $nombres = explode("/",$_SESSION["idsucursal"]);
                          $CODIGO_SUCURSAL=$nombres[0];
                          $item ="COD_SUCURSAL";
                          $valor =  $CODIGO_SUCURSAL;
                          $max =  ControladorSucursales::ctrMostrarSucursal($item, $valor,1);
                                  
                          $maximoMovimiento=0;
                              //var_dump($max);
                          if(!$max){

                            echo '<input type="text" class="form-control input-lg" id="nuevaRemision" name="nuevaRemision" value="1" readonly>';
                              

                            }else{
                              $maximoMovimiento=$max["NROREMISION"]+1;
                              echo '<input type="text" class="form-control input-lg" id="nuevaRemision" name="nuevaRemision" value="'.'00'.$max["NROVERIFICADOR"].'-'.$maximoMovimiento.'" readonly>';

                            }
                        ?>

                      </div>

                    </div>

                        <!-- SEGUNDA FILA -->
                    <div class="form-group col-md-8">

                      <label class="control-label">Usuario</label>
                      <div class="input-group">
                         <input type="hidden" name="idRemision" id="idRemision">
                        <input type="hidden" name="idUsuario"  id="idUsuario" value="<?php echo $_SESSION["id_usu"].'/'.$_SESSION["tokenUsuario"]; ?>">
                        <input type="hidden" name="idSucursal" id="idSucursal"  activo="1" value="<?php echo $_SESSION["idsucursal"]; ?>">
                        <input class="form-control" id="txtNombreUsuario" type="text" value="<?php echo $_SESSION["funcionario"].' - '.$_SESSION["usuario"]; ?>" readonly>

                      </div>


                    </div>

                  </div>

                  <!-- ========================================================================= -->

                 

                <div class="form-row">

                   <!--=====================================
                  ENTRADA DE LA SUCURSAL DESDE
                  ======================================-->

                      <!-- PRIMERA FILA -->
                  <div class="form-group col-md-6">

                    <label class="control-label">Sucursal Actual:</label>

                      <div class="input-group">
                               
                        <input class="form-control" type="text" name="txtSucursal" id="txtSucursal" value="<?php echo $_SESSION["sucursal"]; ?>" readonly>
                        
                      </div>

                  </div>

                        <!-- SEGUNDA FILA -->
                  <div class="form-group col-md-6">
                        
                    <!--=====================================
                          ENTRADA DE LA SUCURSAL HASTA
                    ======================================-->

                  
                    <label class="control-label">Sucursal a donde:</label>
                    <div class="input-group">

                           
                      <select class="form-control" id="cmbSucursalHasta" name="cmbSucursalHasta" required>

                        <option value="">Seleccionar una sucursal</option>

                        <?php 
                        $item="ESTADO_SUCURSAL";
                        $valor=1;
                        $SucursalHasta= ControladorSucursales::ctrMostrarSucursal($item, $valor,null);
                         
                        foreach ($SucursalHasta as $key => $value) {

                          echo '<option value="'.$value["COD_SUCURSAL"].'/'.$value["TOKEN_SUCURSAL"].'" >'.$value["SUCURSAL"].'</option>';


                            }

                       ?>

                      </select>


                    </div>

                  </div>

                </div>

                <!-- ======================================================================================================= -->

                <!-- TABLA PARA AGREGAR LOS PRODUCTOS A SER REMITIDOS -->
                <hr>
                 <div class="table-responsive">

                    <table class="table table-sm" id="tablaRemision">

                      <thead>

                        <tr>
                          <th><center><i class="fas fa-trash"></i></center></th>
                          <th><center>Cant.</center></th>
                          <th><center><i class="fas fa-barcode"></i></center></th>
                          <th><center>Producto</center></th>
                          <th><center>Costo</center></th>
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


              <!-- ENTRADA PARA LA OBSERVACIONES -->
                <div class="form-group">

                  <label class="control-label">Observación 300 caracteres:</label>

                  <div class="input-group">
                               
                    <textarea class="form-control" maxlength="300" name="txtObservacion" id="txtObservacion" placeholder="Ingresar, si hay alguna observación"></textarea>
                        
                  </div>

                </div>

                <!-- ====================================================================================================== -->


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

                    <button type="submit" class="btn btn-primary" id="btnGuardar"><i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar remision</button>

                  </div>


                   <div class="text-right d-sm-none d-md-none d-lg-block d-xl-block">
                     <h6>Items: </h6><h3 class="Can"></h3>
                    
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

            <li class="nav-item"><a class="nav-link active" data-toggle="tab" id="ProductoSucursalActual" href="#prodcuctoActualSucursal">Sucursal Actual</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" id="ProductoActivoOtros" href="#prodcuctoActualSucursal">Otras sucursales</a></li>
                                
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
                          <th>Sucursal</th>
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

                    <table class="table table-hover table-bordered tablasVerRemision">

                      <thead>
                        <tr>

                           <th>#</th>
                          <th >Acciones</th>
                          <th >Nº Remisión</th>
                          <th >Fecha</th>
                          <th>Sucursal de </th>
                          <th>Sucursal a</th>
                          <th>Usuario</th>
                          <th>Observaciones</th>
                  
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


    <div class="notblock CargarRemision">
      
      <button class="botonF1 d-xl-none d-lg-none" style="bottom:10px;right:10px;position:fixed;z-index:9999;" id="botonFlotante">
         <span><i class="fas fa-cart-arrow-down"></i><h6 class="texto-encima Can" style="bottom:10px;right:10px;position:fixed;z-index:9999;">0</h6></span>
      </button>
    </div>

</main>



 <!-- MODAL PARA VER LOS DETALLES DE LA TRANSFERENCIA DE PRODUCTO -->

<!-- Modal -->
<div class="modal fade" id="ModalDetRemision" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header" style="background:#464775; color:white">

        <h6 class="modal-title" id="titulo">Detalle Remisión</h6>

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

                    <table class="table table-hover table-bordered tablasDetRemision">

                      <thead>
                        <tr>
                          <th>#</th>
                          <th >Nº Remisión</th>
                          <th >Fecha</th>
                          <th>Sucursal de </th>
                          <th>Sucursal a</th>
                          <th>Cod. barra</th>
                          <th>Productos</th>
                          <th>Cantidad</th>
                          <th>Cantidad Anterior Sucursal de</th>
                          <th>Cantidad Anterior Sucursal a</th>
                          <th>Usuario</th>
                          <th>Observaciones</th>
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

<script src="vistas/js/remision.js"></script>