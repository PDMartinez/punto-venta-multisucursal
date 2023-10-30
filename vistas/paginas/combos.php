<main class="app-content">

  <!-- EMPIEZA LA CABECERA DEL DOCUMENTO -->

    <div class="app-title">

          <div class="ListarContenido">
            
          <button class="btn btn-primary btnNuevo" type="button"><i class="fas fa-plus-circle"></i> Nuevo combos</button> 
           
          </div>

          <div class="notblock CargarCombos">
            

            <div class='btn-group'>
            
            
             <button class="btn btn-primary btnListar" type="button"><i class="fas fa-th-list"></i> Listar combos</button>

                     
             <button class="btn btn-danger btncancelar" type="button"><i class="fa fa-window-close-o"></i>Cancelar cargar</button>

              
          
          </div>

          <h3 class="text-gray-dark" id="titulo">Cargar combos</h3>

        </div>
          
        <ul class="app-breadcrumb breadcrumb">

          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>

          <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>

        </ul>

      </div>

  <!-- TERMINA LA CABECERA DEL DOCUMENTO -->

    <section class="content">

      <div class="row notblock CargarCombos">

        <div id="cabecera" class="col-lg-5 col-xs-12 d-none d-lg-block d-xl-none d-none d-xl-block">
            
          <div class="tile" id="divcabecera">

              <form onsubmit="return Guardarformulario()" method="post" id="formCombos" class="formularioCombos">
                <div class="box-body">
      
                  <div class="box">

                     <!--=====================================
                           VARIABLE OCULTAS
                    ======================================-->

                    <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $_SESSION["id_usu"].'/'.$_SESSION["tokenUsuario"]; ?>">

                     <input type="hidden" name="activo" id="activo" value="1">
                    <input type="hidden" name="idSucursales" id="idSucursales" stockers="0" tipo_productos='SOLITARIO' value="<?php echo $_SESSION["idsucursal"]; ?>">

                    <input class="form-control" type="hidden" name="idProducto"  id="idProducto">
                    <input class="form-control" type="hidden" name="TokenProducto" id= "TokenProducto">
                    <input type="hidden" id="idStock">

                      <!-- ========================================================================================================== -->


                    <!--=====================================
                    ENTRADA NOMBRE DEL COMBO BOX
                    ======================================-->

              
                    <!-- GENERAR CODIGO DE BARRA -->
                    <label class="control-label">CodigoBarra <span style="color:red">*</span></label>
                      
                      <div class="input-group mb-3">
                        
                        <input class="form-control" type="text" name="txtCodigoBarra" id="txtCodigoBarra" placeholder="Ingresar el codigo de barra" required>
                        
                        <div class="input-group-append">
                          <button class='btn btn-info btn-sm GenerarCodigo' type="button"><i class='fa fa-refresh text-white'></i></button>
                        </div>

                      </div>
               
           
                          <!-- ES DONDE SE GENERA EL CODIGO DE BARRA -->

                        <div id="divBarCode" class="notblock textcenter">

                          <div id="printCode">

                              <svg id="barcode"></svg> 

                          </div>
                            <button class="btn btn-success btn-sm" type="button" onClick="fntPrintBarcode('#printCode')"><i class="fas fa-print"></i> Imprimir</button>

                        </div>

                <!-- PARTE DE NOMBRE DEL COMBO -->
                       <label class="control-label" id="lblclave">Nombre del combo <span style="color:red">*</span></label>
                        
                          <div class="input-group">

                            <input class="form-control" type="text" id="txtDescripcion" name="txtDescripcion"  placeholder="Ingresar el nombre del combo" required  />  
                          
                          </div>
              

                    <!-- ======================================================= -->

                     <hr>


               
                    <!-- EMPIEZA LA TABLA DE PARA CARGAR EL COMBO -->
                    <div class="table-responsive">

                      <table class="table table-sm" id="TablaCombos">

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

                    <!-- TERMINA LA TABLA PARA CARGAR EL COMBO -->

                     <hr>

                      <input type="hidden" id="listaProductos" name="listaProductos">

                    <!--=====================================
                    ENTRADA IMPUESTOS Y TOTAL
                    ======================================-->

                    <!-- DOMDE EMPIEZA PRECIO DE COMPRA Y CODIGO DE BARRA -->
                <div class="row">
                                 
                  <div class="form-group col-md-6">

                  <!-- PRIMERA FILA -->
                      <div class="form-group">
                          <label class="control-label">Precio compra</label>
                        <input class="form-control text-right" type="text" name="txtTotal" id="txtTotal" required readonly="">
                     </div>
                
                  </div>

                    <!-- SEGUNDA FILA -->

                <div class="form-group col-md-6">

                  <label class="control-label">Precio venta <span style="color:red">*</span></label>

                  <div class="input-group">
                    <input class="form-control" type="text" id="txtPrecioVenta" name="txtPrecioVenta" placeholder="Ingresar el precio Venta" onkeyup="format(this)" onchange="format(this)" required='required'>
                            
                  </div>

                     
                  </div>
          


                </div>

                 <!-- TERMINA EL PRECIO DE COMPRA Y CODIGO DE BARRA -->


              
                <!-- =========================================== -->

                <!-- ES DONDE COMIENZA EL PRECIO DE VENTA Y LA GANANCIA -->
              <div class="form-row">

                    <!-- PRIMERA FILA -->
              
                <div class="form-group col-md-6">

                  <label class="control-label">Ganancia %</label>

                  <div class="input-group">

                    <input class="form-control decimales" type="text" id="txtGanancia" name="txtGanancia" placeholder="Ganancia % ">
                  </div>
                   
                </div>

                    <!-- SEGUNDA FILA -->
                <div class="form-group col-md-6">
                  <label class="control-label">Ubicación</label>
                        
                    <div class="input-group">          
                        
                      <input class="form-control" type="text" id ="txtUbicacion" name="txtUbicacion" placeholder="Ingresar ubicacion del producto" onkeyup="mayusculas(this);" >
                    </div>
                  </div>

              </div>
               <!-- =========================================== -->

                <hr>

                <!-- DONDE EMPIEZA EL PIE DE PAGINA -->

                <div class="box-footer">

                  <div class="text-left">

                    <button type="submit" class="btn btn-primary" id="btnGuardar"><i class="fa fa-floppy-o" aria-hidden="true"></i>Guardar</button>

                  </div>

                    <div class="text-right d-sm-none d-md-none d-lg-block d-xl-block">
                     <h6>Items: </h6><h3 class="Can"></h3>
                    
                  </div>

                </div>

              

                  </div>

                </div>

              </form>

              <!-- TERMINA EL FORMULARIO -->

          </div>
          <!-- TERMINA EL div CABECERA -->


        </div>

        <!-- TERMINA LA CABECERA -->



        <!-- EMPIEZA LA CARGA DE PRODUCTOS -->

      <div class="col-lg-7">

          <div class="bs-component" id="divProductos" >
              <!-- PRODUCTO ACTIVO SE PROGRAMA EN ESTE LUGAR -->
        
                <div class="tile">

                  <div class="tile-body">
                  
                      
                   

                   
                    <div class="bs-component">

                      <div class="alert alert-dismissible alert-info">
                      <div class='btn-group'>
                        <button class='btn btn-primary btn-sm TodosProductos ' title="Todos los productos"> <i class='fa fa-list-alt'></i></button>
                         <button class='btn btn-success btn-sm combos' title="Combos de productos"><i class='fa fa-newspaper-o'></i></button>
                        <button class='btn btn-info btn-sm flete' title="Ver Flete"><i class='fa fa-truck'></i></button>
                      </div>
                       <strong class="text-primary plataforma" >Buscar productos</strong>
                      </div>
                    </div>
               

              

         
                 <hr>
                    <div class="table-responsive">

                      <table class="table table-sm table-hover table-bordered tablaProductos">

                        <thead>

                          <tr>
                            <th style="width: 10px">#</th>
                            <th>Accion</th>
                            <th>Cód</th>
                            <th style="width: 250px">Descripcion</th>
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
                        <label class="control-label"><h3>Precio compra</h3></label>
                        <input class="form-control text-right" type="text" name="txtTotalArticulos" id="txtTotalArticulos" readonly="">
                     </div>
                    </div>

                </div>
               
                <!-- ========================================================= -->
            </div>
            <!-- TERMINA EL ROW PARA DIVIR EN 2 PARTES -->
                    

      </div>

     </div> 


 <!-- EMPIEZA LISTAR CONTENIDO -->

    <div class="ListarContenido">

        <div class="row">
          <div class="col-md-12">
            <div class="tile">
              <div class="tile-body">
              
                <div class="table-responsive">
                  <input type="hidden" name="idSucursal" id="idSucursal" stockers="1" tipo_productos='COMBOS' value="<?php echo $_SESSION["idsucursal"]; ?>">
                    <table class="table table-hover table-bordered tablasCombos">

                      <thead>
                        <tr>
                          <th>#</th>
                          <th >Acciones</th>
                          <th >Codigo Barra</th>
                          <th >Nombre combo</th>
                          <th>Productos relacionados con combos</th>
                          <th>Precio compra</th>
                          <th>Precio venta</th>
                          <th>Ganancia %</th>
                          <th>Ubicación</th>
                          <th>Tipo Producto</th>
                          <th>Imagen</th>
                          <th>Estado</th>
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


      <!-- MODAL DE LA IMAGEN -->

      <div class="modal fade" id="modalGaleria" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">

          <div class="modal-content">

            <form method="post" name="formProductoImagen" id="formProductoImagen">

              <div class="modal-header" style="background:#464775; color:white">

                <h6 class="modal-title" id="titulo">Imagen de combos</h6>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                  <span aria-hidden="true">&times;</span>

                </button>

              </div>

               <div class="modal-body" id="modalBodyProducto" style="display: block;">

                  <input class="form-control" type="hidden" name="idProductoImagen"  id="idProductoImagen">
                  <input class="form-control" type="hidden" name="TokenProductoImagen" id= "TokenProductoImagen">

                <div class="form-group col-md-12">

                  <!-- Galeria producto-->

                  <div class="card rounded-lg card-secondary card-outline">
                        
                    <div class="card-header pl-2 pl-sm-3">

                      <h5>Agregar Imagen de combos:</h5>

                    </div>


                     <input type="hidden" class="inputAntiguaGaleriaProducto">
            
                      <div class="card-footer">
                        
                        <input type="file" multiple name="galeriaProducto[]" id="galeriaProducto" class="d-none" accept="image/jpeg,image/png">

                        <label for="galeriaProducto" class="text-dark text-center py-5 border rounded bg-white w-100 subirGaleriaProducto">

                          Haz clic aquí o arrastra las imágenes <br>
                          <span class="help-block small">Formato: JPG-PNG-GIF</span>
                               
                        </label>

                         <!--Mostrar Galeria producto-->

                        <div class="row" id="mostrarImagen">

                      </div>

                      </div>

                  </div>
                </div>
              </div>

              <!-- Mensaje de Cargando... -->

              <div class="padreProducto">

                <img id="mostrar_loadingProducto" class="mx-auto" src="vistas/img/extras/cargando74.gif" alt="..." style="display:none;" />

              </div>


               <!-- =========================================== -->

                <div class="modal-footer">

                  <div>
                    <button type="button" class="btn btn-danger" id="btnCerrar" data-dismiss="modal" style="display: block;">Cerrar</button>
                  </div>

                </div>



            </form>
            </div>
          </div>
        </div>


      <!-- TERMINAL EL MODAL DE LA IMAGEN -->

  </section>
<div class="notblock CargarCombos">
  
    <button class="botonF1 d-xl-none d-lg-none" style="bottom:10px;right:10px;position:fixed;z-index:9999;" id="botonFlotante">
         <span><i class="fas fa-cart-arrow-down"></i><h6 class="texto-encima Can" style="bottom:10px;right:10px;position:fixed;z-index:9999;">0</h6></span>
      </button>
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

<script src="vistas/js/combos.js"></script>
