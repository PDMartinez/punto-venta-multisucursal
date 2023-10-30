
    <main class="app-content">
      <div class="app-title">
        

        <div class="contador">
          <?php 
          
          $Sucursales = ControladorSucursales::ctrMostrarSucursal(null, null,null);
          $Sucursal=count($Sucursales);
         
          $maxihabilitado=0;
          
          $cantidades =ControladorSucursales::ctrMostrarCantidadSucursal(null, null);
     
          foreach ($cantidades as $key => $value){
            $maxihabilitado=$value["CANT_SUCURSALES"];
          
            }

          // if($Sucursal<$maxihabilitado){

          //    echo' <h5><button class="btn btn-primary btnNuevo" CantSucursal="'; echo $maxihabilitado; echo'" type="button"  data-toggle="modal" data-target="#ModalSucursal"><i class="fas fa-plus-circle"></i> Agregar Nuevo</button> Crear sucursales</h5>';
          // }else{
          //     echo '<div class="box-header with-border" >
          //        <label style="color:red"> 
          //        Supero la cantidad de sucursal concedido, puede actualizar su plan llamando a este número 0982-203.704 Ing. Marcos Contrera  0972-905.218 Ing. Danilo Martinez<br>
          //          ESTA PERMITIDO: '; echo $maxihabilitado; echo' SUCURSAL
          //         </label>

          //       </div>';

       // }
        ?>

        <h5><button class="btn btn-primary btnNuevo" CantSucursal="<?php  echo $Sucursal; ?>" type="button"  data-toggle="modal" data-target="#ModalSucursal"><i class="fas fa-plus-circle"></i> Agregar Nueva</button> Crear sucursales</h5>

         <div class="alert alert-dismissible alert-danger texto" >

         <p>Supero la cantidad de sucursal concedido, puedes actualizar su plan llamando a estos números 0982-203.704 o 0972-905.218 CompumarkApp.com<br>
         ESTA PERMITIDO: <?php  echo $maxihabilitado; ?> Sucursal o Punto de venta</p>

        </div>

    
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
             <!--  <div class="row">
                <div class="col-auto mr-auto"></div>
                <div class="col-auto">
                 <button class="btn btn-primary" id="btnActivo" activo=1>Ver datos Inactivo</i></button>
                </div>
              </div>
            
               <div class="mr-md-auto">

              </div> -->

              <div class="table-responsive">
                
                <table class="table table-hover table-bordered tablaSucursales">

                  <thead>
                    <tr>
                      <th>#</th>
                      <th >Acciones</th>
                      <th >Sucursal</th>
                      <th >R.U.C.</th>
                      <th>Encargado</th>
                      <th>Dirección</th>
                      <th>Ciudad</th>
                      <th>N° Verificador</th>
                      <th>N° Pedidos</th>
                      <th>N° Remisión</th>
                      <th>Teléfono</th>
                      <th>Estado</th>
                      <th>N° Imagen</th>
                      <th>P</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>

              </div>
            </div>
          </div>
        </div>

    </main>


    <!-- MODAL AGREGAR -->

<!-- Modal -->
<div class="modal fade" id="ModalSucursal" tabindex=null role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background:#464775; color:white">
        <h6 class="modal-title" id="titulo">Nueva sucursal</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

                     <!-- FORMULARIOS -->
              <!-- <form  onsubmit="return Guardarformulario()" method="post" name="formSucursal" id="formSucursal -->
             <form  onsubmit="return Guardarformulario()" method="post" name="formSucursal" id="formSucursal">
                  <input class="form-control" type="hidden" name="idSucursal"  id="idSucursal">
                  <input class="form-control" type="hidden" name="TokenSucursal" id= "TokenSucursal">

                  <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                    <!-- PRIMERA FILA -->
                    <div class="form-group col-md-6">

                      <div class="form-group">
                        <label class="control-label">Nombre sucursal *</label>
                        <input class="form-control" type="text" onkeyup="mayusculas(this);" name="txtSucursal" placeholder="Ingresar la sucursal">
                     </div>
                    </div>

                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-6">
                      <div class="form-group">
                        <label class="control-label">Nombre del encargado *</label>
                        <input class="form-control" type="text" onkeyup="mayusculas(this);" name="txtEncargado" placeholder="Ingresar el encargado">
                     </div>

                    </div>
                  </div>

                <!-- =========================================== -->


                    <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                    <!-- PRIMERA FILA -->
                    <div class="form-group col-md-6">

                      <div class="form-group">
                        <label class="control-label">Teléfono</label>
                        <input class="form-control" type="text" name="txtTelefono" placeholder="Ingresar el teléfono">
                     </div>
                    </div>


                    <!-- SEGUNDA FILA -->
                    <div class="form-group col-md-6">

                      <div class="form-group">
                        <label class="control-label">R.U.C.</label>
                        <input class="form-control" type="text" name="txtRuc" placeholder="Ingresar el N° RUC">
                     </div>

                    </div>

                   
                  </div>


                  <!-- INPUT DE DONDE SE DIVIDE LOS TEXTOS -->
                  <div class="form-row">

                    <!-- PRIMERA FILA -->
                    <div class="form-group col-md-6">

                      <div class="form-group">
                        <label class="control-label">Dirección</label>
                        <input class="form-control" type="text" onkeyup="mayusculas(this);" name="txtDireccion" placeholder="Ingresar la dirección">
                     </div>
                    </div>

                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-6">
                      <div class="form-group">
                        <label class="control-label">Ciudad * </label>
                       <select class="form-control select2" nane="cmbCiudad" id="cmbCiudad" style="width: 100%;" required="">
                          <option selected="selected">Seleccione la opciones</option>
                          <?php 

                            $item=null;
                            $valor=null;
                            $ciudad = ControladorCiudades::ctrMostrarCiudad($item,$valor);
                       
                           foreach ($ciudad as $key => $value) {

                             echo '<option value="'.$value["COD_CIUDAD"].'-'.$value["TOKEN_CIUDAD"].'" >'.$value["DESCRIPCION_CIUDAD"].'</option>';

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
                    <div class="form-group col-md-4">

                      <div class="form-group">
                        <label class="control-label">N° verificador * </label>
                        <input class="form-control" type="text" onkeyup="format(this)" onchange="format(this)" name="txtNroVerficador" placeholder="Ingresar N° verificador">
                     </div>
                    </div>

                    <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-4">
                       <div class="form-group">
                        <label class="control-label">N° Pedido *</label>
                        <input class="form-control" type="text" onkeyup="format(this)" onchange="format(this)" name="txtnroPedidos" placeholder="Ingresar N° pedido">
                      </div>
                     </div>

                       <!-- TERCERA FILA -->
                    <div class="form-group col-md-4">
                       <div class="form-group">
                        <label class="control-label">N° Remisión *</label>
                        <input class="form-control" type="text" onkeyup="format(this)" onchange="format(this)" name="txtnroRemision" placeholder="Ingresar N° remisión">
                      </div>
                     </div>

                    </div>


                <div class="form-row">

                    <!-- PRIMERA FILA -->
                  <div class="form-group col-md-6">

                   <div class="form-group">
                    <div class="animated-checkbox">
                      <label>
                        <input type="checkbox" value=0 id="nuevoActivo" name="nuevoActivo" onclick="Activarcheck()"><span class="label-text">Local principal</span>
                      </label>
                    </div>
               
                    </div>
                  </div>

                   <!-- SEGUNDAD FILA -->
                    <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="cmbEstado">Seleccione el estado</label>
                        <select class="form-control" name="cmbEstado" id="cmbEstado">
                          <option value="1">Activo</option>
                          <option value="0">Inactivo</option>
                         
                        </select>
                    </div>

                    </div>


                </div>

                <!-- =========================================== -->

                <!-- Galería -->

              <div class="card rounded-lg card-secondary card-outline">
                
                <div class="card-header pl-2 pl-sm-3">

                  <h5>Imagen de la sucursal:</h5>

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
                     <span class="help-block small">Dimensiones: 940px * 480px | Peso Max. 2MB | Formato: JPG o PNG</span>
                     
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
 
<script src="vistas/js/sucursales.js"></script>