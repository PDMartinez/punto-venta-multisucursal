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
   
      
          <div class="tile">
            <div class="tile-body">
              <form role="form" method="post">

                  <div class="row">
                    <div class="col-md-6">

                      <input type="hidden" name="idUsuario" value="<?php echo $_SESSION["id_usu"]; ?>">
                     <input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $_SESSION["idsucursal"]; ?>">
                      <div class="form-group">
                        <label class="control-label">Monto Apertura:</label>
                       <input type="text" class="form-control input-lg" id="nuevoApertura" name="nuevoApertura" min="0" step="any" placeholder="Ingresar el monto de apertura" onkeyup="format(this)" onchange="format(this)" required>

                      </div>

                    </div>

                    <div class="col-md-6">
                    

                        <div class="form-group">
                            <label class="control-label">Seleccionar Caja:</label>
                         
                          <select class="form-control" id="cmbCaja" name="cmbCaja" required>

                            <option value="">Seleccione un caja</option>

                               <?php 

                              $item = "EST_CAJA";
                              $valor = 1;
                              $item1 = "COD_SUCURSAL";
                              $valor1 = $_SESSION["idsucursal"];
                              $var=null;
                              $Apertura = ControladorCajas::ctrMostrarCajaSucursal($item, $valor,$item1, $valor1,$var);


                            

                           foreach ($Apertura as $key => $value) {


                            $item = "ESTADO_APERTURA";
                            $valor = "APERTURA";
                            $var=1;
                            $item1 =null;
                            $valor1 =null;

                            $nombres = explode("/",$_SESSION["idsucursal"]);
                            $TOKEN_SUCURSAL=$nombres[0];

                            $item2 = "COD_SUCURSAL";
                            $valor2= $TOKEN_SUCURSAL;
                    
                            $cajaApertura = ControladorAperturas::ctrMostrarAperturasucursalCaja($item, $valor,$item1,$valor1,$item2,$valor2,$var);

                            if($value["COD_CAJA"]!= $cajaApertura["COD_CAJA"]){
                              echo '<option value="'.$value["COD_CAJA"].'" >'.$value["NROCAJA"].'</option>';
                            }

                            
                           }

                    ?>

                          </select>


                        </div>

                   </div>

         
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar apertura</button>

                      </div>
                          <?php
                            $crearApertura=new ControladorAperturas();
                            $crearApertura-> ctrCrearApertura();
                           ?>
        

                  </div>
                  </form>
            </div>
          </div>
       
    </main>