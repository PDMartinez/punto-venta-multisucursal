  <?php 

  if($_SESSION["superperfil"]==0){
      echo '<script type="text/javascript">
        window.location = "inicio";
        </script>';
        }
   ?>
   
    <main class="app-content">
      <div class="app-title">
        

          <h5><button class="btn btn-primary btnNuevo" type="button"  data-toggle="modal" data-target="#ModalProductos"><i class="fas fa-plus-circle"></i> Agregar Nuevo</button> Crear fletes</h5>

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
                            <th>Descripcion del flete</th>
                            <th>Costo del flete</th>
                            <th>Precio del flete</th>
                            <th>%</th>
                            <th>Tipo movimiento</th>
                            <th>Foto</th>
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

          <h6 class="modal-title" id="titulo">Nuevo flete</h6>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

          </button>

        </div>

        <div class="modal-body" id="modalBody" style="display: block;">

                  <input class="form-control" type="hidden" name="idProducto"  id="idProducto">
                  <input class="form-control" type="hidden" name="TokenProducto" id= "TokenProducto">

                    <label class="control-label">CodigoBarra <span style="color:red">*</span></label>
                      <div class="input-group mb-3">
                        <input class="form-control" type="text" name="txtCodigoBarra" id="txtCodigoBarra" placeholder="Ingresar el codigo de barra" required>
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
                       <label class="control-label" id="lblclave">Descripción <span style="color:red">*</span></label>
                         <div class="input-group">
                            <input class="form-control" type="text" id="txtDescripcion" name="txtDescripcion"  placeholder="Ingresar una descripción" required  />  
                        </div>
                
                     
                    </div>

             
                <!-- =========================================== -->                  

                   <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                    <!-- PRIMERA FILA -->
                    <div class="form-group col-md-6">
                       
                        <label class="control-label">Costo del flete <span style="color:red">*</span></label>
                         <div class="input-group">
                            <input class="form-control" type="text" id="txtPrecioCompra" name="txtPrecioCompra" value="0" placeholder="Ingresar el precio compra" onkeyup="format(this)" onchange="format(this)" required='required'>
                            
                          </div>
                
                     
                    </div>

                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-6">
                     <label class="control-label">Precio del flete<span style="color:red">*</span></label>
                         <div class="input-group">          
                        
                            <input class="form-control" type="text" id ="txtPrecioVenta" name="txtPrecioVenta" placeholder="Ingresar el precio venta" onkeyup="format(this)" onchange="format(this)" required='required'>
                        </div>
                      </div>

                  </div>

                  <div class="notblock">

                    <select class="input-control" nane="cmbCategoria" id="cmbCategoria" style="width: 92%;" required>
                          <?php 
                            $item=null;
                            $valor=null;
                            $categorias=ControladorCategorias::ctrMostrarCategoria($item,$valor);
                          foreach ($categorias as $key => $value) {
                           echo '<option value="'.$value["COD_CATEGORIA"].'/'.$value["TOKEN_CATEGORIA"].'">'.$value["NOMBRE_CATEGORIA"].'</option>';
                          }

                   ?>
                       </select>


   <select class="input-control select2" style="width: 92%;" nane="cmbSubCategoria" id="cmbSubCategoria" required="">
                    
                          <?php 

                            $item=null;
                            $valor=null;
                            $Subcategorias=ControladorSubCategorias::ctrMostrarSubCategoria($item,$valor);
                          foreach ($Subcategorias as $key => $value) {
                           echo '<option value="'.$value["COD_SUBCATEGORIA"].'/'.$value["TOKEN_SUBCATEGORIA"].'">'.$value["NOMBRE_SUBCATEGORIA"].'</option>';
                          }

                   ?>
                       </select>


    <!--  <label class="control-label" name="editarSucursal"></label> -->
                       <select class="input-control select2" style="width: 92%;" nane="cmbMarca" id="cmbMarca" required="">
                        <?php 

                            $item=null;
                            $valor=null;
                            $Marcas = ControladorMarcas::ctrMostrarMarca($item,$valor);
                       
                           foreach ($Marcas as $key => $value) {

                             echo '<option value="'.$value["COD_MARCA"].'/'.$value["TOKEN_MARCA"].'" >'.$value["NOMBRE_MARCA"].'</option>';

                         }

                   ?>
                       </select>

                  <select class="input-control" nane="cmbcanal" id="cmbcanal" style="width: 89%;" required>
                          <?php 
                            $item="ESTADO";
                            $valor=1;
                            $var=null;
                            $order="COD_CANAL ASC";

                            $canales = ControladorCanalesProductos::ctrMostrarCanal($item, $valor, $var, $order);

                          foreach ($canales as $key => $value) {
                           echo '<option value="'.$value["COD_CANAL"].'/'.$value["TOKEN_CANAL"].'">'.$value["DESCRIPCION_CANAL"].'</option>';
                          }

                   ?>
                       </select>

              </div>


                <!-- Galería -->

              <div class="card rounded-lg card-secondary card-outline" id="agregarGaleria" style="display: none;">
                
                <div class="card-header pl-2 pl-sm-3">

                  <h5>Imagen del vehículo</h5>

                </div>

                <div class="card-body" id="AgregarNuevo">  

                  <ul class="row p-0 vistaGaleria">


                    
                  </ul>

                </div>

                <!-- <input type="hidden" class="inputNuevaGaleria">
                <input type="hidden" class="inputGaleria"> -->
                <input type="hidden" class="inputAntiguaGaleria">
               <!--  <input type="hidden" class="inputAntiguaGaleriaEstatica"> -->

                <div class="card-footer">
                  
                  <input type="file" multiple name="galeria" id="galeria" class="d-none" accept="image/jpeg,image/png">

                  <label for="galeria" class="text-dark text-center py-5 border rounded bg-white w-100 subirGaleria">

                    Haz clic aquí o arrastra las imágenes <br>
                    <span class="help-block small">Formato: JPG-PNG-GIF</span>
                         
                  </label>

                </div>

              </div>

        </div>

        <!-- Mensaje de Cargando... -->

          <div class="padre">

            <img id="mostrar_loading" class="mx-auto" src="vistas/img/extras/cargando74.gif" alt="..." style="display:none;" />

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



  <div class="modal fade" id="modalGaleria" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <form method="post" name="formProductoImagen" id="formProductoImagen">

        <div class="modal-header" style="background:#464775; color:white">

          <h6 class="modal-title" id="titulo">Imagen de vehículo</h6>

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

                <h5>Agregar Imagen:</h5>

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

</div>

 

<script src="vistas/js/fletes.js"></script>

