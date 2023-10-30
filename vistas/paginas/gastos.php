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


  ?>
    <main class="app-content">
      <div class="app-title">
        <div>

          <h5>Registro de gastos diarios</h5>
         <!--  <p>En este módulo, puedes crear, modificar,eliminar perfiles</p> -->
         <button class="btn btn-primary btnNuevo" type="button"  data-toggle="modal" data-target="#ModalGastos"><i class="fas fa-plus-circle"></i> Agregar Nuevo </button>
        </div>

        

        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="inicio"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item"><a href="gastos">Gastos</a></li>
        </ul>
      </div>
    

      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered tablaGastos">

                  <thead>
                    <tr>
                      <th style="width:10px">#</th>
                      <th style="width:100px">Acciones</th>
                      <th>DESCRIPCION</th>
                      <th>CATEGORIA</th>
                      <th>TOTAL GASTOS</th>
                      <th>TIPO DE GASTOS</th>
                      <th>EXTRACCIÓN</th>
                      <th>FORMA GASTOS</th>
                      <th>N° CAJA</th>
                      <th>NRO_FACTURA</th>
                      <th>RUC</th>
                      <th>EMPRESA</th>
                      <th>IVA</th>
                      <th>SUCURSAL</th>
                     <th>USUARIO</th>
                     
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


    </main>


  <!-- MODAL PARA AGREGAR MAS GASTOS -->

<!-- Modal -->
<div class="modal fade" id="ModalGastos" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background:#464775; color:white">
        <h6 class="modal-title" id="titulo">Agregar nuevo gastos</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form onsubmit="return guardarFormulario()" id="formularioGastos">
                     <!-- FORMULARIOS -->
                 <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $_SESSION["id_usu"].'/'.$_SESSION["tokenUsuario"]; ?>"> 
                  <input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $_SESSION["idsucursal"]; ?>">

                   <input type="hidden" name="codigoapertura" id="codigoapertura" value="<?php echo $_SESSION["id_apertura"]; ?>">

                  <input type="hidden" name="tokenapertura" id="tokenapertura" estado=1 value="<?php  echo $_SESSION["cod_caja"]; ?>">

                  <input type="hidden" name="codigogastos" id="codigogastos">

                <!-- SELECCION DE TIPO DE GASTOS -->

              <div class="form-row">
                     <div class="form-group col-lg-6">
                      <div class="form-group">
                        <label for="cmbTipoMovimiento">Seleccione tipo</label>
                        <select class="form-control" name="cmbTipoMovimiento" id="cmbTipoMovimiento" required>
                           <option value="TICKET">TICKET</option>  
                          <option value="FACTURA">FACTURA</option>
                                                
                        </select>
                      </div>

                    </div>
                 <div class="form-group col-lg-6">
                      <div class="form-group">
                        <label for="txtFechaGastos">Fecha gastos</label>
                       <input class="form-control" name="txtFechaGastos" id="txtFechaGastos" type="date" value="<?php date_default_timezone_set("America/Asuncion");echo date('Y-m-d'); ?>" placeholder="Seleccionar la fecha">
                      </div>

                  </div>

              </div>

              <!-- ============================================================================== -->

               <!-- SELECCION DE TIPO DE GASTOS -->



              <div class=" notblock form-row Factura">

                     <div class="form-group col-lg-6">
                      <label for="txtFechaGastos">N° Factura:</label>
                       <input class="form-control" name="txtNroFactura" id="txtNroFactura" placeholder="Ingrese el N° factura">
                     </div>

                  <div class="form-group col-lg-6">
                      <label for="txtFechaGastos">Ruc:</label>
                       <input class="form-control" name="txtRuc" id="txtRuc"  placeholder="Ingresar el Ruc">
                   
                  </div>



                  <div class="form-group col-lg-12">
                      <label for="txtFechaGastos">Nombre empresa:</label>
                       <input class="form-control" name="txtNombreEmpresa" id="txtNombreEmpresa"  placeholder="Ingresar el nombre de la empresa">
                   
                  </div>

                  <div class="form-group col-lg-6">
                      <label for="cmbEstado">Seleccione tipo IVA</label>
                        <select class="form-control" name="cmbIva" id="cmbIva">
                          <option value="10">Iva 10%</option>
                          <option value="5">Iva 5%</option> 
                           <option value="0">Exentas</option>                         
                        </select>
                    </div>


               
              </div>

              <!-- ============================================================================== -->


               <!-- SELECCION DE TIPO DE GASTOS -->

          
                     <label class="control-label">Categoria de gastos:</label>
                        <div class="form-group">

                          <div class="input-group mb-auto">
                         
                          <select class="form-control select2" id="cmbCategoria" name="cmbCategoria"  style="width: 92%;">

                            <option value="">Seleccione una categoria</option>

                           <?php 
                            $tabla="gastos";
                            $columna="DISTINCT(CATEGORIA) CATEGORIA";
                            $order="CATEGORIA ASC";
                            $where=null;
                            $item="";
                            $valor="";
                           // $where="WHERE COD_GASTO=".$valor;
                        
                            $Categoria= ControladorGastos::ctrMostrarCategoria($tabla,$columna,$where,$item,$valor,$order);
                            
                           foreach ($Categoria as $key => $value) {

                             echo '<option>'.$value["CATEGORIA"].'</option>';

                          }

                   ?>

                          </select>


                        <div class="input-group-append">
                          <button class='btn btn-info btn-sm' id="btnAgregarCategoria" type="button"> <i class="fas fa-plus-square"></i></button>
                        </div>
                      </div>
                        </div>
                     
                       <div class="notblock form-group CategoriaNuevo">
                         <label for="txtFechaGastos">Nueva categoria:</label>
                         <input class="form-control" name="txtNuevaCategoria" id="txtNuevaCategoria" placeholder="Ingresar una categoria">
                      </div>


                        <div class="form-group">
                         <label for="txtFechaGastos">Descipción del gastos:</label>
                         <textarea class="form-control input-lg" name="txtNuevaDescripcion" id="txtNuevaDescripcion" cols="10" rows="5" required></textarea>
                        
                      </div>

                  <div class="row">
                        <div class="form-group col-lg-6">
                          <label class="control-label">Monto gastos:</label>
                          <input type="text" class="form-control input-lg" id="txtMontoGastos" name="txtMontoGastos" min="0" step="any" placeholder="Ingresar el monto de gastos" onkeyup="format(this)" onchange="format(this)" required>

                      </div>

                       <div class="form-group col-lg-6">
                          <label for="cmbEstado">Seleccione extracción</label>
                        <select class="form-control" name="cmbExtraccion" id="cmbExtraccion" required>
                          <option value="1">Extracción de caja</option>
                          <option value="0">No Extracción</option>                        
                        </select>
                    </div>

                  </div>
                      
              <!-- ============================================================================== -->


                 <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->
               
                <div  class="card mb-1 border-primary metodopago">

                   <div class="card-body">
                  <blockquote class="card-blockquote">

                    <div class="form-row">           
                    
                     <div  class="form-group col-md-12">

                       <label for="nuevoMetodoPago">Seleccione método de pago</label>
                    <div class="input-group mb-auto">
                      <select class="form-control Metodonuevopago Metodonuevopago0" id="nuevoMetodoPago" name="nuevoMetodoPago" style="width: 100%;" required>
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

                       <label for="txtdescuentoTotal">Pago</label>
                       <input class="form-control txtentregaEfectivo" name="txtentregaEfectivo" id="txtentregaEfectivo" type="text" onkeyup="format(this)" onchange="format(this)"> 

                    </div>



                       <div class="form-group col-md-6" id="recibo">
                  
                        <div class="form-group">
                        <label class="NroMovimiento" for="txtnroRecibo">Nº Movimiento</label>
                       <input class="form-control txtnroRecibo" name="txtnroRecibo" id="txtnroRecibo" type="text" placeholder="Nº transacción">
                      </div>

                    </div>

                 
                </div>
              </blockquote>
            </div>

          </div>
  <!-- =================================================================================================================== -->


                             
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardar">Agregar</button>
                  </div>
                  
              </form>
                   
          </div>


    </div>

  </div>

</div>

<script src="vistas/js/gastos.js"></script>