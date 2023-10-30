  <?php 

  if($_SESSION["superperfil"]==0){
      echo '<script type="text/javascript">
        window.location = "inicio";
        </script>';
        }
   ?>
   
    <main class="app-content">
      <div class="app-title">
        

        <div class="contador">
          <?php 

          $item=null;
          $valor=null;
          $item1="EST_ARTICULOS";
          $valor1=1;
              //var_dump($valor);
          $nombres = explode("/",$_SESSION["idsucursal"]);
          $TOKEN_SUCURSAL=$nombres[1];
          $item2="TOKEN_SUCURSAL";
          $valor2=$TOKEN_SUCURSAL;
          $item3="TIPO_PRODUCTO";
          $valor3="SOLITARIO";
          
         $Productos = ControladorProductos::ctrMostrarProducto($item, $valor,$item1, $valor1,$item2, $valor2,$item3,$valor3);
          $Producto=count($Productos);
         
          $maxihabilitado=0;
          
          $cantidades =ControladorSucursales:: ctrMostrarCantidadSucursal(null, null);
     
          foreach ($cantidades as $key => $value){
            $maxihabilitado=$value["CANT_PRODUCTOS"];
          
            }

        ?>
        <h5><button class="btn btn-primary btnNuevo" CantProducto="<?php  echo $Producto; ?>" type="button"  data-toggle="modal" data-target="#ModalProductos"><i class="fas fa-plus-circle"></i> Agregar Nuevo</button> Crear productos</h5>

            
              <div class="alert alert-dismissible alert-danger texto" >

         <p>Supero la cantidad de productos concedido, puedes actualizar su plan llamando a estos números 0982-203.704 o 0972-905.218 CompumarkApp.com<br>
         Está permitido: <?php  echo $maxihabilitado; ?> Productos</p>

        </div>

        <input type="hidden" id="cantidad" value="<?php echo $maxihabilitado; ?>">
         <!--  <p>En este módulo, puedes crear, modificar,eliminar Sucursales</p> -->
        </div>

         <input type="hidden" id="idsucursal" value="<?php echo $_SESSION["idsucursal"] ?>">
          <input type="hidden" id="idusuario" value="<?php echo $_SESSION["id_usu"] ?>">
           <input type="hidden" id="idStock">
           <input type="hidden" id="activo" value="1">
         <!--  <p>En este módulo, puedes crear, modificar,eliminar Sucursales</p> -->

        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        </ul>

        </div>


<!-- MOSTAR LA TABLA DEL PRODUCTO -->
      
  <div class="mostrarGrilla">
  

  <div class="row">
    <div class="col-md-12">
                     
      <div class="bs-component">
          <h3>Productos</h3>
            <ul class="nav nav-tabs">
              <li class="nav-item"><a class="nav-link active" data-toggle="tab" stocker='0' tipo_producto='SOLITARIO' id="ProductoGeneral" href="#productoActivo">Inventario General</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" stocker='1' tipo_producto='SOLITARIO' id="ProductoActivoStock" href="#productoActivo">Stock</a></li>
              <li class="nav-item"><a class="nav-link " data-toggle="tab" stocker='2' tipo_producto='SOLITARIO' id="ProductoActivoAgotado" href="#productoActivo">Agotado</a></li>
              <li class="nav-item"><a class="nav-link " data-toggle="tab" stocker='3' tipo_producto='SOLITARIO' id="ProductoActivoReposicion" href="#productoActivo">Reposición</a></li>
               
            </ul>

              <!-- PRODUCTO ACTIVO SE PROGRAMA EN ESTE LUGAR -->
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade active show"  id="productoActivo" >
            <div class="tile">
              <div class="tile-body">
                  <div class="table-responsive">
               
                    <table class="table table-hover table-bordered tablaProductos">

                      <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th style="width:100px">Acciones</th>
                            <th>Codigo</th>
                            <th>Descripcion</th>
                            <th>Precio compra</th>
                            <th>Precio venta</th>
                            <th>Ganacia venta%</th>
                            <th>Stock</th>
                            <th>Stock minima</th>
                            <th>Categoria</th>
                            <th>Sub categoria</th>
                            <th>Marca</th>
                            <th>Unidad Medida</th>
                            <th>Dimension</th>
                            <th>Cantidad Paquete</th>
                            <th>Estante</th>
                            <th>Tipo producto</th>
                            <th>Oferta</th>
                            <th>Ganancia oferta %</th>
                            <th>Estado oferta</th>
                            <th>Como fue creado</th>
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
    </div>

  </div>
<!-- ======================================================================================== -->

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

<!-- ========================================================================================== -->

    </main>


    <!-- MODAL AGREGAR -->

<!-- Modal -->
<div class="modal fade" id="ModalProductos" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <form  onsubmit="return Guardarformulario()" method="post" name="formProducto" id="formProducto">

        <div class="modal-header" style="background:#464775; color:white">

          <h6 class="modal-title" id="titulo">Nuevo producto</h6>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

          </button>

        </div>

        <div class="modal-body" id="modalBody" style="display: block;">

                  <input class="form-control" type="hidden" name="idProducto"  id="idProducto">
                  <input class="form-control" type="hidden" name="TokenProducto" id= "TokenProducto">

                  <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                <div class="form-row">

                    <!-- PRIMERA FILA -->
                  <div class="form-group col-md-6">
                   
                    <label class="control-label">Categoría <span style="color:red">*</span></label>
                    <div class="messanger">  
                      <div class="sender">
                         <select class="input-control select2" nane="cmbCategoria" id="cmbCategoria" style="width: 92%;" required>
                            <option selected="selected" value="">Seleccione una opción</option>
                            <?php 
                              $item=null;
                              $valor=null;
                              $categorias=ControladorCategorias::ctrMostrarCategoria($item,$valor);
                            foreach ($categorias as $key => $value) {
                             echo '<option value="'.$value["COD_CATEGORIA"].'/'.$value["TOKEN_CATEGORIA"].'">'.$value["NOMBRE_CATEGORIA"].'</option>';
                            }

                     ?>
                         </select>

                          <div class="input-group-append">
                            <button class='btn btn-info btn-sm' id="agregarCategoria" type="button"> <i class="fas fa-plus-square"></i></button>
                          </div>

                        </div>
                      </div>
                    </div>


                    <!-- SEGUNDA FILA -->
                    <div class="form-group col-md-6">
                      <label class="control-label">CodigoBarra <span style="color:red">*</span></label>
                      <div class="input-group mb-3">
                        <input class="form-control" type="text" name="txtCodigoBarra" id="txtCodigoBarra" placeholder="Ingresar el codigo de barra" required>
                        <div class="input-group-append">
                          <button class='btn btn-info btn-sm GenerarCodigo' type="button"><i class='fa fa-refresh text-white'></i></button>
                        </div>
                      </div>
                      
                       

                    </div>
                   

                  </div>

                   <div id="divBarCode" class="notblock textcenter">
                            <div id="printCode">
                                <svg id="barcode"></svg> 
                            </div>
                            <button class="btn btn-success btn-sm" type="button" onClick="fntPrintBarcode('#printCode')"><i class="fas fa-print"></i> Imprimir</button>
                    </div>

                <!-- =========================================== -->

                  <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                    <!-- PRIMERA FILA -->
                   <div class="form-group col-md-6">
                      <label class="control-label">Sub categoría <span style="color:red">*</span></label>
                       
                     <div class="messanger">  
                        <div class="sender">
                        
                            <!-- <label class="control-label" name="editarPerfil"></label> -->
                          <select class="input-control select2" style="width: 92%;" nane="cmbSubCategoria" id="cmbSubCategoria" required="">
                              <option selected="selected" value="">Seleccione una opción</option>
                              <?php 

                                $item=null;
                                $valor=null;
                                $Subcategorias=ControladorSubCategorias::ctrMostrarSubCategoria($item,$valor);
                              foreach ($Subcategorias as $key => $value) {
                               echo '<option value="'.$value["COD_SUBCATEGORIA"].'/'.$value["TOKEN_SUBCATEGORIA"].'">'.$value["NOMBRE_SUBCATEGORIA"].'</option>';
                              }

                       ?>
                           </select>

                          <div class="input-group-append">
                            <button class='btn btn-info btn-sm' id="agregarSubCategoria" type="button"> <i class="fas fa-plus-square"></i></button>
                          </div>

                       </div>

                    </div>

                    </div>

                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-6">
                       <label class="control-label">Marca <span style="color:red">*</span></label>
                          
                    <div class="messanger">  
                      <div class="sender">
                       
                         <!--  <label class="control-label" name="editarSucursal"></label> -->
                         <select class="input-control select2" style="width: 92%;" nane="cmbMarca" id="cmbMarca" required="">
                            <option selected="selected" value="">Seleccione una opción</option>
                            <?php 

                              $item=null;
                              $valor=null;
                              $Marcas = ControladorMarcas::ctrMostrarMarca($item,$valor);
                         
                             foreach ($Marcas as $key => $value) {

                               echo '<option value="'.$value["COD_MARCA"].'/'.$value["TOKEN_MARCA"].'" >'.$value["NOMBRE_MARCA"].'</option>';

                           }

                     ?>
                         </select>

                          <div class="input-group-append">
                            <button class='btn btn-info btn-sm' id="agregarMarca" type="button"> <i class="fas fa-plus-square"></i></button>
                          </div>

                     </div>
                    </div>

                    </div>


                  </div>

                <!-- =========================================== -->

                  <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row" >

                    <!-- PRIMERA FILA -->
                    <div class="form-group col-md-12">
                       <label class="control-label" id="lblclave">Descripción</label>
                        <label class="control-label" style="color:red">*</label>
                          <div class="input-group">
                            <input class="form-control" type="text" id="txtDescripcion" name="txtDescripcion"  placeholder="Ingresar una descripción" required  />  
                          </div>
                
                     
                    </div>

               </div>

                <!-- =========================================== -->                  

                   <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                    <!-- PRIMERA FILA -->
                    <div class="form-group col-md-6">
                       
                        <label class="control-label">Precio compra</label>
                        <label class="control-label" style="color:red">*</label>
                          <div class="input-group">
                            <input class="form-control" type="text" id="txtPrecioCompra" name="txtPrecioCompra" placeholder="Ingresar el precio compra" onkeyup="format(this)" onchange="format(this)" required='required'>
                            
                          </div>
                
                     
                    </div>

                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-6">
                     <label class="control-label">Precio venta</label>
                        <label class="control-label" style="color:red">*</label>
                         <div class="input-group">          
                        
                            <input class="form-control" type="text" id ="txtPrecioVenta" name="txtPrecioVenta" placeholder="Ingresar el precio venta" onkeyup="format(this)" onchange="format(this)" required='required'>
                        </div>
                      </div>

                  </div>

                <!-- =========================================== -->

                   <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                    <!-- PRIMERA FILA -->
                    <div class="form-group col-md-6">
                       <label class="control-label">Gananacia Contado %</label>
                          <div class="input-group">
                            <input class="form-control decimales" type="text" id="txtGanancia" name="txtGanancia" placeholder="Ingresar la ganancia en % ">
                          </div>
                    </div>


                    <!-- SEGUNDA FILA -->
                    <div class="form-group col-md-6">
                       <label class="control-label">Gananacia Contado Gs.</label>
                          <div class="input-group">
                            <input class="form-control decimales" type="text" id="txtGananciags" name="txtGananciags" readonly>
                          </div>
                    </div>




                  </div>

                <!-- =========================================== -->


              
                <!-- =========================================== -->

             
                   <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                    <!-- PRIMERA FILA -->
                    <div class="form-group col-md-6">
                       
                        <label class="control-label">Stock</label>
                        <label class="control-label" style="color:red">*</label>
                          <div class="input-group">
                            <input class="form-control decimales" type="text" id="txtStock" name="txtStock" placeholder="Ingresar el stock" required='required'>
                            
                          </div>
                
                     
                    </div>

                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-6">
                     <label class="control-label">Stock minimo</label>
                        <label class="control-label" style="color:red">*</label>
                         <div class="input-group">          
                        
                            <input class="form-control decimales" type="text" id ="txtStockminimo" name="txtStockminimo" placeholder="Ingresar el stock minimo" required='required'>
                        </div>
                      </div>

                  </div>

                <!-- =========================================== -->

                  <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                <div class="form-row">

                    <!-- PRIMERA FILA -->
                  <div class="form-group col-md-6">
                       
                        <label class="control-label">Unidad de Medida</label>
                        <label class="control-label" style="color:red">*</label>
                      <div class="form-group">
                        <select class="form-control" name="cmdMedida" id="cmdMedida" required>
                          <option value="UNIDADES">UNIDADES</option>
                          <option value="KILOGRAMOS">KILOGRAMOS</option>
                          <option value="DOCENAS">DOCENAS</option>
                          <option value="CAJAS">CAJAS</option>
                          <option value="CONJUNTOS">CONJUNTOS</option>
                          <option value="BOLSAS">BOLSAS</option>
                          <option value="METROS">METROS</option>
                          <option value="PAQUETES">PAQUETES</option>
                          <option value="PARES">PARES</option>
                          <option value="LITROS">LITROS</option>
                          <option value="KITS">KITS</option>
                          <option value="GRUPOS">GRUPOS</option>
                          <option value="OTROS">OTROS</option>
                        </select>
                    </div>
                
                     
                  </div>

                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-6">
                     <label class="control-label">Dimensión</label>
                        <div class="input-group">          
                          <input class="form-control" type="text" id ="txtDimension" name="txtDimension" placeholder="Ingresar la dimensión" >
                        </div>
                      </div>

                  </div>

                <!-- =========================================== -->

                 <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                    <!-- PRIMERA FILA -->
                    <div class="form-group col-md-6">
                       
                        <label class="control-label">Cantidad paquete</label>
                       
                          <div class="input-group">
                            <input class="form-control" type="text" id="txtCantidadPaquete" name="txtCantidadPaquete" onkeyup="format(this)" onchange="format(this)" placeholder="Ingresar la cantidad que hay en su producto">
                            
                          </div>
                
                     
                    </div>

                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-6">
                     <label class="control-label">Ubicación</label>
                        
                         <div class="input-group">          
                        
                            <input class="form-control" type="text" id ="txtUbicacion" name="txtUbicacion" placeholder="Ingresar ubicacion del producto" onkeyup="mayusculas(this);" >
                        </div>
                      </div>

                  </div>

                <!-- =========================================== -->

                <!-- SEGUNDAD FILA -->
                 <div class="form-row">
                  
                 
                       <!-- SEGUNDA FILA -->
                    <div class="form-group col-md-6">
                      <label class="control-label">Descuento por canal con cantidad <span style="color:red">*</span></label>


                       <div class="messanger">  
                        <div class="sender">
                         <select class="input-control" nane="cmbcanal" id="cmbcanal" style="width: 92%;" required>
                          <option selected="selected" value="">Seleccione una opción</option>
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
                        <div class="input-group-append" id="ver">
                          <button class='btn btn-info btn-sm ' id="Verdescuento" type="button"><i class='fa fa-eye text-white'></i></button>
                          <button class='btn btn-info btn-sm notblock' id="nodescuento" type="button"><i class='fa fa-eye-slash text-white' ></i></button>
                        </div>

                        <!--  <div class="input-group-append notblock" id="no">
                          <button class='btn btn-info btn-sm ' id="nodescuento" type="button"><i class='fa fa-eye-slash text-white' ></i></button>

                        </div> -->
                        </div>
                        
                      </div>
                      
                       

                    </div>

                        <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-6">

                     <label class="control-label">Iva</label>
                        <label class="control-label" style="color:red">*</label>
                         <div class="form-group">
                            <select class="form-control" name="cmbIva" id="cmbIva" required>
                                <option value="10">10%</option>
                                <option value="5">5%</option>
                                <option value="0">Exentas</option>
                              </select>
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
                      <tbody>
                                        
                      </tbody>
                </table>
         

                </div>

                
                <!-- =========================================== -->

                 


                 <!-- SEGUNDAD FILA -->
                 <div class="form-row">
                    <div class="form-group col-md-3">
                     <label class="control-label">Marque la opción</label>
                      <div class="form-group">
                       <div class="animated-checkbox">

                          <label>
                            <input type="checkbox" value=0 id="chkOferta" name="chkOferta" onclick="Activarcheck()"><span class="label-text">Aplicar Oferta</span>
                          </label>
                        </div>
                      </div>
                    </div>

                  
                      <div class="form-group col-md-5">
                      <div class="form-group">
                         <label class="control-label" style="display: none;" id="lblOferta">Monto de Oferta</label>
                         <div class="input-group">          
                            <input class="form-control" style="display: none;" type="text" id="txtmontoOferta" name="txtmontoOferta" onkeyup="format(this)" onchange="format(this)" placeholder="Ingresar la cantidad de cuota">
                        </div>
                      </div>

                      </div>


                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-4">
                       <label class="control-label" style="display: none;" id="lblGananciaOferta">Gananacia Oferta%</label>
                          <div class="input-group">
                            <input class="form-control decimales" style="display: none;" type="text" id="txtGananciaOferta" name="txtGananciaOferta" placeholder="Ingresar la ganancia en % ">
                          </div>
                    </div>


                   </div>
                
                <!-- =========================================== -->


                <!-- Galería -->

              <div class="card rounded-lg card-secondary card-outline" id="agregarGaleria" style="display: none;">
                
                <div class="card-header pl-2 pl-sm-3">

                  <h5>Imagenes de los productos</h5>

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

          <h6 class="modal-title" id="titulo">Imagen de producto</h6>

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

                <h5>Agregar Imagen de Producto:</h5>

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
<!-- 
          <div class="padreProducto">

            <img id="mostrar_loadingProducto" class="mx-auto" src="vistas/img/extras/cargando74.gif" alt="..." style="display:none;" />

          </div> -->

        
        <!-- <div
            tabindex="-1" aria-labellbdy="modalImage1" aria-hidden="true"
            class="modal fade" id="modalImage1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                <img src="vistas/img/productos/f6e5e4578a5cb06e3ed21f9a24f556f9.jpg">
              </div>
            </div>
        </div>
 -->
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




       <!-- =========================================== 
        MODAL SUCURSAL
    =========================================== -->


    <!-- MODAL AGREGAR -->

<!-- Modal -->
<!-- <div class="modal fade" id="Modalsucursal" >
  <div class="">
    <div class="modal-content">
      <div class="modal-header" style="background:#464775; color:white">
        <h6 class="modal-title" id="titulo">Nueva marca</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> -->

                  <!--=====================================
                          ENTRADA DE LA SUCURSAL HASTA
                    ======================================-->

                  
                  <!--   <label class="control-label">Sucursal a donde:</label>
                    <div class="input-group">

                           
                      <select class="form-control" id="cmbSucursalHasta" name="cmbSucursalHasta" required>

                        <option value="<?php echo $_SESSION["idsucursal"] ?>"><?php echo $_SESSION["sucursal"] ?></option>

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

               
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" title='Clonar producto' data-toggle='modal' data-target='#ModalProductos' id="btnCargar">Cargar</button>
                  </div>

              </form>
                   
          </div>


    </div>

  </div>

</div> -->
<!-- ===================================================================================================== -->


<script src="vistas/js/productos.js"></script>

<style type="text/css">

  #mostrarImagen img:hover {
    border: 5px solid #f7f7f7;
  }

</style>