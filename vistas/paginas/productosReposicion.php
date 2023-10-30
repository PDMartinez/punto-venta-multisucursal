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
          
         $Productos = ControladorProductos::ctrMostrarProducto($item, $valor,$item1, $valor1,$item2, $valor2);
          $Producto=count($Productos);
         
          $maxihabilitado=0;
          
          $cantidades =ControladorSucursales:: ctrMostrarCantidadSucursal(null, null);
     
          foreach ($cantidades as $key => $value){
            $maxihabilitado=$value["CANT_PRODUCTOS"];
          
            }

        ?>
        <h5><button class="btn btn-primary btnNuevo" CantProducto="<?php  echo $Producto; ?>" type="button"  data-toggle="modal" data-target="#ModalProductos"><i class="fas fa-plus-circle"></i> Agregar Nuevo</button> Crear productos</h5>

        <div class="box-header with-border texto" >
          <label style="color:red"> 
         Supero la cantidad de productos concedido, puede actualizar su plan llamando a este número 0982-203.704 Ing. Marcos Contrera o 0972-905.218 Ing. Danilo Martinez<br>
         ESTA PERMITIDO: <?php  echo $maxihabilitado; ?> Producto
          </label>
        </div>

        <input type="hidden" id="cantidad" value="<?php echo $maxihabilitado; ?>">
         <!--  <p>En este módulo, puedes crear, modificar,eliminar Sucursales</p> -->
        </div>

         <input type="hidden" id="idsucursal" value="<?php echo $_SESSION["idsucursal"] ?>">
          <input type="hidden" id="idusuario" value="<?php echo $_SESSION["id_usu"] ?>">
           <input type="hidden" id="idStock">
           <input type="hidden" id="activo" value="1">
         <!--  <p>En este módulo, puedes crear, modificar,eliminar Sucursales</p> -->
        </div>

        
         <!--  <p>En este módulo, puedes crear, modificar,eliminar Sucursales</p> -->
        </div>

        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        </ul>
      </div>
    

      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
           
            <div class="bs-component">
                <h3>Productos</h3>
              <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#productoActivo">Inventario General</a></li>
               <li class="nav-item"><a class="nav-link" data-toggle="tab" id="ProductoActivoStock" href="#productoStock">Stock</a></li>
                 <li class="nav-item"><a class="nav-link " data-toggle="tab" id="ProductoActivoAgotado" href="#productoAgotado">Agotado</a></li>
                <li class="nav-item"><a class="nav-link " data-toggle="tab" id="ProductoActivoReposicion" href="#productoReposicion">Reposición</a></li>
               
              </ul>

              <!-- PRODUCTO ACTIVO SE PROGRAMA EN ESTE LUGAR -->
              <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="productoActivo">

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
                        <th>Descuento %</th>
                        <th>Stock</th>
                        <th>Stock minima</th>
                        <th>Categoria</th>
                        <th>Sub categoria</th>
                        <th>Marca</th>
                        <th>Unidad Medida</th>
                        <th>Dimension</th>
                        <th>Cantidad Paquete</th>
                        <th>Estante</th>
                        <th>Cantidad cuota</th>
                        <th>Precio Mayorista</th>
                        <th>Ganacia mayorista %</th>
                        <th>Oferta</th>
                        <th>Ganancia oferta %</th>
                        <th>Estado oferta</th>
                        <th>Foto</th>
                        <th>Dar de baja</th>
                       
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>

              </div>
                </div>

                <!-- =========================================================== -->
                 <div class="tab-pane fade" id="productoStock">
                  <div class="table-responsive">
             
                <table class="table table-hover table-bordered tablaProductosStock">

                  <thead>
                    <tr>
                        <th style="width:10px">#</th>
                        <th style="width:100px">Acciones</th>
                        <th>Codigo</th>
                        <th>Descripcion</th>
                        <th>Precio compra</th>
                        <th>Precio venta</th>
                        <th>Ganacia venta%</th>
                        <th>Descuento %</th>
                        <th>Stock</th>
                        <th>Stock minima</th>
                        <th>Categoria</th>
                        <th>Sub categoria</th>
                        <th>Marca</th>
                        <th>Unidad Medida</th>
                        <th>Dimension</th>
                        <th>Cantidad Paquete</th>
                        <th>Estante</th>
                        <th>Cantidad cuota</th>
                        <th>Precio Mayorista</th>
                        <th>Ganacia mayorista %</th>
                        <th>Oferta</th>
                        <th>Ganancia oferta %</th>
                        <th>Estado oferta</th>
                        <th>Foto</th>
                        <th>Dar de baja</th>
                       
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>

              </div>
            </div>
                <!-- ========================================================= -->
                <!-- PRODUCTOS AGOTADOS -->
                <div class="tab-pane fade" id="productoAgotado">
                  <div class="table-responsive">
             
                <table class="table table-hover table-bordered tablaProductosAgotados">

                  <thead>
                    <tr>
                        <th style="width:10px">#</th>
                        <th style="width:100px">Acciones</th>
                        <th>Codigo</th>
                        <th>Descripcion</th>
                        <th>Precio compra</th>
                        <th>Precio venta</th>
                        <th>Ganacia venta%</th>
                        <th>Descuento %</th>
                        <th>Stock</th>
                        <th>Stock minima</th>
                        <th>Categoria</th>
                        <th>Sub categoria</th>
                        <th>Marca</th>
                        <th>Unidad Medida</th>
                        <th>Dimension</th>
                        <th>Cantidad Paquete</th>
                        <th>Estante</th>
                        <th>Cantidad cuota</th>
                        <th>Precio Mayorista</th>
                        <th>Ganacia mayorista %</th>
                        <th>Oferta</th>
                        <th>Ganancia oferta %</th>
                        <th>Estado oferta</th>
                        <th>Foto</th>
                        <th>Dar de baja</th>
                       
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>

              </div>
                </div>
                <div class="tab-pane fade" id="productoReposicion">
                  <div class="table-responsive">
             
                <table class="table table-hover table-bordered tablaProductosReposicion">

                  <thead>
                    <tr>
                        <th style="width:10px">#</th>
                        <th style="width:100px">Acciones</th>
                        <th>Codigo</th>
                        <th>Descripcion</th>
                        <th>Precio compra</th>
                        <th>Precio venta</th>
                        <th>Ganacia venta%</th>
                        <th>Descuento %</th>
                        <th>Stock</th>
                        <th>Stock minima</th>
                        <th>Categoria</th>
                        <th>Sub categoria</th>
                        <th>Marca</th>
                        <th>Unidad Medida</th>
                        <th>Dimension</th>
                        <th>Cantidad Paquete</th>
                        <th>Estante</th>
                        <th>Cantidad cuota</th>
                        <th>Precio Mayorista</th>
                        <th>Ganacia mayorista %</th>
                        <th>Oferta</th>
                        <th>Ganancia oferta %</th>
                        <th>Estado oferta</th>
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

    </main>


    <!-- MODAL AGREGAR -->

<!-- Modal -->
<div class="modal fade" id="ModalProductos" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background:#464775; color:white">
        <h6 class="modal-title" id="titulo">Nuevo producto</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

                     <!-- FORMULARIOS -->
              <!-- <form  onsubmit="return Guardarformulario()" method="post" name="formUsuario" id="formUsuario -->
             <form  onsubmit="return Guardarformulario()" method="post" name="formProducto" id="formProducto">
                  <input class="form-control" type="hidden" name="idProducto"  id="idProducto">
                  <input class="form-control" type="hidden" name="TokenProducto" id= "TokenProducto">

                  <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                <div class="form-row">

                    <!-- PRIMERA FILA -->
                  <div class="form-group col-md-6">
                    <div class="form-group">
                        <label class="control-label">Categoría</label>
                        <label class="control-label" style="color:red">*</label>
                       <!--  <label class="control-label" name="editarFuncionario"></label> -->
                        <input class="form-control" type="text" id="editarCategoria" name="editarCategoria" />
                       <select class="form-control select2" nane="cmbCategoria" id="cmbCategoria" style="width: 100%;" required="">
                          <option selected="selected">Seleccione una opción</option>
                          <?php 
                            $item=null;
                            $valor=null;
                            $categorias=ControladorCategorias::ctrMostrarCategoria($item,$valor);
                          foreach ($categorias as $key => $value) {
                           echo '<option value="'.$value["COD_CATEGORIA"].'/'.$value["TOKEN_CATEGORIA"].'">'.$value["NOMBRE_CATEGORIA"].'</option>';
                          }

                   ?>
                       </select>
                     </div>
                    </div>


                    <!-- SEGUNDA FILA -->
                    <div class="form-group col-md-6">

                      <div class="form-group">
                        <label class="control-label">CodigoBarra</label>
                        <label class="control-label" style="color:red">*</label>
                        <input class="form-control" type="text" name="txtCodigoBarra" placeholder="Ingresar el codigo de barra">
                     </div>
                    </div>

                  </div>

                <!-- =========================================== -->

                  <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                    <!-- PRIMERA FILA -->
                   <div class="form-group col-md-6">
                      <div class="form-group">
                        <label class="control-label">Sub categoría</label>
                         <label class="control-label" style="color:red">*</label>
                        <!-- <label class="control-label" name="editarPerfil"></label> -->
                        <input class="form-control" type="text" id="editarSubCategoria" name="editarSubCategoria" />
                       <select class="form-control select2" style="width: 100%;" nane="cmbSubCategoria" id="cmbSubCategoria" required="">
                          <option selected="selected">Seleccione una opción</option>
                          <?php 

                            $item=null;
                            $valor=null;
                            $Subcategorias=ControladorSubCategorias::ctrMostrarSubCategoria($item,$valor);
                          foreach ($Subcategorias as $key => $value) {
                           echo '<option value="'.$value["COD_SUBCATEGORIA"].'/'.$value["TOKEN_SUBCATEGORIA"].'">'.$value["NOMBRE_SUBCATEGORIA"].'</option>';
                          }

                   ?>
                       </select>
                     </div>

                    </div>

                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-6">
                      <div class="form-group">
                        <label class="control-label">Marca</label>
                        <label class="control-label" style="color:red">*</label>
                       <!--  <label class="control-label" name="editarSucursal"></label> -->
                         <input class="form-control" type="text" id="editarMarca" name="editarMarca" />
                       <select class="form-control select2" style="width: 100%;" nane="cmbMarca" id="cmbMarca" required="">
                          <option selected="selected">Seleccione una opción</option>
                          <?php 

                            $item=null;
                            $valor=null;
                            $Marcas = ControladorMarcas::ctrMostrarMarca($item,$valor);
                       
                           foreach ($Marcas as $key => $value) {

                             echo '<option value="'.$value["COD_MARCA"].'/'.$value["TOKEN_MARCA"].'" >'.$value["NOMBRE_MARCA"].'</option>';

                         }

                   ?>
                       </select>
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
                            <input class="form-control" type="text" id="txtDescripcion" name="txtDescripcion" onkeyup="mayusculas(this);"  placeholder="Ingresar una descripción" required  />  
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


                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-6">
                     <label class="control-label">Descuento %</label>
                        <label class="control-label" style="color:red">*</label>
                         <div class="input-group">          
                        
                            <input class="form-control decimales" style="width: 100%;" type="text" id ="txtDescuento" name="txtDescuento" placeholder="Ingresar el descuento en %" required='required'>
                        </div>
                      </div>

                  </div>

                <!-- =========================================== -->


                   <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                    <!-- PRIMERA FILA -->
                    <div class="form-group col-md-6">
                       
                        <label class="control-label">Precio mayorista</label>
                       
                          <div class="input-group">
                            <input class="form-control" type="text" id="txtPrecioMayorista" name="txtPrecioMayorista" placeholder="Ingresar el precio mayorista" onkeyup="format(this)" onchange="format(this)">
                            
                          </div>
                
                     
                    </div>

                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-6">
                       <label class="control-label">Gananacia Mayorista %</label>
                          <div class="input-group">
                            <input class="form-control decimales" type="text" id="txtGananciaMayorista" name="txtGananciaMayorista" placeholder="Ingresar la ganancia en % ">
                          </div>
                    </div>
                  

                </div>

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
                          <input class="form-control" type="text" id ="txtDimension" onkeyup="mayusculas(this);" name="txtDimension" placeholder="Ingresar la dimensión" >
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
                    <div class="form-group col-md-6">
                     <label class="control-label">Cantidad cuota</label>
                         <div class="input-group">          
                            <input class="form-control" type="number" id="txtCanCuota" name="txtCanCuota" onkeyup="format(this)" onchange="format(this)" placeholder="Ingresar la cantidad de cuota">
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

              <div class="card rounded-lg card-secondary card-outline">
                
                <div class="card-header pl-2 pl-sm-3">

                  <h5>Imagenes de los productos</h5>

                </div>

                <div class="card-body">  

                  <ul class="row p-0 vistaGaleria">


                    
                  </ul>

                </div>

                <input type="hidden" class="inputNuevaGaleria">
                <input type="hidden" class="inputAntiguaGaleria">
                <input type="hidden" class="inputAntiguaGaleriaEstatica">

                <div class="card-footer">
                  
                  <input type="file" multiple id="galeria" class="d-none" accept="image/jpeg,image/png">

                  <label for="galeria" class="text-dark text-center py-5 border rounded bg-white w-100 subirGaleria">

                     Haz clic aquí o arrastra las imágenes <br>
                     <span class="help-block small">Dimensiones: 980px * 740px | Peso Max. 2MB | Formato: JPG o PNG</span>
                     
                  </label>

                </div>

              </div>

        </div>

                <!-- =========================================== -->


                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
                  </div>

              </form>
                   
          </div>


    </div>

  </div>

</div>
 
<script src="vistas/js/productos.js"></script>