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

          // echo '<script>

          //   window.location = "apertura";

          //   </script>';


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

          <h5>Agregar monto de apertura</h5>
         <!--  <p>En este módulo, puedes crear, modificar,eliminar perfiles</p> -->
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
              <div class="table-responsive">
                <table class="table table-hover table-bordered tablaAperturas">

                  <thead>
                    <tr>
                      <th style="width:10px">#</th>
                      <th style="width:100px">Acciones</th>
                      <th>TOTAL APERTURA</th>
                      <th>USUARIO</th>
                      <th>N° CAJA</th>
                      <th>FECHA APERTURA</th>
                      <th>FECHA CIERRE</th>
                      <th>MONTO CIERRE </th>
                      <th>DIFERENCIA</th>
                      <th>OBSERVACIÓN</th>
                      <th>ESTADO</th>
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


    <!-- MODAL PARA VER DETALLE DE LA APERTURA -->

<!-- Modal -->
<div class="modal fade" id="ModalVerApertura" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background:#464775; color:white">
        <h6 class="modal-title" id="titulo">Detalle de apertura</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Detalle de apertura</h3>

             <div class="form-group">
                  <label class="control-label">Usuario</label>
                  <input class="form-control" type="text" id="txtVerUsuario"  value="<?php echo $_SESSION["funcionario"].' - '.$_SESSION["usuario"]; ?>" readonly>
                </div>

                <div class="form-group">
                  <label class="control-label">Caja</label>
                  <input class="form-control" type="text" id="txtVerCaja"readonly>
                </div>
                <div class="form-group">
                  <label class="control-label">Fecha apertura</label>
                  <input class="form-control" type="text" id="txtfechaVerApertura" readonly>
                </div>
                <div class="form-group">
                  <label class="control-label">Fecha cierre</label>
                  <input class="form-control" type="text" id="txtfechaCierreApertura" readonly>
                </div>

                 <div class="form-group">
                  <label class="control-label">Monto cierre</label>
                  <input class="form-control" type="text" id="txtmontocierre" readonly>
                </div>
                <div class="form-group">
                  <label class="control-label">Diferencia cierre</label>
                  <input class="form-control" type="text" id="txtdiferenciacierre" readonly>
                </div>

            <table class="table table-responsive-sm table-bordered" id="TablaVerapertura">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Hora apertura</th>
                  <th>Monto apertura</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                                
              </tbody>
            </table>

             <div class="form-group col-lg-12">
                  <label class="control-label">Observaciones:</label>
                <textarea class="form-control input-lg" name="txtObservaciones" id="txtObservaciones" cols="10" rows="5" readonly></textarea>

              </div>
          </div>
        </div>
      </div>
    </div>

               
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>

                   
          </div>


    </div>

  </div>

</div>


  <!-- MODAL PARA VER DETALLE DE LA APERTURA -->

<!-- Modal -->
<div class="modal fade" id="ModalApertura" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background:#464775; color:white">
        <h6 class="modal-title" id="titulo">Agregar monto de apertura</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form onsubmit="return guardarFormulario()" id="formularioApertura">
                     <!-- FORMULARIOS -->
                 <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $_SESSION["id_usu"].'/'.$_SESSION["tokenUsuario"]; ?>"> 
                  <input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $_SESSION["idsucursal"]; ?>">

                  <input type="hidden" name="codigoapertura" id="codigoapertura">

                  <input type="hidden" name="tokenapertura" id="tokenapertura">

                 <div class="form-group">
                    <label class="control-label">N° de Caja:</label>
                    <input type="text" class="form-control input-lg" id="txtNroCaja" name="txtNroCaja" readonly>

                  </div>


                <div class="form-group">
                        <label class="control-label">Monto Apertura:</label>
                       <input type="text" class="form-control input-lg" id="nuevoApertura" name="nuevoApertura" min="0" step="any" placeholder="Ingresar el monto de apertura" onkeyup="format(this)" onchange="format(this)" required>

                      </div>

                             
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardar">Agregar</button>
                  </div>
                  
              </form>
                   
          </div>


    </div>

  </div>

</div>


<script src="vistas/js/apertura.js"></script>